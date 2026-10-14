<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ============================================================================
 * LOREKEEPER // CANAAN SAGA 1 MASTER WORLD DATA SEEDER
 * ============================================================================
 * Built from the existing World_seeder_template.php schema.
 * Scope: Saga 1 only. Saga 2 developments and future-saga revelations are excluded.
 * Unconfirmed dates, places, and mechanics are explicitly marked as provisional.
 */

class Canaan_saga1_seeder {

    public static function get_meta()
    {
        return array(
            'target_world_slug' => 'canaan',
            'name'              => 'Canaan: Saga 1 Master World',
            'description'       => 'Master Saga 1 world data seeder for Canaan, featuring 49 entries across all 9 archetypes, 42 directed relationship bonds, and full chronological timeline.',
            'category'          => 'Master World / Saga 1',
            'version'           => '1.0.0',
        );
    }

    public static function get_world_meta()
    {
        return array(
            'name' => 'Canaan',
            'slug' => 'canaan',
            'description' => 'A world shaped by portals from distant realms, the mysterious force of mana, and the struggle to build a shared home beneath the shadow of an ancient imprisoned power.',
            'visibility' => 'private',
            'compendium_annals_label' => 'I. ANNALS OF CANAAN',
            'compendium_history_p1' => 'Humanity arrived in Canaan after Earth was devastated by global war and nuclear destruction. The 784 survivors emerged from their final bunker into an unfamiliar world where mana and the land itself would make survival possible. They built settlements, preserved the knowledge of their lost home, and gradually encountered other peoples whose histories had begun elsewhere.',
            'compendium_history_p2' => 'For generations, Canaan’s peoples have lived with the white spirals known as portals, through which refugees, materials, and hostile creatures can arrive without warning. The Temple of Leda is revered as a holy place, but beneath it lies a prison whose truth has shaped the world’s history. In the age of the Rogue Bird, the Kingdom of Valoria presents itself as humanity’s shield while hidden forces and old powers threaten the fragile promise of a shared home.',
            'pillar_1_label' => 'PILLAR I // MYTHOS',
            'pillar_1_title' => 'Bahamut and the Hidden Prison',
            'pillar_1_body' => 'An ancient celestial entity lies imprisoned beneath the rock plates of Canaan. Its portals and fragments have influenced the world’s history, while the Temple of Leda conceals the truth behind a sacred legend.',
            'pillar_2_label' => 'PILLAR II // WORLD & COSMOLOGY',
            'pillar_2_title' => 'A World of Many Arrivals',
            'pillar_2_body' => 'Canaan is a world with its own star and moon, varied regions, and a planetary core bound to Bahamut’s prison. Portals have brought beings and materials from other worlds, creating a complex home for peoples with different origins.',
            'pillar_3_label' => 'PILLAR III // CIVILIZATIONS & POWER',
            'pillar_3_title' => 'Valoria and the Rogue Bird',
            'pillar_3_body' => 'The Kingdom of Valoria dominates human politics, shaping public belief through its interpretation of Lady Leda and the threat of Incursions. The Rogue Bird’s journey exposes the tensions between loyalty, freedom, faith, and the possibility of coexistence.',
            'dominant_seat' => 'Valoria’s royal seat (capital name not yet established)',
            'calendar_system' => 'BV / AV (Before Valoria / After Valoria)',
            'current_cycle' => 'c. 1600 AV (Saga 1; approximate)',
            'realm_status' => 'THE AGE OF THE ROGUE BIRD',
            'map_plate_label' => 'PLATE I // CANAAN WORLD ATLAS',
            'map_plate_file' => '',
            'map_node_1' => 'KINGDOM OF VALORIA',
            'map_node_2' => 'SIRAAJ DESERT REGION',
            'map_node_3' => 'TEMPLE OF LEDA',
            'arch_etching_title' => 'PLATE II // THE TEMPLE OF LEDA',
            'arch_etching_caption' => 'A SACRED TEMPLE BUILT ABOVE AN ANCIENT PRISON'
        );
    }

    public static function get_entries()
    {
        return array(
            array(
                'archetype' => 'characters',
                'title' => 'Rahel Draugar',
                'slug' => 'rahel-draugar',
                'summary' => 'A reckless Northern Clan warrior who left home to choose her own path.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'rogue-bird',
                    'northern-clan',
                    'warrior',
                    'red-eagle'
                ),
                'properties' => array(
                    'species' => 'Human',
                    'age' => '17',
                    'occupation' => 'Warrior / Rogue Bird member',
                    'origin_seat' => 'Northern Clan',
                    'clan' => 'Draugar family',
                    'weapon' => 'Sword and battle hatchet',
                    'aspect' => 'Speed, agility, close combat',
                    'abilities' => 'Highly agile melee fighter; bearer of the Red Eagle curse mark on her lower abdomen'
                ),
                'content_markdown' => '**Rahel Draugar** is the only daughter of the Northern Clan’s leader and the sister of five brothers. Though her father forbade her from fighting, she secretly trained alongside her brothers and eventually ran away to seek a life of her own.

Tomboyish, impatient, stubborn, brave, reckless, and flirtatious, Rahel trusts her own instincts more readily than orders. She fights with a sword and battle hatchet, relying on speed, agility, and raw combat skill rather than formal magic.

Her Red Eagle mark is one of the Rogue Bird’s curse marks, connected to the fragments of Bahamut. Her journey with Blondt-Har grows into a romance, but their different hopes for the future lead to a bittersweet separation.'
            ),
            array(
                'archetype' => 'characters',
                'title' => 'Azura Paonne',
                'slug' => 'azura-paonne',
                'summary' => 'A loyal Valorian gate guardian from a poor village who becomes the group’s dependable big sister.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'rogue-bird',
                    'valoria',
                    'guardian',
                    'blue-heron'
                ),
                'properties' => array(
                    'species' => 'Human',
                    'age' => '22',
                    'occupation' => 'Gate guardian / Rogue Bird member',
                    'origin_seat' => 'A poor village in Valoria',
                    'clan' => 'None established',
                    'weapon' => 'Spear and shield',
                    'aspect' => 'Strength and endurance',
                    'abilities' => 'Defensive frontline fighter; bearer of the Blue Heron curse mark across her back'
                ),
                'content_markdown' => '**Azura Paonne** grew up in a poor village. She volunteered for Valoria’s military in the hope that her service would spare her home from crushing taxes. Kind-hearted, humble, caring, loyal, and determined, she often becomes the group’s big sister.

Azura fights with a spear and shield, relying on strength and endurance. Her faith in Valoria is tested as she discovers how the kingdom’s ideals differ from its actions. Her Blue Heron mark, spread across her back, links her to the wider mystery of Bahamut’s curse.

Her loyalty to the kingdom and her bonds with the Rogue Bird eventually collide, forming one of the most painful conflicts of Saga 1.'
            ),
            array(
                'archetype' => 'characters',
                'title' => 'Blondt-Har',
                'slug' => 'blondt-har',
                'summary' => 'A scarred half-elf ranger mercenary who rejects the heritage that mistreated her.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'rogue-bird',
                    'zauberweisse',
                    'half-elf',
                    'ranger',
                    'yellow-hawk'
                ),
                'properties' => array(
                    'species' => 'Half-Elf',
                    'age' => '20',
                    'occupation' => 'Ranger / mercenary',
                    'origin_seat' => 'Zauberweisse',
                    'clan' => 'Elven royal family; exact house name not established',
                    'weapon' => 'Bow, firearms, and throwing weapons',
                    'aspect' => 'Ranged combat and precision vision',
                    'abilities' => 'Exceptional long-distance vision; no elven magic; curse-amplified precision and solar eye beams; Yellow Hawk mark on right shoulder'
                ),
                'content_markdown' => '**Blondt-Har** was born an elven princess but was unknowingly half-human. Her kin treated her harshly, and after her sister Gul-Har became queen, Blondt abandoned her heritage. She cut her own elf ears and left to live as a mercenary.

A tough, independent, rebellious, and quick-tempered ranger, Blondt fights at range with a bow, firearms, and throwing weapons. Although she cannot use magic like other elves, her vision is extraordinarily precise. Her Yellow Hawk curse mark amplifies that precision and grants solar-powered beams from her eyes.

Blondt joins the Rogue Bird for her own reasons and develops a romance with Rahel. By the end of Saga 1, she chooses to return to the people who finally accept her, while Rahel continues toward a more uncertain struggle.'
            ),
            array(
                'archetype' => 'characters',
                'title' => 'Kuroko Mitsuki',
                'slug' => 'kuroko-mitsuki',
                'summary' => 'A sixteen-year-old Earth schoolgirl stranded in Canaan whose smartphone becomes a magical Secret Tome.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'rogue-bird',
                    'earth',
                    'scholar',
                    'black-raven'
                ),
                'properties' => array(
                    'species' => 'Human (from Earth)',
                    'age' => '16',
                    'occupation' => 'Scholar / student',
                    'origin_seat' => 'Earth, another dimension',
                    'clan' => 'None',
                    'weapon' => 'Secret Tome (transformed smartphone)',
                    'aspect' => 'Ancient knowledge and learned space-time techniques',
                    'abilities' => 'Cursed power of deep ancient knowledge; learns time-freezing and destination teleportation through her tome; Black Raven mark on back of left hand'
                ),
                'content_markdown' => '**Kuroko Mitsuki** was an ordinary schoolgirl from Earth before a portal stranded her in Canaan. Her smartphone transformed into a magical book known as the **Secret Tome**, which she uses to study Canaan’s magic while searching for a way home.

