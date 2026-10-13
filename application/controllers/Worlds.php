<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Worlds extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('form_validation');
        $this->ensure_user_session();
    }

    /**
     * Switch Active World in Session
     */
    public function switch_world($id)
    {
        $id = (int)$id;
        $world = $this->db->get_where('worlds', array('id' => $id))->row();

        if ($world) {
            $this->session->set_userdata('active_world_id', $world->id);
            $this->session->set_flashdata('success_msg', 'Switched realm focus to ' . $world->name);
        }

        $ref = $this->input->server('HTTP_REFERER');
        if ($ref) {
            redirect($ref);
        } else {
            redirect('dashboard');
        }
    }

    /**
     * Create / Inscribe New World Form & Processing
     */
    public function create()
    {
        $user_id = $this->session->userdata('user_id');
        $current_user = $this->db->get_where('users', array('id' => $user_id))->row();
        $all_worlds = $this->db->order_by('name', 'ASC')->get('worlds')->result();

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name', 'World Name', 'required|trim|max_length[150]');
            $this->form_validation->set_rules('description', 'Description', 'trim');

            if ($this->form_validation->run() === TRUE) {
                $name = $this->input->post('name', TRUE);
                $description = $this->input->post('description', TRUE);
                $visibility = $this->input->post('visibility', TRUE) ?: 'private';

                $base_slug = url_title($name, '-', TRUE);
                $slug = $base_slug;
                $counter = 1;
                while ($this->db->where('slug', $slug)->count_all_results('worlds') > 0) {
                    $slug = $base_slug . '-' . $counter;
                    $counter++;
                }

                $world_data = array(
                    'public_id'   => $this->generate_uuid(),
                    'owner_id'    => $user_id,
                    'name'        => $name,
                    'slug'        => $slug,
                    'visibility'  => $visibility,
                    'description' => $description,
                    'created_at'  => date('Y-m-d H:i:s'),
                    'updated_at'  => date('Y-m-d H:i:s'),
                );

                $this->db->insert('worlds', $world_data);
                $new_world_id = $this->db->insert_id();

                // Assign membership
                $this->db->insert('world_members', array(
                    'world_id'   => $new_world_id,
                    'user_id'    => $user_id,
                    'role'       => 'owner',
                    'created_at' => date('Y-m-d H:i:s'),
                ));

                // Provision the standard 5 Book Tome Entry Types for the new realm
                $default_types = array(
                    array('name' => 'Persons & Clans', 'slug' => 'persons', 'icon' => 'user', 'sort_order' => 1),
                    array('name' => 'Realms & Seats', 'slug' => 'realms', 'icon' => 'map-pin', 'sort_order' => 2),
                    array('name' => 'Sacred Orders', 'slug' => 'orders', 'icon' => 'shield', 'sort_order' => 3),
                    array('name' => 'Bestiary & Relics', 'slug' => 'bestiary', 'icon' => 'gem', 'sort_order' => 4),
                    array('name' => 'Chronicle & Eras', 'slug' => 'chronicle', 'icon' => 'history', 'sort_order' => 5),
                );

                foreach ($default_types as $t) {
                    $this->db->insert('entry_types', array(
                        'world_id'    => $new_world_id,
                        'name'        => $t['name'],
                        'slug'        => $t['slug'],
                        'icon'        => $t['icon'],
                        'is_system'   => 1,
                        'sort_order'  => $t['sort_order'],
                        'created_at'  => date('Y-m-d H:i:s'),
                        'updated_at'  => date('Y-m-d H:i:s'),
                    ));
                    $type_id = $this->db->insert_id();

                    // Seed default property definitions for each type
                    $this->seed_type_properties($type_id, $t['slug']);
                }

                // Seed starter Compendium settings for this new realm
                $compendium_defaults = array(
                    'compendium_annals_label' => 'I. ANNALS OF ' . strtoupper($name),
                    'compendium_history_p1'   => 'The foundations of ' . $name . ' were first forged in the primordial epochs before the written word. Recorded here are the sovereign clans, ancient landmarks, and foundational treaties that bind the realm together.',
                    'compendium_history_p2'   => 'As the eras turn and new dynasties rise, the archivists of ' . $name . ' continue to chronicle each covenant, conflict, and mythic milestone.',
                    'pillar_1_label'          => 'PILLAR I // FOUNDATIONS',
                    'pillar_1_title'          => 'The High Covenant',
                    'pillar_1_body'           => 'The primary mythos or founding treaty that establishes the sovereign identity of ' . $name . '.',
                    'pillar_2_label'          => 'PILLAR II // GEOGRAPHY',
                    'pillar_2_title'          => 'Heart of the Realm',
                    'pillar_2_body'           => 'The central geographic territory, river basin, or mountain pass that anchors the civilization.',
                    'pillar_3_label'          => 'PILLAR III // FACTIONS',
                    'pillar_3_title'          => 'The Great Compact',
                    'pillar_3_body'           => 'The ruling houses, sacred synods, and sworn orders that govern the realm.',
                    'dominant_seat'           => 'Capital Citadel',
                    'calendar_system'         => 'First Era (1E)',
                    'current_cycle'           => 'Cycle 100',
                    'realm_status'            => 'ESTABLISHED',
                    'map_plate_label'         => 'PLATE II // CARTOGRAPHIC SURVEY',
                    'map_plate_file'          => 'MAP_OF_' . strtoupper($slug) . '.WEBP',
                    'map_node_1'              => 'SOVEREIGN SEAT (Capital)',
                    'map_node_2'              => 'BORDER CITADEL (Pass)',
                    'map_node_3'              => 'OUTER PROVINCES',
                    'arch_etching_title'      => 'PLATE III // ARCHITECTURAL ETCHING',
                    'arch_etching_caption'    => 'MONUMENT OF ' . strtoupper($name) . ' (ETCHING_001.WEBP)',
                );

                foreach ($compendium_defaults as $k => $v) {
                    $this->db->insert('app_settings', array(
                        'world_id'      => $new_world_id,
                        'setting_key'   => $k,
                        'setting_value' => $v,
                        'updated_at'    => date('Y-m-d H:i:s'),
                    ));
                }

                // Switch active session to the newly forged realm
                $this->session->set_userdata('active_world_id', $new_world_id);
                $this->session->set_flashdata('success_msg', 'The realm of "' . $name . '" has been inscribed into the Imperial Archives!');
                redirect('dashboard');
                return;
            }
        }

        $active_world_id = $this->session->userdata('active_world_id');
        $active_world = $this->db->get_where('worlds', array('id' => $active_world_id))->row();

        $data = array(
            'page_title'         => 'Inscribe New Realm // World Registry',
            'header_title'       => 'Forge New Realm',
            'sub_heading'        => 'CODEX CREATOR // REALM GENESIS',
            'header_caption'     => 'Found a new canonical continent, universe, or sovereign setting',
            'active_tab'         => 'dashboard',
            'active_world'       => $active_world,
            'current_user'       => $current_user,
            'all_worlds'         => $all_worlds,
            'content_view'       => 'worlds/create',
        );

        $this->load->view('layouts/main', $data);
    }

    private function seed_type_properties($type_id, $slug)
    {
        if ($slug === 'persons') {
            $defs = array(
                array('field_key' => 'origin_seat', 'label' => 'Origin Seat', 'field_type' => 'text', 'sort_order' => 1),
                array('field_key' => 'clan', 'label' => 'Cohort / Clan', 'field_type' => 'text', 'sort_order' => 2),
                array('field_key' => 'aspect', 'label' => 'Arcane Aspect', 'field_type' => 'text', 'sort_order' => 3),
                array('field_key' => 'primary_relic', 'label' => 'Primary Relic', 'field_type' => 'text', 'sort_order' => 4),
            );
        } elseif ($slug === 'realms') {
            $defs = array(
                array('field_key' => 'ruler', 'label' => 'Current Ruler', 'field_type' => 'text', 'sort_order' => 1),
                array('field_key' => 'capital', 'label' => 'Seat of Power', 'field_type' => 'text', 'sort_order' => 2),
                array('field_key' => 'climate', 'label' => 'Climate / Terrain', 'field_type' => 'text', 'sort_order' => 3),
            );
        } else {
            $defs = array(
                array('field_key' => 'origin', 'label' => 'Origin / Creator', 'field_type' => 'text', 'sort_order' => 1),
                array('field_key' => 'powers', 'label' => 'Potency / Class', 'field_type' => 'text', 'sort_order' => 2),
            );
        }

        foreach ($defs as $d) {
            $this->db->insert('property_definitions', array(
                'entry_type_id' => $type_id,
                'field_key'     => $d['field_key'],
                'label'         => $d['label'],
                'field_type'    => $d['field_type'],
                'sort_order'    => $d['sort_order'],
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ));
        }
    }

    private function ensure_user_session()
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            $user = $this->db->get_where('users', array('username' => 'Zerotsu'))->row();
            if (!$user) {
                $user = $this->db->get('users')->row();
            }
            if ($user) {
                $this->session->set_userdata('user_id', $user->id);
            }
        }
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
