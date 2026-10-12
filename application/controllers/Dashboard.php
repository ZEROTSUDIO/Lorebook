<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->ensure_initial_world();
    }

    public function index()
    {
        // 1. Get active world
        $world_id = $this->session->userdata('active_world_id');
        $active_world = $this->db->get_where('worlds', array('id' => $world_id))->row();
        
        if (!$active_world) {
            $active_world = $this->db->get('worlds')->row();
            if ($active_world) {
                $this->session->set_userdata('active_world_id', $active_world->id);
            }
        }

        // 2. Fetch live stats for active world
        $total_entries = 0;
        $canon_count = 0;
        $draft_count = 0;

        if ($active_world) {
            $total_entries = $this->db->where('world_id', $active_world->id)->count_all_results('entries');
            $canon_count = $this->db->where(array('world_id' => $active_world->id, 'status' => 'canon'))->count_all_results('entries');
            $draft_count = $this->db->where(array('world_id' => $active_world->id, 'status' => 'draft'))->count_all_results('entries');
        }

        // 3. Prepare data for layout and view
        $data = array(
            'page_title'     => 'The Field Journal',
            'header_title'   => 'The Field Journal',
            'sub_heading'    => 'LIBER PERSONARUM // CHRONICLES OF CANAAN',
            'header_caption' => 'Imperial Vault of Recorded Histories · Scribe Dossier 014',
            'active_tab'     => 'dashboard',
            'active_world'   => $active_world,
            'current_cycle'  => '842 2A',
            'total_entries'  => ($total_entries > 0) ? $total_entries : 142,
            'canon_count'    => ($canon_count > 0) ? $canon_count : 128,
            'draft_count'    => ($draft_count > 0) ? $draft_count : 14,
            'content_view'   => 'dashboard/index',
        );

        // 4. Load master layout
        $this->load->view('layouts/main', $data);
    }

    /**
     * Auto-seeds initial admin user & test world Canaan if empty
     */
    private function ensure_initial_world()
    {
        // Check if users table is empty
        $user_count = $this->db->count_all('users');
        $admin_id = 1;

        if ($user_count === 0) {
            $user_data = array(
                'public_id'     => $this->generate_uuid(),
                'username'      => 'weng',
                'email'         => 'weng@zerotsudio.com',
                'password_hash' => password_hash('lorekeeper', PASSWORD_DEFAULT),
                'display_name'  => 'Scribe Weng',
                'role'          => 'admin',
                'is_active'     => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            );
            $this->db->insert('users', $user_data);
            $admin_id = $this->db->insert_id();
        }

        // Check if worlds table is empty
        $world_count = $this->db->count_all('worlds');
        if ($world_count === 0) {
            $world_data = array(
                'public_id'   => $this->generate_uuid(),
                'owner_id'    => $admin_id,
                'name'        => 'Canaan',
                'slug'        => 'canaan',
                'visibility'  => 'private',
                'description' => 'The shattered northern continent of ancient clans, high keeps, and frozen covenants.',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            );
            $this->db->insert('worlds', $world_data);
            $world_id = $this->db->insert_id();

            // Insert world membership for owner
            $this->db->insert('world_members', array(
                'world_id'   => $world_id,
                'user_id'    => $admin_id,
                'role'       => 'owner',
                'created_at' => date('Y-m-d H:i:s'),
            ));

            // Seed default entry types for Canaan
            $default_types = array(
                array('name' => 'Persons & Clans', 'slug' => 'persons', 'icon' => 'user', 'sort_order' => 1),
                array('name' => 'Realms & Seats', 'slug' => 'realms', 'icon' => 'map-pin', 'sort_order' => 2),
                array('name' => 'Sacred Orders', 'slug' => 'orders', 'icon' => 'shield', 'sort_order' => 3),
                array('name' => 'Bestiary & Relics', 'slug' => 'bestiary', 'icon' => 'gem', 'sort_order' => 4),
                array('name' => 'Chronicle & Eras', 'slug' => 'chronicle', 'icon' => 'history', 'sort_order' => 5),
            );

            foreach ($default_types as $t) {
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

            $this->session->set_userdata('active_world_id', $world_id);
            $this->session->set_userdata('user_id', $admin_id);
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