Petite, intelligent, focused, mysterious, deadpan, and sarcastic, Kuroko approaches danger with the analytical habits of a scholar. Her actual cursed power is deep ancient knowledge. The space-time techniques she uses—including freezing time and teleporting to a destination—are skills she learns through the tome, not the innate curse itself.

Her search for knowledge becomes increasingly dangerous as the Rogue Bird uncovers the truth behind the curse marks. Her role in Violet’s death is one of Saga 1’s major tragedies.'
            ),
            array(
                'archetype' => 'characters',
                'title' => 'Zara Al-Akhdar',
                'slug' => 'zara-al-akhdar',
                'summary' => 'A quiet desert assassin trained by the Hassans whose violent alter ego is known as the Green Lady.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'rogue-bird',
                    'siraaj',
                    'assassin',
                    'green-owl',
                    'green-lady'
                ),
                'properties' => array(
                    'species' => 'Human',
                    'age' => '18',
                    'occupation' => 'Assassin / Rogue Bird member',
                    'origin_seat' => 'Siraaj Desert',
                    'clan' => 'Hassans',
                    'weapon' => 'Talon dagger',
                    'aspect' => 'Stealth and silent movement',
                    'abilities' => 'Silent movement; Green Lady manifests stronger assassin abilities, including blinking and shadow-like intangibility; Green Owl mark at front center of neck'
                ),
                'content_markdown' => '**Zara Al-Akhdar**, known as the Green Lady when her other identity takes control, grew up an orphan in a harsh, lawless part of Siraaj. She and other children stole to survive, until they robbed the wrong person and were captured. The Hassans took her in and trained her as an assassin.

Zara herself is shy and quiet, while the Green Lady is chaotic, maniacal, and hungry for violence. The split developed through severe trauma and exploitation; the Hassans came to regard the result as evidence that Zara might be their prophesied vessel of Zabaniya.

Zara bears the Green Owl mark at the center front of her neck. Her story concerns the struggle for freedom from the sect that made her into a weapon.'
            ),
            array(
                'archetype' => 'characters',
                'title' => 'Violet Calanthe',
                'slug' => 'violet-calanthe',
                'summary' => 'An ambitious mage from an elite family who seeks forbidden power and recognition.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'rogue-bird',
                    'calanthe',
                    'mage',
                    'purple-peacock'
                ),
                'properties' => array(
                    'species' => 'Human',
                    'age' => '19',
                    'occupation' => 'Mage / Rogue Bird member',
                    'origin_seat' => 'House of Calanthe',
                    'clan' => 'House of Calanthe',
                    'weapon' => 'Magic wand',
                    'aspect' => 'Elemental magic and dark magic manipulation',
                    'abilities' => 'Elemental magic; forbidden dark magic; Purple Peacock curse mark on left thigh'
                ),
                'content_markdown' => '**Violet Calanthe** was born into an elite family and always had access to privilege, yet never felt satisfied. Prideful, elegant, ambitious, and driven, she seeks forbidden dark magic to prove her worth and earn the recognition she craves.

Violet wields a wand and commands elemental magic as well as dark magic manipulation. Her Purple Peacock mark is part of the curse system tied to Bahamut. Her ambition and the pressure she places on herself become central to her tragedy.

Violet’s relationship with Kuroko ends in catastrophe when Kuroko kills her, a pivotal rupture in the Rogue Bird’s story.'
            ),
            array(
                'archetype' => 'characters',
                'title' => 'Lady Leda',
                'slug' => 'lady-leda',
                'summary' => 'A legendary explorer whose discovery of Bahamut’s prison transformed her into humanity’s revered savior.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'leda',
                    'legend',
                    'first-portal-wars',
                    'phoenix-mark'
                ),
                'properties' => array(
                    'species' => 'Human',
                    'age' => 'Historical figure; exact age unknown',
                    'occupation' => 'Explorer / legendary knight',
                    'origin_seat' => 'Early human civilization in Canaan',
                    'clan' => 'Expedition companions: Carlos, Christoph, Ariel, Leon, Abigail, and Clay',
                    'weapon' => 'Sword of Valor',
                    'aspect' => 'Healing, regeneration, radiant flight, and light beams',
                    'abilities' => 'Powers gained after touching Bahamut’s horn; golden phoenix mark between her breasts over her heart'
                ),
                'content_markdown' => 'Before she became a legendary saint-like figure, **Lady Leda** was an expedition leader searching Canaan for resources and ruins. Her companions—Carlos, Christoph, Ariel, Leon, Abigail, and Clay—accompanied her into a deep cave, where she touched the tip of Bahamut’s horn and formed a connection with the imprisoned entity.

Leda gained healing, regeneration, flight with radiant wings, and powerful beams of light. A golden phoenix mark appeared over her heart and spread as she used her powers, gradually turning her into a potential vessel for Bahamut. During the First Portal Wars, humanity came to worship her as a savior, while Bahamut tempted her with the prospect of becoming a god-like protector.

Leda ultimately refused that destiny and sealed herself with Bahamut. The Temple of Leda was built above the prison to strengthen its protections and conceal its true purpose. Her legacy is both a genuine act of sacrifice and the foundation of a faith later distorted for political ends.'
            ),
            array(
                'archetype' => 'characters',
                'title' => 'King Aldric',
                'slug' => 'king-aldric',
                'summary' => 'The final antagonist of Saga 1 and ruler of Valoria, corrupted by the All Black Sword.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'valoria',
                    'royalty',
                    'antagonist',
                    'all-black-sword'
                ),
                'properties' => array(
                    'species' => 'Human',
                    'age' => 'In his fifties',
                    'occupation' => 'King of Valoria',
                    'origin_seat' => 'Kingdom of Valoria',
                    'clan' => 'Valerian royal bloodline',
                    'weapon' => 'All Black Sword',
                    'aspect' => 'Royal authority and swordsmanship',
                    'abilities' => 'Wields the corrupted All Black Sword; final major antagonist of Saga 1'
                ),
                'content_markdown' => '**King Aldric** is the final major antagonist of Saga 1. In his fifties, he has short white hair and facial hair, a gold crown, a red fur-lined cape, armor, and a blue tunic bearing Valoria’s winged-sword emblem.

The All Black Sword, a ceremonial royal weapon containing a fragment of Bahamut, corrupts its bearer. Under its influence, Valoria’s claim to defend humanity becomes a vehicle for conquest and domination. Aldric’s reign brings the Rogue Bird into direct conflict with the kingdom’s power.

Rahel ultimately defeats Aldric and keeps the All Black Sword. This closes the immediate royal conflict without resolving the larger danger posed by the Hews and Bahamut.'
            ),
            array(
                'archetype' => 'characters',
                'title' => 'Kingu',
                'slug' => 'kingu',
                'summary' => 'The leader of the Hews, a refugee people who secretly seek to free Bahamut.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'hews',
                    'conspiracy',
                    'bahamut'
                ),
                'properties' => array(
                    'species' => 'Human (Hew)',
                    'age' => 'Unknown',
                    'occupation' => 'Leader of the Hews',
                    'origin_seat' => 'A dying, plague-ridden world',
                    'clan' => 'The Hews',
                    'weapon' => 'Not established',
                    'aspect' => 'Religious and political leadership',
                    'abilities' => 'Directs the Hews’ long-term covert agenda'
                ),
                'content_markdown' => '**Kingu** leads the Hews, refugees who entered Canaan from a world devastated by plague. Welcomed by General Valerius, they came to believe Canaan was the divine land promised by their god Arsses. Ancient texts beneath the Temple of Leda later connected their beliefs to Bahamut.

