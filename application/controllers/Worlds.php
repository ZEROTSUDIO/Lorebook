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

                // Provision the 9 Archetype Entry Types for the new realm
                $default_types = array(
                    array('name' => 'Personae & Bloodlines', 'slug' => 'characters', 'icon' => 'user', 'sort_order' => 1),
                    array('name' => 'Realms & Sovereign Nations', 'slug' => 'nations', 'icon' => 'map-pin', 'sort_order' => 2),
                    array('name' => 'Reliquary & Sacred Armaments', 'slug' => 'artifacts', 'icon' => 'gem', 'sort_order' => 3),
                    array('name' => 'Annals of Great Epochs', 'slug' => 'events', 'icon' => 'history', 'sort_order' => 4),
                    array('name' => 'Arcana, Doctrines & Lore', 'slug' => 'concepts', 'icon' => 'book-open', 'sort_order' => 5),
                    array('name' => 'Synod of Guilds & Orders', 'slug' => 'orders', 'icon' => 'shield', 'sort_order' => 6),
                    array('name' => 'Bestiary of Primal Beasts', 'slug' => 'species', 'icon' => 'feather', 'sort_order' => 7),
                    array('name' => 'Landmarks, Sites & Ruins', 'slug' => 'locations', 'icon' => 'compass', 'sort_order' => 8),
                    array('name' => 'Codex of Arcane Arts', 'slug' => 'magic', 'icon' => 'zap', 'sort_order' => 9),
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
        if ($slug === 'characters' || $slug === 'persons') {
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
        } elseif ($slug === 'nations' || $slug === 'realms') {
            $defs = array(
                array('field_key' => 'government', 'label' => 'Government Type',           'field_type' => 'text', 'sort_order' => 1),
                array('field_key' => 'ruler',      'label' => 'Current Sovereign / Ruler', 'field_type' => 'text', 'sort_order' => 2),
                array('field_key' => 'capital',    'label' => 'Seat of Power / Capital',   'field_type' => 'text', 'sort_order' => 3),
                array('field_key' => 'population', 'label' => 'Approximate Population',     'field_type' => 'text', 'sort_order' => 4),
                array('field_key' => 'military',   'label' => 'Dominant Military / Guard', 'field_type' => 'text', 'sort_order' => 5),
                array('field_key' => 'climate',    'label' => 'Climate / Terrain',         'field_type' => 'text', 'sort_order' => 6),
            );
        } elseif ($slug === 'artifacts') {
            $defs = array(
                array('field_key' => 'item_class',     'label' => 'Relic Classification',       'field_type' => 'text', 'sort_order' => 1),
                array('field_key' => 'origin_creator', 'label' => 'Origin / Forged By',         'field_type' => 'text', 'sort_order' => 2),
                array('field_key' => 'materials',      'label' => 'Materials & Runes',          'field_type' => 'text', 'sort_order' => 3),
                array('field_key' => 'wielder',        'label' => 'Current Wielder / Bearer',   'field_type' => 'text', 'sort_order' => 4),
                array('field_key' => 'powers',         'label' => 'Potency / Arcane Properties','field_type' => 'text', 'sort_order' => 5),
            );
        } elseif ($slug === 'events' || $slug === 'chronicle') {
            $defs = array(
                array('field_key' => 'epoch',        'label' => 'Era / Epoch',            'field_type' => 'text', 'sort_order' => 1),
                array('field_key' => 'event_date',   'label' => 'Recorded Date',          'field_type' => 'text', 'sort_order' => 2),
                array('field_key' => 'participants', 'label' => 'Key Figures & Factions', 'field_type' => 'text', 'sort_order' => 3),
                array('field_key' => 'outcome',      'label' => 'Treaty / Outcome',       'field_type' => 'text', 'sort_order' => 4),
            );
        } elseif ($slug === 'concepts') {
            $defs = array(
                array('field_key' => 'sphere',       'label' => 'Cosmic Sphere / Domain',   'field_type' => 'text', 'sort_order' => 1),
                array('field_key' => 'doctrine',     'label' => 'Core Doctrine / Tenet',    'field_type' => 'text', 'sort_order' => 2),
                array('field_key' => 'sacred_texts', 'label' => 'Sacred Texts / Treatises', 'field_type' => 'text', 'sort_order' => 3),
            );
        } elseif ($slug === 'orders') {
            $defs = array(
                array('field_key' => 'grandmaster', 'label' => 'Grandmaster / Leader', 'field_type' => 'text', 'sort_order' => 1),
                array('field_key' => 'sanctum',     'label' => 'Primary Sanctum',      'field_type' => 'text', 'sort_order' => 2),
                array('field_key' => 'doctrine',    'label' => 'Order Creed / Vow',    'field_type' => 'text', 'sort_order' => 3),
            );
        } elseif ($slug === 'species' || $slug === 'bestiary') {
            $defs = array(
                array('field_key' => 'classification', 'label' => 'Classification / Biology', 'field_type' => 'text', 'sort_order' => 1),
                array('field_key' => 'habitat',        'label' => 'Primary Habitat',          'field_type' => 'text', 'sort_order' => 2),
                array('field_key' => 'threat_level',   'label' => 'Threat / Disposition',     'field_type' => 'text', 'sort_order' => 3),
            );
        } elseif ($slug === 'locations') {
            $defs = array(
                array('field_key' => 'region',              'label' => 'Surrounding Region',  'field_type' => 'text', 'sort_order' => 1),
                array('field_key' => 'terrain',             'label' => 'Terrain & Climate',   'field_type' => 'text', 'sort_order' => 2),
                array('field_key' => 'controlling_faction', 'label' => 'Controlling Faction', 'field_type' => 'text', 'sort_order' => 3),
                array('field_key' => 'danger_level',        'label' => 'Wards / Hazards',     'field_type' => 'text', 'sort_order' => 4),
            );
        } elseif ($slug === 'magic') {
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
