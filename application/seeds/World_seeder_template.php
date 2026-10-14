<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ============================================================================
 * LOREKEEPER // MASTER WORLD DATA SEEDER TEMPLATE
 * ============================================================================
 * 
 * Use this file as a blueprint to craft rich, structured lore datasets for your
 * fictional worlds. This seeder handles all 6 layers of the Lorekeeper engine:
 * 
 * 1. World Compendium & Atlas Preferences (History, 3 Pillars, Cartography)
 * 2. The 9 Core Entry Archetypes (Characters, Nations, Relics, Events, etc.)
 * 3. Structured Properties & Bio Data (Attributes, Weapons, Aspects, Stats)
 * 4. Illuminated Grimoire Markdown Prose (Drop-caps, quotes, [[Wiki Links]])
 * 5. Directed Relationship Matrix (Semantic graph bonds & inverse predicates)
 * 6. Fictional Calendar Timeline Events (Eras, signed sort years, BCE/CE)
 * 
 * HOW TO USE:
 * 1. Duplicate this file (e.g. `My_world_seeder.php`).
 * 2. Customize the `$world_meta`, `$entries`, `$relationships`, and `$timeline`.
 * 3. Run via browser at `http://localhost/Lorekeeper/seed` or via CLI.
 */

class World_seeder_template {

    /**
     * World Identity & Compendium Settings
     */
    public static function get_world_meta()
    {
        return array(
            'name'            => 'Aethelgard',
            'slug'            => 'aethelgard',
            'description'     => 'The sun-bleached archipelagos of shattered obsidian keeps and wind-sail galleons.',
            'visibility'      => 'private',

            // Compendium Annals & History Prose
            'compendium_annals_label' => 'I. ANNALS OF THE OBSIDIAN ISLES',
            'compendium_history_p1'   => 'Before the Sundering of the Seventh Tide, the high kings of Aethelgard commanded the sea-spires from their coral citadels. Now, scattered clanwardens navigate the shallow reef-passes with runic astrolabes.',
            'compendium_history_p2'   => 'Every generation, the Obsidian Mist rises from the deep ocean trenches, awakening the sunken leviathans and testing the wards of the coastal beacons.',

            // The Three Foundational Lore Pillars
            'pillar_1_label'          => 'PILLAR I // MYTHOS',
            'pillar_1_title'          => 'The Seventh Tide',
            'pillar_1_body'           => 'The ancient cataclysm that drowned the inland continent and fractured the land into three hundred sovereign islands.',

            'pillar_2_label'          => 'PILLAR II // GEOGRAPHY',
            'pillar_2_title'          => 'The Sunken Trench',
            'pillar_2_body'           => 'A fathomless undersea fissure where ancient starlight crystals still radiate heat and arcane power.',

            'pillar_3_label'          => 'PILLAR III // FACTIONS',
            'pillar_3_title'          => 'The Corsair Compact',
            'pillar_3_body'           => 'An alliance of seafaring clanwardens pledged to guard the lighthouse beacons against deep-veil beasts.',

            // Fictional Telemetry & Cartography Plate
            'dominant_seat'           => 'Spire of the Dawn',
            'calendar_system'         => 'BT / AT (Before / After Tide)',
            'current_cycle'           => '420 AT',
            'realm_status'            => 'HIGH TIDE VIGIL',
            'map_plate_label'         => 'PLATE I // NAUTICAL CHART',
            'map_plate_file'          => 'AETHELGARD_ARCHIPELAGO_CHART.WEBP',
            'map_node_1'              => 'SPIRE OF THE DAWN (Capital)',
            'map_node_2'              => 'REEF OF WHISPERS (Pass)',
            'map_node_3'              => 'THE OBSIDIAN TRENCH',
            'arch_etching_title'      => 'PLATE II // ARCHITECTURAL ENGRAVING',
            'arch_etching_caption'    => 'THE BEACON WATCHTOWER OF KORVASH',
        );
    }

