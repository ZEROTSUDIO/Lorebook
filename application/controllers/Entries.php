<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entries extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('form_validation');
        $this->ensure_session_world();
    }

    /**
     * Browse encyclopedia entries with search, type, status, tag filters, and sorting
     */
    public function index()
    {
        $world_id = $this->session->userdata('active_world_id');
        $search    = trim((string)$this->input->get('q', TRUE));
        $type_slug = trim((string)$this->input->get('type', TRUE));
        $status    = trim((string)$this->input->get('status', TRUE));
        $tag_slug  = trim((string)$this->input->get('tag', TRUE));
        $sort      = trim((string)$this->input->get('sort', TRUE)) ?: 'updated_desc';

        $this->db->select('entries.*, entry_types.name as type_name, entry_types.slug as type_slug, users.display_name as author_name, users.username as author_username');
        $this->db->from('entries');
        $this->db->join('entry_types', 'entry_types.id = entries.entry_type_id', 'left');
        $this->db->join('users', 'users.id = entries.created_by', 'left');

        if (!empty($tag_slug)) {
            $this->db->join('entry_tags', 'entry_tags.entry_id = entries.id', 'inner');
            $this->db->join('tags', 'tags.id = entry_tags.tag_id', 'inner');
            $this->db->where('tags.slug', $tag_slug);
        }

        $this->db->where('entries.world_id', $world_id);

        if (!empty($type_slug)) {
            $target_slugs = array($type_slug);
            if ($type_slug === 'persons')    $target_slugs[] = 'characters';
            if ($type_slug === 'characters') $target_slugs[] = 'persons';
            if ($type_slug === 'realms')     $target_slugs[] = 'nations';
            if ($type_slug === 'nations')    $target_slugs[] = 'realms';
            if ($type_slug === 'chronicle')  $target_slugs[] = 'events';
            if ($type_slug === 'events')     $target_slugs[] = 'chronicle';
            if ($type_slug === 'bestiary')   $target_slugs[] = 'species';
            if ($type_slug === 'species')    $target_slugs[] = 'bestiary';

            $this->db->where_in('entry_types.slug', $target_slugs);
        }

        if (!empty($status)) {
            if ($status === 'archived') {
                $this->db->where('entries.is_archived', 1);
            } else {
                $this->db->where('entries.status', $status);
                $this->db->where('entries.is_archived', 0);
            }
        } else {
            // Default view hides archived entries unless filtered
            $this->db->where('entries.is_archived', 0);
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('entries.title', $search);
            $this->db->or_like('entries.summary', $search);
            $this->db->or_like('entries.content_markdown', $search);
            $this->db->group_end();
        }

        if ($sort === 'title_asc') {
            $this->db->order_by('entries.title', 'ASC');
        } elseif ($sort === 'created_desc') {
            $this->db->order_by('entries.created_at', 'DESC');
        } else {
            $this->db->order_by('entries.updated_at', 'DESC');
        }

        $entries = $this->db->get()->result();

        // Attach tags for each entry
        foreach ($entries as $entry) {
            $entry->tags = $this->db->select('t.name, t.slug')
                                    ->from('entry_tags et')
                                    ->join('tags t', 't.id = et.tag_id')
                                    ->where('et.entry_id', $entry->id)
                                    ->get()->result();
        }

        $active_world = $this->db->get_where('worlds', array('id' => $world_id))->row();
        $entry_types  = $this->db->order_by('sort_order', 'ASC')->get_where('entry_types', array('world_id' => $world_id))->result();
        $all_tags     = $this->db->order_by('name', 'ASC')->get_where('tags', array('world_id' => $world_id))->result();

        // Topbar stats
        $total_entries = $this->db->where('world_id', $world_id)->count_all_results('entries');
        $canon_count   = $this->db->where(array('world_id' => $world_id, 'status' => 'canon'))->count_all_results('entries');
        $draft_count   = $this->db->where(array('world_id' => $world_id, 'status' => 'draft'))->count_all_results('entries');

        // Determine dynamic header title when filtering by category
        $header_title = 'The Encyclopedia';
        $sub_heading  = 'CATALOGUS OMNIUM // VAULT OF RECORDED LORE';
        if (!empty($type_slug)) {
            $mapped_slug = $type_slug;
            if ($type_slug === 'persons')    $mapped_slug = 'characters';
            if ($type_slug === 'characters') $mapped_slug = 'persons';
            if ($type_slug === 'realms')     $mapped_slug = 'nations';
            if ($type_slug === 'nations')    $mapped_slug = 'realms';
            if ($type_slug === 'chronicle')  $mapped_slug = 'events';
            if ($type_slug === 'events')     $mapped_slug = 'chronicle';
            if ($type_slug === 'bestiary')   $mapped_slug = 'species';
            if ($type_slug === 'species')    $mapped_slug = 'bestiary';

            foreach ($entry_types as $et) {
                if ($et->slug === $type_slug || $et->slug === $mapped_slug) {
                    $header_title = $et->name;
                    $sub_heading  = 'CODEX CATEGORY // ' . strtoupper($et->name);
                    break;
                }
            }
        }

        $user_id = $this->session->userdata('user_id');
        $current_user = $user_id ? $this->db->get_where('users', array('id' => $user_id))->row() : $this->db->get('users')->row();

        $normalized_type = $type_slug;
        if ($type_slug === 'persons')    $normalized_type = 'characters';
        if ($type_slug === 'realms')     $normalized_type = 'nations';
        if ($type_slug === 'chronicle')  $normalized_type = 'events';
        if ($type_slug === 'bestiary')   $normalized_type = 'species';

        $data = array(
            'page_title'     => $header_title,
            'header_title'   => $header_title,
            'sub_heading'    => $sub_heading,
            'header_caption' => 'Master Index of Recorded Entities, Artifacts, and Chronicles',
            'active_tab'     => !empty($normalized_type) ? $normalized_type : 'encyclopedia',
            'active_world'   => $active_world,
            'current_user'   => $current_user,
            'entries'        => $entries,
            'entry_types'    => $entry_types,
            'all_tags'       => $all_tags,
            'search_query'   => $search,
            'selected_type'  => $normalized_type,
            'selected_status'=> $status,
            'selected_tag'   => $tag_slug,
            'selected_sort'  => $sort,
            'total_entries'  => $total_entries,
            'canon_count'    => $canon_count,
            'draft_count'    => $draft_count,
            'content_view'   => 'entries/index',
        );

        $this->load->view('layouts/main', $data);
    }

    /**
     * Inscribe new lore entry form
     */
    public function create()
    {
        $world_id = $this->session->userdata('active_world_id');
        $active_world = $this->db->get_where('worlds', array('id' => $world_id))->row();
        
        // Fetch entry types for active world
        $entry_types = $this->db->order_by('sort_order', 'ASC')->get_where('entry_types', array('world_id' => $world_id))->result();

        // Ensure default property definitions exist for entry types
        $this->ensure_default_properties($entry_types);

        // Fetch properties definitions mapped by entry_type_id
        $properties_by_type = array();
        foreach ($entry_types as $type) {
            $props = $this->db->order_by('sort_order', 'ASC')->get_where('property_definitions', array('entry_type_id' => $type->id))->result();
            $properties_by_type[$type->id] = $props;
        }

        $initial_title = $this->input->get('title', TRUE);

        $user_id = $this->session->userdata('user_id');
        $current_user = $user_id ? $this->db->get_where('users', array('id' => $user_id))->row() : $this->db->get('users')->row();

        $data = array(
            'page_title'         => 'Inscribe Entry',
            'header_title'       => 'Inscribe Entry',
            'sub_heading'        => 'CODEX SCRIBE // INSCRIBE NEW CHRONICLE',
            'header_caption'     => 'Record a new person, seat of power, sacred relic, or historical event',
            'active_tab'         => 'create',
            'active_world'       => $active_world,
            'current_user'       => $current_user,
            'entry_types'        => $entry_types,
            'properties_by_type' => $properties_by_type,
            'initial_title'      => $initial_title,
            'content_view'       => 'entries/create',
        );

        $this->load->view('layouts/main', $data);
    }

    /**
     * Store new lore entry in MySQL
     */
    public function store()
    {
        $world_id = $this->session->userdata('active_world_id');
        $user_id = $this->session->userdata('user_id') ?: 1;

        // Validation rules
        $this->form_validation->set_rules('title', 'Entry Title', 'required|trim|max_length[200]');
        $this->form_validation->set_rules('entry_type_id', 'Entry Type', 'required|numeric');
        $this->form_validation->set_rules('status', 'Canon Status', 'required|in_list[draft,canon,archived]');

        if ($this->form_validation->run() === FALSE) {
            $this->create();
            return;
        }

        $title = $this->input->post('title', TRUE);
        $slug_input = $this->input->post('slug', TRUE);
        $slug = !empty($slug_input) ? url_title($slug_input, '-', TRUE) : url_title($title, '-', TRUE);

        // Ensure slug uniqueness within world
        $slug = $this->make_unique_slug($world_id, $slug);

        $entry_data = array(
            'public_id'        => $this->generate_uuid(),
            'world_id'         => $world_id,
            'entry_type_id'    => (int)$this->input->post('entry_type_id'),
            'title'            => $title,
            'slug'             => $slug,
            'summary'          => $this->input->post('summary', TRUE),
            'content_markdown' => $this->input->post('content_markdown'),
            'status'           => $this->input->post('status', TRUE),
            'cover_image'      => $this->input->post('cover_image', TRUE),
            'is_archived'      => ($this->input->post('status') === 'archived') ? 1 : 0,
            'created_by'       => $user_id,
            'updated_by'       => $user_id,
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s'),
        );

        $this->db->insert('entries', $entry_data);
        $entry_id = $this->db->insert_id();

        // Save structured property values if submitted
        $properties = $this->input->post('properties');
        if (is_array($properties)) {
            foreach ($properties as $prop_def_id => $val) {
                if ($val !== '' && $val !== null) {
                    $this->db->insert('property_values', array(
                        'entry_id'               => $entry_id,
                        'property_definition_id' => (int)$prop_def_id,
                        'value_text'             => is_string($val) ? $val : json_encode($val),
                        'created_at'             => date('Y-m-d H:i:s'),
                        'updated_at'             => date('Y-m-d H:i:s'),
                    ));
                }
            }
        }

        // Save tags if provided
        $tags_input = $this->input->post('tags', TRUE);
        if (!empty($tags_input)) {
            $tag_names = array_map('trim', explode(',', $tags_input));
            foreach ($tag_names as $tag_name) {
                if (empty($tag_name)) continue;
                $tag_slug = url_title($tag_name, '-', TRUE);

                // Find or insert tag
                $tag = $this->db->get_where('tags', array('world_id' => $world_id, 'slug' => $tag_slug))->row();
                if (!$tag) {
                    $this->db->insert('tags', array(
                        'world_id'   => $world_id,
                        'name'       => $tag_name,
                        'slug'       => $tag_slug,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ));
                    $tag_id = $this->db->insert_id();
                } else {
                    $tag_id = $tag->id;
                }

                $this->db->insert('entry_tags', array(
                    'entry_id' => $entry_id,
                    'tag_id'   => $tag_id,
                ));
            }
        }

        $this->session->set_flashdata('success_msg', 'Entry "' . $title . '" inscribed successfully into the Codex!');
        redirect('entries/view/' . $entry_id);
    }

    /**
     * Read / View Entry Dossier
     */
    public function view($id)
    {
        $world_id = $this->session->userdata('active_world_id');
        $entry = $this->db->select('entries.*, entry_types.name as type_name, entry_types.slug as type_slug, creator.display_name as author_name, creator.username as author_username, creator.role as author_role, updater.display_name as updater_name, updater.username as updater_username')
                          ->from('entries')
                          ->join('entry_types', 'entry_types.id = entries.entry_type_id', 'left')
                          ->join('users as creator', 'creator.id = entries.created_by', 'left')
                          ->join('users as updater', 'updater.id = entries.updated_by', 'left')
                          ->where('entries.id', $id)
                          ->where('entries.world_id', $world_id)
                          ->get()->row();

        if (!$entry) {
            show_404();
        }

        // Fetch structured property values
        $this->db->select('pv.*, pd.label, pd.field_key, pd.field_type');
        $this->db->from('property_values pv');
        $this->db->join('property_definitions pd', 'pd.id = pv.property_definition_id');
        $this->db->where('pv.entry_id', $id);
        $this->db->order_by('pd.sort_order', 'ASC');
        $properties = $this->db->get()->result();

        // Fetch tags
        $this->db->select('t.name, t.slug');
        $this->db->from('entry_tags et');
        $this->db->join('tags t', 't.id = et.tag_id');
        $this->db->where('et.entry_id', $id);
        $tags = $this->db->get()->result();

        $active_world = $this->db->get_where('worlds', array('id' => $world_id))->row();

        // 1. Parse Markdown & [[Wiki Links]] via Grimoire Engine
        $this->load->library('markdown_parser');
        $parsed_content = $this->markdown_parser->parse($entry->content_markdown, $world_id);

        // 2. Query Backlinks (Other entries referencing this entry's title or slug)
        $escaped_title = $this->db->escape_like_str($entry->title);
        $escaped_slug  = $this->db->escape_like_str($entry->slug);

        $this->db->select('entries.id, entries.title, entries.slug, entries.summary, entries.content_markdown, entry_types.name as type_name, entry_types.slug as type_slug');
        $this->db->from('entries');
        $this->db->join('entry_types', 'entry_types.id = entries.entry_type_id', 'left');
        $this->db->where('entries.world_id', $world_id);
        $this->db->where('entries.id !=', $id);
        $this->db->where('entries.is_archived', 0);
        $this->db->group_start();
        $this->db->like('entries.content_markdown', '[[' . $escaped_title);
        $this->db->or_like('entries.content_markdown', '[[' . $escaped_slug);
        $this->db->group_end();
        $this->db->limit(8);
        $backlinks = $this->db->get()->result();

        // Extract excerpt snippet for each backlink
        foreach ($backlinks as $bl) {
            $pos = stripos($bl->content_markdown, '[[' . $entry->title);
            if ($pos === false) {
                $pos = stripos($bl->content_markdown, '[[' . $entry->slug);
            }
            if ($pos !== false) {
                $start = max(0, $pos - 50);
                $snippet = substr($bl->content_markdown, $start, 150);
                $bl->snippet = ($start > 0 ? '...' : '') . trim($snippet) . '...';
            } else {
                $bl->snippet = $bl->summary;
            }
        }

        // 3. Query Outbound Relationships (Where this entry is source)
        $this->db->select('er.*, tgt.id as target_id, tgt.title as target_title, tgt.slug as target_slug, tgt.status as target_status, tgt_t.name as target_type_name, tgt_t.slug as target_type_slug');
        $this->db->from('entry_relationships er');
        $this->db->join('entries tgt', 'tgt.id = er.target_entry_id', 'inner');
        $this->db->join('entry_types tgt_t', 'tgt_t.id = tgt.entry_type_id', 'left');
        $this->db->where('er.source_entry_id', $id);
        $this->db->where('er.world_id', $world_id);
        $this->db->where('tgt.is_archived', 0);
        $this->db->order_by('er.id', 'ASC');
        $outbound_relationships = $this->db->get()->result();

        // 4. Query Inbound Relationships (Where this entry is target)
        $this->db->select('er.*, src.id as source_id, src.title as source_title, src.slug as source_slug, src.status as source_status, src_t.name as source_type_name, src_t.slug as source_type_slug');
        $this->db->from('entry_relationships er');
        $this->db->join('entries src', 'src.id = er.source_entry_id', 'inner');
        $this->db->join('entry_types src_t', 'src_t.id = src.entry_type_id', 'left');
        $this->db->where('er.target_entry_id', $id);
        $this->db->where('er.world_id', $world_id);
        $this->db->where('src.is_archived', 0);
        $this->db->order_by('er.id', 'ASC');
        $inbound_relationships = $this->db->get()->result();

        // 5. Fetch other active entries for the "+ Forge Bond" modal
        $other_entries = $this->db->select('entries.id, entries.title, entries.slug, entry_types.name as type_name')
                                  ->from('entries')
                                  ->join('entry_types', 'entry_types.id = entries.entry_type_id', 'left')
                                  ->where(array('entries.world_id' => $world_id, 'entries.id !=' => $id, 'entries.is_archived' => 0))
                                  ->order_by('entries.title', 'ASC')
                                  ->get()->result();

        $user_id = $this->session->userdata('user_id');
        $current_user = $user_id ? $this->db->get_where('users', array('id' => $user_id))->row() : $this->db->get('users')->row();

        $data = array(
            'page_title'             => $entry->title,
            'header_title'           => $entry->title,
            'sub_heading'            => 'DOSSIER // ' . strtoupper($entry->type_name),
            'header_caption'         => 'Codex Entry Public ID: ' . $entry->public_id,
            'active_tab'             => $entry->type_slug,
            'active_world'           => $active_world,
            'current_user'           => $current_user,
            'entry'                  => $entry,
            'properties'             => $properties,
            'tags'                   => $tags,
            'parsed_content'         => $parsed_content,
            'backlinks'              => $backlinks,
            'outbound_relationships' => $outbound_relationships,
            'inbound_relationships'  => $inbound_relationships,
            'other_entries'          => $other_entries,
            'content_view'           => 'entries/view',
        );

        $this->load->view('layouts/main', $data);
    }

    /**
     * AJAX Live Markdown & Wiki Link Preview Endpoint
     */
    public function preview()
    {
        $world_id = $this->session->userdata('active_world_id') ?: 1;
        $this->load->library('markdown_parser');
        $raw_markdown = $this->input->post('markdown');
        $html = $this->markdown_parser->parse($raw_markdown, $world_id);
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(array('html' => $html)));
    }

    /**
     * Edit Entry Form
     */
    public function edit($id)
    {
        $world_id = $this->session->userdata('active_world_id');
        $entry = $this->db->select('entries.*, entry_types.name as type_name, entry_types.slug as type_slug')
                          ->from('entries')
                          ->join('entry_types', 'entry_types.id = entries.entry_type_id', 'left')
                          ->where('entries.id', $id)
                          ->where('entries.world_id', $world_id)
                          ->get()->row();

        if (!$entry) {
            show_404();
        }

        $active_world = $this->db->get_where('worlds', array('id' => $world_id))->row();
        $entry_types = $this->db->order_by('sort_order', 'ASC')->get_where('entry_types', array('world_id' => $world_id))->result();
        $this->ensure_default_properties($entry_types);

        // Fetch property definitions by type
        $properties_by_type = array();
        foreach ($entry_types as $type) {
            $props = $this->db->order_by('sort_order', 'ASC')->get_where('property_definitions', array('entry_type_id' => $type->id))->result();
            $properties_by_type[$type->id] = $props;
        }

        // Fetch existing property values for this entry keyed by definition id
        $raw_values = $this->db->get_where('property_values', array('entry_id' => $id))->result();
        $saved_properties = array();
        foreach ($raw_values as $pv) {
            $saved_properties[$pv->property_definition_id] = $pv->value_text;
        }

        // Fetch existing tags formatted as comma-separated string
        $raw_tags = $this->db->select('t.name')
                             ->from('entry_tags et')
                             ->join('tags t', 't.id = et.tag_id')
                             ->where('et.entry_id', $id)
                             ->get()->result();
        $tag_names = array();
        foreach ($raw_tags as $rt) {
            $tag_names[] = $rt->name;
        }
        $saved_tags = implode(', ', $tag_names);

        $user_id = $this->session->userdata('user_id');
        $current_user = $user_id ? $this->db->get_where('users', array('id' => $user_id))->row() : $this->db->get('users')->row();

        $data = array(
            'page_title'         => 'Edit ' . $entry->title,
            'header_title'       => 'Edit Codex Record',
            'sub_heading'        => 'CODEX SCRIBE // AMEND DOSSIER',
            'header_caption'     => 'Revising recorded history for Public ID: ' . $entry->public_id,
            'active_tab'         => $entry->type_slug,
            'active_world'       => $active_world,
            'current_user'       => $current_user,
            'entry'              => $entry,
            'entry_types'        => $entry_types,
            'properties_by_type' => $properties_by_type,
            'saved_properties'   => $saved_properties,
            'saved_tags'         => $saved_tags,
            'content_view'       => 'entries/edit',
        );

        $this->load->view('layouts/main', $data);
    }

    /**
     * Update existing lore entry in MySQL
     */
    public function update($id)
    {
        $world_id = $this->session->userdata('active_world_id');
        $user_id  = $this->session->userdata('user_id') ?: 1;

        $entry = $this->db->get_where('entries', array('id' => $id, 'world_id' => $world_id))->row();
        if (!$entry) {
            show_404();
        }

        // Validation Rules
        $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[2]|max_length[200]');
        $this->form_validation->set_rules('entry_type_id', 'Entry Type', 'required|numeric');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[canon,draft,apocrypha,retconned]');

        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
            return;
        }

        $title = $this->input->post('title', TRUE);
        $raw_slug = $this->input->post('slug', TRUE);
        $base_slug = !empty($raw_slug) ? url_title($raw_slug, '-', TRUE) : url_title($title, '-', TRUE);

        // Ensure slug is unique per world (excluding current entry id)
        $slug = $this->make_unique_slug_for_update($world_id, $base_slug, $id);

        $entry_type_id = (int)$this->input->post('entry_type_id');
        $status = $this->input->post('status', TRUE);
        $cover_image = $this->input->post('cover_image', TRUE);
        $summary = $this->input->post('summary', TRUE);
        $content_markdown = $this->input->post('content_markdown');

        // Start Transaction
        $this->db->trans_start();

        $update_data = array(
            'entry_type_id'    => $entry_type_id,
            'title'            => $title,
            'slug'             => $slug,
            'summary'          => $summary,
            'content_markdown' => $content_markdown,
            'status'           => $status,
            'cover_image'      => !empty($cover_image) ? $cover_image : NULL,
            'updated_by'       => $user_id,
            'updated_at'       => date('Y-m-d H:i:s'),
        );

        $this->db->where('id', $id)->update('entries', $update_data);

        // Sync Custom Properties
        $properties = $this->input->post('properties');
        $this->db->where('entry_id', $id)->delete('property_values');

        if (is_array($properties)) {
            foreach ($properties as $prop_def_id => $val) {
                if ($val !== '' && $val !== null) {
                    $this->db->insert('property_values', array(
                        'entry_id'               => $id,
                        'property_definition_id' => (int)$prop_def_id,
                        'value_text'             => is_string($val) ? $val : json_encode($val),
                        'created_at'             => date('Y-m-d H:i:s'),
                        'updated_at'             => date('Y-m-d H:i:s'),
                    ));
                }
            }
        }

        // Sync Tags
        $this->db->where('entry_id', $id)->delete('entry_tags');
        $tags_input = $this->input->post('tags', TRUE);
        if (!empty($tags_input)) {
            $tag_names = array_map('trim', explode(',', $tags_input));
            foreach ($tag_names as $tag_name) {
                if (empty($tag_name)) continue;
                $tag_slug = url_title($tag_name, '-', TRUE);

                $tag = $this->db->get_where('tags', array('world_id' => $world_id, 'slug' => $tag_slug))->row();
                if (!$tag) {
                    $this->db->insert('tags', array(
                        'world_id'   => $world_id,
                        'name'       => $tag_name,
                        'slug'       => $tag_slug,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ));
                    $tag_id = $this->db->insert_id();
                } else {
                    $tag_id = $tag->id;
                }

                $this->db->insert('entry_tags', array(
                    'entry_id' => $id,
                    'tag_id'   => $tag_id,
                ));
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error_msg', 'Failed to update record due to a database error.');
            redirect('entries/edit/' . $id);
        } else {
            $this->session->set_flashdata('success_msg', 'Record "' . $title . '" updated successfully in the Codex!');
            redirect('entries/view/' . $id);
        }
    }

    /**
     * Reversible Soft-Archive an Entry
     */
    public function archive($id)
    {
        $world_id = $this->session->userdata('active_world_id');
        $entry = $this->db->get_where('entries', array('id' => $id, 'world_id' => $world_id))->row();

        if (!$entry) {
            show_404();
        }

        $this->db->where('id', $id)->update('entries', array(
            'is_archived' => 1,
            'deleted_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ));

        $this->session->set_flashdata('success_msg', 'Record "' . $entry->title . '" has been sealed in the archives.');
        redirect('entries');
    }

    /**
     * Restore an Archived Entry
     */
    public function restore($id)
    {
        $world_id = $this->session->userdata('active_world_id');
        $entry = $this->db->get_where('entries', array('id' => $id, 'world_id' => $world_id))->row();

        if (!$entry) {
            show_404();
        }

        $this->db->where('id', $id)->update('entries', array(
            'is_archived' => 0,
            'deleted_at'  => NULL,
            'updated_at'  => date('Y-m-d H:i:s'),
        ));

        $this->session->set_flashdata('success_msg', 'Record "' . $entry->title . '" has been unsealed and restored to the active codex.');
        redirect('entries/view/' . $id);
    }

    private function make_unique_slug_for_update($world_id, $base_slug, $exclude_id)
    {
        $slug = $base_slug;
        $counter = 1;
        while ($this->db->where(array('world_id' => $world_id, 'slug' => $slug, 'id !=' => $exclude_id))->count_all_results('entries') > 0) {
            $slug = $base_slug . '-' . $counter;
            $counter++;
        }
        return $slug;
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

    private function ensure_default_properties($entry_types)
    {
        foreach ($entry_types as $type) {
            $count = $this->db->where('entry_type_id', $type->id)->count_all_results('property_definitions');
            if ($count === 0) {
                if ($type->slug === 'characters' || $type->slug === 'persons') {
                    $defs = array(
                        array('field_key' => 'species',     'label' => 'Species / Race',      'field_type' => 'text', 'sort_order' => 1),
                        array('field_key' => 'age',         'label' => 'Age / Lifespan',      'field_type' => 'text', 'sort_order' => 2),
                        array('field_key' => 'occupation',  'label' => 'Title / Occupation',  'field_type' => 'text', 'sort_order' => 3),
                        array('field_key' => 'origin_seat', 'label' => 'Origin Seat',         'field_type' => 'text', 'sort_order' => 4),
                        array('field_key' => 'clan',        'label' => 'Cohort / Clan',       'field_type' => 'text', 'sort_order' => 5),
                        array('field_key' => 'weapon',      'label' => 'Signature Weapon',    'field_type' => 'text', 'sort_order' => 6),
                        array('field_key' => 'aspect',      'label' => 'Arcane Aspect',       'field_type' => 'text', 'sort_order' => 7),
                        array('field_key' => 'abilities',   'label' => 'Abilities / Arts',    'field_type' => 'text', 'sort_order' => 8),
                    );
                } elseif ($type->slug === 'nations' || $type->slug === 'realms') {
                    $defs = array(
                        array('field_key' => 'government', 'label' => 'Government Type',           'field_type' => 'text', 'sort_order' => 1),
                        array('field_key' => 'ruler',      'label' => 'Current Sovereign / Ruler', 'field_type' => 'text', 'sort_order' => 2),
                        array('field_key' => 'capital',    'label' => 'Seat of Power / Capital',   'field_type' => 'text', 'sort_order' => 3),
                        array('field_key' => 'population', 'label' => 'Approximate Population',     'field_type' => 'text', 'sort_order' => 4),
                        array('field_key' => 'military',   'label' => 'Dominant Military / Guard', 'field_type' => 'text', 'sort_order' => 5),
                        array('field_key' => 'climate',    'label' => 'Climate / Terrain',         'field_type' => 'text', 'sort_order' => 6),
                    );
                } elseif ($type->slug === 'artifacts') {
                    $defs = array(
                        array('field_key' => 'item_class',     'label' => 'Relic Classification',       'field_type' => 'text', 'sort_order' => 1),
                        array('field_key' => 'origin_creator', 'label' => 'Origin / Forged By',         'field_type' => 'text', 'sort_order' => 2),
                        array('field_key' => 'materials',      'label' => 'Materials & Runes',          'field_type' => 'text', 'sort_order' => 3),
                        array('field_key' => 'wielder',        'label' => 'Current Wielder / Bearer',   'field_type' => 'text', 'sort_order' => 4),
                        array('field_key' => 'powers',         'label' => 'Potency / Arcane Properties','field_type' => 'text', 'sort_order' => 5),
                    );
                } elseif ($type->slug === 'events' || $type->slug === 'chronicle') {
                    $defs = array(
                        array('field_key' => 'epoch',        'label' => 'Era / Epoch',            'field_type' => 'text', 'sort_order' => 1),
                        array('field_key' => 'event_date',   'label' => 'Recorded Date',          'field_type' => 'text', 'sort_order' => 2),
                        array('field_key' => 'participants', 'label' => 'Key Figures & Factions', 'field_type' => 'text', 'sort_order' => 3),
                        array('field_key' => 'outcome',      'label' => 'Treaty / Outcome',       'field_type' => 'text', 'sort_order' => 4),
                    );
                } elseif ($type->slug === 'concepts') {
                    $defs = array(
                        array('field_key' => 'sphere',       'label' => 'Cosmic Sphere / Domain',   'field_type' => 'text', 'sort_order' => 1),
                        array('field_key' => 'doctrine',     'label' => 'Core Doctrine / Tenet',    'field_type' => 'text', 'sort_order' => 2),
                        array('field_key' => 'sacred_texts', 'label' => 'Sacred Texts / Treatises', 'field_type' => 'text', 'sort_order' => 3),
                    );
                } elseif ($type->slug === 'orders') {
                    $defs = array(
                        array('field_key' => 'grandmaster', 'label' => 'Grandmaster / Leader', 'field_type' => 'text', 'sort_order' => 1),
                        array('field_key' => 'sanctum',     'label' => 'Primary Sanctum',      'field_type' => 'text', 'sort_order' => 2),
                        array('field_key' => 'doctrine',    'label' => 'Order Creed / Vow',    'field_type' => 'text', 'sort_order' => 3),
                    );
                } elseif ($type->slug === 'species' || $type->slug === 'bestiary') {
                    $defs = array(
                        array('field_key' => 'classification', 'label' => 'Classification / Biology', 'field_type' => 'text', 'sort_order' => 1),
                        array('field_key' => 'habitat',        'label' => 'Primary Habitat',          'field_type' => 'text', 'sort_order' => 2),
                        array('field_key' => 'threat_level',   'label' => 'Threat / Disposition',     'field_type' => 'text', 'sort_order' => 3),
                    );
                } elseif ($type->slug === 'locations') {
                    $defs = array(
                        array('field_key' => 'region',              'label' => 'Surrounding Region',  'field_type' => 'text', 'sort_order' => 1),
                        array('field_key' => 'terrain',             'label' => 'Terrain & Climate',   'field_type' => 'text', 'sort_order' => 2),
                        array('field_key' => 'controlling_faction', 'label' => 'Controlling Faction', 'field_type' => 'text', 'sort_order' => 3),
                        array('field_key' => 'danger_level',        'label' => 'Wards / Hazards',     'field_type' => 'text', 'sort_order' => 4),
                    );
                } elseif ($type->slug === 'magic') {
                    $defs = array(
                        array('field_key' => 'source',        'label' => 'Source of Power',      'field_type' => 'text', 'sort_order' => 1),
                        array('field_key' => 'practitioners', 'label' => 'Covenant / Weavers',   'field_type' => 'text', 'sort_order' => 2),
                        array('field_key' => 'taboos',        'label' => 'Limitations & Taboos', 'field_type' => 'text', 'sort_order' => 3),
                    );
                } else {
                    $defs = array(
                        array('field_key' => 'origin', 'label' => 'Origin / Creator', 'field_type' => 'text', 'sort_order' => 1),
                        array('field_key' => 'powers', 'label' => 'Potency / Class',   'field_type' => 'text', 'sort_order' => 2),
                    );
                }

                foreach ($defs as $d) {
                    $this->db->insert('property_definitions', array(
                        'entry_type_id' => $type->id,
                        'field_key'     => $d['field_key'],
                        'label'         => $d['label'],
                        'field_type'    => $d['field_type'],
                        'sort_order'    => $d['sort_order'],
                        'created_at'    => date('Y-m-d H:i:s'),
                        'updated_at'    => date('Y-m-d H:i:s'),
                    ));
                }
            }
        }
    }

    private function make_unique_slug($world_id, $base_slug)
    {
        $slug = $base_slug;
        $counter = 1;
        while ($this->db->where(array('world_id' => $world_id, 'slug' => $slug))->count_all_results('entries') > 0) {
            $slug = $base_slug . '-' . $counter;
            $counter++;
        }
        return $slug;
    }

    private function generate_uuid()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}
