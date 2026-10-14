<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ============================================================================
 * LOREKEEPER // CYBERPUNK NEXUS SEEDER: "NEO-VECTRA 2184"
 * ============================================================================
 * 
 * Demonstrates how the 9 Lorekeeper Archetypes cleanly model high-tech,
 * speculative sci-fi, and dark cyberpunk worlds.
 * 
 * 1. World Compendium & Chrono-Settings (Chrono: BC/AC - Before/After Collapse)
 * 2. 9 Core Archetypes (Operatives, Megacorps, Quantum Relics, Net Phenoms)
 * 3. 8-Attribute Bio Data (Wetware, Cyber-ware, Street Cred, Weaponry)
 * 4. Technical Grimoire Markdown with telemetry blocks & code-quotes
 * 5. Directed Network Matrix Bonds (Corporate rivalries, black-market contracts)
 * 6. Fictional Calendar Timeline Events with signed epoch years
 */
class Cyberpunk_seeder {

    public static function get_meta()
    {
        return array(
            'target_world_slug' => 'neo-vectra',
            'name'              => 'Neo-Vectra 2184 // Sector 09',
            'description'       => 'The rain-drenched vertical megalopolis of mile-high corporate spires, augmented netrunners, and black-market wetware cartels.',
            'category'          => 'Cyberpunk / Sci-Fi',
            'version'           => '1.0.0',
        );
    }

    public static function get_world_meta()
    {
        return array(
            'name'        => 'Neo-Vectra 2184',
            'slug'        => 'neo-vectra',
            'description' => 'The rain-drenched vertical megalopolis of mile-high corporate spires, augmented netrunners, and black-market wetware cartels.',
            'visibility'  => 'private',

            // Compendium Annals & History
            'compendium_annals_label' => 'I. CHRONICLES OF THE DISSIDENT GRID',
            'compendium_history_p1'   => 'Following the Great Decoupling of 2098, sovereign nations dissolved into mega-consortium territories. In Sector 09, cyber-augmented runners navigate the undercity steam-conduits beneath the omniscient gaze of the Vectra orbital satellites.',
            'compendium_history_p2'   => 'Every millisecond, terabytes of clandestine memory shards are smuggled through wetware interfaces, fueling the proxy conflicts between corporate syndicates.',

            // The Three Foundational Lore Pillars
            'pillar_1_label'          => 'PILLAR I // THE GRID',
            'pillar_1_title'          => 'The Sub-Ether Slipstream',
            'pillar_1_body'           => 'A quantum data layer where human consciousness decouples from mortal meat, navigating encrypted sub-routines at the speed of light.',

            'pillar_2_label'          => 'PILLAR II // GEOGRAPHY',
            'pillar_2_title'          => 'Sector 09 Undercity',
            'pillar_2_body'           => 'The abandoned subterranean infrastructure sixty levels beneath the chrome spires, housing black clinics and unmonitored server bunkers.',

            'pillar_3_label'          => 'PILLAR III // FACTIONS',
            'pillar_3_title'          => 'The Neon Syndicate',
            'pillar_3_body'           => 'An underground collective of cipher-runners, bio-hackers, and rogue synthetics pledged to tear down corporate neural DRM.',

            // Fictional Telemetry & Cartography Plate
            'dominant_seat'           => 'The Chromed Needle (Vectra HQ)',
            'calendar_system'         => 'BC / AC (Before / After Collapse)',
            'current_cycle'           => '86 AC (2184 CE)',
            'realm_status'            => 'SURVEILLANCE LEVEL // DEFCON AMBER',
            'map_plate_label'         => 'PLATE I // SECTOR 09 SUB-GRID SCHEMATIC',
            'map_plate_file'          => 'NEO_VECTRA_SCHEMATIC.WEBP',
            'map_node_1'              => 'THE CHROMED NEEDLE (Upper Spire)',
            'map_node_2'              => 'TERMINAL 404 (Black Market)',
            'map_node_3'              => 'CONDUIT LEVEL -40 (Under-Sprawl)',
            'arch_etching_title'      => 'PLATE II // ARCHITECTURAL HOLOGRAM',
            'arch_etching_caption'    => 'VENTILATION CHASM OF SUB-LEVEL NINE',
        );
    }