The Hews secretly vowed to free Bahamut and infiltrated Canaanian politics. Their manipulation of the Valerian royal line helped turn Valoria into an instrument for their long-term plans. Their immediate objective in Saga 1’s background is to destroy the Temple of Leda and reopen Bahamut’s portal so the surviving Hews can escape their dying world and invade Canaan.'
            ),
            array(
                'archetype' => 'characters',
                'title' => 'Gul-Har',
                'slug' => 'gul-har',
                'summary' => 'Blondt-Har’s sister and the elven queen who became her only protector before Blondt’s departure.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'zauberweisse',
                    'elves',
                    'royalty',
                    'blondt-har'
                ),
                'properties' => array(
                    'species' => 'Elf',
                    'age' => 'Unknown',
                    'occupation' => 'Queen of Zauberweisse',
                    'origin_seat' => 'Zauberweisse',
                    'clan' => 'Elven royal family',
                    'weapon' => 'Not established',
                    'aspect' => 'Royal leadership',
                    'abilities' => 'Not established'
                ),
                'content_markdown' => '**Gul-Har** is Blondt-Har’s sister. She was Blondt’s only protector during a childhood marked by mistreatment from their elven kin. When Gul-Har rose to become queen, Blondt nevertheless abandoned her homeland, rejecting the heritage that had made her feel unwanted.

The details of Gul-Har’s reign and the wider politics of Zauberweisse remain to be established. This entry records the family connection without inventing additional motives or events.'
            ),
            array(
                'archetype' => 'characters',
                'title' => 'Melissa',
                'slug' => 'melissa',
                'summary' => 'A small orange, antlered creature whose bonds with the Rogue Bird unlock unusual transformations.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'rogue-bird',
                    'companion',
                    'transformations'
                ),
                'properties' => array(
                    'species' => 'Unusual magical creature; exact classification unknown',
                    'age' => 'Unknown',
                    'occupation' => 'Companion',
                    'origin_seat' => 'Unknown',
                    'clan' => 'Rogue Bird',
                    'weapon' => 'None established',
                    'aspect' => 'Transformation',
                    'abilities' => 'Limited speech; dragon form and other animal forms; later gains human form through bonding; associated with the Verdant Weave'
                ),
                'content_markdown' => '**Melissa** is an orange, kitten-like creature with tiny antlers, a tail, and slit pupils. She is soft, graceful, and feminine in presentation rather than muscular, and speaks only in a limited way.

Melissa can take a dragon form and other animal forms. Through bonding, she later gains a human form. The Verdant Weave is associated with Violet and Kuroko’s work involving her. Melissa’s exact species and origin have not yet been established, so those details remain open.'
            ),
            array(
                'archetype' => 'characters',
                'title' => 'Skadi',
                'slug' => 'skadi',
                'summary' => 'A sentient former warhorse who willingly carries the Rogue Bird’s wagon and travels as their companion.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'rogue-bird',
                    'companion',
                    'shapeshifter'
                ),
                'properties' => array(
                    'species' => 'Sentient magical horse / human-shifting being',
                    'age' => 'Unknown',
                    'occupation' => 'Wagon carrier and companion',
                    'origin_seat' => 'Unknown',
                    'clan' => 'Rogue Bird',
                    'weapon' => 'None established',
                    'aspect' => 'Strength and transformation',
                    'abilities' => 'Can transform between a white draft horse and a human woman; transformation does not create clothing'
                ),
                'content_markdown' => '**Skadi** is a sentient magical warhorse who was once enslaved. The Rogue Bird gives her a new purpose, and she willingly travels with the group as the wagon carrier and companion.

In horse form she is a powerful white draft horse. In human form she is approximately 188 cm (6 ft 2 in), tall and heavily muscular, with ice-blue eyes and white mane-like hair. Her collar, piercings, and branding scars remain after transformation; she does not generate clothing when she changes shape. Her design is rugged and dignified, not intended as sexualized presentation.'
            ),
            array(
                'archetype' => 'nations',
                'title' => 'Kingdom of Valoria',
                'slug' => 'kingdom-of-valoria',
                'summary' => 'The largest human empire in Canaan, whose royal power and public faith conceal a history of manipulation.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'valoria',
                    'humanity',
                    'empire',
                    'politics'
                ),
                'properties' => array(
                    'government' => 'Monarchy',
                    'ruler' => 'King Aldric during Saga 1',
                    'capital' => 'Royal seat; capital name not established',
                    'population' => 'Not established',
                    'military' => 'Valorian military and royal forces',
                    'climate' => 'Varies across its territories'
                ),
                'content_markdown' => '**Valoria** is the largest human empire in Canaan. Founded by Valerius after a civil war, it built its legitimacy around order, human unity, and a distorted interpretation of Lady Leda’s legacy. Incursions are used in public messaging to present Valoria as humanity’s necessary shield.

Behind the kingdom’s official story, the Hews manipulated Valorian politics over generations and used the All Black Sword to corrupt the royal line. During Saga 1, King Aldric’s reign brings Valoria into conflict with the Rogue Bird. Valoria is not simply a villainous nation: its people, soldiers, and local communities have varied motives and loyalties.'
            ),
            array(
                'archetype' => 'nations',
                'title' => 'The Northern Clan',
                'slug' => 'the-northern-clan',
                'summary' => 'A northern warrior community led by Rahel Draugar’s father.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'northern-clan',
                    'draugar',
                    'rahel'
                ),
                'properties' => array(
                    'government' => 'Clan leadership',
                    'ruler' => 'Rahel’s father; personal name not established',
                    'capital' => 'Not established',
                    'population' => 'Not established',
                    'military' => 'Clan warriors',
                    'climate' => 'Northern region; exact climate not established'
                ),
                'content_markdown' => 'The **Northern Clan** is Rahel Draugar’s homeland. Its leader is her father, and Rahel is his only daughter among five brothers. The clan’s expectations forbid her from fighting, even as she secretly trains with her brothers.

Its broader customs, territory, and political relationships remain open for future development. The clan entry should preserve what is established without inventing a full social system.'
            ),
            array(
                'archetype' => 'nations',
                'title' => 'Siraaj',
                'slug' => 'siraaj',
                'summary' => 'A harsh desert region associated with lawless settlements and the secretive Hassans.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'siraaj',
                    'desert',
                    'zara',
                    'hassans'
                ),
                'properties' => array(
                    'government' => 'No unified government established',
                    'ruler' => 'Not established',
                    'capital' => 'Not established',
                    'population' => 'Not established',
                    'military' => 'Not established',
                    'climate' => 'Desert'
                ),
                'content_markdown' => '**Siraaj** is a harsh desert region associated with outcasts, criminals, and people beyond Valoria’s direct claim. Zara grew up in a poor, lawless town here, surviving alongside other orphaned children before the Hassans captured and trained her.

The region’s political status, settlements, and internal cultures have not yet been fully defined. Its entry should leave those fields open rather than treating rumor about the region as objective truth.'
            ),
            array(
                'archetype' => 'nations',
                'title' => 'Zauberweisse',
                'slug' => 'zauberweisse',
                'summary' => 'The elven homeland associated with Blondt-Har and Queen Gul-Har.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'zauberweisse',
                    'elves',
                    'blondt-har'
                ),
                'properties' => array(
                    'government' => 'Monarchy',
                    'ruler' => 'Queen Gul-Har',
                    'capital' => 'Not established',
                    'population' => 'Not established',
                    'military' => 'Not established',
                    'climate' => 'Not established'
                ),
                'content_markdown' => '**Zauberweisse** is the elven homeland of Blondt-Har and Gul-Har. Blondt was born into its royal family but was mistreated by her kin after her half-human heritage went unrecognized. Her sister Gul-Har eventually became queen and had been Blondt’s only protector.

The country’s geography, institutions, and relationship with Valoria are not yet fully established. The central known conflict is Blondt’s rejection of a heritage that never accepted her, followed by her eventual decision to return when acceptance becomes possible.'
            ),
            array(
                'archetype' => 'artifacts',
                'title' => 'The All Black Sword',
                'slug' => 'the-all-black-sword',
                'summary' => 'A ceremonial Valorian longsword containing a fragment of Bahamut that corrupts its bearer.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'valoria',
                    'bahamut',
                    'relic',
                    'curse'
                ),
                'properties' => array(
                    'item_class' => 'Ceremonial royal longsword',
                    'origin_creator' => 'Not established',
                    'materials' => 'Ceremonial silver and gold appearance; contains a fragment of Bahamut',
                    'wielder' => 'King Aldric during Saga 1; Rahel keeps it after his defeat',
                    'powers' => 'Corrupts its bearer; linked to Bahamut’s influence'
                ),
                'content_markdown' => 'The **All Black Sword** is a ceremonial sword used in Valorian coronations. Its public appearance is silver and gold, with an ornate crossguard, but its true cursed form is black. A fragment of Bahamut is embedded within it.