    /**
     * Master Lore Entries Array across the 9 Archetypes
     */
    public static function get_entries()
    {
        return array(

            // ================================================================
            // ARCHETYPE 1: CHARACTERS (Personae & Bloodlines)
            // ================================================================
            array(
                'archetype'   => 'characters',
                'title'       => 'Captain Maren Vane',
                'slug'        => 'captain-maren-vane',
                'summary'     => 'High Navigator of the Dawn Spire and master of the Obsidian Sextant.',
                'status'      => 'canon', // 'canon', 'draft', or 'archived'
                'cover_image' => 'MAREN_VANE_PORTRAIT.WEBP',
                'tags'        => array('navigators', 'corsairs', 'dawn-spire'),
                
                // Structured Bio Data (8 Canonical Character Attributes)
                'properties'  => array(
                    'species'     => 'Human (Islander)',
                    'age'         => '38 Cycles',
                    'occupation'  => 'Grand Navigator of the Coastal Fleet',
                    'origin_seat' => 'Spire of the Dawn',
                    'clan'        => 'House of Vane',
                    'weapon'      => 'Star-Glass Cutlass & Runic Harpoon',
                    'aspect'      => 'Tide-Calling & Wind-Tuning',
                    'abilities'   => 'Mist-Sight, Storm Current Charting, Runic Wayfinding',
                ),

                'content_markdown' => <<<MARKDOWN
Born under the green flash of the solstice dawn, **Captain Maren Vane** charted the treacherous reefs of the outer reaches before she was twenty cycles of age.

When the Obsidian Mist Dimmed the great braziers of the [[Spire of the Dawn]], she steered her flagship, the *Sea Wraith*, straight through the jaws of the [[Reef of Whispers]] to retrieve the sacred [[Obsidian Sextant]].

> "The tide bows to no sovereign, yet it respects the pilot who speaks the language of the brine."
> — *Logbook of the Sea Wraith*

### The Oath of the Coral Reef
Her sworn loyalty to [[House of Vane]] has positioned her at odds with the southern mercantile synods, who demand unrestricted navigation through the trench.
MARKDOWN
            ),

            // ================================================================
            // ARCHETYPE 2: NATIONS (Realms & Sovereign Nations)
            // ================================================================
            array(
                'archetype'   => 'nations',
                'title'       => 'The Coral Dominion',
                'slug'        => 'the-coral-dominion',
                'summary'     => 'The sovereign naval kingdom ruling the northern archipelago from the Dawn Spire.',
                'status'      => 'canon',
                'cover_image' => 'CORAL_DOMINION_CITADEL.WEBP',
                'tags'        => array('kingdoms', 'naval-power', 'isles'),
                
                'properties'  => array(
                    'government' => 'Elective Admiralty Moot',
                    'ruler'      => 'Lord Admiral Corvin Thal',
                    'capital'    => 'Spire of the Dawn',
                    'population' => 'c. 85,000 sworn mariners and artisans',
                    'military'   => 'The Gilded Galley Fleet & Tide-Wardens',
                    'climate'    => 'Maritime Subtropical, Seasonal Gale-Typhoons',
                ),

                'content_markdown' => <<<MARKDOWN
Wrought from calcified volcanic stone and living reef coral, **The Coral Dominion** has stood undefeated on the open waters for over four centuries.

### Bastions of the Archipelago
The primary citadel sits astride the [[Spire of the Dawn]], where three massive tidal gates control all ship traffic into the sheltered inner lagoons.
MARKDOWN
            ),

            // ================================================================
            // ARCHETYPE 3: ARTIFACTS (Reliquary & Sacred Armaments)
            // ================================================================
            array(
                'archetype'   => 'artifacts',
                'title'       => 'The Obsidian Sextant',
                'slug'        => 'the-obsidian-sextant',
                'summary'     => 'Pre-cataclysm navigational relic that reveals hidden astral pathways through the mist.',
                'status'      => 'canon',
                'cover_image' => 'OBSIDIAN_SEXTANT_RELIC.WEBP',
                'tags'        => array('relics', 'astronomy', 'pre-tide'),
                
                'properties'  => array(
                    'item_class'     => 'First Era Navigational Regalia',
                    'origin_creator' => 'Star-Wrights of the Sunken Spire',
                    'materials'      => 'Black Volcanic Glass, Star-Brass, Leviathan Bone',
                    'wielder'        => 'Captain Maren Vane',
                    'powers'         => 'Pierces the Obsidian Mist, Charts Ley-Lines across water',
                ),

                'content_markdown' => <<<MARKDOWN
Forged before the Great Sundering, the **Obsidian Sextant** does not measure degrees of latitude by common stars. Instead, its polarized lenses reveal the invisible currents of arcane ether that flow between the sea trenches.
MARKDOWN
            ),

            // ================================================================
            // ARCHETYPE 4: EVENTS (Annals of Great Epochs)
            // ================================================================
            array(
                'archetype'   => 'events',
                'title'       => 'The Midnight Typhoon of 398 AT',
                'slug'        => 'the-midnight-typhoon-of-398-at',
                'summary'     => 'A devastating tempest that breached the outer sea-walls and submerged the lower archives.',
                'status'      => 'canon',
                'cover_image' => 'TYPHOON_ENGRAVING.WEBP',
                'tags'        => array('cataclysms', 'annals', 'history'),
                
                'properties'  => array(
                    'epoch'        => 'Second Era of Tides (2E)',
                    'event_date'   => 'Autumn Equinox, 398 AT',
                    'participants' => 'The Coastal Wardens, House of Vane, Leviathans of the Deep',
                    'outcome'      => 'Rebuilding of the Spire Walls, Treaty of the Sunken Trench',
                ),

                'content_markdown' => <<<MARKDOWN
For three unbroken nights, winds howling at sixty knots tore the sails from every docked vessel in the archipelago. It was during this catastrophe that the first sighting of the [[Reef of Whispers]] was logged in the annals.
MARKDOWN
            ),

            // ================================================================
            // ARCHETYPE 5: CONCEPTS (Arcana, Doctrines & Lore)
            // ================================================================
            array(
                'archetype'   => 'concepts',
                'title'       => 'The Obsidian Mist',
                'slug'        => 'the-obsidian-mist',
                'summary'     => 'A supernatural black sea fog that disables magnetic compasses and breeds spectral rifts.',
                'status'      => 'canon',
                'cover_image' => 'OBSIDIAN_MIST_ETCHING.WEBP',
                'tags'        => array('arcana', 'hazards', 'phenomena'),
                
                'properties'  => array(
                    'sphere'       => 'Liminal Hydromancy & Arcane Veil',
                    'doctrine'     => 'The Law of the Deep Return',
                    'sacred_texts' => 'The Mariner\'s Vigil, Treatises of the Tide-Wardens',
                ),

                'content_markdown' => <<<MARKDOWN
Unlike ordinary maritime weather, **The Obsidian Mist** possesses weight and texture. Lantern light fails to illuminate more than three paces, turning from warm yellow to pale azure when inside the fog.
MARKDOWN
            ),

            // ================================================================
            // ARCHETYPE 6: ORDERS (Synod of Guilds & Orders)
            // ================================================================
            array(
                'archetype'   => 'orders',
                'title'       => 'The Guild of Tide-Wardens',
                'slug'        => 'the-guild-of-tide-wardens',
                'summary'     => 'Sworn brotherhood of beacon-keepers, lighthouse sentinels, and mist-watchers.',
                'status'      => 'canon',
                'cover_image' => 'TIDE_WARDENS_CREST.WEBP',
                'tags'        => array('guilds', 'orders', 'sentinels'),
                
                'properties'  => array(
                    'grandmaster' => 'High Warden Kaelen Frost',
                    'sanctum'     => 'The Great Beacon of Korvash',
                    'doctrine'    => 'The Light Shall Never Drown',
                ),

                'content_markdown' => <<<MARKDOWN
Stationed atop solitary rock pillars far out at sea, the **Tide-Wardens** burn alchemical amber oil day and night. Their bells warn approaching merchant galleons away from submerged reefs.
MARKDOWN
            ),

            // ================================================================
            // ARCHETYPE 7: SPECIES (Bestiary of Primal Beasts)
            // ================================================================
            array(
                'archetype'   => 'species',
                'title'       => 'Abyssal Trench Drake',
                'slug'        => 'abyssal-trench-drake',
                'summary'     => 'Bioluminescent serpent-drakes inhabiting underwater magma vents.',
                'status'      => 'canon',
                'cover_image' => 'TRENCH_DRAKE_SKETCH.WEBP',
                'tags'        => array('bestiary', 'monsters', 'aquatic'),
                
                'properties'  => array(
                    'classification' => 'Serpentine Draconic / Abyssal',
                    'habitat'        => 'Underwater Geothermal Vents & Deep Trenches',
                    'threat_level'   => 'Extremely Dangerous (Calamity Grade)',
                ),

                'content_markdown' => <<<MARKDOWN
Reaching lengths of thirty fathoms, these creatures possess scales as dense as volcanic glass. They hunt by emitting dazzling pulses of emerald bioluminescence that paralyze prey before striking.
MARKDOWN
            ),

            // ================================================================
            // ARCHETYPE 8: LOCATIONS (Landmarks, Sites & Ruins)
            // ================================================================
            array(
                'archetype'   => 'locations',
                'title'       => 'The Reef of Whispers',
                'slug'        => 'the-reef-of-whispers',
                'summary'     => 'A graveyard of ancient shipwrecks trapped atop needle-sharp basalt pillars.',
                'status'      => 'canon',
                'cover_image' => 'REEF_OF_WHISPERS.WEBP',
                'tags'        => array('landmarks', 'shipwrecks', 'hazards'),
                
                'properties'  => array(
                    'region'              => 'Eastern Perimeter of Aethelgard',
                    'terrain'             => 'Shallow Basalt Pinnacles & Submerged Caves',
                    'controlling_faction' => 'None (Disputed Waters / Mist Terrors)',
                    'danger_level'        => 'Lethal (Tidal Riptides & Mist Haunts)',
                ),

                'content_markdown' => <<<MARKDOWN
When the tides recede at dusk, the hulls of over forty galleons emerge from the waves like the ribs of beached leviathans. It is said that mariners who listen closely can hear the voices of the First Fleet echoing through the hollow masts.
MARKDOWN
            ),

            // ================================================================
            // ARCHETYPE 9: MAGIC (Codex of Arcane Arts)
            // ================================================================
            array(
                'archetype'   => 'magic',
                'title'       => 'Tide-Calling & Wave-Weaving',
                'slug'        => 'tide-calling-and-wave-weaving',
                'summary'     => 'The esoteric art of shaping ocean currents and calling down atmospheric squalls.',
                'status'      => 'canon',
                'cover_image' => 'WAVE_WEAVING_DIAGRAM.WEBP',
                'tags'        => array('magic', 'sorcery', 'hydromancy'),
                
                'properties'  => array(
                    'source'        => 'The Lunar Pull & Deep Sea Rifts',
                    'practitioners' => 'Sea-Seers of the Coral Dominion',
                    'taboos'        => 'Drawing on the Blood-Tide or Waking Trench Beasts',
                ),

                'content_markdown' => <<<MARKDOWN
Wave-Weavers do not manipulate water by brute force. Instead, they sing resonant harmonics through hollow conch shells carved with lunar sigils, causing the sea around their vessels to rise and push them forward against contrary winds.
MARKDOWN
            ),

        );
    }

