<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relationships extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('form_validation');
        $this->ensure_session_world();
    }

    /**
     * Directed Relationship Matrix Directory & Graph Explorer
     */
    public function index()
    {
        $world_id = $this->session->userdata('active_world_id');
        $active_world = $this->db->get_where('worlds', array('id' => $world_id))->row();

        $search = trim((string)$this->input->get('q', TRUE));
        $type_filter = trim((string)$this->input->get('predicate', TRUE));

        // Fetch all relationships with source and target entry details
        $this->db->select('er.*, 
                           src.title as source_title, src.slug as source_slug, src.status as source_status,
                           src_t.name as source_type_name, src_t.slug as source_type_slug,
                           tgt.title as target_title, tgt.slug as target_slug, tgt.status as target_status,
                           tgt_t.name as target_type_name, tgt_t.slug as target_type_slug');
        $this->db->from('entry_relationships er');
        $this->db->join('entries src', 'src.id = er.source_entry_id', 'inner');
        $this->db->join('entry_types src_t', 'src_t.id = src.entry_type_id', 'left');
        $this->db->join('entries tgt', 'tgt.id = er.target_entry_id', 'inner');
        $this->db->join('entry_types tgt_t', 'tgt_t.id = tgt.entry_type_id', 'left');
        $this->db->where('er.world_id', $world_id);
        $this->db->where('src.is_archived', 0);
        $this->db->where('tgt.is_archived', 0);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('src.title', $search);
            $this->db->or_like('tgt.title', $search);
            $this->db->or_like('er.relationship_type', $search);
            $this->db->or_like('er.inverse_label', $search);
            $this->db->or_like('er.description', $search);
            $this->db->group_end();
        }

        if (!empty($type_filter)) {
            $this->db->where('er.relationship_type', $type_filter);
        }

        $this->db->order_by('er.id', 'DESC');
        $relationships = $this->db->get()->result();

        // Distinct relationship predicates for filtering
        $predicate_rows = $this->db->select('DISTINCT(relationship_type) as p')->where('world_id', $world_id)->order_by('p', 'ASC')->get('entry_relationships')->result();
        $predicates = array();
        foreach ($predicate_rows as $pr) {
            if (!empty($pr->p)) $predicates[] = $pr->p;
        }

        // Compute Network Telemetry: total bonds, unique connected entities, top nexuses
        $total_bonds = count($relationships);
        $connected_entities = array();
        $entity_frequency = array();

        foreach ($relationships as $r) {
            $connected_entities[$r->source_entry_id] = $r->source_title;
            $connected_entities[$r->target_entry_id] = $r->target_title;

            $entity_frequency[$r->source_title] = isset($entity_frequency[$r->source_title]) ? $entity_frequency[$r->source_title] + 1 : 1;
            $entity_frequency[$r->target_title] = isset($entity_frequency[$r->target_title]) ? $entity_frequency[$r->target_title] + 1 : 1;
        }

        arsort($entity_frequency);
        $top_nexuses = array_slice($entity_frequency, 0, 5, true);

        // Fetch all active entries for the quick bind modal
        $all_entries = $this->db->select('entries.id, entries.title, entries.slug, entry_types.name as type_name')
                                ->from('entries')
                                ->join('entry_types', 'entry_types.id = entries.entry_type_id', 'left')
                                ->where(array('entries.world_id' => $world_id, 'entries.is_archived' => 0))
                                ->order_by('entries.title', 'ASC')
                                ->get()->result();

        $user_id = $this->session->userdata('user_id');
        $current_user = $user_id ? $this->db->get_where('users', array('id' => $user_id))->row() : $this->db->get('users')->row();

        $data = array(
            'page_title'         => 'Sworn Bonds // Relationship Matrix',
            'header_title'       => 'Relationship Matrix',
            'sub_heading'        => 'COMPENDIUM VINCULORUM // WEB OF SWORN TIES',
            'header_caption'     => 'Directed Semantic Graph of Characters, Realms, Relics, and Factions',
            'active_tab'         => 'relationships',
            'active_world'       => $active_world,
            'current_user'       => $current_user,
            'relationships'      => $relationships,
            'predicates'         => $predicates,
            'selected_search'    => $search,
            'selected_predicate' => $type_filter,
            'total_bonds'        => $total_bonds,
            'unique_entities'    => count($connected_entities),
            'top_nexuses'        => $top_nexuses,
            'all_entries'        => $all_entries,
            'content_view'       => 'relationships/index',
        );

        $this->load->view('layouts/main', $data);
    }

    /**
     * Forge a New Directed Bond between two entries
     */
    public function store()
    {
        $world_id = $this->session->userdata('active_world_id');
        $user_id = $this->session->userdata('user_id') ?: 1;

        $source_id = (int)$this->input->post('source_entry_id');
        $target_id = (int)$this->input->post('target_entry_id');
        $type      = trim((string)$this->input->post('relationship_type', TRUE));
        $inverse   = trim((string)$this->input->post('inverse_label', TRUE));
        $desc      = trim((string)$this->input->post('description', TRUE));

        $is_ajax = $this->input->is_ajax_request();

        if (!$source_id || !$target_id || empty($type)) {
            if ($is_ajax) {
                return $this->output->set_content_type('application/json')
                    ->set_output(json_encode(array('success' => false, 'error' => 'Source, Target, and Predicate are required.')));
            }
            $this->session->set_flashdata('error_msg', 'Source, Target, and Predicate are required.');
            redirect(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'relationships');
            return;
        }

        if ($source_id === $target_id) {
            if ($is_ajax) {
                return $this->output->set_content_type('application/json')
                    ->set_output(json_encode(array('success' => false, 'error' => 'An entity cannot be bound to itself.')));
            }
            $this->session->set_flashdata('error_msg', 'An entity cannot be bound to itself.');
            redirect(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'relationships');
            return;
        }

        // Verify both entries exist in this world
        $src = $this->db->get_where('entries', array('id' => $source_id, 'world_id' => $world_id))->row();
        $tgt = $this->db->get_where('entries', array('id' => $target_id, 'world_id' => $world_id))->row();

        if (!$src || !$tgt) {
            if ($is_ajax) {
                return $this->output->set_content_type('application/json')
                    ->set_output(json_encode(array('success' => false, 'error' => 'One or both entities not found in active realm.')));
            }
            show_error('Entries not found in active realm.');
            return;
        }

        // Check for duplicate
        $existing = $this->db->get_where('entry_relationships', array(
            'world_id'          => $world_id,
            'source_entry_id'   => $source_id,
            'target_entry_id'   => $target_id,
            'relationship_type' => $type,
        ))->row();

        if ($existing) {
            if ($is_ajax) {
                return $this->output->set_content_type('application/json')
                    ->set_output(json_encode(array('success' => false, 'error' => 'This bond already exists.')));
            }
            $this->session->set_flashdata('error_msg', 'This bond already exists.');
            redirect(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'entries/view/' . $source_id);
            return;
        }

        $now = date('Y-m-d H:i:s');
        $this->db->insert('entry_relationships', array(
            'world_id'          => $world_id,
            'source_entry_id'   => $source_id,
            'target_entry_id'   => $target_id,
            'relationship_type' => $type,
            'inverse_label'     => !empty($inverse) ? $inverse : $type,
            'description'       => !empty($desc) ? $desc : NULL,
            'created_at'        => $now,
            'updated_at'        => $now,
        ));
        $new_id = $this->db->insert_id();

        if ($is_ajax) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'success' => true,
                    'message' => "Bond forged: {$src->title} --[{$type}]--> {$tgt->title}",
                    'id'      => $new_id,
                )));
        }

        $this->session->set_flashdata('success_msg', "Bond forged: \"{$src->title}\" is now {$type} \"{$tgt->title}\".");
        redirect(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'entries/view/' . $source_id);
    }

    /**
     * Sever an Existing Bond
     */
    public function delete($id)
    {
        $world_id = $this->session->userdata('active_world_id');
        $rel = $this->db->get_where('entry_relationships', array('id' => $id, 'world_id' => $world_id))->row();

        $is_ajax = $this->input->is_ajax_request();

        if (!$rel) {
            if ($is_ajax) {
                return $this->output->set_content_type('application/json')
                    ->set_output(json_encode(array('success' => false, 'error' => 'Bond not found.')));
            }
            show_404();
            return;
        }

        $this->db->where('id', $id)->delete('entry_relationships');

        if ($is_ajax) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(array('success' => true, 'message' => 'Bond severed.')));
        }

        $this->session->set_flashdata('success_msg', 'The bond has been dissolved from the archives.');
        redirect(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'relationships');
    }

    private function ensure_session_world()
    {
        $world_id = $this->session->userdata('active_world_id');
        if (!$world_id) {
            $world = $this->db->get('worlds')->row();
            if ($world) {
                $this->session->set_userdata('active_world_id', $world->id);
            }
        }
    }
}
