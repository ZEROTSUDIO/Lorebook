<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ============================================================================
 * LOREKEEPER // SEED VAULT CONTROLLER & RUNNER
 * ============================================================================
 * 
 * Provides an archival interface to browse, inspect, and execute world data
 * seeders across the 6 lore layers (Settings, Archetypes, Bio Data, Prose,
 * Directed Relationships, and Signed-Year Fictional Timelines).
 */
class Seed extends CI_Controller {

    private $available_seeders = array(
        'Canaan_saga1_seeder'     => 'Canaan_saga1_seeder.php',
        'Canaan_expansion_seeder' => 'Canaan_expansion_seeder.php',
        'Cyberpunk_seeder'        => 'Cyberpunk_seeder.php',
        'Aethelgard_seeder'       => 'Aethelgard_seeder.php',
        'World_seeder_template'   => 'World_seeder_template.php',
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->ensure_session_user();
    }

    /**
     * Seed Vault Catalog: Inspect available lore seed templates
     */
    public function index()
    {
        $world_id = $this->session->userdata('active_world_id');
        $active_world = $world_id ? $this->db->get_where('worlds', array('id' => $world_id))->row() : $this->db->get('worlds')->row();

        $templates = array();

        foreach ($this->available_seeders as $class_name => $file_name) {
            $file_path = APPPATH . 'seeds/' . $file_name;
            if (file_exists($file_path)) {
                require_once $file_path;
                if (class_exists($class_name)) {
                    $meta = method_exists($class_name, 'get_meta') ? $class_name::get_meta() : array();
                    $world_meta = method_exists($class_name, 'get_world_meta') ? $class_name::get_world_meta() : array();
                    $entries = method_exists($class_name, 'get_entries') ? $class_name::get_entries() : array();
                    $relationships = method_exists($class_name, 'get_relationships') ? $class_name::get_relationships() : array();
                    $timeline = method_exists($class_name, 'get_timeline_events') ? $class_name::get_timeline_events() : array();

                    // Count entries per archetype
                    $archetype_counts = array();
                    foreach ($entries as $e) {
                        $arc = isset($e['archetype']) ? $e['archetype'] : 'concepts';
                        if (!isset($archetype_counts[$arc])) {
                            $archetype_counts[$arc] = 0;
                        }
                        $archetype_counts[$arc]++;
                    }

                    $target_slug = isset($meta['target_world_slug']) ? $meta['target_world_slug'] : (isset($world_meta['slug']) ? $world_meta['slug'] : 'canaan');
                    $existing_world = $this->db->get_where('worlds', array('slug' => $target_slug))->row();

                    $templates[] = array(
                        'key'              => $class_name,
                        'file_name'        => $file_name,
                        'name'             => isset($meta['name']) ? $meta['name'] : (isset($world_meta['name']) ? $world_meta['name'] : $class_name),
                        'description'      => isset($meta['description']) ? $meta['description'] : (isset($world_meta['description']) ? $world_meta['description'] : ''),
                        'category'         => isset($meta['category']) ? $meta['category'] : 'World Seeder',
                        'target_slug'      => $target_slug,
                        'target_exists'    => $existing_world ? TRUE : FALSE,
                        'existing_world'   => $existing_world,
                        'entry_count'      => count($entries),
                        'archetype_counts' => $archetype_counts,
                        'relation_count'   => count($relationships),
                        'timeline_count'   => count($timeline),
                    );
                }
            }
        }

        $user_id = $this->session->userdata('user_id');
        $current_user = $user_id ? $this->db->get_where('users', array('id' => $user_id))->row() : $this->db->get('users')->row();

        $data = array(
            'page_title'     => 'Seed Vault & World Templates',
            'header_title'   => 'Seed Vault',
            'sub_heading'    => 'TABULA GENESIS // DATA SEEDER BLUEPRINTS',
            'header_caption' => 'Pre-configured World Templates, 9-Archetype Expansions, and Relational Matrices',
            'active_tab'     => 'seed',
            'active_world'   => $active_world,
            'current_user'   => $current_user,
            'templates'      => $templates,
            'content_view'   => 'seed/index',
        );

        $this->load->view('layouts/main', $data);
    }

