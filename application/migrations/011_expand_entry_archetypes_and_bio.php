<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Expand_entry_archetypes_and_bio extends CI_Migration {

    public function up()
    {
        // 1. Fetch all existing worlds to provision or align the 9 Entry Archetypes
        $worlds = $this->db->get('worlds')->result();

        $archetypes = array(
            array(
                'slug'        => 'characters',
                'name'        => 'Personae & Bloodlines',
                'icon'        => 'user',
                'description' => 'Sworn champions, bloodlines, clanwardens, and mythic figures of note.',
                'sort_order'  => 1,
                'is_system'   => 1,
                'properties'  => array(
                    array('field_key' => 'species',     'label' => 'Species / Race',      'field_type' => 'text', 'sort_order' => 1),
                    array('field_key' => 'age',         'label' => 'Age / Lifespan',      'field_type' => 'text', 'sort_order' => 2),
                    array('field_key' => 'occupation',  'label' => 'Title / Occupation',  'field_type' => 'text', 'sort_order' => 3),
                    array('field_key' => 'origin_seat', 'label' => 'Origin Seat',         'field_type' => 'text', 'sort_order' => 4),
                    array('field_key' => 'clan',        'label' => 'Cohort / Clan',       'field_type' => 'text', 'sort_order' => 5),
                    array('field_key' => 'weapon',      'label' => 'Signature Weapon',    'field_type' => 'text', 'sort_order' => 6),
                    array('field_key' => 'aspect',      'label' => 'Arcane Aspect',       'field_type' => 'text', 'sort_order' => 7),
                    array('field_key' => 'abilities',   'label' => 'Abilities / Arts',    'field_type' => 'text', 'sort_order' => 8),
                )
            ),
            array(
                'slug'        => 'nations',
                'name'        => 'Realms & Sovereign Nations',
                'icon'        => 'map-pin',
                'description' => 'High keeps, basalt citadels, frozen passes, and sovereign seats of power.',
                'sort_order'  => 2,
                'is_system'   => 1,
                'properties'  => array(
                    array('field_key' => 'government', 'label' => 'Government Type',             'field_type' => 'text', 'sort_order' => 1),
                    array('field_key' => 'ruler',      'label' => 'Current Sovereign / Ruler',   'field_type' => 'text', 'sort_order' => 2),
                    array('field_key' => 'capital',    'label' => 'Seat of Power / Capital',     'field_type' => 'text', 'sort_order' => 3),
                    array('field_key' => 'population', 'label' => 'Approximate Population',       'field_type' => 'text', 'sort_order' => 4),
                    array('field_key' => 'military',   'label' => 'Dominant Military / Guard',   'field_type' => 'text', 'sort_order' => 5),
                    array('field_key' => 'climate',    'label' => 'Climate / Terrain',           'field_type' => 'text', 'sort_order' => 6),
                )
            ),
            array(
                'slug'        => 'artifacts',
                'name'        => 'Reliquary & Sacred Armaments',
                'icon'        => 'gem',
                'description' => 'Sanctified censers, ancient runic arms, talismans, and vessels of power.',
                'sort_order'  => 3,
                'is_system'   => 1,
                'properties'  => array(
                    array('field_key' => 'item_class',     'label' => 'Relic Classification',       'field_type' => 'text', 'sort_order' => 1),
                    array('field_key' => 'origin_creator', 'label' => 'Origin / Forged By',         'field_type' => 'text', 'sort_order' => 2),
                    array('field_key' => 'materials',      'label' => 'Materials & Runes',          'field_type' => 'text', 'sort_order' => 3),
                    array('field_key' => 'wielder',        'label' => 'Current Wielder / Bearer',   'field_type' => 'text', 'sort_order' => 4),
                    array('field_key' => 'powers',         'label' => 'Potency / Arcane Properties','field_type' => 'text', 'sort_order' => 5),
                )
            ),
            array(
                'slug'        => 'events',
                'name'        => 'Annals of Great Epochs',
                'icon'        => 'history',
                'description' => 'Recorded cataclysms, solstice crossings, covenants, and mythic wars.',
                'sort_order'  => 4,
                'is_system'   => 1,
                'properties'  => array(
                    array('field_key' => 'epoch',        'label' => 'Era / Epoch',               'field_type' => 'text', 'sort_order' => 1),
                    array('field_key' => 'event_date',   'label' => 'Recorded Date',             'field_type' => 'text', 'sort_order' => 2),
                    array('field_key' => 'participants', 'label' => 'Key Figures & Factions',    'field_type' => 'text', 'sort_order' => 3),
                    array('field_key' => 'outcome',      'label' => 'Treaty / Outcome',          'field_type' => 'text', 'sort_order' => 4),
                )
            ),
            array(
                'slug'        => 'concepts',
                'name'        => 'Arcana, Doctrines & Lore',
                'icon'        => 'book-open',
                'description' => 'Cosmic mysteries, arcane arts, primal laws, and sacred traditions.',
                'sort_order'  => 5,
                'is_system'   => 1,
                'properties'  => array(
                    array('field_key' => 'sphere',       'label' => 'Cosmic Sphere / Domain',    'field_type' => 'text', 'sort_order' => 1),
                    array('field_key' => 'doctrine',     'label' => 'Core Doctrine / Tenet',     'field_type' => 'text', 'sort_order' => 2),
                    array('field_key' => 'sacred_texts', 'label' => 'Sacred Texts / Treatises',  'field_type' => 'text', 'sort_order' => 3),
                )
            ),
            array(
                'slug'        => 'orders',
                'name'        => 'Synod of Guilds & Orders',
                'icon'        => 'shield',
                'description' => 'Inquisitorial synods, border cohorts, chivalric houses, and ancient brotherhoods.',
                'sort_order'  => 6,
                'is_system'   => 1,
                'properties'  => array(
                    array('field_key' => 'grandmaster', 'label' => 'Grandmaster / Leader', 'field_type' => 'text', 'sort_order' => 1),
                    array('field_key' => 'sanctum',     'label' => 'Primary Sanctum',      'field_type' => 'text', 'sort_order' => 2),
                    array('field_key' => 'doctrine',    'label' => 'Order Creed / Vow',    'field_type' => 'text', 'sort_order' => 3),
                )
            ),
            array(
                'slug'        => 'species',
                'name'        => 'Bestiary of Primal Beasts',
                'icon'        => 'feather',
                'description' => 'Ancient beasts, creatures of the veil, monsters, and indigenous humanoid races.',
                'sort_order'  => 7,
                'is_system'   => 1,
                'properties'  => array(
                    array('field_key' => 'classification', 'label' => 'Classification / Biology', 'field_type' => 'text', 'sort_order' => 1),
                    array('field_key' => 'habitat',        'label' => 'Primary Habitat',          'field_type' => 'text', 'sort_order' => 2),
                    array('field_key' => 'threat_level',   'label' => 'Threat / Disposition',     'field_type' => 'text', 'sort_order' => 3),
                )
            ),
            array(
                'slug'        => 'locations',
                'name'        => 'Landmarks, Sites & Ruins',
                'icon'        => 'compass',
                'description' => 'Crumbling fortresses, ancient passes, sacred shrines, and geographic landmarks.',
                'sort_order'  => 8,
                'is_system'   => 1,
                'properties'  => array(
                    array('field_key' => 'region',             'label' => 'Surrounding Region',  'field_type' => 'text', 'sort_order' => 1),
                    array('field_key' => 'terrain',            'label' => 'Terrain & Climate',   'field_type' => 'text', 'sort_order' => 2),
                    array('field_key' => 'controlling_faction','label' => 'Controlling Faction', 'field_type' => 'text', 'sort_order' => 3),
                    array('field_key' => 'danger_level',       'label' => 'Wards / Hazards',     'field_type' => 'text', 'sort_order' => 4),
                )
            ),
            array(
                'slug'        => 'magic',
                'name'        => 'Codex of Arcane Arts',
                'icon'        => 'zap',
                'description' => 'Schools of sorcery, elemental covenants, ritual rites, and metaphysical systems.',
                'sort_order'  => 9,
                'is_system'   => 1,
                'properties'  => array(
                    array('field_key' => 'source',        'label' => 'Source of Power',     'field_type' => 'text', 'sort_order' => 1),
                    array('field_key' => 'practitioners', 'label' => 'Covenant / Weavers',  'field_type' => 'text', 'sort_order' => 2),
                    array('field_key' => 'taboos',        'label' => 'Limitations & Taboos','field_type' => 'text', 'sort_order' => 3),
                )
            ),
        );

        foreach ($worlds as $world) {
            $type_id_map = array();

            foreach ($archetypes as $arch) {
                // Check if an existing type matches either current slug or legacy slug
                $existing = null;
                $legacy_slugs = array();
                if ($arch['slug'] === 'characters') $legacy_slugs[] = 'persons';
                if ($arch['slug'] === 'nations')    $legacy_slugs[] = 'realms';
                if ($arch['slug'] === 'events')     $legacy_slugs[] = 'chronicle';
                if ($arch['slug'] === 'species')    $legacy_slugs[] = 'bestiary';

                $existing = $this->db->get_where('entry_types', array('world_id' => $world->id, 'slug' => $arch['slug']))->row();
                if (!$existing && !empty($legacy_slugs)) {
                    $existing = $this->db->where('world_id', $world->id)->where_in('slug', $legacy_slugs)->get('entry_types')->row();
                }

                if ($existing) {
                    $this->db->where('id', $existing->id)->update('entry_types', array(
                        'name'        => $arch['name'],
                        'slug'        => $arch['slug'],
                        'icon'        => $arch['icon'],
                        'description' => $arch['description'],
                        'sort_order'  => $arch['sort_order'],
                        'is_system'   => 1,
                        'updated_at'  => date('Y-m-d H:i:s'),
                    ));
                    $type_id = $existing->id;
                } else {
                    $this->db->insert('entry_types', array(
                        'world_id'    => $world->id,
                        'name'        => $arch['name'],
                        'slug'        => $arch['slug'],
                        'icon'        => $arch['icon'],
                        'description' => $arch['description'],
                        'sort_order'  => $arch['sort_order'],
                        'is_system'   => 1,
                        'created_at'  => date('Y-m-d H:i:s'),
                        'updated_at'  => date('Y-m-d H:i:s'),
                    ));
                    $type_id = $this->db->insert_id();
                }

                $type_id_map[$arch['slug']] = $type_id;

                // Sync property definitions for this archetype
                foreach ($arch['properties'] as $prop) {
                    $existing_prop = $this->db->get_where('property_definitions', array(
                        'entry_type_id' => $type_id,
                        'field_key'     => $prop['field_key']
                    ))->row();

                    if ($existing_prop) {
                        $this->db->where('id', $existing_prop->id)->update('property_definitions', array(
                            'label'      => $prop['label'],
                            'field_type' => $prop['field_type'],
                            'sort_order' => $prop['sort_order'],
                            'updated_at' => date('Y-m-d H:i:s'),
                        ));
                    } else {
                        $this->db->insert('property_definitions', array(
                            'entry_type_id' => $type_id,
                            'field_key'     => $prop['field_key'],
                            'label'         => $prop['label'],
                            'field_type'    => $prop['field_type'],
                            'sort_order'    => $prop['sort_order'],
                            'is_required'   => 0,
                            'created_at'    => date('Y-m-d H:i:s'),
                            'updated_at'    => date('Y-m-d H:i:s'),
                        ));
                    }
                }
            }

            // Cleanly remap canonical test entries for Canaan
            if ($world->slug === 'canaan') {
                if (isset($type_id_map['artifacts'])) {
                    $this->db->where(array('world_id' => $world->id, 'slug' => 'censer-of-the-north'))
                             ->update('entries', array('entry_type_id' => $type_id_map['artifacts']));
                }

                // Seed character bio property values for Ilsabet Voss (id 1)
                $ilsabet = $this->db->get_where('entries', array('world_id' => $world->id, 'slug' => 'ilsabet-voss'))->row();
                if ($ilsabet && isset($type_id_map['characters'])) {
                    $char_type_id = $type_id_map['characters'];
                    $char_props = $this->db->get_where('property_definitions', array('entry_type_id' => $char_type_id))->result();
                    $props_by_key = array();
                    foreach ($char_props as $cp) $props_by_key[$cp->field_key] = $cp->id;

                    $ilsabet_values = array(
                        'species'     => 'Human (Draugar Lineage)',
                        'age'         => '32 Cycles',
                        'occupation'  => 'First Lamplighter of the Iron Pass',
                        'origin_seat' => 'The Frost Keep',
                        'clan'        => 'Draugar Bloodline',
                        'weapon'      => 'Censer of the North & Runic Hatchet',
                        'aspect'      => 'Pale Flame Pyromancy',
                        'abilities'   => 'Covenant Flame Stance, White Gale Wards',
                    );

                    foreach ($ilsabet_values as $k => $val) {
                        if (isset($props_by_key[$k])) {
                            $def_id = $props_by_key[$k];
                            $this->upsert_prop_val($ilsabet->id, $def_id, $val);
                        }
                    }
                }

                // Seed character bio property values for Kaelen Ward (id 2)
                $kaelen = $this->db->get_where('entries', array('world_id' => $world->id, 'slug' => 'kaelen-ward'))->row();
                if ($kaelen && isset($type_id_map['characters'])) {
                    $char_type_id = $type_id_map['characters'];
                    $char_props = $this->db->get_where('property_definitions', array('entry_type_id' => $char_type_id))->result();
                    $props_by_key = array();
                    foreach ($char_props as $cp) $props_by_key[$cp->field_key] = $cp->id;

                    $kaelen_values = array(
                        'species'     => 'Human (Northern Clan)',
                        'age'         => '28 Cycles',
                        'occupation'  => 'First Scout of the Red Gorge',
                        'origin_seat' => 'Basalt Outpost III',
                        'clan'        => 'Wardens of the Pale Verge',
                        'weapon'      => 'Meteoric Shortbow & Iron Dirk',
                        'aspect'      => 'Wind-Weaving & Pathfinding',
                        'abilities'   => 'Veil-Step, Three Pass Charting',
                    );

                    foreach ($kaelen_values as $k => $val) {
                        if (isset($props_by_key[$k])) {
                            $def_id = $props_by_key[$k];
                            $this->upsert_prop_val($kaelen->id, $def_id, $val);
                        }
                    }
                }

                // Seed Nation properties for The Frost Keep (id 3)
                $frost_keep = $this->db->get_where('entries', array('world_id' => $world->id, 'slug' => 'the-frost-keep'))->row();
                if ($frost_keep && isset($type_id_map['nations'])) {
                    $nation_props = $this->db->get_where('property_definitions', array('entry_type_id' => $type_id_map['nations']))->result();
                    $np_by_key = array();
                    foreach ($nation_props as $np) $np_by_key[$np->field_key] = $np->id;

                    $keep_values = array(
                        'government' => 'Hereditary Warden Citadel',
                        'ruler'      => 'Clanwarden Council',
                        'capital'    => 'The High Basalt Keep',
                        'population' => 'c. 14,000 sworn souls',
                        'military'   => 'Draugar Vanguard & Lamplighter Cohorts',
                        'climate'    => 'Perpetual Frost & Alpine Crags',
                    );

                    foreach ($keep_values as $k => $val) {
                        if (isset($np_by_key[$k])) {
                            $this->upsert_prop_val($frost_keep->id, $np_by_key[$k], $val);
                        }
                    }
                }

                // Seed Artifact properties for Censer of the North (id 5)
                $censer = $this->db->get_where('entries', array('world_id' => $world->id, 'slug' => 'censer-of-the-north'))->row();
                if ($censer && isset($type_id_map['artifacts'])) {
                    $artifact_props = $this->db->get_where('property_definitions', array('entry_type_id' => $type_id_map['artifacts']))->result();
                    $ap_by_key = array();
                    foreach ($artifact_props as $ap) $ap_by_key[$ap->field_key] = $ap->id;

                    $censer_values = array(
                        'item_class'     => 'Sanctified First Age Relic',
                        'origin_creator' => 'Northern Bronzesmiths of Stone Age',
                        'materials'      => 'Meteoric Bronze, Subterranean Pitch, Star-Iron',
                        'wielder'        => 'Lamplighter Ilsabet Voss',
                        'powers'         => 'Undying Pale Fire, Repels the White Gale',
                    );

                    foreach ($censer_values as $k => $val) {
                        if (isset($ap_by_key[$k])) {
                            $this->upsert_prop_val($censer->id, $ap_by_key[$k], $val);
                        }
                    }
                }
            }
        }
    }

    private function upsert_prop_val($entry_id, $def_id, $val)
    {
        $existing = $this->db->get_where('property_values', array(
            'entry_id'               => $entry_id,
            'property_definition_id' => $def_id
        ))->row();

        if ($existing) {
            $this->db->where('id', $existing->id)->update('property_values', array(
                'value_text' => $val,
                'updated_at' => date('Y-m-d H:i:s'),
            ));
        } else {
            $this->db->insert('property_values', array(
                'entry_id'               => $entry_id,
                'property_definition_id' => $def_id,
                'value_text'             => $val,
                'created_at'             => date('Y-m-d H:i:s'),
                'updated_at'             => date('Y-m-d H:i:s'),
            ));
        }
    }

    public function down()
    {
        // Non-destructive rollback: keep tables intact
    }
}
