<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ============================================================================
 * LOREKEEPER // MEDIA VAULT & ATTACHMENT CONTROLLER
 * ============================================================================
 * 
 * Handles secure local-first media uploads, entry portrait management,
 * gallery attachments, and asset metadata tracking.
 */
class Media extends CI_Controller {

    private $upload_dir;
    private $allowed_extensions = array('jpg', 'jpeg', 'png', 'webp', 'svg', 'gif');
    private $allowed_mimes = array(
        'image/jpeg',
        'image/png',
        'image/webp',
        'image/svg+xml',
        'image/gif',
        'image/pjpeg',
        'image/x-png',
    );
    private $max_size_bytes = 15728640; // 15 Megabytes

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->upload_dir = FCPATH . 'storage/media/';
        $this->ensure_upload_directory();
    }

    /**
     * AJAX/Multipart file upload endpoint
     * Accepts: $_FILES['file'] or $_FILES['portrait'] or $_FILES['image']
     * Optional POST params:
     * - entry_id (int)
     * - is_cover (bool/int 1)
     * - caption (string)
     * - world_id (int)
     */
    public function upload()
    {
        // 1. Locate uploaded file from any accepted input name
        $file_field = null;
        foreach (array('file', 'portrait', 'image', 'cover') as $field) {
            if (isset($_FILES[$field]) && !empty($_FILES[$field]['name'])) {
                $file_field = $field;
                break;
            }
        }

        if (!$file_field) {
            return $this->json_response(false, 'No image file was received for upload.');
        }

        $file = $_FILES[$file_field];

        // 2. Check for native upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $error_messages = array(
                UPLOAD_ERR_INI_SIZE   => 'File exceeds php.ini upload_max_filesize limit.',
                UPLOAD_ERR_FORM_SIZE  => 'File exceeds MAX_FILE_SIZE specified in the form.',
                UPLOAD_ERR_PARTIAL    => 'File was only partially uploaded.',
                UPLOAD_ERR_NO_FILE    => 'No file was uploaded.',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder on server.',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
                UPLOAD_ERR_EXTENSION  => 'A PHP extension halted the file upload.',
            );
            $msg = isset($error_messages[$file['error']]) ? $error_messages[$file['error']] : 'Unknown upload error occurred.';
            return $this->json_response(false, $msg);
        }

        // 3. Validate size
        if ($file['size'] > $this->max_size_bytes) {
            return $this->json_response(false, 'File size exceeds 15MB limit.');
        }

        // 4. Validate extension
        $original_name = basename($file['name']);
        $ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
        if (!in_array($ext, $this->allowed_extensions)) {
            return $this->json_response(false, 'Invalid image format. Allowed: ' . implode(', ', $this->allowed_extensions));
        }

        // 5. Validate MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $detected_mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($detected_mime, $this->allowed_mimes)) {
            // Special fallback check for SVG XML text
            if ($ext === 'svg' && (strpos($detected_mime, 'xml') !== false || strpos($detected_mime, 'text') !== false)) {
                $detected_mime = 'image/svg+xml';
            } else {
                return $this->json_response(false, 'MIME type verification failed: ' . htmlspecialchars($detected_mime));
            }
        }

        // 6. Resolve World and Entry context
        $world_id = (int)$this->input->post('world_id');
        $entry_id = (int)$this->input->post('entry_id');
        $is_cover = (int)$this->input->post('is_cover');
        $caption  = trim((string)$this->input->post('caption', TRUE));

        if ($entry_id > 0) {
            $entry = $this->db->get_where('entries', array('id' => $entry_id))->row();
            if ($entry && empty($world_id)) {
                $world_id = $entry->world_id;
            }
        }

        if (empty($world_id)) {
            $world_id = (int)$this->session->userdata('active_world_id') ?: 1;
        }

        $world = $this->db->get_where('worlds', array('id' => $world_id))->row();
        $world_slug = $world ? $world->slug : 'world';
        $entry_slug = (!empty($entry) && !empty($entry->slug)) ? $entry->slug : 'media';

        // 7. Generate clean collision-resistant stored filename
        $safe_stem = url_title(pathinfo($original_name, PATHINFO_FILENAME), '-', TRUE);
        if (empty($safe_stem)) {
            $safe_stem = 'art';
        }
        $stored_filename = sprintf('%s_%s_%s_%s.%s',
            substr($world_slug, 0, 16),
            substr($entry_slug, 0, 24),
            time(),
            substr(md5(uniqid(mt_rand(), true)), 0, 6),
            $ext
        );

        $destination_path = $this->upload_dir . $stored_filename;

        // 8. Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $destination_path)) {
            return $this->json_response(false, 'Failed to store file in storage/media/. Check directory permissions.');
        }

        // Relative path for database and web links
        $relative_file_path = 'storage/media/' . $stored_filename;
        $public_url = base_url($relative_file_path);

        // 9. Inscribe into media_attachments table
        $media_record = array(
            'world_id'          => $world_id,
            'entry_id'          => $entry_id > 0 ? $entry_id : NULL,
            'original_filename' => $original_name,
            'stored_filename'   => $stored_filename,
            'file_path'         => $relative_file_path,
            'mime_type'         => $detected_mime,
            'file_size'         => (int)$file['size'],
            'caption'           => !empty($caption) ? $caption : $safe_stem,
            'created_at'        => date('Y-m-d H:i:s'),
        );
        $this->db->insert('media_attachments', $media_record);
        $media_id = $this->db->insert_id();

        // 10. Automatically set as Entry Cover Portrait if requested
        if ($is_cover === 1 && $entry_id > 0) {
            $this->db->where('id', $entry_id)->update('entries', array(
                'cover_image'    => $relative_file_path,
                'cover_media_id' => $media_id,
                'updated_at'     => date('Y-m-d H:i:s'),
            ));
        }

        return $this->json_response(true, 'Illumination successfully inscribed into the Media Vault.', array(
            'media_id'        => $media_id,
            'entry_id'        => $entry_id,
            'is_cover'        => $is_cover === 1,
            'original_name'   => $original_name,
            'stored_filename' => $stored_filename,
            'file_path'       => $relative_file_path,
            'url'             => $public_url,
            'caption'         => $media_record['caption'],
            'markdown_tag'    => '![' . html_escape($media_record['caption']) . '](' . $relative_file_path . ')',
        ));
    }

    /**
     * Set an existing media attachment or image path as entry cover
     */
    public function set_cover()
    {
        $entry_id = (int)$this->input->post('entry_id');
        $media_id = (int)$this->input->post('media_id');
        $file_path = trim((string)$this->input->post('file_path', TRUE));

        if ($entry_id <= 0) {
            return $this->json_response(false, 'Valid entry ID required.');
        }

        $entry = $this->db->get_where('entries', array('id' => $entry_id))->row();
        if (!$entry) {
            return $this->json_response(false, 'Entry not found.');
        }

        if ($media_id > 0) {
            $media = $this->db->get_where('media_attachments', array('id' => $media_id))->row();
            if ($media) {
                $file_path = $media->file_path;
            }
        }

        if (empty($file_path)) {
            return $this->json_response(false, 'No image path or media attachment provided.');
        }

        $this->db->where('id', $entry_id)->update('entries', array(
            'cover_image'    => $file_path,
            'cover_media_id' => $media_id > 0 ? $media_id : NULL,
            'updated_at'     => date('Y-m-d H:i:s'),
        ));

        return $this->json_response(true, 'Cover portrait updated.', array(
            'entry_id'    => $entry_id,
            'cover_image' => $file_path,
            'url'         => (strpos($file_path, 'http') === 0) ? $file_path : base_url($file_path),
        ));
    }

    /**
     * Clear the cover portrait of an entry
     */
    public function remove_cover()
    {
        $entry_id = (int)$this->input->post('entry_id');
        if ($entry_id <= 0) {
            return $this->json_response(false, 'Valid entry ID required.');
        }

        $this->db->where('id', $entry_id)->update('entries', array(
            'cover_image'    => NULL,
            'cover_media_id' => NULL,
            'updated_at'     => date('Y-m-d H:i:s'),
        ));

        return $this->json_response(true, 'Portrait removed from dossier.');
    }

    /**
     * List all attachments for a specific entry or active world
     */
    public function gallery($entry_id = 0)
    {
        $entry_id = (int)$entry_id;
        $world_id = (int)$this->session->userdata('active_world_id') ?: 1;

        $this->db->select('*')->from('media_attachments');
        if ($entry_id > 0) {
            $this->db->where('entry_id', $entry_id);
        } else {
            $this->db->where('world_id', $world_id);
        }
        $this->db->order_by('id', 'DESC');
        $records = $this->db->get()->result();

        foreach ($records as $r) {
            $r->url = base_url($r->file_path);
            $r->formatted_size = $this->format_bytes($r->file_size);
        }

        return $this->json_response(true, 'Gallery loaded.', array('items' => $records));
    }

    /**
     * Delete a media attachment
     */
    public function delete($id = 0)
    {
        $id = (int)$id;
        $attachment = $this->db->get_where('media_attachments', array('id' => $id))->row();
        if (!$attachment) {
            return $this->json_response(false, 'Media record not found.');
        }

        // Unlink physical file if exists
        $full_path = FCPATH . $attachment->file_path;
        if (file_exists($full_path) && is_file($full_path)) {
            @unlink($full_path);
        }

        // Clear references in entries table
        $this->db->where('cover_media_id', $id)->update('entries', array(
            'cover_image'    => NULL,
            'cover_media_id' => NULL,
        ));

        // Delete record
        $this->db->where('id', $id)->delete('media_attachments');

        return $this->json_response(true, 'Illumination excised from the Vault.');
    }

    private function ensure_upload_directory()
    {
        if (!is_dir($this->upload_dir)) {
            @mkdir($this->upload_dir, 0777, true);
        }
    }

    private function format_bytes($bytes, $precision = 1)
    {
        $units = array('B', 'KB', 'MB', 'GB');
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    private function json_response($success, $message, $extra = array())
    {
        $response = array_merge(array(
            'success' => $success,
            'message' => $message,
        ), $extra);

        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($response));
    }
}
