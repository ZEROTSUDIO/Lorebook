<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Seed_canonical_relationships extends CI_Migration {

    public function up()
    {
        // 1. Fetch Canaan world
        $canaan = $this->db->get_where('worlds', array('slug' => 'canaan'))->row();
        if (!$canaan) {
            return;
        }

        $entries = $this->db->get_where('entries', array('world_id' => $canaan->id))->result();
        $entry_map = array();
        foreach ($entries as $e) {
            $entry_map[$e->slug] = $e->id;
        }

        // Canonical bonds for Canaan
        $bonds = array(
            array(
                'source'      => 'ilsabet-voss',
                'target'      => 'censer-of-the-north',
                'type'        => 'bearer of',
                'inverse'     => 'wielded by',
                'description' => 'Sanctified during the Solstice Crossing of 842 2A to keep the northern braziers ablaze.',
            ),
            array(
                'source'      => 'ilsabet-voss',
                'target'      => 'the-frost-keep',
                'type'        => 'sworn warden of',
                'inverse'     => 'protected by',
                'description' => 'Sworn by the First Lamplighter oath upon the high basalt watchtower.',
            ),
            array(
                'source'      => 'kaelen-ward',
                'target'      => 'the-frost-keep',
                'type'        => 'sworn scout of',
                'inverse'     => 'scouted by',
                'description' => 'Dispatched to chart the three treacherous approaches through the Red Gorge.',
            ),
            array(
                'source'      => 'kaelen-ward',
                'target'      => 'ilsabet-voss',
                'type'        => 'sworn comrade of',
                'inverse'     => 'sworn comrade of',
                'description' => 'Fought side-by-side during the White Gale breach of the Iron Pass.',
            ),
            array(
                'source'      => 'ilsabet-voss',
                'target'      => 'order-of-the-silver-hand',
                'type'        => 'opposed to',
                'inverse'     => 'ideological rival of',
                'description' => 'Defied the Grand Inquisitor\'s mandate to surrender all ancient pyromantic censers.',
            ),
            array(
                'source'      => 'the-frost-keep',
                'target'      => 'the-winter-solstice-crossing',
                'type'        => 'staging ground of',
                'inverse'     => 'staged from',
                'description' => 'The northern vanguard departed from the Basalt Gates into the teeth of the storm.',
            ),
        );

        $now = date('Y-m-d H:i:s');
        foreach ($bonds as $b) {
            if (isset($entry_map[$b['source']]) && isset($entry_map[$b['target']])) {
                $src_id = $entry_map[$b['source']];
                $tgt_id = $entry_map[$b['target']];

                $exists = $this->db->get_where('entry_relationships', array(
                    'world_id'          => $canaan->id,
                    'source_entry_id'   => $src_id,
                    'target_entry_id'   => $tgt_id,
                    'relationship_type' => $b['type'],
                ))->row();

                if (!$exists) {
                    $this->db->insert('entry_relationships', array(
                        'world_id'          => $canaan->id,
                        'source_entry_id'   => $src_id,
                        'target_entry_id'   => $tgt_id,
                        'relationship_type' => $b['type'],
                        'inverse_label'     => $b['inverse'],
                        'description'       => $b['description'],
                        'created_at'        => $now,
                        'updated_at'        => $now,
                    ));
                }
            }
        }
    }

    public function down()
    {
        // Non-destructive
    }
}