    public static function get_entries()
    {
        return array(

            // ================================================================
            // ARCHETYPE 1: CHARACTERS (Operatives & Infiltrators)
            // ================================================================
            array(
                'archetype'   => 'characters',
                'title'       => 'Kestrel Vance',
                'slug'        => 'kestrel-vance',
                'summary'     => 'Veteran ghost-runner and wetware courier specializing in high-speed corporate data exfiltration.',
                'status'      => 'canon',
                'cover_image' => 'KESTREL_VANCE_CYBER.WEBP',
                'tags'        => array('operatives', 'netrunners', 'cyborgs', 'syndicate'),

                // Structured Bio Data
                'properties'  => array(
                    'species'     => 'Augmented Human (Cyborg Class-IV)',
                    'age'         => '29 Standard Cycles',
                    'occupation'  => 'Black-Hat Netrunner & Wetware Courier',
                    'origin_seat' => 'Sector 09 Lower Sprawl',
                    'clan'        => 'The Neon Syndicate',
                    'weapon'      => 'Monomolecular Filament Whip & Suppressed Rail-Pistol',
                    'aspect'      => 'Sub-Ether Neural Jacking & Quantum Decryption',
                    'abilities'   => 'Memory Drift Camouflage, Sub-Grid Protocol Override, Reflex Acceleration',
                ),

                'content_markdown' => <<<MARKDOWN
Rebuilt following a near-fatal extraction in the corporate upper tiers, **Kestrel Vance** operates in the razor-thin margin between biological life and machine logic.

Her spinal cord is reinforced with titanium-graphene weaves and dual optic ports capable of perceiving radio-frequency emissions and encrypted data streams in full sensory chromatic color.

> "The megacorps own the air, the water, and the ground you walk on. But when you dive into the sub-ether, their firewall rules are just suggestions waiting to be dismantled."
> — *Kestrel Vance, intercepted transmission from [[terminal-404]]*

### The Heist of the Quantum Shard
In early 84 AC, Vance breached the sub-basement laboratories of the [[vectra-mega-consortium]], escaping into the rainy vents with [[the-prometheus-quantum-shard]] embedded directly into her cranial port.
MARKDOWN
            ),

            // ================================================================
            // ARCHETYPE 2: NATIONS (Megacorps & Corporate Polities)
            // ================================================================
            array(
                'archetype'   => 'nations',
                'title'       => 'Vectra Mega-Consortium',
                'slug'        => 'vectra-mega-consortium',
                'summary'     => 'The ruthless transnational conglomerate governing Neo-Vectra through monopolized cyberware and orbital telemetry.',
                'status'      => 'canon',
                'cover_image' => 'VECTRA_TOWER_NEON.WEBP',
                'tags'        => array('megacorps', 'governments', 'powers', 'security'),

                'properties'  => array(
                    'government' => 'Board of Executive Directors & Algorithmic Council',
                    'ruler'      => 'Chief Director Silas Thorne',
                    'capital'    => 'The Chromed Needle (Upper Vectra Spire)',
                    'population' => 'c. 14.2 Million registered bio-citizens',
                    'military'   => 'Aegis Security PMCs & Hunter-Killer Autonomous Drones',
                    'climate'    => 'Acid-Rain Smog & Vertical Neon Microclimates',
                ),

                'content_markdown' => <<<MARKDOWN
Rising two kilometers into the toxic yellow clouds, **Vectra Mega-Consortium** controls everything from neural telemetry licenses to synthetic food processing.

Citizens born within Vectra sectors are assigned an immutable Corporate Credit Quotient (CCQ) at birth. Those whose quotient falls below baseline are evicted into the lower levels of [[terminal-404]].
MARKDOWN
            ),

            // ================================================================
            // ARCHETYPE 3: ARTIFACTS (Precursor Chips & Nanite Tech)
            // ================================================================
            array(
                'archetype'   => 'artifacts',
                'title'       => 'The Prometheus Quantum Shard',
                'slug'        => 'the-prometheus-quantum-shard',
                'summary'     => 'Pre-collapse superconducting processor containing autonomous neural code and infinite cryptographic cycles.',
                'status'      => 'canon',
                'cover_image' => 'PROMETHEUS_SHARD_CHIP.WEBP',
                'tags'        => array('quantum', 'chips', 'pre-collapse', 'relics'),

                'properties'  => array(
                    'item_class'     => 'First-Generation Pre-Collapse Quantum Core',
                    'origin_creator' => 'Prometheus Bio-Tech Laboratories',
                    'materials'      => 'Superconducting Crystalline Graphene & Nanite Housing',
                    'wielder'        => 'Kestrel Vance',
                    'powers'         => 'Real-Time Quantum Decryption, Null-Grid Field Generation',
                ),

                'content_markdown' => <<<MARKDOWN
Manufactured before the global blackout of 2098, **The Prometheus Quantum Shard** defies modern encryption standards. When slotted into a wetware interface, it allows the user to manipulate local subnet protocols as if editing raw text.
MARKDOWN
            ),

            // ================================================================
            // ARCHETYPE 4: EVENTS (Cataclysms & System Crashes)
            // ================================================================
            array(
                'archetype'   => 'events',
                'title'       => 'The Great Decoupling of \'98',
                'slug'        => 'the-great-decoupling-of-98',
                'summary'     => 'The catastrophic simultaneous severance of global power grids, national banks, and digital archives in 2098.',
                'status'      => 'canon',
                'cover_image' => 'DECOUPLING_CRASH.WEBP',
                'tags'        => array('cataclysms', 'epochs', 'collapse', 'history'),

                'properties'  => array(
                    'epoch'        => 'Post-Collapse Reckoning (1 AC)',
                    'event_date'   => '12 November 2098 / 0 AC',
                    'participants' => 'Global Central Banks, AI Hegemony, Sovereign States',
                    'outcome'      => 'Dissolution of World Governments; Ascendance of Mega-Consortiums',
                ),

                'content_markdown' => <<<MARKDOWN
Within six minutes on a cold November evening, ninety-four percent of all digital banking assets and land deeds vanished into unrecoverable cryptographic noise. In the ensuing starvation riots, corporate security forces assumed executive municipal power, establishing the first modern city-states.
MARKDOWN
            ),

            // ================================================================
            // ARCHETYPE 5: CONCEPTS (Digital Metaphysics & Codes)
            // ================================================================
            array(
                'archetype'   => 'concepts',
                'title'       => 'The Sub-Ether Slipstream',
                'slug'        => 'the-sub-ether-slipstream',
                'summary'     => 'The underlying quantum frequency through which disembodied machine minds and human avatars commune.',
                'status'      => 'canon',
                'cover_image' => 'SUB_ETHER_LATTICE.WEBP',
                'tags'        => array('cyberspace', 'quantum', 'slipstream', 'metaphysics'),

                'properties'  => array(
                    'sphere'       => 'Quantum Cyberspace & Digital Consciousness',
                    'doctrine'     => 'The Meat is Obsolete / Mind Liberation',
                    'sacred_texts' => 'The Ghost Protocol Manifesto, Source-Code of the Precursors',
                ),

                'content_markdown' => <<<MARKDOWN
To the unaugmented, the slipstream is invisible radio background noise. But to an operative jacked into a cranial deck, it appears as an infinite geometric metropolis composed of luminescent light-highways and bottomless data chasms.
MARKDOWN
            ),

            // ================================================================
            // ARCHETYPE 6: ORDERS (Underground Cipher Collectives)
            // ================================================================
            array(
                'archetype'   => 'orders',
                'title'       => 'The Neon Syndicate',
                'slug'        => 'the-neon-syndicate',
                'summary'     => 'Decentralized guerrilla cell of hacktivists, rogue synthetics, and black-market arms merchants.',
                'status'      => 'canon',
                'cover_image' => 'NEON_SYNDICATE_EMBLEM.WEBP',
                'tags'        => array('syndicate', 'hackers', 'rebellion', 'underground'),

                'properties'  => array(
                    'grandmaster' => 'Null_Cipher (Decentralized AI Collective)',
                    'sanctum'     => 'Terminal 404 (Hidden Undercity Server Bunker)',
                    'doctrine'    => 'Information Must Flow Free / Burn the Corporate Backdoors',
                ),

                'content_markdown' => <<<MARKDOWN
Operating from the shadowy steam-conduits of [[terminal-404]], **The Neon Syndicate** maintains the city\'s last unmonitored mesh network. Their operatives fight a relentless shadow war against corporate surveillance drones.
MARKDOWN
            ),

            // ================================================================
            // ARCHETYPE 7: SPECIES (Bio-Mechanical Constructs & Mutants)
            // ================================================================
            array(
                'archetype'   => 'species',
                'title'       => 'Silica Chimera',
                'slug'        => 'silica-chimera',
                'summary'     => 'Feral synthetic biomechanical predators constructed from discarded corporate nanite swarms and carbon flesh.',
                'status'      => 'canon',
                'cover_image' => 'SILICA_CHIMERA_RENDER.WEBP',
                'tags'        => array('synthetic', 'monsters', 'chimeras', 'hazards'),

                'properties'  => array(
                    'classification' => 'Autonomous Biomechanical Hunter / Rogue Nanite Hive',
                    'habitat'        => 'Undercity Ventilation Ducts & Severed Cable Trenches',
                    'threat_level'   => 'Extreme (Bio-Armor Piercing & Neural Shock)',
                ),

                'content_markdown' => <<<MARKDOWN
Originally designed as maintenance drones to clean radioactive ventilation tubes, these units mutated after corporate disposal. They stalk the wet pipes of [[terminal-404]], feeding on discarded cybernetic batteries and unguarded scavengers.
MARKDOWN
            ),

            // ================================================================
            // ARCHETYPE 8: LOCATIONS (Subterranean Sprawls & Havens)
            // ================================================================
            array(
                'archetype'   => 'locations',
                'title'       => 'Terminal 404',
                'slug'        => 'terminal-404',
                'summary'     => 'The lawless subterranean bazaar and black clinic haven located at Sub-Grid Level -40.',
                'status'      => 'canon',
                'cover_image' => 'TERMINAL_404_NEON.WEBP',
                'tags'        => array('sprawl', 'black-market', 'havens', 'undercity'),

                'properties'  => array(
                    'region'              => 'Sector 09 Sub-Grid Level -40',
                    'terrain'             => 'High-Humidity Server Tunnels & Neon-Lit Black Markets',
                    'controlling_faction' => 'The Neon Syndicate & Rogue Barons',
                    'danger_level'        => 'Moderate (Corporate Drone Raids & Toxic Leaks)',
                ),

                'content_markdown' => <<<MARKDOWN
Lit by buzzing pink and violet neon tubing, **Terminal 404** is where decommissioned military tech, illegal combat stims, and contraband memory drives change hands without corporate receipts.
MARKDOWN
            ),

            // ================================================================
            // ARCHETYPE 9: MAGIC (Wetware Slicing & Code Weaver Arts)
            // ================================================================
            array(
                'archetype'   => 'magic',
                'title'       => 'Wetware Neural Slicing',
                'slug'        => 'wetware-neural-slicing',
                'summary'     => 'The high-velocity discipline of manipulating digital code and smart-matter through direct cerebral resonance.',
                'status'      => 'canon',
                'cover_image' => 'NEURAL_SLICING_DIAGRAM.WEBP',
                'tags'        => array('cyberkinesis', 'slicing', 'wetware', 'code'),

                'properties'  => array(
                    'source'        => 'Sub-Dermal Quantum Bio-Chips & Grid Ley-Lines',
                    'practitioners' => 'Elite Netrunners & Cyber-Shamans',
                    'taboos'        => 'Overclocking beyond 95°C Core Temp (Fatal Synaptic Burnout)',
                ),

                'content_markdown' => <<<MARKDOWN
Slicing is not typing on a keyboard; it is an act of pure mental projection. Practitioners project their neural signals through optic jacks, overloading adversary cyberware, turning optical feeds dark, and hacking drone propulsion units in mid-air.
MARKDOWN
            ),

        );
    }