The Hews used the sword to corrupt Valerius and turn his legacy toward conquest, helping establish the political order that became Valoria. Generations later, the sword continues to influence the royal bloodline and King Aldric. At the end of Saga 1, Rahel defeats Aldric and keeps the weapon, leaving its danger unresolved.'
            ),
            array(
                'archetype' => 'artifacts',
                'title' => 'The Sword of Valor',
                'slug' => 'the-sword-of-valor',
                'summary' => 'The legendary weapon associated with Lady Leda and her role in the First Portal Wars.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'leda',
                    'relic',
                    'first-portal-wars'
                ),
                'properties' => array(
                    'item_class' => 'Legendary sword',
                    'origin_creator' => 'Not established',
                    'materials' => 'Not established',
                    'wielder' => 'Lady Leda in the legends',
                    'powers' => 'Associated with Leda’s radiant power; later history is connected to a stolen and blackened sword'
                ),
                'content_markdown' => 'The **Sword of Valor** is associated with Lady Leda’s legendary life and the light that made her a symbol of hope during the First Portal Wars. Its full construction, original creator, and complete chain of ownership are not yet established.

Later accounts connect Leda’s sword legacy to a stolen and blackened weapon. The precise relationship between the Sword of Valor and the All Black Sword should remain flagged for confirmation rather than being silently treated as settled detail.'
            ),
            array(
                'archetype' => 'artifacts',
                'title' => 'The Secret Tome',
                'slug' => 'the-secret-tome',
                'summary' => 'Kuroko Mitsuki’s smartphone transformed into a magical book through which she studies Canaan’s magic.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'kuroko',
                    'magic',
                    'earth',
                    'relic'
                ),
                'properties' => array(
                    'item_class' => 'Transformed personal device / magical tome',
                    'origin_creator' => 'Originally Kuroko’s smartphone; transformation cause not fully established',
                    'materials' => 'Unknown after transformation',
                    'wielder' => 'Kuroko Mitsuki',
                    'powers' => 'Stores and enables study of ancient knowledge and learned space-time techniques'
                ),
                'content_markdown' => 'The **Secret Tome** began as Kuroko Mitsuki’s smartphone from Earth and transformed into a magical book after she arrived in Canaan. Kuroko uses it to study the world’s magic and develop techniques that include freezing time and teleporting to a destination.

The tome is a learning tool and conduit for techniques, while Kuroko’s innate cursed power is deep ancient knowledge. It does not grant her a general ability to rewind history.'
            ),
            array(
                'archetype' => 'events',
                'title' => 'Humanity Arrives in Canaan',
                'slug' => 'humanity-arrives-in-canaan',
                'summary' => 'Seven hundred and eighty-four survivors from Earth reach Canaan after the destruction of their world.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'history',
                    'earth',
                    'settlement'
                ),
                'properties' => array(
                    'epoch' => 'Early human-colony era',
                    'event_date' => 'Year 0 BV',
                    'participants' => '784 human survivors',
                    'outcome' => 'Survivors establish a new home in Canaan'
                ),
                'content_markdown' => 'After Earth was devastated by global war and nuclear destruction, **784 survivors** emerged from their final bunker and entered Canaan. They brought remnants of their former world and knowledge of a civilization that no longer existed, but not an advanced technological society capable of simply rebuilding Earth.

Canaan’s magic helped protect the survivors from the effects of radiation and the collapse of their old environment. Their arrival marks Year 0 BV in the colony calendar.'
            ),
            array(
                'archetype' => 'events',
                'title' => 'Founding of the First City',
                'slug' => 'founding-of-the-first-city',
                'summary' => 'The survivors establish their first city and central government ten years after arriving in Canaan.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'history',
                    'settlement',
                    'humanity'
                ),
                'properties' => array(
                    'epoch' => 'Early human-colony era',
                    'event_date' => 'Year 10 BV',
                    'participants' => 'The first human settlers',
                    'outcome' => 'A permanent city and central government are established'
                ),
                'content_markdown' => 'Ten years after arriving in Canaan, the survivors establish their first city and a central government. This marks the transition from a precarious refugee settlement toward a lasting human community.'
            ),
            array(
                'archetype' => 'events',
                'title' => 'Founding of Mara Library',
                'slug' => 'founding-of-mara-library',
                'summary' => 'The first death among the settlers inspires the preservation of memory and the founding of the archive.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'history',
                    'mara-library',
                    'archive'
                ),
                'properties' => array(
                    'epoch' => 'Early human-colony era',
                    'event_date' => 'Around Year 100 BV',
                    'participants' => 'Early human settlers',
                    'outcome' => 'The archive that becomes Mara Library is founded'
                ),
                'content_markdown' => 'The first death among the human settlers was an elder who had lived long enough to see the new community take root. The survivors preserved records and memories rather than allowing the person’s life to disappear from history. The archive that became **Mara Library** grew from this act of remembrance.

The library eventually included a tower and deep underground levels. Its surface spaces remained usable, while knowledge of advanced Earth technology came to be feared by later generations as “dark magic.”'
            ),
            array(
                'archetype' => 'events',
                'title' => 'Expansion of Human Settlements',
                'slug' => 'expansion-of-human-settlements',
                'summary' => 'Human settlements expand across Canaan and make contact with other peoples.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'history',
                    'settlement',
                    'humanity'
                ),
                'properties' => array(
                    'epoch' => 'Early human-colony era',
                    'event_date' => 'Around Year 600 BV',
                    'participants' => 'Human settlements and peoples encountered in Canaan',
                    'outcome' => 'Expansion beyond the earliest colony; details vary by region'
                ),
                'content_markdown' => 'Around Year 600 BV, human settlements expanded beyond the earliest community, with coastal and mountain settlements and further contact with other peoples. Canaan’s developing civilization became more geographically and culturally varied, though the exact names and dates of each settlement are not yet established.'
            ),
            array(
                'archetype' => 'events',
                'title' => 'Lady Leda’s Expedition',
                'slug' => 'lady-ledas-expedition',
                'summary' => 'Leda’s expedition discovers Bahamut’s underground prison and changes the course of Canaanian history.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'leda',
                    'bahamut',
                    'exploration'
                ),
                'properties' => array(
                    'epoch' => 'Early human-colony era',
                    'event_date' => 'Around Year 200 BV; approximate',
                    'participants' => 'Leda, Carlos, Christoph, Ariel, Leon, Abigail, and Clay',
                    'outcome' => 'Discovery of the prison; Leda gains extraordinary powers'
                ),
                'content_markdown' => 'During an era when the young civilization lacked a formal army, Leda led an expedition across Canaan to investigate its ruins and resources. Deep underground, she and her companions discovered Bahamut’s prison. Leda touched the tip of Bahamut’s horn, gaining extraordinary powers and a connection that would define her fate.'
            ),
            array(
                'archetype' => 'events',
                'title' => 'The First Portal Wars',
                'slug' => 'the-first-portal-wars',
                'summary' => 'Canaan’s early people fight hostile beings arriving through portals while Lady Leda becomes a legendary savior.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'war',
                    'portals',
                    'leda',
                    'history'
                ),
                'properties' => array(
                    'epoch' => 'Early human-colony era',
                    'event_date' => 'After Lady Leda’s discovery; exact dates unknown',
                    'participants' => 'Early Canaanian communities, Lady Leda, otherworldly invaders',
                    'outcome' => 'Leda’s legend grows; the prison is concealed beneath the Temple of Leda'
                ),
                'content_markdown' => 'After Leda’s discovery, portals and otherworldly threats became part of Canaan’s history. During the First Portal Wars, Leda’s healing, regeneration, radiant wings, and light beams made her a celebrated protector of humanity.

The public remembered a savior; the deeper truth was more dangerous. Bahamut tempted Leda with god-like power, and her phoenix mark spread as she used her abilities. She eventually refused the role of a god and sealed herself with Bahamut.'
            ),
            array(
                'archetype' => 'events',
                'title' => 'The Founding of Valoria',
                'slug' => 'the-founding-of-valoria',
                'summary' => 'Valerius establishes Valoria after a civil war, beginning a new royal calendar.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'valoria',
                    'history',
                    'hews'
                ),
                'properties' => array(
                    'epoch' => 'Valorian era',
                    'event_date' => 'Around Year 3000 BV / Year 1 AV; chronology provisional',
                    'participants' => 'Valerius, rival human factions, the Hews',
                    'outcome' => 'The Kingdom of Valoria is founded and the AV calendar begins'
                ),
                'content_markdown' => 'After a civil war, Valerius rose to power and founded the Kingdom of Valoria. The Hews had secretly influenced events through the All Black Sword, corrupting Valerius and steering his rule toward conquest.