    /**
     * Directed Relationship Matrix Bonds between Entries
     */
    public static function get_relationships()
    {
        return array(
            array(
                'source'      => 'captain-maren-vane',
                'target'      => 'the-obsidian-sextant',
                'type'        => 'bearer of',
                'inverse'     => 'wielded by',
                'description' => 'Entrusted to Captain Vane after her successful passage through the Reef of Whispers.',
            ),
            array(
                'source'      => 'captain-maren-vane',
                'target'      => 'the-coral-dominion',
                'type'        => 'sworn commander of',
                'inverse'     => 'commanded by',
                'description' => 'Serves as First Captain of the High Admiralty fleet.',
            ),
            array(
                'source'      => 'the-coral-dominion',
                'target'      => 'the-guild-of-tide-wardens',
                'type'        => 'patron of',
                'inverse'     => 'supported by',
                'description' => 'Funds the beacon network with silver bullion and dry timber.',
            ),
            array(
                'source'      => 'abyssal-trench-drake',
                'target'      => 'the-reef-of-whispers',
                'type'        => 'roams within',
                'inverse'     => 'hunting ground of',
                'description' => 'Prowls the submerged caverns below the sunken wrecks.',
            ),
            array(
                'source'      => 'the-midnight-typhoon-of-398-at',
                'target'      => 'the-coral-dominion',
                'type'        => 'devastated',
                'inverse'     => 'endured by',
                'description' => 'Breached the lower seawalls and destroyed nineteen galleons in port.',
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
                'entry_slug'     => 'the-coral-dominion',
                'title'          => 'The Great Sundering of the Seventh Tide',
                'era'            => 'First Age (1E)',
                'event_date'     => 'c. 500 BT',
                'sort_year'      => -500, // Signed integer sort key (negative for BCE/BT)
                'end_year'       => -498,
                'is_approximate' => 1,
                'sort_order'     => 10,
                'summary'        => 'The continental mainland fractures into three hundred sovereign isles, birthing the archipelago.',
            ),
            array(
                'entry_slug'     => 'the-guild-of-tide-wardens',
                'title'          => 'Founding of the Beacon Synod',
                'era'            => 'Age of Beacons',
                'event_date'     => 'c. 120 AT',
                'sort_year'      => 120,
                'end_year'       => NULL,
                'is_approximate' => 1,
                'sort_order'     => 20,
                'summary'        => 'The first amber braziers are ignited atop the rock pinnacles to guide navigators through the dark.',
            ),
            array(
                'entry_slug'     => 'the-midnight-typhoon-of-398-at',
                'title'          => 'The Midnight Typhoon of 398 AT',
                'era'            => 'Second Era of Tides (2E)',
                'event_date'     => 'Autumn Equinox, 398 AT',
                'sort_year'      => 398,
                'end_year'       => NULL,
                'is_approximate' => 0,
                'sort_order'     => 30,
                'summary'        => 'Cataclysmic storm breaches the seawalls of the Dawn Spire, forcing the signing of the Corsair Compact.',
            ),
            array(
                'entry_slug'     => 'captain-maren-vane',
                'title'          => 'Recovery of the Obsidian Sextant',
                'era'            => 'Second Era of Tides (2E)',
                'event_date'     => 'High Solstice, 418 AT',
                'sort_year'      => 418,
                'end_year'       => NULL,
                'is_approximate' => 0,
                'sort_order'     => 40,
                'summary'        => 'Captain Maren Vane returns from the Reef of Whispers bearing the star-glass navigational regalia.',
            ),
        );
    }
}