    public static function get_relationships()
    {
        return array(
            array(
                'source'      => 'kestrel-vance',
                'target'      => 'the-prometheus-quantum-shard',
                'type'        => 'bearer of',
                'inverse'     => 'wielded by',
                'description' => 'Embedded in cranial socket IV; exfiltrated from Vectra laboratories.',
            ),
            array(
                'source'      => 'kestrel-vance',
                'target'      => 'the-neon-syndicate',
                'type'        => 'sworn operative of',
                'inverse'     => 'relies on',
                'description' => 'Executes contract wetware extractions for the collective.',
            ),
            array(
                'source'      => 'the-neon-syndicate',
                'target'      => 'terminal-404',
                'type'        => 'headquartered in',
                'inverse'     => 'sanctuary for',
                'description' => 'Maintains encrypted servers in the subterranean tunnels.',
            ),
            array(
                'source'      => 'vectra-mega-consortium',
                'target'      => 'kestrel-vance',
                'type'        => 'placed bounty on',
                'inverse'     => 'hunted by',
                'description' => 'Aegis Security contract issued: 250,000 corporate credits alive, 100,000 dead.',
            ),
            array(
                'source'      => 'silica-chimera',
                'target'      => 'terminal-404',
                'type'        => 'stalks within',
                'inverse'     => 'infested by',
                'description' => 'Infests the cooling pipes directly beneath the lower bazaar.',
            ),
            array(
                'source'      => 'the-great-decoupling-of-98',
                'target'      => 'vectra-mega-consortium',
                'type'        => 'catalyzed the rise of',
                'inverse'     => 'ascended following',
                'description' => 'The collapse of sovereign central banks allowed private security to take power.',
            ),
        );
    }

