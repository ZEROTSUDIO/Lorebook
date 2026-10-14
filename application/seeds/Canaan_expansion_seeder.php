<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ============================================================================
 * LOREKEEPER // CANAAN REALM EXPANSION SEEDER
 * ============================================================================
 * 
 * Expands the canonical test realm "Canaan" to complete 100% coverage across
 * all 9 Core Archetypes, enriching the realm with:
 * 
 * 1. Missing Archetype Entries (Species, Locations, Magic, Concepts).
 * 2. Granular Structured Bio & Environmental Attributes (Property Definitions).
 * 3. Illuminated Grimoire Markdown with [[Wiki Links]] and blockquotes.
 * 4. Directed Semantic Graph Bonds with reciprocal inverse predicates.
 * 5. Fictional Calendar Timeline Events anchored to signed-year epochs.
 */
class Canaan_expansion_seeder {

    public static function get_meta()
    {
        return array(
            'target_world_slug' => 'canaan',
            'name'              => 'Canaan Realm Expansion',
            'description'       => 'Populates the missing 4 archetypes (Species, Locations, Magic, Concepts) for Canaan, weaving complete 9-archetype bonds and timeline records.',
            'category'          => 'Expansion',
            'version'           => '1.0.0',
        );
    }

    /**
     * Master Lore Entries across the remaining archetypes
     */
    public static function get_entries()
    {
        return array(

            // ================================================================
            // ARCHETYPE 7: SPECIES (Bestiary of Primal Beasts)
            // ================================================================
            array(
                'archetype'   => 'species',
                'title'       => 'Frost-Veil Stalker',
                'slug'        => 'frost-veil-stalker',
                'summary'     => 'Apex rime predator possessing a semi-translucent chitin shell that camouflages in glacial blizzards.',
                'status'      => 'canon',
                'cover_image' => 'FROST_VEIL_STALKER_SKETCH.WEBP',
                'tags'        => array('bestiary', 'predators', 'glaciers', 'hazards'),

                'properties'  => array(
                    'classification' => 'Apex Rime Predator / Veil-Drifter',
                    'habitat'        => 'Glacial Crevasses of the Upper Iron Pass',
                    'threat_level'   => 'Lethal (Boreal Ambush & Frostbite Venom)',
                ),

                'content_markdown' => <<<MARKDOWN
Wandering the howling heights above [[the-iron-pass]], the **Frost-Veil Stalker** is neither beast nor demon, but an ancient rime-carved hunter spawned during the first deep freeze of the world.

Its exoskeleton is composed of pressurized glacial ice and chitin, rendering it nearly invisible in active blizzards. Only the cold phosphorescent glint of its twin ocular clusters betrays its approach through the rime.

> "If the wind halts and the snowflakes hang suspended in the stillness, do not draw breath. The Stalker has tasted your warmth."
> — *Scout's Field Guide of [[kaelen-ward]]*

### Hunting Doctrines
Stalkers avoid open confrontations with armed cohorts. Instead, they stalk border patrols along the sheer cliffs, severing tether ropes and dragging isolated sentinels into bottomless crevasses. Their venom crystallizes mortal blood within heartbeats unless treated with embers from the [[censer-of-the-north]].
MARKDOWN
            ),

            // ================================================================
            // ARCHETYPE 8: LOCATIONS (Landmarks, Sites & Ruins)
            // ================================================================
            array(
                'archetype'   => 'locations',
                'title'       => 'The Iron Pass',
                'slug'        => 'the-iron-pass',
                'summary'     => 'The treacherous basalt defile through the northern razor peaks, guarded by the Frost Keep.',
                'status'      => 'canon',
                'cover_image' => 'IRON_PASS_DEFpost.WEBP',
                'tags'        => array('geography', 'passes', 'fortifications', 'frontier'),

                'properties'  => array(
                    'region'              => 'Canaan Northern Frontier',
                    'terrain'             => 'Sheer Basalt Chasm & Permafrost Spires',
                    'controlling_faction' => 'The Frost Keep Garrison (Voss Cohort)',
                    'danger_level'        => 'High (White Gale Tempests & Stalker Prowls)',
                ),

                'content_markdown' => <<<MARKDOWN
Spanning eleven leagues of razor-sharp volcanic rock, **The Iron Pass** is the solitary overland corridor connecting the fertile southern basins to the frozen expanse of [[the-frost-keep]].

Flanked by towering obsidian walls that block all sunlight, the pass is notorious for spontaneous squalls and avalanche chutes. Ancient iron chains—each link forged larger than a warhorse—are anchored into the rock faces to guide caravans through zero-visibility rime storms.

### Bastion of the Wardens
At the narrowest bottleneck stands the ancient Gate of Thorns, maintained by [[ilsabet-voss]]. Beyond this gate, no southern writ or merchant seal carries authority.
MARKDOWN
            ),

            // ================================================================
            // ARCHETYPE 9: MAGIC (Codex of Arcane Arts)
            // ================================================================
            array(
                'archetype'   => 'magic',
                'title'       => 'Pale Flame Pyromancy',
                'slug'        => 'pale-flame-pyromancy',
                'summary'     => 'The sacred, heatless amber fire art that burns only arcane rot, frostbite, and corruption.',
                'status'      => 'canon',
                'cover_image' => 'PALE_FLAME_SEAL.WEBP',
                'tags'        => array('pyromancy', 'arcana', 'sacred-arts', 'draugar'),

                'properties'  => array(
                    'source'        => 'Deep Pitch Veins & Meteoric Flame Covenants',
                    'practitioners' => 'Draugar Bloodline & First Lamplighters',
                    'taboos'        => 'Extinguishing with water; spilling human blood into the hearth',
                ),

                'content_markdown' => <<<MARKDOWN
Unlike vulgar sorcerous flames that devour dry timber and blister skin, **Pale Flame Pyromancy** produces an ethereal, cold amber blaze. It consumes neither air nor fuel, feeding solely on metaphysical rot, miasma, and the biting supernatural chill of [[the-white-gale]].

When held in the palm of a consecrated warden, the pale flame illuminates hidden pathways across [[the-iron-pass]] and repels beasts of the deep ice.

### The Focus of Office
True mastery of the art requires a sanctified vessel. Without the containment of the [[censer-of-the-north]], unchecked ignition can freeze the caster's marrow into solid crystal.
MARKDOWN
            ),

            // ================================================================
            // ARCHETYPE 5: CONCEPTS (Arcana, Doctrines & Lore)
            // ================================================================
            array(
                'archetype'   => 'concepts',
                'title'       => 'The White Gale',
                'slug'        => 'the-white-gale',
                'summary'     => 'A cyclical supernatural blizzard phenomenon that descends from the polar void every 70 cycles.',
                'status'      => 'canon',
                'cover_image' => 'WHITE_GALE_ETCHING.WEBP',
                'tags'        => array('phenomena', 'cataclysms', 'annals', 'lore'),

                'properties'  => array(
                    'sphere'       => 'Primordial Cryo-Veil & Cyclic Cataclysm',
                    'doctrine'     => 'The Great Freeze / The Vigil of Embers',
                    'sacred_texts' => 'The First Lamplighter\'s Log, Treatises of the Keep',
                ),

                'content_markdown' => <<<MARKDOWN
**The White Gale** is not ordinary winter weather. It is a sentient, howling vortex of elemental ice that descends upon Canaan once every seven decades, plunging the continent into months of unbroken darkness.

Metal weapons exposed to the Gale turn brittle as chalk, and unprotected travelers freeze in place, preserved as silent marble statues along [[the-iron-pass]].

### The Counter-Vigil
The survival of civilization hinges entirely upon the braziers of [[the-frost-keep]] and the consecrated flame tended by [[ilsabet-voss]]. If the fires falter, the frost claims the land permanently.
MARKDOWN
            ),

        );
    }

