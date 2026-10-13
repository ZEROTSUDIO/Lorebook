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

        // 2. Fetch live stats, Tome categories, Featured Spotlight, Recent Entries, and Timeline Events
        $total_entries = 0;
        $canon_count = 0;
        $draft_count = 0;
        $entry_types = array();
        $recent_entries = array();
        $featured_entry = null;
        $featured_props = array();
        $timeline_events = array();
        $world_tags = array();

        if ($active_world) {
            $wid = $active_world->id;

            $total_entries = $this->db->where(array('world_id' => $wid, 'is_archived' => 0))->count_all_results('entries');
            $canon_count   = $this->db->where(array('world_id' => $wid, 'status' => 'canon', 'is_archived' => 0))->count_all_results('entries');
            $draft_count   = $this->db->where(array('world_id' => $wid, 'status' => 'draft', 'is_archived' => 0))->count_all_results('entries');

            // Fetch the 5 Archive Tome Categories with live counts
            $raw_types = $this->db->where('world_id', $wid)->order_by('sort_order', 'ASC')->get('entry_types')->result();
            $tome_meta = array(
                'persons'   => array('tomus' => 'TOMUS I',   'latin' => 'LIBER PERSONARUM',   'desc' => 'Bloodlines, clanwardens, lamplighters, and sworn figures of note.'),
                'realms'    => array('tomus' => 'TOMUS II',  'latin' => 'GAZETTEER OF REALMS', 'desc' => 'High keeps, basalt citadels, frozen passes, and sovereign seats.'),
                'orders'    => array('tomus' => 'TOMUS III', 'latin' => 'SYNOD OF ORDERS',    'desc' => 'Inquisitorial synods, border cohorts, and ancient brotherhoods.'),
                'bestiary'  => array('tomus' => 'TOMUS IV',  'latin' => 'RELIQUARY & BEASTS', 'desc' => 'Sanctified censers, runic arms, relics, and creatures of the veil.'),
                'chronicle' => array('tomus' => 'TOMUS V',   'latin' => 'ANNALS OF THE AGES', 'desc' => 'Recorded wars, solstice covenants, treaties, and mythic epochs.'),
            );

            $vol_idx = 1;
            $romans = array(1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI');
            foreach ($raw_types as $t) {
                $cnt = $this->db->where(array(
                    'world_id'      => $wid,
                    'entry_type_id' => $t->id,
                    'is_archived'   => 0
                ))->count_all_results('entries');
                $t->entry_count = $cnt;
                if (isset($tome_meta[$t->slug])) {
                    $t->tomus = $tome_meta[$t->slug]['tomus'];
                    $t->latin = $tome_meta[$t->slug]['latin'];
                    $t->tome_desc = $tome_meta[$t->slug]['desc'];
                } else {
                    $r = isset($romans[$vol_idx]) ? $romans[$vol_idx] : $vol_idx;
                    $t->tomus = 'TOMUS ' . $r;
                    $t->latin = 'CODEX ARCHIVUM';
                    $t->tome_desc = $t->description ? $t->description : 'Inscribed lore records belonging to this volume.';
                }
                $entry_types[] = $t;
                $vol_idx++;
            }

            // Fetch Notable / Recent Entries for exploration grid
            $this->db->select('entries.*, entry_types.name as type_name, entry_types.slug as type_slug');
            $this->db->from('entries');
            $this->db->join('entry_types', 'entry_types.id = entries.entry_type_id', 'left');
            $this->db->where('entries.world_id', $wid);
            $this->db->where('entries.is_archived', 0);
            $this->db->order_by('entries.id', 'ASC');
            $this->db->limit(8);
            $recent_entries = $this->db->get()->result();

            // Determine Featured Spotlight Entry (supports ?spotlight=random or ?spotlight_id=X)
            $spotlight_mode = $this->input->get('spotlight', TRUE);
            $spotlight_id   = (int)$this->input->get('spotlight_id', TRUE);

            if ($spotlight_mode === 'random' && !empty($recent_entries)) {
                $featured_entry = $recent_entries[array_rand($recent_entries)];
            } elseif ($spotlight_id > 0) {
                $this->db->select('entries.*, entry_types.name as type_name, entry_types.slug as type_slug');
                $this->db->from('entries');
                $this->db->join('entry_types', 'entry_types.id = entries.entry_type_id', 'left');
                $this->db->where(array('entries.id' => $spotlight_id, 'entries.world_id' => $wid));
                $featured_entry = $this->db->get()->row();
            }

            if (!$featured_entry && !empty($recent_entries)) {
                $featured_entry = $recent_entries[0];
            }

            // Load custom properties for the Featured Spotlight Entry
            if ($featured_entry) {
                $this->db->select('property_definitions.label, property_definitions.field_key, property_values.value_text');
                $this->db->from('property_values');
                $this->db->join('property_definitions', 'property_definitions.id = property_values.property_definition_id', 'inner');
                $this->db->where('property_values.entry_id', $featured_entry->id);
                $this->db->order_by('property_definitions.sort_order', 'ASC');
                $featured_props = $this->db->get()->result();
            }

            // Fetch Chronological Timeline Events (using 3-layer Fictional Calendar ordering)
            $this->db->select('timeline_events.*, entries.slug as entry_slug, entries.title as linked_entry_title');
            $this->db->from('timeline_events');
            $this->db->join('entries', 'entries.id = timeline_events.entry_id', 'left');
            $this->db->where('timeline_events.world_id', $wid);
            $this->db->order_by('timeline_events.sort_year IS NULL', 'DESC', FALSE);
            $this->db->order_by('timeline_events.sort_year', 'ASC');
            $this->db->order_by('timeline_events.sort_order', 'ASC');
            $this->db->limit(6);
            $timeline_events = $this->db->get()->result();

            // Fetch World Tags for quick topic exploration
            $this->db->select('tags.*, COUNT(entry_tags.entry_id) as usage_count');
            $this->db->from('tags');
            $this->db->join('entry_tags', 'entry_tags.tag_id = tags.id', 'left');
            $this->db->where('tags.world_id', $wid);
            $this->db->group_by('tags.id');
            $this->db->order_by('usage_count', 'DESC');
            $world_tags = $this->db->get()->result();
        }

        // 3. Prepare data for layout and view
        $data = array(
            'page_title'         => 'Chronicles of ' . ($active_world ? $active_world->name : 'Canaan'),
            'hide_header_banner' => TRUE,
            'active_tab'         => 'dashboard',
            'active_world'       => $active_world,
            'current_cycle'      => '842 2A',
            'total_entries'      => $total_entries,
            'canon_count'        => $canon_count,
            'draft_count'        => $draft_count,
            'entry_types'        => $entry_types,
            'recent_entries'     => $recent_entries,
            'featured_entry'     => $featured_entry,
            'featured_props'     => $featured_props,
            'timeline_events'    => $timeline_events,
            'world_tags'         => $world_tags,
            'content_view'       => 'dashboard/index',
        );

        // 4. Load master layout
        $this->load->view('layouts/main', $data);
    }

    /**
     * Auto-seeds initial admin user, test world Canaan, sample entries, and fictional timeline events if empty
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

            $this->db->insert('world_members', array(
                'world_id'   => $world_id,
                'user_id'    => $admin_id,
                'role'       => 'owner',
                'created_at' => date('Y-m-d H:i:s'),
            ));

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

        $world = $this->db->get('worlds')->row();
        if (!$world) {
            return;
        }

        // Ensure Bestiary and Chronicle also have a starter record so all 5 Book Tomes are populated
        $type_bestiary  = $this->db->get_where('entry_types', array('world_id' => $world->id, 'slug' => 'bestiary'))->row();
        $type_chronicle = $this->db->get_where('entry_types', array('world_id' => $world->id, 'slug' => 'chronicle'))->row();

        if ($type_bestiary && $this->db->where('entry_type_id', $type_bestiary->id)->count_all_results('entries') === 0) {
            $this->db->insert('entries', array(
                'public_id'        => $this->generate_uuid(),
                'world_id'         => $world->id,
                'entry_type_id'    => $type_bestiary->id,
                'title'            => 'Censer of the North',
                'slug'             => 'censer-of-the-north',
                'summary'          => 'Sanctified bronze vessel forged in the First Age that sustains the undying Pale Flame.',
                'content_markdown' => "Wrought from meteoric bronze and bound with iron chains of the High Keep, the Censer of the North is the sacred badge of office carried by the Lamplighter of Canaan. Its pale amber fire neither scorches flesh nor falters in the gale-force blizzards of the Iron Pass.",
                'status'           => 'canon',
                'cover_image'      => 'CENSER_OF_THE_NORTH_RELIC.WEBP',
                'is_archived'      => 0,
                'created_by'       => $admin_id,
                'updated_by'       => $admin_id,
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ));
        }

        if ($type_chronicle && $this->db->where('entry_type_id', $type_chronicle->id)->count_all_results('entries') === 0) {
            $this->db->insert('entries', array(
                'public_id'        => $this->generate_uuid(),
                'world_id'         => $world->id,
                'entry_type_id'    => $type_chronicle->id,
                'title'            => 'The Winter Solstice Crossing',
                'slug'             => 'the-winter-solstice-crossing',
                'summary'          => 'The fateful Cycle 842 2A expedition that rekindled the dormant wards of the Iron Pass.',
                'content_markdown' => "When the great braziers of the northern border began to dim in the winter of 842 2A, Ilsabet Voss and the Draugar vanguard marched into the teeth of the White Gale. Their success prevented the collapse of the Valorian frontier.",
                'status'           => 'canon',
                'cover_image'      => 'SOLSTICE_CROSSING_ENGRAVING.WEBP',
                'is_archived'      => 0,
                'created_by'       => $admin_id,
                'updated_by'       => $admin_id,
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ));
        }

        // Seed starter Fictional Calendar Timeline Events if timeline_events is empty
        if ($this->db->where('world_id', $world->id)->count_all_results('timeline_events') === 0) {
            $frost_keep = $this->db->get_where('entries', array('world_id' => $world->id, 'slug' => 'the-frost-keep'))->row();
            $censer     = $this->db->get_where('entries', array('world_id' => $world->id, 'slug' => 'censer-of-the-north'))->row();
            $kaelen     = $this->db->get_where('entries', array('world_id' => $world->id, 'slug' => 'kaelen-ward'))->row();
            $ilsabet    = $this->db->get_where('entries', array('world_id' => $world->id, 'slug' => 'ilsabet-voss'))->row();

            $starter_events = array(
                array(
                    'world_id'       => $world->id,
                    'entry_id'       => $frost_keep ? $frost_keep->id : NULL,
                    'title'          => 'Raising of the Frost Keep',
                    'era'            => 'First Age of Stone',
                    'event_date'     => 'c. 410 BV',
                    'sort_year'      => -410,
                    'end_year'       => -395,
                    'is_approximate' => 1,
                    'sort_order'     => 10,
                    'summary'        => 'Northern stonemasons carve the great basalt citadel above the Iron Pass and ignite the subterranean pitch veins.',
                    'created_at'     => date('Y-m-d H:i:s'),
                    'updated_at'     => date('Y-m-d H:i:s'),
                ),
                array(
                    'world_id'       => $world->id,
                    'entry_id'       => $censer ? $censer->id : NULL,
                    'title'          => 'Covenant of the Pale Flame',
                    'era'            => 'Age of Ash',
                    'event_date'     => 'c. 200 AV',
                    'sort_year'      => 200,
                    'end_year'       => NULL,
                    'is_approximate' => 1,
                    'sort_order'     => 10,
                    'summary'        => 'The Draugar Bloodline swears the eternal oath to tend the Censer of the North and guard the frontier.',
                    'created_at'     => date('Y-m-d H:i:s'),
                    'updated_at'     => date('Y-m-d H:i:s'),
                ),
                array(
                    'world_id'       => $world->id,
                    'entry_id'       => $kaelen ? $kaelen->id : NULL,
                    'title'          => 'Defense of Red Gorge',
                    'era'            => 'Second Age (2A)',
                    'event_date'     => 'Autumn, 838 2A',
                    'sort_year'      => 838,
                    'end_year'       => NULL,
                    'is_approximate' => 0,
                    'sort_order'     => 10,
                    'summary'        => 'First Scout Kaelen Ward charts the three hidden approaches, thwarting an incursion along the Frost-Veil.',
                    'created_at'     => date('Y-m-d H:i:s'),
                    'updated_at'     => date('Y-m-d H:i:s'),
                ),
                array(
                    'world_id'       => $world->id,
                    'entry_id'       => $ilsabet ? $ilsabet->id : NULL,
                    'title'          => 'The Winter Solstice Crossing',
                    'era'            => 'Second Age (2A)',
                    'event_date'     => 'Solstice, 842 2A',
                    'sort_year'      => 842,
                    'end_year'       => NULL,
                    'is_approximate' => 0,
                    'sort_order'     => 20,
                    'summary'        => 'Lamplighter Ilsabet Voss bears the Censer across the Iron Pass, rekindling the ancient wards of Valoria.',
                    'created_at'     => date('Y-m-d H:i:s'),
                    'updated_at'     => date('Y-m-d H:i:s'),
                ),
            );

            foreach ($starter_events as $ev) {
                $this->db->insert('timeline_events', $ev);
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