Valoria’s founding marks the proposed transition from BV, the human-colony calendar, to AV, the calendar counted from Valoria. The exact alignment between the two systems remains provisional in the current chronology.'
            ),
            array(
                'archetype' => 'events',
                'title' => 'The Rogue Bird’s Campaign',
                'slug' => 'the-rogue-birds-campaign',
                'summary' => 'The six women of the Rogue Bird confront Valoria’s growing threat and uncover the consequences of Bahamut’s curse.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'rogue-bird',
                    'saga-1',
                    'valoria'
                ),
                'properties' => array(
                    'epoch' => 'Rogue Bird era',
                    'event_date' => 'Around Year 1600 AV; approximate',
                    'participants' => 'Rahel, Azura, Blondt-Har, Kuroko, Zara, Violet, and their allies',
                    'outcome' => 'The Rogue Bird’s bonds are tested; King Aldric is defeated'
                ),
                'content_markdown' => 'During Saga 1, the Rogue Bird’s journey brings six women with different origins and motives into conflict with Valoria’s power and the mystery of the curse marks. Their relationships fracture under pressure: Violet dies at Kuroko’s hands, the Green Lady kills Melissa and dies, and Azura’s betrayal ends in her death.

Kuroko later revives Rahel using Blondt’s eye power. Rahel defeats King Aldric and keeps the All Black Sword. The saga closes on a bittersweet separation: Blondt chooses to return to her people, who now accept her, while Rahel believes her fight is not over.'
            ),
            array(
                'archetype' => 'concepts',
                'title' => 'Bahamut',
                'slug' => 'bahamut',
                'summary' => 'An ancient imprisoned entity beneath Canaan whose portals and fragments have shaped the world.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'cosmology',
                    'portals',
                    'curse',
                    'central-mystery'
                ),
                'properties' => array(
                    'sphere' => 'Cosmology / ancient power',
                    'doctrine' => 'Not applicable',
                    'sacred_texts' => 'Ancient texts beneath the Temple of Leda; exact titles unknown'
                ),
                'content_markdown' => '**Bahamut** is an ancient celestial entity imprisoned deep beneath Canaan, under layers of rock that form part of the world’s core. His influence is associated with the white spiral portals that bring creatures, materials, and refugees from other worlds.

Fragments of Bahamut’s celestial body carry power and can corrupt those who use them. The Hews discovered ancient texts beneath the Temple of Leda and connected their god Arsses to Bahamut, leading them to seek his release. Bahamut once whispered to Lady Leda, tempting her to become a god-like savior; the established Saga 1 lore does not establish that he whispers to every curse bearer.'
            ),
            array(
                'archetype' => 'concepts',
                'title' => 'Mana',
                'slug' => 'mana',
                'summary' => 'A supernatural force that rewrites the physical laws of matter it touches.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'magic',
                    'cosmology',
                    'world-rules'
                ),
                'properties' => array(
                    'sphere' => 'Fundamental supernatural force',
                    'doctrine' => 'Mana changes the physical laws of touched matter',
                    'sacred_texts' => 'Not established'
                ),
                'content_markdown' => '**Mana** is a fundamental force in Canaan. Rather than simply acting as energy in the ordinary sense, it rewrites the physical laws of the matter it touches. Humans cannot directly sense mana, even though it shapes the world around them.

Mana and Canaan’s other supernatural phenomena make survival and transformation possible in ways that would not have been possible on the survivors’ ruined Earth. The precise limits and taxonomy of mana remain open for future definition.'
            ),
            array(
                'archetype' => 'concepts',
                'title' => 'The Curse of Bahamut',
                'slug' => 'the-curse-of-bahamut',
                'summary' => 'A family of powers linked to fragments of Bahamut that can spread marks and corrupt their bearers.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'bahamut',
                    'curse',
                    'rogue-bird',
                    'magic'
                ),
                'properties' => array(
                    'sphere' => 'Celestial fragment / supernatural corruption',
                    'doctrine' => 'Power use and a bearer’s desire to become a savior can accelerate corruption',
                    'sacred_texts' => 'Not established'
                ),
                'content_markdown' => 'The **Curse of Bahamut** originates in fragments of Bahamut’s celestial body. Its bearers manifest different powers, and the curse marks are associated with the fragments’ influence. The Rogue Bird’s six marks resemble pieces of wings or vessels when considered together.

Using the power and embracing the desire to save or rule others as a god-like figure can cause the mark to spread and the bearer to become corrupted or monstrous. The exact mechanics vary by bearer and should not be collapsed into one identical ability set.'
            ),
            array(
                'archetype' => 'concepts',
                'title' => 'The Temple of Leda',
                'slug' => 'the-temple-of-leda',
                'summary' => 'A revered holy site built above Bahamut’s prison to strengthen its seals and disguise its purpose.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'leda',
                    'bahamut',
                    'temple',
                    'religion'
                ),
                'properties' => array(
                    'sphere' => 'Sacred site / prison seal',
                    'doctrine' => 'Publicly revered as holy; secretly safeguards Bahamut’s prison',
                    'sacred_texts' => 'Not established'
                ),
                'content_markdown' => 'The **Temple of Leda** was built above the place where Leda discovered Bahamut’s prison. Its enchantments suppress Bahamut’s influence, while the temple’s public reputation as a holy site helps misdirect those who might otherwise search for the prison.

For many people, the temple represents Leda’s holiness and sacrifice. Its hidden function is more literal: it is a guardian structure intended to keep Bahamut imprisoned. The Hews’ plan to destroy it threatens both the seal and Canaan’s future.'
            ),
            array(
                'archetype' => 'concepts',
                'title' => 'Incursions',
                'slug' => 'incursions',
                'summary' => 'Portal-related threats that Valoria uses in its public narrative to justify human unity and centralized order.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'valoria',
                    'portals',
                    'propaganda'
                ),
                'properties' => array(
                    'sphere' => 'Public threat / political narrative',
                    'doctrine' => 'Valoria presents itself as humanity’s shield against incursions',
                    'sacred_texts' => 'Valorian interpretations of Lady Leda’s faith; exact texts unknown'
                ),
                'content_markdown' => 'Portals bring hostile creatures into Canaan, and these dangers become part of the public idea of **Incursions**. Valoria uses the threat to argue that humanity needs unity, order, and strong centralized rule.

The danger is real, but Valoria’s interpretation of Lady Leda’s legacy distorts the meaning of her sacrifice to support imperial power. The lore should distinguish actual portal events from political claims made about them.'
            ),
            array(
                'archetype' => 'orders',
                'title' => 'The Rogue Bird',
                'slug' => 'the-rogue-bird',
                'summary' => 'A traveling group of six women whose journey exposes political, personal, and supernatural conflicts in Canaan.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'rogue-bird',
                    'adventurers',
                    'saga-1'
                ),
                'properties' => array(
                    'grandmaster' => 'No formal leader established',
                    'sanctum' => 'Their traveling wagon',
                    'doctrine' => 'No formal doctrine; members pursue overlapping personal goals'
                ),
                'content_markdown' => 'The **Rogue Bird** is the central traveling group of Saga 1: Rahel Draugar, Azura Paonne, Blondt-Har, Kuroko Mitsuki, Zara Al-Akhdar, and Violet Calanthe. They come from different cultures and circumstances, and each brings distinct skills, loyalties, and reasons for traveling.

Their adventure has a lively surface, but the group becomes entangled in Valorian politics, the curse marks, and the hidden history of Bahamut. Their bonds do not protect them from tragedy: members die, loyalties fracture, and the survivors reach different conclusions about what home means.'
            ),
            array(
                'archetype' => 'orders',
                'title' => 'The Hassans',
                'slug' => 'the-hassans',
                'summary' => 'A secretive assassin sect that trains children and seeks a vessel associated with its salvation prophecy.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'hassans',
                    'siraaj',
                    'assassins',
                    'zara'
                ),
                'properties' => array(
                    'grandmaster' => 'Hassan al Qadim, known as the Old Man',
                    'sanctum' => 'Secret operations in Siraaj; exact location unknown',
                    'doctrine' => 'Followers worship Zabaniya and seek salvation at the end of Canaan'
                ),
                'content_markdown' => 'The **Hassans** are a secretive assassin sect operating in Siraaj. They train agents through specialized divisions and worship Zabaniya, whom their followers associate with salvation at the end of Canaan. Their members do not understand their faith as worship of Bahamut; the connection is part of the setting’s deeper mystery.

The sect’s leaders include Hassan al Qadim, known as the Old Man, with a veiled presence and cobra staff; Raas, called Crocodile, a massive executioner; and Skarlet, called Spider, who manages operations, clients, and targets. Zara was trained by the Hassans and became central to their hopes for a vessel.'
            ),
            array(
                'archetype' => 'orders',
                'title' => 'The Hews',
                'slug' => 'the-hews',
                'summary' => 'Refugees from a dying world who infiltrated Valorian politics to free Bahamut and reopen their route into Canaan.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'hews',
                    'conspiracy',
                    'valoria',
                    'bahamut'
                ),
                'properties' => array(
                    'grandmaster' => 'Kingu',
                    'sanctum' => 'Embedded within Canaanian society; exact headquarters unknown',
                    'doctrine' => 'Originally worship Arsses; later connect their faith to Bahamut through ancient texts'
                ),
                'content_markdown' => 'The **Hews** arrived in Canaan as refugees from a dying, plague-ridden world. General Valerius welcomed them, and they came to believe Canaan was the divine land promised by their god Arsses. Ancient texts found beneath the Temple of Leda later linked Arsses to Bahamut.