    /**
     * Directed Relationship Matrix Bonds linking old and new entries
     */
    public static function get_relationships()
    {
        return array(
            array(
                'source'      => 'frost-veil-stalker',
                'target'      => 'the-iron-pass',
                'type'        => 'inhabits',
                'inverse'     => 'stalked by',
                'description' => 'Prowls the glacial crevices and blizzard corridors of the pass.',
            ),
            array(
                'source'      => 'the-iron-pass',
                'target'      => 'the-frost-keep',
                'type'        => 'approach to',
                'inverse'     => 'fortified by',
                'description' => 'The sole traversable mountain pass leading to the high basalt fortress.',
            ),
            array(
                'source'      => 'ilsabet-voss',
                'target'      => 'pale-flame-pyromancy',
                'type'        => 'master of',
                'inverse'     => 'wielded by',
                'description' => 'Trained in the ancestral rites of the cold amber flame.',
            ),
            array(
                'source'      => 'pale-flame-pyromancy',
                'target'      => 'censer-of-the-north',
                'type'        => 'channeled through',
                'inverse'     => 'conduit for',
                'description' => 'The meteoric bronze censer stabilizes the volatile cold flame.',
            ),
            array(
                'source'      => 'the-white-gale',
                'target'      => 'the-iron-pass',
                'type'        => 'sweeps across',
                'inverse'     => 'battered by',
                'description' => 'Descends periodically through the gorge, burying the road in glaciers.',
            ),
            array(
                'source'      => 'censer-of-the-north',
                'target'      => 'the-white-gale',
                'type'        => 'repels',
                'inverse'     => 'held at bay by',
                'description' => 'The sacred ember creates a ten-pace aura of temperate warmth against the rime.',
            ),
            array(
                'source'      => 'kaelen-ward',
                'target'      => 'the-iron-pass',
                'type'        => 'scouts along',
                'inverse'     => 'surveyed by',
                'description' => 'Patrols the hidden goat tracks and avalanche ridges.',
            ),
        );
    }

    /**
     * Timeline Events with Fictional Calendar signed-year keys
     */
    public static function get_timeline_events()
    {
        return array(
            array(
                'entry_slug'     => 'frost-veil-stalker',
                'title'          => 'Awakening of the Frost-Veil Stalkers',
                'era'            => 'Age of Primeval Rime',
                'event_date'     => 'c. 1200 BV',
                'sort_year'      => -1200,
                'end_year'       => NULL,
                'is_approximate' => 1,
                'sort_order'     => 5,
                'summary'        => 'First recorded encounters with translucent apex predators in the deep northern crevasses.',
            ),
            array(
                'entry_slug'     => 'pale-flame-pyromancy',
                'title'          => 'Codification of Pale Flame Pyromancy',
                'era'            => 'Age of Ash',
                'event_date'     => 'c. 150 AV',
                'sort_year'      => 150,
                'end_year'       => NULL,
                'is_approximate' => 1,
                'sort_order'     => 15,
                'summary'        => 'Draugar mystics master the heatless cold fire to treat deep frostbite and illuminate mountain storms.',
            ),
            array(
                'entry_slug'     => 'the-white-gale',
                'title'          => 'The Great Blizzard of 830 2A',
                'era'            => 'Second Age (2A)',
                'event_date'     => 'Winter, 830 2A',
                'sort_year'      => 830,
                'end_year'       => 831,
                'is_approximate' => 0,
                'sort_order'     => 25,
                'summary'        => 'The White Gale seals the Iron Pass for nine continuous moons, testing the endurance of the Frost Keep garrison.',
            ),
        );
    }
}
