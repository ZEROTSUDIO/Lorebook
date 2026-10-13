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

        // 2. Fetch live stats and recent entries for active world
        $total_entries = 0;
        $canon_count = 0;
        $draft_count = 0;
        $recent_entries = array();
        $featured_entry = null;

        if ($active_world) {
            $total_entries = $this->db->where('world_id', $active_world->id)->count_all_results('entries');
            $canon_count = $this->db->where(array('world_id' => $active_world->id, 'status' => 'canon'))->count_all_results('entries');
            $draft_count = $this->db->where(array('world_id' => $active_world->id, 'status' => 'draft'))->count_all_results('entries');

            $this->db->select('entries.*, entry_types.name as type_name, entry_types.slug as type_slug');
            $this->db->from('entries');
            $this->db->join('entry_types', 'entry_types.id = entries.entry_type_id', 'left');
            $this->db->where('entries.world_id', $active_world->id);
            $this->db->where('entries.is_archived', 0);
            $this->db->order_by('entries.updated_at', 'DESC');
            $this->db->limit(6);
            $recent_entries = $this->db->get()->result();

            if (!empty($recent_entries)) {
                $featured_entry = $recent_entries[0];
            }
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
            'total_entries'  => $total_entries,
            'canon_count'    => $canon_count,
            'draft_count'    => $draft_count,
            'recent_entries' => $recent_entries,
            'featured_entry' => $featured_entry,
            'content_view'   => 'dashboard/index',
        );

        // 4. Load master layout
        $this->load->view('layouts/main', $data);
    }

    /**
     * Auto-seeds initial admin user, test world Canaan, and sample entries if empty
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
        } else {
            $first_user = $this->db->get('users')->row();
            $admin_id = $first_user ? $first_user->id : 1;
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

        // Seed initial sample entries if entries table is empty
        if ($this->db->count_all('entries') === 0) {
            $world = $this->db->get('worlds')->row();
            if ($world) {
                $type_persons = $this->db->get_where('entry_types', array('world_id' => $world->id, 'slug' => 'persons'))->row();
                $type_realms  = $this->db->get_where('entry_types', array('world_id' => $world->id, 'slug' => 'realms'))->row();
                $type_orders  = $this->db->get_where('entry_types', array('world_id' => $world->id, 'slug' => 'orders'))->row();

                if ($type_persons) {
                    $this->db->insert('entries', array(
                        'public_id'        => $this->generate_uuid(),
                        'world_id'         => $world->id,
                        'entry_type_id'    => $type_persons->id,
                        'title'            => 'Ilsabet Voss',
                        'slug'             => 'ilsabet-voss',
                        'summary'          => 'The Lamplighter of Canaan, bearer of the Censer of the North across the Iron Pass.',
                        'content_markdown' => "Before the third bell of the winter solstice had finished echoing over the crags, the torches of the Draugar cohort appeared upon the crest. Ilsabet stood at the precipice, censer in hand, watching the white frost creep over the iron stones. It was whispered among the high priests of the Keep that no mortal fire could endure the breath of the Northern Pass, yet her lamp burned with an unflickering pale amber flame.\n\nThe chronicles record little of what passed between the Lamplighter and the Wardens at the Gate. What remains certain is that by daybreak, the ancient wards were rekindled, and the road to the valley of Valoria lay open once more.",
                        'status'           => 'canon',
                        'cover_image'      => 'ILSABET_VOSS_PORTRAIT.WEBP',
                        'is_archived'      => 0,
                        'created_by'       => $admin_id,
                        'updated_by'       => $admin_id,
                        'created_at'       => date('Y-m-d H:i:s'),
                        'updated_at'       => date('Y-m-d H:i:s'),
                    ));

                    $this->db->insert('entries', array(
                        'public_id'        => $this->generate_uuid(),
                        'world_id'         => $world->id,
                        'entry_type_id'    => $type_persons->id,
                        'title'            => 'Kaelen Ward',
                        'slug'             => 'kaelen-ward',
                        'summary'          => 'First Scout of the Border Watch and sworn cohort ally to the Draugar bloodline.',
                        'content_markdown' => "Kaelen Ward served nineteen winters along the Frost-Veil frontier before taking the oath of the Lamplighter's vanguard. Armed with a recurve ash bow and an encyclopedic memory of the northern passes, he mapped the three hidden Approaches that prevented the ambush at Red Gorge.",
                        'status'           => 'canon',
                        'cover_image'      => 'KAELEN_WARD_PORTRAIT.WEBP',
                        'is_archived'      => 0,
                        'created_by'       => $admin_id,
                        'updated_by'       => $admin_id,
                        'created_at'       => date('Y-m-d H:i:s'),
                        'updated_at'       => date('Y-m-d H:i:s'),
                    ));
                }

                if ($type_realms) {
                    $this->db->insert('entries', array(
                        'public_id'        => $this->generate_uuid(),
                        'world_id'         => $world->id,
                        'entry_type_id'    => $type_realms->id,
                        'title'            => 'The Frost Keep',
                        'slug'             => 'the-frost-keep',
                        'summary'          => 'Ancient bastion of the Northern Highlands carved into the basalt cliffs above the Iron Pass.',
                        'content_markdown' => "Built during the First Age of Stone, the Frost Keep stands as the northernmost sanctuary in Canaan. Its great braziers are fed by subterranean pitch veins that have burned without interruption for four centuries.",
                        'status'           => 'canon',
                        'cover_image'      => 'FROST_KEEP_CITADEL.WEBP',
                        'is_archived'      => 0,
                        'created_by'       => $admin_id,
                        'updated_by'       => $admin_id,
                        'created_at'       => date('Y-m-d H:i:s'),
                        'updated_at'       => date('Y-m-d H:i:s'),
                    ));
                }

                if ($type_orders) {
                    $this->db->insert('entries', array(
                        'public_id'        => $this->generate_uuid(),
                        'world_id'         => $world->id,
                        'entry_type_id'    => $type_orders->id,
                        'title'            => 'Order of the Silver Hand',
                        'slug'             => 'order-of-the-silver-hand',
                        'summary'          => 'Inquisitorial synod charged with cataloging and sealing unsanctioned relics across Canaan.',
                        'content_markdown' => "Led by High Inquisitor Vane, the Order of the Silver Hand operates out of the southern capital. They regard the northern pyromancy traditions with deep suspicion.",
                        'status'           => 'draft',
                        'cover_image'      => 'SILVER_HAND_SIGIL.WEBP',
                        'is_archived'      => 0,
                        'created_by'       => $admin_id,
                        'updated_by'       => $admin_id,
                        'created_at'       => date('Y-m-d H:i:s'),
                        'updated_at'       => date('Y-m-d H:i:s'),
                    ));
                }
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