Led by Kingu, the Hews secretly vowed to free Bahamut and infiltrated Canaanian politics. They used the All Black Sword to corrupt Valerius and helped shape Valoria’s royal line as a pawn. Their Saga 1 objective is to destroy the Temple of Leda and reopen Bahamut’s portal, allowing the remaining Hews to escape their dead world and invade Canaan.'
            ),
            array(
                'archetype' => 'species',
                'title' => 'Humans of Canaan',
                'slug' => 'humans-of-canaan',
                'summary' => 'Humans in Canaan include descendants of Earth’s survivors and peoples who arrived through portals.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'species',
                    'humanity',
                    'refugees'
                ),
                'properties' => array(
                    'classification' => 'Human',
                    'habitat' => 'Settlements throughout Canaan',
                    'threat_level' => 'Varies by individual and society'
                ),
                'content_markdown' => 'Humans in Canaan do not share a single origin. The first human colony consisted of 784 survivors from Earth’s final bunker, while later portals also brought people and materials from other worlds. Canaan’s human communities developed different political systems and cultures over time.

The arrival of refugees is central to Canaan’s theme: the world becomes a possible second home for peoples displaced from worlds that can no longer sustain them.'
            ),
            array(
                'archetype' => 'species',
                'title' => 'Elves',
                'slug' => 'elves',
                'summary' => 'A people with their own magical traditions and homeland, including the royal family of Zauberweisse.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'species',
                    'elves',
                    'zauberweisse'
                ),
                'properties' => array(
                    'classification' => 'Elven people',
                    'habitat' => 'Zauberweisse; further regions not established',
                    'threat_level' => 'Not applicable as a people'
                ),
                'content_markdown' => 'Elves are a people with magical abilities and a distinct heritage. Blondt-Har’s inability to perform elven magic is connected to her half-human ancestry, which was not understood by her kin during her childhood.

The established lore does not yet define all elven customs, lifespans, or political institutions. Blondt’s experience of mistreatment should not automatically be treated as a complete description of every elf.'
            ),
            array(
                'archetype' => 'species',
                'title' => 'Portaled Creatures',
                'slug' => 'portaled-creatures',
                'summary' => 'Hostile creatures that enter Canaan through the white spiral portals.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'species',
                    'portals',
                    'incursions',
                    'monsters'
                ),
                'properties' => array(
                    'classification' => 'Varied otherworldly beings',
                    'habitat' => 'Portals and regions of Canaan after arrival',
                    'threat_level' => 'Varies; some are hostile'
                ),
                'content_markdown' => 'Canaan’s portals can bring hostile creatures from other worlds. Their origins, bodies, and abilities vary, and their arrival contributes to the danger that communities face beyond their borders.

Valoria invokes these threats through its political narrative of Incursions. Individual creature species and their behaviors should be recorded separately once they are established in the canon.'
            ),
            array(
                'archetype' => 'species',
                'title' => 'Sentient Shifters',
                'slug' => 'sentient-shifters',
                'summary' => 'A provisional category for beings such as Skadi who can change between animal and human forms.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'species',
                    'transformation',
                    'skadi'
                ),
                'properties' => array(
                    'classification' => 'Unusual magical beings; taxonomy provisional',
                    'habitat' => 'Not established',
                    'threat_level' => 'Varies'
                ),
                'content_markdown' => 'Some beings in Canaan can transform between forms that ordinary animals and humans cannot. Skadi, for example, is a sentient magical warhorse who can take the form of a human woman.

This entry is a provisional grouping rather than a claim that all such beings share one biological species. Skadi’s exact origin and the rules governing her transformation remain to be established.'
            ),
            array(
                'archetype' => 'locations',
                'title' => 'Mara Library',
                'slug' => 'mara-library',
                'summary' => 'A tower and underground archive founded to preserve the memory and knowledge of the first human settlers.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'archive',
                    'history',
                    'earth',
                    'humanity'
                ),
                'properties' => array(
                    'region' => 'Early human settlement; precise location not established',
                    'terrain' => 'Tower with deep underground levels',
                    'controlling_faction' => 'Human archive keepers; formal organization not established',
                    'danger_level' => 'Some underground knowledge is feared as dark magic'
                ),
                'content_markdown' => '**Mara Library** began as an act of remembrance after the first death among the human settlers. Over time it became a tower and deep underground archive, preserving records from Earth and the history of the growing colony.

The surface remains usable, but the lower levels hold advanced Earth knowledge that later generations fear as “dark magic.” This reflects the colony’s slow development and its loss of technological context, not the existence of a modern computer society in Saga 1.'
            ),
            array(
                'archetype' => 'locations',
                'title' => 'The Temple of Leda',
                'slug' => 'the-temple-of-leda-location',
                'summary' => 'A holy temple built above the hidden prison of Bahamut.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'leda',
                    'bahamut',
                    'temple',
                    'prison'
                ),
                'properties' => array(
                    'region' => 'Above Bahamut’s underground prison; broader region not established',
                    'terrain' => 'Temple over deep underground chambers',
                    'controlling_faction' => 'Temple custodians; exact structure not established',
                    'danger_level' => 'Extremely consequential because it protects the prison'
                ),
                'content_markdown' => 'The Temple of Leda stands above Bahamut’s hidden prison. Its enchantments suppress his influence, and its sacred public identity conceals its practical purpose as a guardian and misdirection.

The temple is one of the most important sites in Canaan. Destroying it would threaten the prison and enable the Hews’ plan to reopen Bahamut’s portal.'
            ),
            array(
                'archetype' => 'locations',
                'title' => 'Bahamut’s Prison',
                'slug' => 'bahamuts-prison',
                'summary' => 'The deep underground place where Bahamut is imprisoned beneath Canaan’s rock plates.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'bahamut',
                    'prison',
                    'cosmology',
                    'leda'
                ),
                'properties' => array(
                    'region' => 'Deep underground beneath the Temple of Leda',
                    'terrain' => 'Cavern beneath layers of rock',
                    'controlling_faction' => 'Protected by the Temple of Leda’s enchantments',
                    'danger_level' => 'Catastrophic if the prisoner is released'
                ),
                'content_markdown' => '**Bahamut’s Prison** was discovered by Lady Leda and her expedition deep underground. The prison lies beneath layers of rock associated with Canaan’s core, and the Temple of Leda was built above it to strengthen its protections and disguise the location.

The prison is more than a dungeon: Bahamut’s relationship with Canaan’s portals and the fragments of his celestial body makes his confinement central to the world’s stability.'
            ),
            array(
                'archetype' => 'locations',
                'title' => 'Valoria',
                'slug' => 'valoria-location',
                'summary' => 'The territories and political heartland controlled by the Kingdom of Valoria.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'valoria',
                    'kingdom',
                    'politics'
                ),
                'properties' => array(
                    'region' => 'Human territories; exact borders not established',
                    'terrain' => 'Varied; detailed atlas pending',
                    'controlling_faction' => 'Kingdom of Valoria',
                    'danger_level' => 'Varies by location and current conflict'
                ),
                'content_markdown' => 'Valoria refers both to the kingdom and, in common use, to the lands under its rule. Its military, royal institutions, and public interpretation of Lady Leda shape life across its territories.

A precise map, capital name, borders, and regional divisions have not yet been established in the current canon. Those should be added when the atlas is defined.'
            ),
            array(
                'archetype' => 'locations',
                'title' => 'Siraaj Desert',
                'slug' => 'siraaj-desert',
                'summary' => 'A harsh desert region containing lawless settlements and the environment in which Zara grew up.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'siraaj',
                    'desert',
                    'zara',
                    'hassans'
                ),
                'properties' => array(
                    'region' => 'Siraaj',
                    'terrain' => 'Desert settlements and surrounding arid terrain',
                    'controlling_faction' => 'No unified controller established',
                    'danger_level' => 'High in the lawless town where Zara grew up'
                ),
                'content_markdown' => 'The Siraaj Desert is associated with harsh conditions and settlements beyond Valoria’s direct claim. Zara grew up in one such town, where orphans stole to survive and powerful people could exploit the vulnerable.

The Hassans operate in this wider region, though their exact sanctum and the desert’s full political geography remain undefined.'
            ),
            array(
                'archetype' => 'magic',
                'title' => 'Elemental Magic',
                'slug' => 'elemental-magic',
                'summary' => 'A magical discipline through which practitioners manipulate elemental forces.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'magic',
                    'violet',
                    'elements'
                ),
                'properties' => array(
                    'source' => 'Magic in Canaan; exact mechanism not fully established',
                    'practitioners' => 'Violet Calanthe and other practitioners not yet specified',
                    'taboos' => 'Not established'
                ),
                'content_markdown' => 'Elemental magic is one of Violet Calanthe’s principal disciplines. She wields a magic wand and can command elemental forces alongside her more dangerous pursuit of dark magic.