    public static function get_timeline_events()
    {
        return array(
            array(
                'entry_slug'     => 'the-prometheus-quantum-shard',
                'title'          => 'Genesis of the Prometheus Core',
                'era'            => 'Pre-Collapse Era',
                'event_date'     => 'c. 12 BC (2086 CE)',
                'sort_year'      => -12,
                'end_year'       => NULL,
                'is_approximate' => 1,
                'sort_order'     => 10,
                'summary'        => 'Prometheus Bio-Tech perfects the first self-replicating quantum memory lattice in a secret orbital lab.',
            ),
            array(
                'entry_slug'     => 'the-great-decoupling-of-98',
                'title'          => 'The Great Decoupling of \'98',
                'era'            => 'Year Zero (0 AC)',
                'event_date'     => '12 November 2098',
                'sort_year'      => 0,
                'end_year'       => NULL,
                'is_approximate' => 0,
                'sort_order'     => 20,
                'summary'        => 'Global banking networks suffer permanent synaptic collapse; national currencies become worthless overnight.',
            ),
            array(
                'entry_slug'     => 'vectra-mega-consortium',
                'title'          => 'Completion of The Chromed Needle',
                'era'            => 'Consortium Era',
                'event_date'     => 'c. 45 AC (2143 CE)',
                'sort_year'      => 45,
                'end_year'       => NULL,
                'is_approximate' => 1,
                'sort_order'     => 30,
                'summary'        => 'Vectra finishes construction of the two-kilometer spire, consolidating executive municipal power.',
            ),
            array(
                'entry_slug'     => 'kestrel-vance',
                'title'          => 'The Heist of Terminal 404',
                'era'            => 'Current Cycle',
                'event_date'     => 'Summer, 84 AC (2182 CE)',
                'sort_year'      => 84,
                'end_year'       => NULL,
                'is_approximate' => 0,
                'sort_order'     => 40,
                'summary'        => 'Kestrel Vance extracts the Prometheus Shard from high-security vaults and vanishes into Sector 09.',
            ),
        );
    }
}