    /**
     * Execute a specific data seeder safely and idempotently
     */
    public function run($seeder_key = '')
    {
        $seeder_key = trim((string)$seeder_key);
        if (!isset($this->available_seeders[$seeder_key])) {
            if (is_cli()) {
                echo "Error: Invalid or unapproved seeder specified: {$seeder_key}\n";
                return;
            }
            $this->session->set_flashdata('error_msg', 'Invalid or unapproved seeder specified.');
            redirect('seed');
            return;
        }

        $file_path = APPPATH . 'seeds/' . $this->available_seeders[$seeder_key];
        if (!file_exists($file_path)) {
            if (is_cli()) {
                echo "Error: Seeder file not found: {$file_path}\n";
                return;
            }
            $this->session->set_flashdata('error_msg', 'Seeder file not found: ' . htmlspecialchars($this->available_seeders[$seeder_key]));
            redirect('seed');
            return;
        }

        require_once $file_path;
        if (!class_exists($seeder_key)) {
            if (is_cli()) {
                echo "Error: Seeder class definition not found: {$seeder_key}\n";
                return;
            }
            $this->session->set_flashdata('error_msg', 'Seeder class definition not found.');
            redirect('seed');
            return;
        }

        $user_id = $this->session->userdata('user_id') ?: 1;

        $meta = method_exists($seeder_key, 'get_meta') ? $seeder_key::get_meta() : array();
        $world_meta = method_exists($seeder_key, 'get_world_meta') ? $seeder_key::get_world_meta() : array();
        $entries = method_exists($seeder_key, 'get_entries') ? $seeder_key::get_entries() : array();
        $relationships = method_exists($seeder_key, 'get_relationships') ? $seeder_key::get_relationships() : array();
        $timeline = method_exists($seeder_key, 'get_timeline_events') ? $seeder_key::get_timeline_events() : array();

        $target_slug = isset($meta['target_world_slug']) ? $meta['target_world_slug'] : (isset($world_meta['slug']) ? $world_meta['slug'] : 'canaan');

        $this->db->trans_start();

        // 1. Resolve or Create Target World
        $world = $this->db->get_where('worlds', array('slug' => $target_slug))->row();
        $created_world = false;

        if (!$world) {
            $world_data = array(
                'public_id'   => $this->generate_uuid(),
                'owner_id'    => $user_id,
                'name'        => isset($world_meta['name']) ? $world_meta['name'] : ucfirst($target_slug),
                'slug'        => $target_slug,
                'visibility'  => isset($world_meta['visibility']) ? $world_meta['visibility'] : 'private',
                'description' => isset($world_meta['description']) ? $world_meta['description'] : '',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            );
            $this->db->insert('worlds', $world_data);
            $world_id = $this->db->insert_id();

            $this->db->insert('world_members', array(
                'world_id'   => $world_id,
                'user_id'    => $user_id,
                'role'       => 'owner',
                'created_at' => date('Y-m-d H:i:s'),
            ));

            $world = $this->db->get_where('worlds', array('id' => $world_id))->row();
            $created_world = true;
        } else {
            $world_id = $world->id;
            if (!empty($world_meta['description']) || !empty($world_meta['name'])) {
                $world_update = array('updated_at' => date('Y-m-d H:i:s'));
                if (!empty($world_meta['name'])) $world_update['name'] = $world_meta['name'];
                if (!empty($world_meta['description'])) $world_update['description'] = $world_meta['description'];
                $this->db->where('id', $world_id)->update('worlds', $world_update);
                $world = $this->db->get_where('worlds', array('id' => $world_id))->row();
            }
        }

        // Set as active world in session
        $this->session->set_userdata('active_world_id', $world_id);

        // 2. Ensure all 9 Archetype Entry Types exist for this world
        $this->ensure_world_entry_types($world_id);

        // 3. Save World Compendium Settings & Pillars if available
        if (!empty($world_meta)) {
            $compendium_keys = array(
                'compendium_annals_label', 'compendium_history_p1', 'compendium_history_p2',
                'pillar_1_label', 'pillar_1_title', 'pillar_1_body',
                'pillar_2_label', 'pillar_2_title', 'pillar_2_body',
                'pillar_3_label', 'pillar_3_title', 'pillar_3_body',
                'dominant_seat', 'calendar_system', 'current_cycle', 'realm_status',
                'map_plate_label', 'map_plate_file', 'map_node_1', 'map_node_2', 'map_node_3',
                'arch_etching_title', 'arch_etching_caption'
            );

            foreach ($compendium_keys as $ck) {
                if (isset($world_meta[$ck])) {
                    $this->upsert_setting($world_id, $ck, $world_meta[$ck]);
                }
            }
        }

        // 4. Inscribe / Upsert Entries & Structured Properties
        $inscribed_count = 0;
        $updated_count = 0;

        foreach ($entries as $e) {
            $archetype_slug = isset($e['archetype']) ? $e['archetype'] : 'concepts';
            
            // Map common archetype synonyms to canonical slugs
            $target_types = array($archetype_slug);
            if ($archetype_slug === 'characters') $target_types[] = 'persons';
            if ($archetype_slug === 'nations')    $target_types[] = 'realms';
            if ($archetype_slug === 'events')     $target_types[] = 'chronicle';
            if ($archetype_slug === 'species')    $target_types[] = 'bestiary';

            $entry_type = $this->db->where('world_id', $world_id)->where_in('slug', $target_types)->get('entry_types')->row();
            if (!$entry_type) {
                $entry_type = $this->db->get_where('entry_types', array('world_id' => $world_id, 'sort_order' => 1))->row();
            }

            $existing_entry = $this->db->get_where('entries', array('world_id' => $world_id, 'slug' => $e['slug']))->row();

            if (!$existing_entry) {
                $entry_record = array(
                    'public_id'        => $this->generate_uuid(),
                    'world_id'         => $world_id,
                    'entry_type_id'    => $entry_type->id,
                    'title'            => $e['title'],
                    'slug'             => $e['slug'],
                    'summary'          => isset($e['summary']) ? $e['summary'] : '',
                    'content_markdown' => isset($e['content_markdown']) ? $e['content_markdown'] : '',
                    'status'           => isset($e['status']) ? $e['status'] : 'canon',
                    'cover_image'      => isset($e['cover_image']) ? $e['cover_image'] : '',
                    'is_archived'      => 0,
                    'created_by'       => $user_id,
                    'updated_by'       => $user_id,
                    'created_at'       => date('Y-m-d H:i:s'),
                    'updated_at'       => date('Y-m-d H:i:s'),
                );
                $this->db->insert('entries', $entry_record);
                $entry_id = $this->db->insert_id();
                $inscribed_count++;
            } else {
                $entry_id = $existing_entry->id;
                $this->db->where('id', $entry_id)->update('entries', array(
                    'title'            => $e['title'],
                    'summary'          => isset($e['summary']) ? $e['summary'] : $existing_entry->summary,
                    'content_markdown' => isset($e['content_markdown']) ? $e['content_markdown'] : $existing_entry->content_markdown,
                    'status'           => isset($e['status']) ? $e['status'] : $existing_entry->status,
                    'cover_image'      => isset($e['cover_image']) ? $e['cover_image'] : $existing_entry->cover_image,
                    'updated_at'       => date('Y-m-d H:i:s'),
                ));
                $updated_count++;
            }

            // Assign Tags
            if (!empty($e['tags'])) {
                foreach ($e['tags'] as $tag_name) {
                    $tag_slug = url_title($tag_name, '-', TRUE);
                    $tag_row = $this->db->get_where('tags', array('world_id' => $world_id, 'slug' => $tag_slug))->row();
                    if (!$tag_row) {
                        $this->db->insert('tags', array(
                            'world_id'   => $world_id,
                            'name'       => ucwords(str_replace('-', ' ', $tag_name)),
                            'slug'       => $tag_slug,
                            'created_at' => date('Y-m-d H:i:s'),
                        ));
                        $tag_id = $this->db->insert_id();
                    } else {
                        $tag_id = $tag_row->id;
                    }

                    $has_tag = $this->db->get_where('entry_tags', array('entry_id' => $entry_id, 'tag_id' => $tag_id))->row();
                    if (!$has_tag) {
                        $this->db->insert('entry_tags', array(
                            'entry_id' => $entry_id,
                            'tag_id'   => $tag_id,
                        ));
                    }
                }
            }

            // Upsert Structured Bio / Properties
            if (!empty($e['properties']) && is_array($e['properties'])) {
                foreach ($e['properties'] as $field_key => $val) {
                    $def = $this->db->get_where('property_definitions', array(
                        'entry_type_id' => $entry_type->id,
                        'field_key'     => $field_key,
                    ))->row();

                    if (!$def) {
                        $this->db->insert('property_definitions', array(
                            'entry_type_id' => $entry_type->id,
                            'field_key'     => $field_key,
                            'label'         => ucwords(str_replace('_', ' ', $field_key)),
                            'field_type'    => 'text',
                            'sort_order'    => 10,
                            'created_at'    => date('Y-m-d H:i:s'),
                            'updated_at'    => date('Y-m-d H:i:s'),
                        ));
                        $def_id = $this->db->insert_id();
                    } else {
                        $def_id = $def->id;
                    }

                    $val_row = $this->db->get_where('property_values', array(
                        'entry_id'               => $entry_id,
                        'property_definition_id' => $def_id,
                    ))->row();

                    if (!$val_row) {
                        $this->db->insert('property_values', array(
                            'entry_id'               => $entry_id,
                            'property_definition_id' => $def_id,
                            'value_text'             => (string)$val,
                            'created_at'             => date('Y-m-d H:i:s'),
                            'updated_at'             => date('Y-m-d H:i:s'),
                        ));
                    } else {
                        $this->db->where('id', $val_row->id)->update('property_values', array(
                            'value_text' => (string)$val,
                            'updated_at' => date('Y-m-d H:i:s'),
                        ));
                    }
                }
            }
        }

        // 5. Inscribe Directed Relationship Matrix Bonds
        $bonds_seeded = 0;
        foreach ($relationships as $rel) {
            $src = $this->db->get_where('entries', array('world_id' => $world_id, 'slug' => $rel['source']))->row();
            $tgt = $this->db->get_where('entries', array('world_id' => $world_id, 'slug' => $rel['target']))->row();

            if ($src && $tgt) {
                $has_rel = $this->db->get_where('entry_relationships', array(
                    'world_id'          => $world_id,
                    'source_entry_id'   => $src->id,
                    'target_entry_id'   => $tgt->id,
                    'relationship_type' => $rel['type'],
                ))->row();

                if (!$has_rel) {
                    $this->db->insert('entry_relationships', array(
                        'world_id'          => $world_id,
                        'source_entry_id'   => $src->id,
                        'target_entry_id'   => $tgt->id,
                        'relationship_type' => $rel['type'],
                        'inverse_label'     => isset($rel['inverse']) ? $rel['inverse'] : NULL,
                        'description'       => isset($rel['description']) ? $rel['description'] : NULL,
                        'created_at'        => date('Y-m-d H:i:s'),
                        'updated_at'        => date('Y-m-d H:i:s'),
                    ));
                    $bonds_seeded++;
                }
            }
        }

        // 6. Inscribe Fictional Calendar Timeline Events
        $timeline_seeded = 0;
        foreach ($timeline as $t_ev) {
            $t_entry = !empty($t_ev['entry_slug']) ? $this->db->get_where('entries', array('world_id' => $world_id, 'slug' => $t_ev['entry_slug']))->row() : NULL;
            
            $has_ev = $this->db->get_where('timeline_events', array(
                'world_id' => $world_id,
                'title'    => $t_ev['title'],
            ))->row();

            if (!$has_ev) {
                $this->db->insert('timeline_events', array(
                    'world_id'       => $world_id,
                    'entry_id'       => $t_entry ? $t_entry->id : NULL,
                    'title'          => $t_ev['title'],
                    'era'            => isset($t_ev['era']) ? $t_ev['era'] : 'Imperial Epoch',
                    'event_date'     => $t_ev['event_date'],
                    'sort_year'      => isset($t_ev['sort_year']) ? (int)$t_ev['sort_year'] : 0,
                    'end_year'       => isset($t_ev['end_year']) ? (int)$t_ev['end_year'] : NULL,
                    'is_approximate' => !empty($t_ev['is_approximate']) ? 1 : 0,
                    'sort_order'     => isset($t_ev['sort_order']) ? (int)$t_ev['sort_order'] : 10,
                    'summary'        => isset($t_ev['summary']) ? $t_ev['summary'] : '',
                    'created_at'     => date('Y-m-d H:i:s'),
                    'updated_at'     => date('Y-m-d H:i:s'),
                ));
                $timeline_seeded++;
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            if (is_cli()) {
                echo "Error: Database transaction failed during seeding of {$seeder_key}\n";
                return;
            }
            $this->session->set_flashdata('error_msg', 'Database transaction failed during seeding of ' . $seeder_key);
            redirect('seed');
            return;
        }

        $realm_name = $world->name;
        $msg = "Seeder \"{$seeder_key}\" executed successfully for realm \"{$realm_name}\"! Inscribed {$inscribed_count} new entries, {$bonds_seeded} directed bonds, and {$timeline_seeded} timeline events.";
        if (is_cli()) {
            echo "SUCCESS: {$msg}\n";
            return;
        }
        $this->session->set_flashdata('success_msg', $msg);

        redirect('dashboard');
    }

    private function ensure_world_entry_types($world_id)
    {
        $types = array(
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

        foreach ($types as $t) {
            $exists = $this->db->get_where('entry_types', array('world_id' => $world_id, 'slug' => $t['slug']))->row();
            if (!$exists) {
                $this->db->insert('entry_types', array(
                    'world_id'    => $world_id,
                    'name'        => $t['name'],
                    'slug'        => $t['slug'],
                    'icon'        => $t['icon'],
                    'is_system'   => 1,
                    'sort_order'  => $t['sort_order'],
                    'created_at'  => date('Y-m-d H:i:s'),
                    'updated_at'  => date('Y-m-d H:i:s'),
                ));
            }
        }
    }

    private function upsert_setting($world_id, $key, $value)
    {
        $existing = $this->db->get_where('app_settings', array('world_id' => $world_id, 'setting_key' => $key))->row();
        if ($existing) {
            $this->db->where('id', $existing->id)->update('app_settings', array(
                'setting_value' => (string)$value,
                'updated_at'    => date('Y-m-d H:i:s'),
            ));
        } else {
            $this->db->insert('app_settings', array(
                'world_id'      => $world_id,
                'setting_key'   => $key,
                'setting_value' => (string)$value,
                'updated_at'    => date('Y-m-d H:i:s'),
            ));
        }
    }

    private function ensure_session_user()
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            $user = $this->db->get('users')->row();
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