The full elemental taxonomy, costs, and limitations are not yet established in the current lore. This entry should expand only when those rules are decided.'
            ),
            array(
                'archetype' => 'magic',
                'title' => 'Dark Magic',
                'slug' => 'dark-magic',
                'summary' => 'A forbidden magical discipline pursued by Violet Calanthe in her search for recognition.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'magic',
                    'violet',
                    'forbidden'
                ),
                'properties' => array(
                    'source' => 'Not fully established',
                    'practitioners' => 'Violet Calanthe',
                    'taboos' => 'Forbidden techniques; exact prohibitions not established'
                ),
                'content_markdown' => 'Dark magic is a forbidden field that Violet Calanthe pursues to prove herself and gain the recognition she craves. Her ambition makes the discipline both a source of power and a reflection of her dissatisfaction.

Its exact source, costs, and boundaries have not yet been defined, so the entry deliberately avoids inventing a universal rule set.'
            ),
            array(
                'archetype' => 'magic',
                'title' => 'Space-Time Techniques',
                'slug' => 'space-time-techniques',
                'summary' => 'Techniques Kuroko learns through the Secret Tome to freeze time and teleport to a destination.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'magic',
                    'kuroko',
                    'secret-tome',
                    'time',
                    'space'
                ),
                'properties' => array(
                    'source' => 'Techniques learned through the Secret Tome, supported by Kuroko’s cursed power of deep ancient knowledge',
                    'practitioners' => 'Kuroko Mitsuki',
                    'taboos' => 'Limitations beyond established uses not yet specified'
                ),
                'content_markdown' => 'Kuroko uses her Secret Tome to study and learn space-time techniques, including freezing time and teleporting to a destination. These are learned applications, not the definition of her innate cursed power.

Kuroko’s actual curse is deep ancient knowledge. Her established teleportation is destination-based, and she does not simply rewind history.'
            ),
            array(
                'archetype' => 'magic',
                'title' => 'Curse-Bearer Manifestations',
                'slug' => 'curse-bearer-manifestations',
                'summary' => 'The different ways Bahamut’s curse appears in individual bearers.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'magic',
                    'bahamut',
                    'curse',
                    'rogue-bird'
                ),
                'properties' => array(
                    'source' => 'Fragments of Bahamut’s celestial body',
                    'practitioners' => 'The Rogue Bird curse bearers',
                    'taboos' => 'Power use and savior-like ambition can accelerate corruption'
                ),
                'content_markdown' => 'The curse manifests differently in each bearer rather than granting a single standardized power. Kuroko’s is deep ancient knowledge; Blondt’s enhances her precision vision and gives her solar eye beams; the Green Lady gains shadow-like movement and intangibility; other bearers express their own distinct abilities.

The marks are physical signs of the connection to Bahamut. Their spread reflects the danger of power use and the bearer’s desire to become a savior. Details should be documented per character so that unique abilities remain distinct.'
            ),
            array(
                'archetype' => 'magic',
                'title' => 'The Verdant Weave',
                'slug' => 'the-verdant-weave',
                'summary' => 'A magical work associated with Violet and Kuroko involving Melissa.',
                'status' => 'canon',
                'cover_image' => '',
                'tags' => array(
                    'magic',
                    'melissa',
                    'violet',
                    'kuroko'
                ),
                'properties' => array(
                    'source' => 'Collaborative magic; exact mechanism not established',
                    'practitioners' => 'Violet Calanthe and Kuroko Mitsuki',
                    'taboos' => 'Not established'
                ),
                'content_markdown' => 'The **Verdant Weave** is associated with Violet and Kuroko’s magical work involving Melissa. The precise process, effects, and limits have not been fully established in the current canon.

This entry reserves a place for the concept without inventing a more detailed spell system than has been defined.'
            )
        );
    }

    public static function get_relationships()
    {
        return array(
            array(
                'source' => 'rahel-draugar',
                'target' => 'the-rogue-bird',
                'type' => 'member of',
                'inverse' => 'includes',
                'description' => 'Rahel travels with the group during Saga 1.'
            ),
            array(
                'source' => 'azura-paonne',
                'target' => 'the-rogue-bird',
                'type' => 'member of',
                'inverse' => 'includes',
                'description' => 'Azura joins the traveling group and often acts as its big sister.'
            ),
            array(
                'source' => 'blondt-har',
                'target' => 'the-rogue-bird',
                'type' => 'member of',
                'inverse' => 'includes',
                'description' => 'Blondt travels with the group as a ranged mercenary.'
            ),
            array(
                'source' => 'kuroko-mitsuki',
                'target' => 'the-rogue-bird',
                'type' => 'member of',
                'inverse' => 'includes',
                'description' => 'Kuroko joins while studying Canaan and searching for a way home.'
            ),
            array(
                'source' => 'zara-al-akhdar',
                'target' => 'the-rogue-bird',
                'type' => 'member of',
                'inverse' => 'includes',
                'description' => 'Zara travels with the group while struggling with the Green Lady.'
            ),
            array(
                'source' => 'violet-calanthe',
                'target' => 'the-rogue-bird',
                'type' => 'member of',
                'inverse' => 'includes',
                'description' => 'Violet is a mage member of the group before her death.'
            ),
            array(
                'source' => 'rahel-draugar',
                'target' => 'blondt-har',
                'type' => 'loves',
                'inverse' => 'loves',
                'description' => 'Their romance becomes one of Saga 1’s central personal arcs.'
            ),
            array(
                'source' => 'rahel-draugar',
                'target' => 'the-all-black-sword',
                'type' => 'keeps after defeating Aldric',
                'inverse' => 'is kept by',
                'description' => 'Rahel keeps the sword at the end of Saga 1.'
            ),
            array(
                'source' => 'king-aldric',
                'target' => 'the-all-black-sword',
                'type' => 'wields',
                'inverse' => 'wielded by',
                'description' => 'Aldric is corrupted while wielding the royal relic.'
            ),
            array(
                'source' => 'the-all-black-sword',
                'target' => 'bahamut',
                'type' => 'contains a fragment of',
                'inverse' => 'fragment contained in',
                'description' => 'The sword holds a fragment of Bahamut’s celestial body.'
            ),
            array(
                'source' => 'kingdom-of-valoria',
                'target' => 'the-hews',
                'type' => 'manipulated by',
                'inverse' => 'manipulates',
                'description' => 'The Hews influence Valorian politics over generations.'
            ),
            array(
                'source' => 'kingu',
                'target' => 'the-hews',
                'type' => 'leads',
                'inverse' => 'led by',
                'description' => 'Kingu directs the Hews’ covert agenda.'
            ),
            array(
                'source' => 'the-hews',
                'target' => 'the-temple-of-leda',
                'type' => 'seeks to destroy',
                'inverse' => 'threatened by',
                'description' => 'The Hews intend to destroy the temple and reopen Bahamut’s portal.'
            ),
            array(
                'source' => 'lady-leda',
                'target' => 'bahamut',
                'type' => 'sealed herself with',
                'inverse' => 'sealed with',
                'description' => 'Leda refuses Bahamut’s temptation and seals herself with him.'
            ),
            array(
                'source' => 'lady-leda',
                'target' => 'the-temple-of-leda',
                'type' => 'is honored by',
                'inverse' => 'honors',
                'description' => 'The temple preserves Leda’s public legacy and conceals the prison.'
            ),
            array(
                'source' => 'the-temple-of-leda-location',
                'target' => 'bahamuts-prison',
                'type' => 'conceals above',
                'inverse' => 'lies beneath',
                'description' => 'The temple was built above the prison.'
            ),
            array(
                'source' => 'bahamut',
                'target' => 'incursions',
                'type' => 'is associated with',
                'inverse' => 'associated with',
                'description' => 'Bahamut’s portals bring hostile creatures and other arrivals into Canaan.'
            ),
            array(
                'source' => 'kuroko-mitsuki',
                'target' => 'the-secret-tome',
                'type' => 'uses',
                'inverse' => 'used by',
                'description' => 'Kuroko uses the transformed smartphone to study magic.'
            ),
            array(
                'source' => 'kuroko-mitsuki',
                'target' => 'space-time-techniques',
                'type' => 'learns',
                'inverse' => 'learned by',
                'description' => 'Kuroko learns these techniques through her Secret Tome.'
            ),
            array(
                'source' => 'kuroko-mitsuki',
                'target' => 'violet-calanthe',
                'type' => 'kills',
                'inverse' => 'killed by',
                'description' => 'Kuroko kills Violet, a major tragedy in Saga 1.'
            ),
            array(
                'source' => 'zara-al-akhdar',
                'target' => 'the-hassans',
                'type' => 'trained by',
                'inverse' => 'trained',
                'description' => 'The Hassans trained Zara as an assassin.'
            ),
            array(
                'source' => 'the-hassans',
                'target' => 'siraaj',
                'type' => 'operates in',
                'inverse' => 'contains operations of',
                'description' => 'The sect operates in the Siraaj region.'
            ),
            array(
                'source' => 'blondt-har',
                'target' => 'gul-har',
                'type' => 'sister of',
                'inverse' => 'sister of',
                'description' => 'Gul-Har is Blondt’s sister and former protector.'
            ),
            array(
                'source' => 'blondt-har',
                'target' => 'king-aldric',
                'type' => 'daughter of',
                'inverse' => 'father of',
                'description' => 'The Saga 1 bloodline revelation establishes Aldric as Blondt’s human father.'
            ),
            array(
                'source' => 'skadi',
                'target' => 'the-rogue-bird',
                'type' => 'carries the wagon for',
                'inverse' => 'travels with',
                'description' => 'Skadi willingly carries the group’s wagon and travels with them.'
            ),
            array(
                'source' => 'melissa',
                'target' => 'the-rogue-bird',
                'type' => 'travels with',
                'inverse' => 'includes companion',
                'description' => 'Melissa becomes a companion to the group.'
            ),
            array(
                'source' => 'violet-calanthe',
                'target' => 'the-verdant-weave',
                'type' => 'participates in',
                'inverse' => 'involves',
                'description' => 'Violet and Kuroko are associated with this magical work involving Melissa.'
            ),
            array(
                'source' => 'kuroko-mitsuki',
                'target' => 'the-verdant-weave',
                'type' => 'participates in',
                'inverse' => 'involves',
                'description' => 'Kuroko and Violet are associated with this magical work involving Melissa.'
            ),
            array(
                'source' => 'humanity-arrives-in-canaan',
                'target' => 'mara-library',
                'type' => 'precedes the founding of',
                'inverse' => 'founded after',
                'description' => 'Mara Library develops during the early human-colony era.'
            ),
            array(
                'source' => 'lady-ledas-expedition',
                'target' => 'bahamuts-prison',
                'type' => 'discovers',
                'inverse' => 'discovered by',
                'description' => 'Leda’s expedition discovers the hidden prison.'
            ),
            array(
                'source' => 'the-first-portal-wars',
                'target' => 'lady-leda',
                'type' => 'is shaped by',
                'inverse' => 'shapes',
                'description' => 'Leda becomes a legendary savior during the wars.'
            ),
            array(
                'source' => 'the-founding-of-valoria',
                'target' => 'kingdom-of-valoria',
                'type' => 'establishes',
                'inverse' => 'founded by',
                'description' => 'Valoria is founded after a civil war, beginning the proposed AV calendar.'
            ),
            array(
                'source' => 'the-rogue-birds-campaign',
                'target' => 'king-aldric',
                'type' => 'ends with the defeat of',
                'inverse' => 'is defeated during',
                'description' => 'The campaign culminates in Aldric’s defeat.'
            ),
            array(
                'source' => 'the-rogue-birds-campaign',
                'target' => 'the-rogue-bird',
                'type' => 'follows',
                'inverse' => 'undertaken by',
                'description' => 'The campaign describes the group’s Saga 1 journey.'
            ),
            array(
                'source' => 'the-curse-of-bahamut',
                'target' => 'rahel-draugar',
                'type' => 'marks',
                'inverse' => 'bears mark of',
                'description' => 'Rahel bears the Red Eagle mark.'
            ),
            array(
                'source' => 'the-curse-of-bahamut',
                'target' => 'azura-paonne',
                'type' => 'marks',
                'inverse' => 'bears mark of',
                'description' => 'Azura bears the Blue Heron mark.'
            ),
            array(
                'source' => 'the-curse-of-bahamut',
                'target' => 'blondt-har',
                'type' => 'marks',
                'inverse' => 'bears mark of',
                'description' => 'Blondt bears the Yellow Hawk mark.'
            ),
            array(
                'source' => 'the-curse-of-bahamut',
                'target' => 'kuroko-mitsuki',
                'type' => 'marks',
                'inverse' => 'bears mark of',
                'description' => 'Kuroko bears the Black Raven mark.'
            ),
            array(
                'source' => 'the-curse-of-bahamut',
                'target' => 'zara-al-akhdar',
                'type' => 'marks',
                'inverse' => 'bears mark of',
                'description' => 'Zara bears the Green Owl mark.'
            ),
            array(
                'source' => 'the-curse-of-bahamut',
                'target' => 'violet-calanthe',
                'type' => 'marks',
                'inverse' => 'bears mark of',
                'description' => 'Violet bears the Purple Peacock mark.'
            ),
            array(
                'source' => 'mana',
                'target' => 'humans-of-canaan',
                'type' => 'shapes the world inhabited by',
                'inverse' => 'inhabit a world shaped by',
                'description' => 'Mana alters the physical laws of matter it touches in Canaan.'
            ),
            array(
                'source' => 'kingdom-of-valoria',
                'target' => 'incursions',
                'type' => 'uses as political justification',
                'inverse' => 'used to justify',
                'description' => 'Valoria invokes Incursions to argue for unity and order.'
            )
        );
    }

    public static function get_timeline_events()
    {
        return array(
            array(
                'entry_slug' => 'humanity-arrives-in-canaan',
                'title' => 'Humanity Arrives in Canaan',
                'era' => 'Early Human-Colony Era',
                'event_date' => 'Year 0 BV',
                'sort_year' => 0,
                'end_year' => NULL,
                'is_approximate' => 0,
                'sort_order' => 10,
                'summary' => '784 survivors from Earth’s final bunker arrive in Canaan after the destruction of their world.'
            ),
            array(
                'entry_slug' => 'founding-of-the-first-city',
                'title' => 'Founding of the First City',
                'era' => 'Early Human-Colony Era',
                'event_date' => 'Year 10 BV',
                'sort_year' => 10,
                'end_year' => NULL,
                'is_approximate' => 0,
                'sort_order' => 20,
                'summary' => 'The survivors establish their first city and a central government.'
            ),
            array(
                'entry_slug' => 'founding-of-mara-library',
                'title' => 'Founding of Mara Library',
                'era' => 'Early Human-Colony Era',
                'event_date' => 'Around Year 100 BV',
                'sort_year' => 100,
                'end_year' => NULL,
                'is_approximate' => 1,
                'sort_order' => 30,
                'summary' => 'The first death inspires the settlers to preserve memory and records in an archive.'
            ),
            array(
                'entry_slug' => 'expansion-of-human-settlements',
                'title' => 'Expansion of Human Settlements',
                'era' => 'Early Human-Colony Era',
                'event_date' => 'Around Year 600 BV',
                'sort_year' => 600,
                'end_year' => NULL,
                'is_approximate' => 1,
                'sort_order' => 35,
                'summary' => 'Human settlements expand beyond the earliest colony and encounter more of Canaan’s peoples.'
            ),
            array(
                'entry_slug' => 'lady-ledas-expedition',
                'title' => 'Lady Leda’s Expedition',
                'era' => 'Early Human-Colony Era',
                'event_date' => 'Around Year 200 BV',
                'sort_year' => 200,
                'end_year' => NULL,
                'is_approximate' => 1,
                'sort_order' => 40,
                'summary' => 'Leda and her companions discover Bahamut’s prison deep underground.'
            ),
            array(
                'entry_slug' => 'the-first-portal-wars',
                'title' => 'The First Portal Wars',
                'era' => 'Early Human-Colony Era',
                'event_date' => 'After Leda’s discovery; exact year unknown',
                'sort_year' => 220,
                'end_year' => NULL,
                'is_approximate' => 1,
                'sort_order' => 50,
                'summary' => 'Canaan’s early peoples fight hostile arrivals while Leda becomes a legendary savior.'
            ),
            array(
                'entry_slug' => 'the-founding-of-valoria',
                'title' => 'Founding of Valoria',
                'era' => 'Valorian Era',
                'event_date' => 'Around Year 3000 BV / Year 1 AV',
                'sort_year' => 1,
                'end_year' => NULL,
                'is_approximate' => 1,
                'sort_order' => 60,
                'summary' => 'Valerius founds Valoria after a civil war; the BV-to-AV calendar alignment remains provisional.'
            ),
            array(
                'entry_slug' => 'the-rogue-birds-campaign',
                'title' => 'The Rogue Bird’s Campaign',
                'era' => 'Rogue Bird Era',
                'event_date' => 'Around Year 1600 AV',
                'sort_year' => 1600,
                'end_year' => NULL,
                'is_approximate' => 1,
                'sort_order' => 70,
                'summary' => 'The Rogue Bird confronts Valoria, curse-bearer tragedies, and King Aldric.'
            )
        );
    }
}
