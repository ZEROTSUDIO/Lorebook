<?php
  $world_name = isset($active_world->name) ? $active_world->name : 'Canaan';
  $world_desc = !empty($active_world->description)
    ? $active_world->description
    : 'The shattered northern continent of ancient clans, high keeps, and frozen covenants.';

  if (!function_exists('resolve_lore_media_url')) {
    function resolve_lore_media_url($path) {
      if (empty($path)) return null;
      $t = trim($path);
      if (preg_match('#^https?://#i', $t)) return $t;
      if (strpos($t, 'storage/media/') === 0 && file_exists(FCPATH . $t)) {
        return base_url($t);
      }
      if (file_exists(FCPATH . 'storage/media/' . $t)) {
        return base_url('storage/media/' . $t);
      }
      if (file_exists(FCPATH . $t)) {
        return base_url($t);
      }
      return null;
    }
  }

  $map_plate_file = isset($world_settings['map_plate_file']) ? $world_settings['map_plate_file'] : '';
  $map_plate_url = resolve_lore_media_url($map_plate_file);

  $arch_etching_file = isset($world_settings['arch_etching_file']) ? $world_settings['arch_etching_file'] : '';
  $arch_etching_url = resolve_lore_media_url($arch_etching_file);

  $hero_panorama_file = isset($world_settings['hero_panorama_file']) ? $world_settings['hero_panorama_file'] : '';
  $hero_panorama_url = resolve_lore_media_url($hero_panorama_file);
?>

<div class="flex flex-col gap-12">

  <!-- ===================================================================== -->
  <!-- SECTION 1: ILLUMINATED HERO PANORAMA (WORLD FRONTISPIECE)             -->
  <!-- ===================================================================== -->
  <section class="bg-paper-panel border-2 border-paper-line shadow-ink-lg relative overflow-hidden">
    
    <!-- Top Archival Frame Strip -->
    <div class="bg-paper-ink border-b-2 border-paper-line px-4 py-2 flex flex-wrap items-center justify-between gap-2 text-[11px] font-mono">
      <div class="flex items-center gap-2.5">
        <span class="w-2 h-2 bg-gold rotate-45"></span>
        <span class="text-gold font-bold tracking-widest uppercase">FRONTISPIECE // IMPERIAL ARCHIVE OF <?php echo strtoupper(html_escape($world_name)); ?></span>
      </div>
      <div class="flex items-center gap-4 text-ash">
        <span>PLATE I: PANORAMA_SHATTERED_NORTH.WEBP</span>
        <span class="text-copper font-bold hidden sm:inline">● CANONICAL EDITION</span>
      </div>
    </div>

    <!-- Outer Padding Frame -->
    <div class="p-3 sm:p-5 bg-paper-base">
      <!-- Inner Artwork Panorama Container -->
      <div class="relative min-h-[380px] sm:min-h-[430px] bg-paper-deep border-2 border-gold/50 corner-brackets overflow-hidden flex flex-col justify-between p-6 sm:p-10 shadow-ink">
        
        <?php if (!empty($hero_panorama_url)): ?>
          <!-- Custom Uploaded Hero Frontispiece Panorama Artwork -->
          <img src="<?php echo html_escape($hero_panorama_url); ?>" alt="<?php echo html_escape($world_name); ?> Frontispiece Panorama" class="absolute inset-0 w-full h-full object-cover opacity-35 mix-blend-luminosity filter transition duration-700 pointer-events-none">
        <?php endif; ?>

        <!-- Placeholder Atmospheric Artwork SVG (Celestial Astrolabe + Northern Crags & Watchtower Beacon) -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden <?php echo !empty($hero_panorama_url) ? 'opacity-40' : ''; ?>">
          <!-- Subtle Radial Gold Glow -->
          <div class="absolute inset-0" style="background: radial-gradient(circle at 50% 32%, rgba(197, 168, 105, 0.16) 0%, rgba(186, 122, 85, 0.06) 38%, rgba(17, 16, 20, 0.94) 80%);"></div>

          <!-- Celestial Astrolabe Rings & Horizon Grid SVG -->
          <svg class="w-full h-full opacity-25 text-gold" viewBox="0 0 1200 500" preserveAspectRatio="xMidYMid slice" fill="none">
            <!-- Coordinate Grid Lines -->
            <line x1="0" y1="120" x2="1200" y2="120" stroke="currentColor" stroke-width="0.5" stroke-dasharray="4 8"/>
            <line x1="0" y1="250" x2="1200" y2="250" stroke="currentColor" stroke-width="0.5" stroke-dasharray="2 6"/>
            <line x1="600" y1="0" x2="600" y2="500" stroke="currentColor" stroke-width="0.5" stroke-dasharray="4 8"/>
            <line x1="300" y1="0" x2="300" y2="500" stroke="currentColor" stroke-width="0.4" stroke-dasharray="3 9"/>
            <line x1="900" y1="0" x2="900" y2="500" stroke="currentColor" stroke-width="0.4" stroke-dasharray="3 9"/>

            <!-- Celestial Rings -->
            <circle cx="600" cy="185" r="155" stroke="currentColor" stroke-width="1"/>
            <circle cx="600" cy="185" r="195" stroke="currentColor" stroke-width="0.75" stroke-dasharray="6 6"/>
            <circle cx="600" cy="185" r="245" stroke="currentColor" stroke-width="0.5"/>
            <polygon points="600,20 635,150 765,185 635,220 600,350 565,220 435,185 565,150" stroke="currentColor" stroke-width="0.75" fill="none"/>

            <!-- Distant Mountain Ranges of Canaan (Engraving Silhouette) -->
            <path d="M0,430 L90,340 L165,385 L270,275 L365,355 L475,240 L560,320 L600,265 L650,325 L755,230 L860,350 L965,280 L1075,365 L1150,310 L1200,355 L1200,500 L0,500 Z" fill="#151419" stroke="currentColor" stroke-width="1.2"/>
            <path d="M0,465 L140,395 L235,430 L345,350 L450,415 L575,335 L685,405 L810,330 L920,410 L1040,360 L1200,425 L1200,500 L0,500 Z" fill="#08070A" stroke="#BA7A55" stroke-width="0.8"/>

            <!-- High Keep Watchtower & Pale Flame Beacon at Center -->
            <rect x="593" y="228" width="14" height="42" fill="#151419" stroke="currentColor" stroke-width="1.2"/>
            <circle cx="600" cy="216" r="6" fill="#C5A869"/>
            <circle cx="600" cy="216" r="14" stroke="#C5A869" stroke-width="1" stroke-dasharray="2 3"/>
          </svg>
        </div>

        <!-- Top Plate Registration Marks -->
        <div class="relative z-10 flex items-center justify-between text-[10px] font-mono text-gold/70 tracking-widest uppercase">
          <span>+ REG. 54°12'N // IRON PASS SURVEY</span>
          <span class="border border-gold/40 bg-paper-ink/80 px-2.5 py-0.5 text-copper">
            [ARTWORK PLACEHOLDER // HERO PANORAMA PLATE]
          </span>
          <span>EPOCH: <?php echo html_escape($current_cycle); ?> +</span>
        </div>

        <!-- Centerpiece World Title & Lore Epigraph -->
        <div class="relative z-10 my-auto py-6 flex flex-col items-center text-center max-w-3xl mx-auto">
          <div class="flex flex-wrap items-center justify-center gap-2.5 mb-3">
            <span class="wax-seal text-parchment font-cinzel text-[11px] font-bold px-3 py-0.5 rounded-sm tracking-widest uppercase flex items-center gap-1.5">
              <span>✦</span> REALM OF <?php echo strtoupper(html_escape($world_name)); ?>
            </span>
            <span class="font-mono text-[11px] uppercase tracking-widest text-gold border border-gold/60 bg-paper-ink/90 px-3 py-0.5">
              <?php echo (int)$total_entries; ?> INSCRIBED RECORDS
            </span>
          </div>

          <h1 class="font-display font-bold text-5xl sm:text-6xl lg:text-7xl tracking-widest uppercase text-gold leading-none drop-shadow">
            The Chronicles of <?php echo html_escape($world_name); ?>
          </h1>

          <p class="font-prose italic text-lg sm:text-xl text-parchment-dim mt-3 max-w-2xl leading-relaxed">
            “<?php echo html_escape($world_desc); ?>”
          </p>

          <!-- Reader Search & Exploration Bar -->
          <form action="<?php echo base_url('entries'); ?>" method="get" class="w-full max-w-2xl mt-7 flex flex-col sm:flex-row gap-2.5">
            <div class="relative flex-1">
              <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gold font-mono text-xs">⌕</span>
              <input
                type="text"
                name="q"
                placeholder="Search characters, realms, sacred orders, or relics to read..."
                class="w-full bg-paper-ink/95 border-2 border-paper-line focus:border-gold pl-9 pr-4 py-2.5 text-sm font-prose text-parchment placeholder-ash/70 focus:outline-none shadow-ink-sm"
              >
            </div>
            <button type="submit" class="px-6 py-2.5 bg-gold hover:bg-gold-light text-paper-ink font-mono font-bold text-xs uppercase tracking-widest border-2 border-gold shadow-ink-sm transition">
              CONSULT ARCHIVE
            </button>
          </form>

          <!-- Quick Reader Jumps -->
          <div class="flex flex-wrap items-center justify-center gap-4 mt-5 font-mono text-[11px] uppercase tracking-wider">
            <a href="#archive-tomes" class="text-gold hover:text-gold-light border-b border-gold/50 pb-0.5 transition">
              ↓ Browse the Five Tomes
            </a>
            <span class="text-paper-line">•</span>
            <a href="#world-compendium" class="text-parchment-dim hover:text-gold border-b border-transparent hover:border-gold/50 pb-0.5 transition">
              ↓ Read World History &amp; Atlas
            </a>
            <span class="text-paper-line">•</span>
            <a href="#chronology-ribbon" class="text-parchment-dim hover:text-gold border-b border-transparent hover:border-gold/50 pb-0.5 transition">
              ↓ Traverse the Timeline
            </a>
          </div>
        </div>

        <!-- Bottom Plate Caption Strip -->
        <div class="relative z-10 flex flex-wrap items-center justify-between gap-2 text-[10px] font-mono text-ash border-t border-paper-line/80 pt-3">
          <span>ENGRAVING: THE WATCHTOWERS OF THE NORTHERN CRAGS (SOLSTICE OF 842 2A)</span>
          <span>ARCHIVIST: <?php echo strtoupper(html_escape(isset($current_user) && !empty($current_user->display_name) ? $current_user->display_name : 'ARCHIVIST ZEROTSU')); ?> // VERIFIED CANON: <?php echo (int)$canon_count; ?> OF <?php echo (int)$total_entries; ?></span>
        </div>

      </div>
    </div>
  </section>


  <!-- ===================================================================== -->
  <!-- SECTION 2: THE ARCHIVE OF TOMES (BOOK-SHAPED CATEGORY CARDS)          -->
  <!-- ===================================================================== -->
  <section id="archive-tomes" class="flex flex-col gap-5">
    
    <!-- Section Heading -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2 border-b-2 border-paper-line pb-3">
      <div>
        <div class="font-mono text-[11px] uppercase tracking-[0.25em] text-copper">
          SECTION I // THE IMPERIAL LIBRARY SHELF
        </div>
        <h2 class="font-display font-bold text-3xl sm:text-4xl uppercase tracking-wider text-gold">
          The Five Volumes of <?php echo html_escape($world_name); ?>
        </h2>
      </div>
      <a href="<?php echo base_url('entries'); ?>" class="font-mono text-xs uppercase tracking-widest text-parchment-dim hover:text-gold transition">
        [VIEW COMPLETE REGISTRY INDEX &rarr;]
      </a>
    </div>

    <!-- 5 Book-Shaped Grimoire Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 pt-1">
      <?php foreach ($entry_types as $tome): ?>
        <a
          href="<?php echo base_url('entries?type=' . urlencode($tome->slug)); ?>"
          class="tome-card group bg-paper-panel border-2 border-paper-line hover:border-gold flex min-h-[310px] overflow-hidden"
        >
          <!-- Bound Leather & Gold Foil Book Spine (Left Edge) -->
          <div class="tome-spine w-5 sm:w-6 shrink-0 border-r-2 border-paper-line flex flex-col items-center justify-center py-6">
            <span class="font-mono text-[9px] tracking-[0.3em] text-gold/60 uppercase" style="writing-mode: vertical-rl; transform: rotate(180deg);">
              <?php echo html_escape($tome->tomus); ?>
            </span>
          </div>

          <!-- Book Front Cover Plate -->
          <div class="flex-1 p-4 flex flex-col justify-between bg-gradient-to-b from-paper-panel via-paper-panel to-paper-deep relative">
            
            <!-- Top Volume Header -->
            <div class="flex items-center justify-between border-b border-paper-line pb-2 font-mono text-[10px]">
              <span class="text-gold font-bold tracking-widest"><?php echo html_escape($tome->tomus); ?></span>
              <span class="text-ash">◈</span>
            </div>

            <!-- Center Heraldic Emblem + Tome Title -->
            <div class="my-auto py-4 flex flex-col items-center text-center">
              <!-- Ornamental Medallion SVG per Tome Type -->
              <div class="w-14 h-14 rounded-full border-2 border-gold/50 group-hover:border-gold bg-paper-ink flex items-center justify-center mb-3 shadow-ink-sm transition">
                <?php if ($tome->slug === 'characters' || $tome->slug === 'persons'): ?>
                  <!-- Personae: Champion Bust / Silhouette -->
                  <svg class="w-7 h-7 text-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M5 20c0-3.866 3.134-7 7-7s7 3.134 7 7"/>
                  </svg>
                <?php elseif ($tome->slug === 'nations' || $tome->slug === 'realms'): ?>
                  <!-- Nations: Citadel / Fortress Keep -->
                  <svg class="w-7 h-7 text-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M3 21h18M5 21V7l4-3 3 3 3-3 4 3v14M9 21v-6h6v6"/>
                  </svg>
                <?php elseif ($tome->slug === 'artifacts'): ?>
                  <!-- Reliquary: Sacred Censer & Gem Relic -->
                  <svg class="w-7 h-7 text-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <polygon points="12 2 19 8 16 21 8 21 5 8 12 2"/>
                    <line x1="12" y1="2" x2="12" y2="21"/>
                    <line x1="5" y1="8" x2="19" y2="8"/>
                  </svg>
                <?php elseif ($tome->slug === 'events' || $tome->slug === 'chronicle'): ?>
                  <!-- Annals: Orbit / Sundial / Epoch -->
                  <svg class="w-7 h-7 text-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="9"/>
                    <polyline points="12 7 12 12 15 15"/>
                  </svg>
                <?php elseif ($tome->slug === 'concepts'): ?>
                  <!-- Arcana: Open Codex & Arcane Spark -->
                  <svg class="w-7 h-7 text-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                  </svg>
                <?php else: ?>
                  <svg class="w-7 h-7 text-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="9"/>
                    <polygon points="12 8 8 12 12 16 16 12 12 8"/>
                  </svg>
                <?php endif; ?>
              </div>

              <div class="font-mono text-[9px] uppercase tracking-[0.2em] text-copper mb-1">
                <?php echo html_escape($tome->latin); ?>
              </div>
              <h3 class="font-display font-bold text-2xl uppercase tracking-wide text-parchment group-hover:text-gold transition leading-tight">
                <?php echo html_escape($tome->name); ?>
              </h3>
              <p class="font-prose text-xs text-parchment-dark mt-2 line-clamp-3 leading-relaxed">
                <?php echo html_escape($tome->tome_desc); ?>
              </p>
            </div>

            <!-- Bottom Brass Record Count Plate -->
            <div class="border-t border-paper-line pt-2.5 flex items-center justify-between font-mono text-[10px]">
              <span class="text-parchment-dim font-bold">
                <?php echo sprintf('%02d', (int)$tome->entry_count); ?> <?php echo ((int)$tome->entry_count === 1) ? 'RECORD' : 'RECORDS'; ?>
              </span>
              <span class="text-gold group-hover:translate-x-0.5 transition uppercase">
                OPEN TOME &rarr;
              </span>
            </div>

          </div>
        </a>
      <?php endforeach; ?>
    </div>

    <?php if (!empty($extended_types)): ?>
      <!-- Extended Volumes Shelf Strip (Orders, Species, Locations, Magic) -->
      <div class="mt-2 pt-4 border-t border-paper-line/70">
        <div class="flex items-center justify-between mb-3 font-mono text-[10px] tracking-widest uppercase">
          <span class="text-copper flex items-center gap-2">
            <span class="w-1.5 h-1.5 bg-copper"></span>
            EXTENDED ARCHIVES &amp; SECONDARY REGISTRIES (VOL. VI &mdash; IX)
          </span>
          <span class="text-ash hidden sm:inline">SWORN ORDERS · BESTIARY · SITES · CODEX ARCANUM</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
          <?php foreach ($extended_types as $ext): ?>
            <a
              href="<?php echo base_url('entries?type=' . urlencode($ext->slug)); ?>"
              class="group bg-paper-ink border-2 border-paper-line hover:border-gold p-3 flex items-center justify-between transition shadow-ink-sm"
            >
              <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded border border-gold/40 group-hover:border-gold bg-paper-panel flex items-center justify-center text-gold transition shrink-0 shadow-inner">
                  <?php if ($ext->slug === 'orders'): ?>
                    <!-- Shield icon -->
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                      <path d="M12 3l8 4v5c0 5.25-3.5 9.75-8 11-4.5-1.25-8-5.75-8-11V7l8-4z"/>
                    </svg>
                  <?php elseif ($ext->slug === 'species' || $ext->slug === 'bestiary'): ?>
                    <!-- Feather / Beast icon -->
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                      <path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"/>
                      <line x1="16" y1="8" x2="2" y2="22"/>
                      <line x1="17.5" y1="15" x2="9" y2="15"/>
                    </svg>
                  <?php elseif ($ext->slug === 'locations'): ?>
                    <!-- Compass icon -->
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                      <circle cx="12" cy="12" r="10"/>
                      <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/>
                    </svg>
                  <?php elseif ($ext->slug === 'magic'): ?>
                    <!-- Arcane Zap icon -->
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                      <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                    </svg>
                  <?php else: ?>
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                      <circle cx="12" cy="12" r="9"/>
                      <polyline points="12 7 12 12 15 15"/>
                    </svg>
                  <?php endif; ?>
                </div>

                <div class="overflow-hidden">
                  <div class="font-mono text-[9px] uppercase tracking-wider text-copper truncate">
                    <?php echo html_escape($ext->tomus); ?> &bull; <?php echo html_escape($ext->latin); ?>
                  </div>
                  <div class="font-display font-bold text-sm uppercase text-parchment group-hover:text-gold transition truncate">
                    <?php echo html_escape($ext->name); ?>
                  </div>
                </div>
              </div>

              <div class="text-right shrink-0 pl-2">
                <span class="font-mono text-[11px] text-parchment-dim font-bold block">
                  <?php echo sprintf('%02d', (int)$ext->entry_count); ?>
                </span>
                <span class="font-mono text-[9px] text-gold uppercase group-hover:underline">
                  OPEN &rarr;
                </span>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
  </section>


  <!-- ===================================================================== -->
  <!-- SECTION 3: WORLD COMPENDIUM — HISTORY, GEOGRAPHY & ARCHIVAL PLATES    -->
  <!-- ===================================================================== -->
  <section id="world-compendium" class="bg-paper-panel border-2 border-paper-line shadow-ink relative overflow-hidden">
    
    <!-- Flush Title Bar -->
    <div class="bg-paper-ink border-b-2 border-paper-line px-5 py-2.5 flex flex-wrap items-center justify-between gap-2 text-xs font-mono">
      <div class="flex items-center gap-2">
        <span class="w-2 h-2 bg-copper rotate-45"></span>
        <span class="text-gold font-bold tracking-widest uppercase">SECTION II // COMPENDIUM OF THE REALM — <?php echo strtoupper(html_escape($world_name)); ?></span>
      </div>
      <div class="flex items-center gap-3">
        <a href="<?php echo base_url('dashboard/settings'); ?>" class="text-[10px] text-copper hover:text-gold border border-copper/50 hover:border-gold px-2 py-0.5 transition uppercase tracking-wider">
          ⚙ EDIT COMPENDIUM
        </a>
        <span class="text-ash text-[11px] hidden sm:inline">HISTORICAL &amp; GEOGRAPHIC SURVEY</span>
      </div>
    </div>

    <!-- Open Two-Page Manuscript Spread -->
    <div class="p-6 sm:p-8 lg:p-10 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
      
      <!-- LEFT COLUMN (7 COLS): WORLD HISTORY & THREE PILLARS -->
      <div class="lg:col-span-7 flex flex-col gap-6">
        
        <div class="border-b border-paper-line pb-4">
          <div class="font-mono text-[11px] uppercase tracking-widest text-copper mb-1">
            <?php echo html_escape(isset($world_settings['compendium_annals_label']) && $world_settings['compendium_annals_label'] !== '' ? $world_settings['compendium_annals_label'] : 'I. ANNALS OF THE REALM'); ?>
          </div>
          <h2 class="font-display font-bold text-3xl sm:text-4xl uppercase tracking-wide text-gold">
            History &amp; Foundations of <?php echo html_escape($world_name); ?>
          </h2>
        </div>

        <!-- Illuminated Drop-Cap Prose -->
        <div class="font-prose text-base sm:text-[17px] leading-relaxed text-parchment space-y-4">
          <?php 
            $p1 = isset($world_settings['compendium_history_p1']) && $world_settings['compendium_history_p1'] !== '' 
              ? $world_settings['compendium_history_p1'] 
              : "Long before the southern synods raised their marble courts, the northern reaches of " . html_escape($world_name) . " were bound by the ancient covenants of the First Age of Stone.";
            $p2 = isset($world_settings['compendium_history_p2']) && $world_settings['compendium_history_p2'] !== '' 
              ? $world_settings['compendium_history_p2'] 
              : "Survival across the frontier rests upon the sacred wardens and lamplighters who tend the eternal braziers between the isolated clan keeps.";
          ?>
          <p class="first-letter:float-left first-letter:font-display first-letter:text-5xl first-letter:font-bold first-letter:text-gold first-letter:mr-3.5 first-letter:leading-none first-letter:border-2 first-letter:border-gold first-letter:px-3 first-letter:py-1 first-letter:bg-paper-base first-letter:shadow-ink-sm">
            <?php echo nl2br(html_escape($p1)); ?>
          </p>
          <?php if (!empty($p2)): ?>
            <p class="text-parchment-dim">
              <?php echo nl2br(html_escape($p2)); ?>
            </p>
          <?php endif; ?>
        </div>

        <!-- Three Lore Pillars Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
          <!-- Pillar I -->
          <div class="bg-paper-base border-2 border-paper-line p-4 shadow-ink-sm">
            <div class="font-mono text-[10px] text-copper uppercase tracking-widest mb-1">
              <?php echo html_escape(isset($world_settings['pillar_1_label']) && $world_settings['pillar_1_label'] !== '' ? $world_settings['pillar_1_label'] : 'PILLAR I // MYTHOS'); ?>
            </div>
            <h3 class="font-display font-bold text-xl text-gold uppercase mb-1.5">
              <?php echo html_escape(isset($world_settings['pillar_1_title']) && $world_settings['pillar_1_title'] !== '' ? $world_settings['pillar_1_title'] : 'The Pale Flame'); ?>
            </h3>
            <p class="font-prose text-xs text-parchment-dim leading-relaxed">
              <?php echo html_escape(isset($world_settings['pillar_1_body']) && $world_settings['pillar_1_body'] !== '' ? $world_settings['pillar_1_body'] : 'An unflickering amber fire drawn from deep subterranean veins.'); ?>
            </p>
          </div>

          <!-- Pillar II -->
          <div class="bg-paper-base border-2 border-paper-line p-4 shadow-ink-sm">
            <div class="font-mono text-[10px] text-copper uppercase tracking-widest mb-1">
              <?php echo html_escape(isset($world_settings['pillar_2_label']) && $world_settings['pillar_2_label'] !== '' ? $world_settings['pillar_2_label'] : 'PILLAR II // GEOGRAPHY'); ?>
            </div>
            <h3 class="font-display font-bold text-xl text-gold uppercase mb-1.5">
              <?php echo html_escape(isset($world_settings['pillar_2_title']) && $world_settings['pillar_2_title'] !== '' ? $world_settings['pillar_2_title'] : 'The Iron Pass'); ?>
            </h3>
            <p class="font-prose text-xs text-parchment-dim leading-relaxed">
              <?php echo html_escape(isset($world_settings['pillar_2_body']) && $world_settings['pillar_2_body'] !== '' ? $world_settings['pillar_2_body'] : 'The narrow mountain artery linking the Highlands to the lowlands.'); ?>
            </p>
          </div>

          <!-- Pillar III -->
          <div class="bg-paper-base border-2 border-paper-line p-4 shadow-ink-sm">
            <div class="font-mono text-[10px] text-copper uppercase tracking-widest mb-1">
              <?php echo html_escape(isset($world_settings['pillar_3_label']) && $world_settings['pillar_3_label'] !== '' ? $world_settings['pillar_3_label'] : 'PILLAR III // POLITICS'); ?>
            </div>
            <h3 class="font-display font-bold text-xl text-gold uppercase mb-1.5">
              <?php echo html_escape(isset($world_settings['pillar_3_title']) && $world_settings['pillar_3_title'] !== '' ? $world_settings['pillar_3_title'] : 'The Synod Split'); ?>
            </h3>
            <p class="font-prose text-xs text-parchment-dim leading-relaxed">
              <?php echo html_escape(isset($world_settings['pillar_3_body']) && $world_settings['pillar_3_body'] !== '' ? $world_settings['pillar_3_body'] : 'The ideological divide between clan wardens and inquisitorial orders.'); ?>
            </p>
          </div>
        </div>

        <!-- World Metadata Ledger Strip -->
        <div class="bg-paper-deep border border-paper-line p-4 font-mono text-xs grid grid-cols-2 sm:grid-cols-4 gap-4">
          <div>
            <span class="block text-[10px] text-ash uppercase">Dominant Seat</span>
            <span class="text-parchment font-bold">
              <?php echo html_escape(isset($world_settings['dominant_seat']) && $world_settings['dominant_seat'] !== '' ? $world_settings['dominant_seat'] : 'High Keep'); ?>
            </span>
          </div>
          <div>
            <span class="block text-[10px] text-ash uppercase">Calendar System</span>
            <span class="text-gold font-bold">
              <?php echo html_escape(isset($world_settings['calendar_system']) && $world_settings['calendar_system'] !== '' ? $world_settings['calendar_system'] : 'Standard Era'); ?>
            </span>
          </div>
          <div>
            <span class="block text-[10px] text-ash uppercase">Current Cycle</span>
            <span class="text-parchment font-bold"><?php echo html_escape($current_cycle); ?></span>
          </div>
          <div>
            <span class="block text-[10px] text-ash uppercase">Realm Status</span>
            <span class="text-copper font-bold">
              <?php echo html_escape(isset($world_settings['realm_status']) && $world_settings['realm_status'] !== '' ? $world_settings['realm_status'] : 'CANONICAL'); ?>
            </span>
          </div>
        </div>

      </div>

      <!-- RIGHT COLUMN (5 COLS): CARTOGRAPHY & ENGRAVING PLACEHOLDER PLATES -->
      <div class="lg:col-span-5 flex flex-col gap-5">
        
        <!-- PLATE II: CARTOGRAPHIC MAP SURVEY PLATE -->
        <div class="bg-paper-base border-2 border-paper-line p-3 shadow-ink corner-brackets">
          <div class="flex items-center justify-between font-mono text-[10px] text-ash pb-2 border-b border-paper-line mb-2">
            <span class="text-gold font-bold">
              <?php echo html_escape(isset($world_settings['map_plate_label']) && $world_settings['map_plate_label'] !== '' ? $world_settings['map_plate_label'] : 'PLATE II // CARTOGRAPHIC SURVEY'); ?>
            </span>
            <span class="text-copper font-bold hidden sm:inline">● CANONICAL ATLAS</span>
          </div>

          <?php if (!empty($map_plate_url)): ?>
            <!-- Real Uploaded Cartography Image Plate -->
            <div class="relative min-h-[220px] max-h-[360px] bg-paper-deep border-2 border-gold/50 corner-brackets overflow-hidden flex flex-col justify-between p-3 group cursor-pointer transition hover:border-gold shadow-ink-sm" onclick="if(typeof openLightbox==='function') openLightbox('<?php echo html_escape($map_plate_url); ?>', '<?php echo html_escape($world_name); ?> — Cartographic Survey');">
              <span class="absolute top-1 left-1 text-[10px] font-mono text-gold/60 pointer-events-none z-20">+</span>
              <span class="absolute top-1 right-1 text-[10px] font-mono text-gold/60 pointer-events-none z-20">+</span>
              <span class="absolute bottom-1 left-1 text-[10px] font-mono text-gold/60 pointer-events-none z-20">+</span>
              <span class="absolute bottom-1 right-1 text-[10px] font-mono text-gold/60 pointer-events-none z-20">+</span>

              <img src="<?php echo html_escape($map_plate_url); ?>" alt="Cartographic Survey Plate" class="absolute inset-0 w-full h-full object-cover transition duration-700 group-hover:scale-[1.03]">
              <div class="absolute inset-0 bg-gradient-to-t from-paper-ink/90 via-paper-ink/25 to-transparent pointer-events-none"></div>

              <div class="relative z-10 flex justify-between text-[10px] font-mono text-gold font-bold">
                <span class="bg-paper-ink/85 px-2 py-0.5 border border-gold/50 shadow-ink-sm">[MAP SURVEY]</span>
                <span class="bg-paper-ink/85 px-2 py-0.5 border border-gold/50 shadow-ink-sm"><?php echo strtoupper(html_escape($world_name)); ?></span>
              </div>

              <!-- Overlaid Landmark Node Badges -->
              <div class="relative z-10 my-auto flex flex-col gap-1.5 pl-2 font-mono text-[10px]">
                <?php if (!empty($world_settings['map_node_1'])): ?>
                  <span class="inline-flex items-center gap-1.5 bg-paper-ink/85 border border-gold text-gold px-2 py-0.5 shadow-ink-sm w-fit font-bold">
                    <span class="w-1.5 h-1.5 bg-gold rotate-45"></span>
                    <?php echo html_escape($world_settings['map_node_1']); ?>
                  </span>
                <?php endif; ?>
                <?php if (!empty($world_settings['map_node_2'])): ?>
                  <span class="inline-flex items-center gap-1.5 bg-paper-ink/85 border border-copper text-copper px-2 py-0.5 shadow-ink-sm w-fit font-bold pl-4">
                    <span class="w-1.5 h-1.5 bg-copper rotate-45"></span>
                    <?php echo html_escape($world_settings['map_node_2']); ?>
                  </span>
                <?php endif; ?>
                <?php if (!empty($world_settings['map_node_3'])): ?>
                  <span class="inline-flex items-center gap-1.5 bg-paper-ink/85 border border-paper-line text-parchment-dim px-2 py-0.5 shadow-ink-sm w-fit pl-8">
                    <span class="w-1.5 h-1.5 bg-parchment-dim rotate-45"></span>
                    <?php echo html_escape($world_settings['map_node_3']); ?>
                  </span>
                <?php endif; ?>
              </div>

              <div class="relative z-10 font-mono text-[10px] text-ash flex justify-between items-center bg-paper-ink/85 px-2.5 py-1 border border-paper-line/50">
                <span class="text-gold flex items-center gap-1 font-bold"><span>⤢</span> CLICK TO EXPAND ATLAS</span>
                <a href="<?php echo base_url('entries?type=realms'); ?>" class="text-copper hover:text-gold uppercase font-bold" onclick="event.stopPropagation()">GAZETTEER &rarr;</a>
              </div>
            </div>
          <?php else: ?>
            <!-- Fallback Cartographic Map Placeholder SVG -->
            <div class="h-52 bg-paper-deep border border-dashed border-gold/40 relative overflow-hidden flex flex-col justify-between p-3">
              <svg class="absolute inset-0 w-full h-full opacity-35 text-gold" viewBox="0 0 400 220" fill="none">
                <line x1="330" y1="55" x2="0" y2="200" stroke="currentColor" stroke-width="0.5" stroke-dasharray="3 3"/>
                <line x1="330" y1="55" x2="0" y2="40" stroke="currentColor" stroke-width="0.5" stroke-dasharray="3 3"/>
                <line x1="330" y1="55" x2="180" y2="220" stroke="currentColor" stroke-width="0.5" stroke-dasharray="3 3"/>
                <circle cx="330" cy="55" r="24" stroke="currentColor" stroke-width="1"/>
                <polygon points="330,24 335,49 360,55 335,61 330,86 325,61 300,55 325,49" fill="currentColor" fill-opacity="0.25" stroke="currentColor" stroke-width="1"/>
                <path d="M15,25 Q85,40 120,85 T210,145 T310,195" stroke="currentColor" stroke-width="1.5" fill="none"/>
                <path d="M90,190 Q150,150 185,115 T255,60" stroke="#BA7A55" stroke-width="1.2" stroke-dasharray="4 3" fill="none"/>
                <circle cx="135" cy="65" r="4" fill="#C5A869"/>
                <circle cx="185" cy="115" r="4" fill="#BA7A55"/>
                <circle cx="235" cy="165" r="4" fill="#C5A869"/>
              </svg>

              <div class="relative z-10 flex justify-between text-[10px] font-mono text-gold/80">
                <span>[MAP SURVEY]</span>
                <span><?php echo strtoupper(html_escape($world_name)); ?></span>
              </div>

              <!-- Dynamic Map Labels -->
              <div class="relative z-10 my-auto flex flex-col gap-1.5 pl-4 font-mono text-[10px]">
                <span class="text-gold">◈ <?php echo html_escape(isset($world_settings['map_node_1']) && $world_settings['map_node_1'] !== '' ? $world_settings['map_node_1'] : 'PRIMARY CITADEL'); ?></span>
                <span class="text-copper pl-6">◈ <?php echo html_escape(isset($world_settings['map_node_2']) && $world_settings['map_node_2'] !== '' ? $world_settings['map_node_2'] : 'BORDER PASS / GATEWAY'); ?></span>
                <span class="text-parchment-dim pl-12">◈ <?php echo html_escape(isset($world_settings['map_node_3']) && $world_settings['map_node_3'] !== '' ? $world_settings['map_node_3'] : 'OUTER SETTLEMENTS'); ?></span>
              </div>

              <div class="relative z-10 font-mono text-[10px] text-ash flex justify-between">
                <span>FILE: <?php echo html_escape(isset($world_settings['map_plate_file']) && $world_settings['map_plate_file'] !== '' ? $world_settings['map_plate_file'] : 'MAP_' . strtoupper($world_name) . '.WEBP'); ?></span>
                <a href="<?php echo base_url('dashboard/settings'); ?>" class="text-gold hover:underline">[UPLOAD MAP &rarr;]</a>
              </div>
            </div>
          <?php endif; ?>
        </div>

        <!-- PLATE III: HISTORICAL ARCHITECTURAL ETCHING / WOODCUT -->
        <div class="bg-paper-base border-2 border-paper-line p-3 shadow-ink corner-brackets">
          <div class="flex items-center justify-between font-mono text-[10px] text-ash pb-2 border-b border-paper-line mb-2">
            <span class="text-copper font-bold">
              <?php echo html_escape(isset($world_settings['arch_etching_title']) && $world_settings['arch_etching_title'] !== '' ? $world_settings['arch_etching_title'] : 'PLATE III // ARCHITECTURAL ETCHING'); ?>
            </span>
            <span class="text-gold font-bold">● ETCHING</span>
          </div>

          <?php if (!empty($arch_etching_url)): ?>
            <!-- Real Uploaded Architectural Etching Plate -->
            <div class="relative min-h-[160px] max-h-[240px] bg-paper-deep border-2 border-copper/50 corner-brackets overflow-hidden flex flex-col justify-end p-3 group cursor-pointer transition hover:border-copper shadow-ink-sm" onclick="if(typeof openLightbox==='function') openLightbox('<?php echo html_escape($arch_etching_url); ?>', '<?php echo html_escape(!empty($world_settings['arch_etching_caption']) ? $world_settings['arch_etching_caption'] : 'Architectural Etching'); ?>');">
              <span class="absolute top-1 left-1 text-[10px] font-mono text-copper/60 pointer-events-none z-20">+</span>
              <span class="absolute top-1 right-1 text-[10px] font-mono text-copper/60 pointer-events-none z-20">+</span>
              <span class="absolute bottom-1 left-1 text-[10px] font-mono text-copper/60 pointer-events-none z-20">+</span>
              <span class="absolute bottom-1 right-1 text-[10px] font-mono text-copper/60 pointer-events-none z-20">+</span>

              <img src="<?php echo html_escape($arch_etching_url); ?>" alt="Architectural Etching Plate" class="absolute inset-0 w-full h-full object-cover transition duration-700 group-hover:scale-[1.03]">
              <div class="absolute inset-0 bg-gradient-to-t from-paper-ink/90 via-paper-ink/20 to-transparent pointer-events-none"></div>

              <div class="relative z-10 font-mono text-[10px] text-parchment flex justify-between items-center bg-paper-ink/80 px-2 py-1 border border-paper-line/50">
                <span class="text-parchment font-newsreader italic text-xs truncate max-w-[240px]">
                  <?php echo html_escape(!empty($world_settings['arch_etching_caption']) ? $world_settings['arch_etching_caption'] : 'Engraving of ' . $world_name); ?>
                </span>
                <span class="text-copper font-bold text-[9px] flex items-center gap-1"><span>⤢</span> ENLARGE</span>
              </div>
            </div>
          <?php else: ?>
            <!-- Fallback Architectural Arch SVG Placeholder -->
            <div class="h-40 bg-paper-deep border border-dashed border-paper-line relative overflow-hidden flex flex-col items-center justify-center p-4 text-center">
              <svg class="w-20 h-20 opacity-20 text-copper mb-1" viewBox="0 0 100 100" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M15,90 L15,45 A35,35 0 0,1 85,45 L85,90"/>
                <path d="M28,90 L28,48 A22,22 0 0,1 72,48 L72,90"/>
                <line x1="5" y1="90" x2="95" y2="90"/>
                <circle cx="50" cy="28" r="5"/>
              </svg>
              <span class="font-display italic text-base text-parchment-dim">[Woodcut Engraving]</span>
              <span class="font-mono text-[10px] text-ash uppercase tracking-widest mt-0.5">
                <?php echo html_escape(isset($world_settings['arch_etching_caption']) && $world_settings['arch_etching_caption'] !== '' ? $world_settings['arch_etching_caption'] : 'ENGRAVING OF ' . strtoupper($world_name)); ?>
              </span>
            </div>
          <?php endif; ?>
        </div>

      </div>

    </div>
  </section>


  <!-- ===================================================================== -->
  <!-- SECTION 4: FEATURED LORE SPOTLIGHT & NOTABLE DOSSIERS TO READ         -->
  <!-- ===================================================================== -->
  <section id="lore-spotlight" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    
    <!-- LEFT COLUMN (4 COLS): FEATURED RECORD SPOTLIGHT DOSSIER -->
    <aside class="lg:col-span-4 flex flex-col gap-4">
      <?php if ($featured_entry): ?>
        <div class="bg-paper-panel border-2 border-paper-line shadow-ink relative overflow-hidden">
          
          <!-- Title Bar with Random Shuffle Action -->
          <div class="bg-paper-ink border-b-2 border-paper-line px-4 py-2.5 flex items-center justify-between text-xs font-mono">
            <div class="flex items-center gap-2">
              <span class="w-2 h-2 bg-gold rotate-45"></span>
              <span class="text-gold tracking-widest font-bold">LORE SPOTLIGHT</span>
            </div>
            <a
              href="<?php echo base_url('?spotlight=random#lore-spotlight'); ?>"
              class="text-[10px] text-copper hover:text-gold border border-copper/50 hover:border-gold px-2 py-0.5 transition"
              title="Draw a random record from the vault"
            >
              ↻ RANDOM RECORD
            </a>
          </div>

          <div class="p-5 flex flex-col gap-5">
            
            <!-- Portrait / Plate Placeholder Frame -->
            <div class="relative bg-paper-base border-2 border-paper-line p-2 shadow-ink-sm corner-brackets">
              <div class="h-60 bg-paper-deep flex flex-col items-center justify-end pb-4 border border-dashed border-paper-line relative overflow-hidden">
                <svg class="absolute inset-0 m-auto w-36 h-36 opacity-10 text-gold" viewBox="0 0 100 100" fill="currentColor">
                  <polygon points="50,5 90,25 90,75 50,95 10,75 10,25" fill="none" stroke="currentColor" stroke-width="2"/>
                  <circle cx="50" cy="50" r="28" fill="none" stroke="currentColor" stroke-width="1.5"/>
                  <line x1="50" y1="5" x2="50" y2="95" stroke="currentColor" stroke-width="1"/>
                  <line x1="10" y1="50" x2="90" y2="50" stroke="currentColor" stroke-width="1"/>
                </svg>
                <span class="absolute top-2 left-2 text-[11px] font-mono text-gold/60">+</span>
                <span class="absolute top-2 right-2 text-[11px] font-mono text-gold/60">+</span>
                <span class="absolute bottom-2 left-2 text-[11px] font-mono text-gold/60">+</span>
                <span class="absolute bottom-2 right-2 text-[11px] font-mono text-gold/60">+</span>
                
                <span class="font-display italic text-lg text-copper mb-1">[Illuminated Plate]</span>
                <span class="font-mono text-[10px] text-ash tracking-widest uppercase px-2 text-center">
                  PLATE: <?php echo html_escape($featured_entry->cover_image ? $featured_entry->cover_image : strtoupper($featured_entry->slug) . '.WEBP'); ?>
                </span>
              </div>
            </div>

            <!-- Title & Category -->
            <div class="text-center">
              <div class="font-mono text-[11px] uppercase tracking-widest text-copper mb-1">
                <?php echo html_escape($featured_entry->type_name ? $featured_entry->type_name : 'ARCHIVAL RECORD'); ?>
              </div>
              <h2 class="font-display font-bold text-3xl tracking-wider uppercase text-gold leading-tight">
                <?php echo html_escape($featured_entry->title); ?>
              </h2>
              <p class="font-prose italic text-parchment-dim text-sm mt-1.5 leading-relaxed">
                “<?php echo html_escape($featured_entry->summary); ?>”
              </p>
            </div>

            <!-- Stamps & Wax Seal -->
            <div class="flex flex-wrap justify-center items-center gap-2 py-1">
              <span class="font-mono font-bold text-[11px] uppercase tracking-widest text-gold border-2 border-gold px-2.5 py-0.5 -rotate-2 shadow-ink-sm bg-paper-base">
                <?php echo strtoupper(html_escape($featured_entry->status)); ?> VERIFIED
              </span>
              <span class="wax-seal text-parchment font-cinzel text-[10px] font-bold px-2.5 py-0.5 rounded-sm tracking-wider uppercase flex items-center gap-1">
                <span>✦</span> SEAL OF CANAAN
              </span>
            </div>

            <!-- Custom Attributes or Default Dossier Telemetry -->
            <div class="border-t-2 border-paper-line pt-3 font-mono text-xs divide-y divide-paper-line">
              <?php if (!empty($featured_props)): ?>
                <?php foreach ($featured_props as $prop): ?>
                  <div class="flex justify-between py-2 gap-2">
                    <span class="text-ash uppercase"><?php echo html_escape($prop->label); ?></span>
                    <span class="text-parchment font-bold text-right"><?php echo html_escape($prop->value_text); ?></span>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <div class="flex justify-between py-2">
                  <span class="text-ash uppercase">Origin Realm</span>
                  <span class="text-parchment font-bold"><?php echo html_escape($world_name); ?></span>
                </div>
                <div class="flex justify-between py-2">
                  <span class="text-ash uppercase">Volume Classification</span>
                  <span class="text-gold font-bold"><?php echo html_escape($featured_entry->type_name); ?></span>
                </div>
                <div class="flex justify-between py-2">
                  <span class="text-ash uppercase">Recorded Cycle</span>
                  <span class="text-parchment"><?php echo html_escape($current_cycle); ?></span>
                </div>
              <?php endif; ?>
            </div>

            <!-- Primary Read CTA -->
            <a
              href="<?php echo base_url('entries/view/' . $featured_entry->id); ?>"
              class="w-full border-2 border-gold py-2.5 text-center font-mono text-xs uppercase tracking-widest text-paper-ink font-bold bg-gold hover:bg-gold-light transition shadow-ink-sm block"
            >
              [READ FULL DOSSIER &rarr;]
            </a>

          </div>
        </div>
      <?php endif; ?>
    </aside>

    <!-- RIGHT COLUMN (8 COLS): NOTABLE RECORDS TO EXPLORE (2x2 ILLUSTRATED GRID) -->
    <div class="lg:col-span-8 flex flex-col gap-5">
      
      <div class="flex flex-wrap items-end justify-between gap-2 border-b-2 border-paper-line pb-3">
        <div>
          <div class="font-mono text-[11px] uppercase tracking-[0.25em] text-copper">
            SECTION III // CURATED MANUSCRIPTS
          </div>
          <h2 class="font-display font-bold text-3xl uppercase tracking-wider text-gold">
            Notable Records from the Vault
          </h2>
        </div>
        <a href="<?php echo base_url('entries'); ?>" class="font-mono text-xs uppercase tracking-widest text-gold hover:text-gold-light transition">
          [BROWSE ALL <?php echo (int)$total_entries; ?> RECORDS &rarr;]
        </a>
      </div>

      <!-- 2x2 Reading Cards Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <?php foreach (array_slice($recent_entries, 0, 6) as $rec): ?>
          <article class="bg-paper-panel border-2 border-paper-line hover:border-gold shadow-ink transition flex flex-col justify-between group overflow-hidden">
            
            <div>
              <!-- Card Header Strip -->
              <div class="bg-paper-ink border-b border-paper-line px-3.5 py-2 flex items-center justify-between font-mono text-[10px]">
                <span class="text-copper uppercase tracking-widest font-bold">
                  <?php echo html_escape($rec->type_name ? $rec->type_name : 'RECORD'); ?>
                </span>
                <span class="px-1.5 py-0.5 border <?php echo ($rec->status === 'canon') ? 'border-gold/60 text-gold' : 'border-paper-line text-ash'; ?> uppercase">
                  <?php echo html_escape($rec->status); ?>
                </span>
              </div>

              <!-- Miniature Plate Placeholder + Title -->
              <div class="p-4 flex gap-4 items-start">
                <div class="w-16 h-20 shrink-0 bg-paper-deep border border-paper-line group-hover:border-gold/60 flex flex-col items-center justify-center text-center p-1 relative">
                  <span class="font-display italic text-[11px] text-copper leading-tight">Plate</span>
                  <span class="font-mono text-[8px] text-ash mt-0.5">#<?php echo sprintf('%03d', (int)$rec->id); ?></span>
                </div>

                <div class="flex-1 min-w-0">
                  <h3 class="font-display font-bold text-2xl text-parchment group-hover:text-gold uppercase tracking-wide leading-tight transition">
                    <a href="<?php echo base_url('entries/view/' . $rec->id); ?>">
                      <?php echo html_escape($rec->title); ?>
                    </a>
                  </h3>
                  <p class="font-prose text-xs text-parchment-dim mt-1.5 line-clamp-3 leading-relaxed">
                    <?php echo html_escape($rec->summary); ?>
                  </p>
                </div>
              </div>
            </div>

            <!-- Card Footer Read Link -->
            <div class="px-4 py-2 bg-paper-base border-t border-paper-line flex items-center justify-between font-mono text-[10px]">
              <span class="text-ash">
                SCRIBE: <strong class="text-parchment"><?php echo html_escape(!empty($rec->author_name) ? $rec->author_name : 'Archivist Zerotsu'); ?></strong>
              </span>
              <a href="<?php echo base_url('entries/view/' . $rec->id); ?>" class="text-gold font-bold group-hover:translate-x-0.5 transition uppercase">
                READ DOSSIER &rarr;
              </a>
            </div>

          </article>
        <?php endforeach; ?>
      </div>

      <!-- Topic / Folklore Tag Exploration Bar -->
      <?php if (!empty($world_tags)): ?>
        <div class="bg-paper-panel border-2 border-paper-line p-4 flex flex-wrap items-center gap-2 shadow-ink-sm">
          <span class="font-mono text-[10px] uppercase tracking-widest text-copper font-bold mr-2">
            EXPLORE BY FOLKLORE TAG:
          </span>
          <?php foreach ($world_tags as $tg): ?>
            <a
              href="<?php echo base_url('entries?tag=' . urlencode($tg->slug)); ?>"
              class="font-mono text-[11px] px-2.5 py-1 bg-paper-base border border-paper-line hover:border-gold text-parchment-dim hover:text-gold transition"
            >
              #<?php echo html_escape($tg->name); ?>
              <span class="text-ash text-[10px]">(<?php echo (int)$tg->usage_count; ?>)</span>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

    </div>

  </section>


  <!-- ===================================================================== -->
  <!-- SECTION 5: THE CHRONOLOGICAL TAPESTRY (FICTIONAL CALENDAR TIMELINE)   -->
  <!-- ===================================================================== -->
  <section id="chronology-ribbon" class="bg-paper-panel border-2 border-paper-line shadow-ink p-6 sm:p-8">
    
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2 border-b-2 border-paper-line pb-4 mb-6">
      <div>
        <div class="font-mono text-[11px] uppercase tracking-[0.25em] text-copper">
          SECTION IV // THE CHRONOLOGICAL TAPESTRY
        </div>
        <h2 class="font-display font-bold text-3xl uppercase tracking-wider text-gold">
          Recorded Epochs &amp; Milestones of <?php echo html_escape($world_name); ?>
        </h2>
      </div>
      <a href="<?php echo base_url('entries?type=chronicle'); ?>" class="font-mono text-xs uppercase tracking-widest text-parchment-dim hover:text-gold transition">
        [EXPLORE ANNALS &amp; ERAS &rarr;]
      </a>
    </div>

    <!-- Horizontal Timeline Nodes Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 relative">
      <?php foreach ($timeline_events as $idx => $ev): ?>
        <div class="bg-paper-base border-2 border-paper-line hover:border-gold p-4 shadow-ink-sm flex flex-col justify-between transition relative">
          
          <div>
            <!-- Era + Fictional Date Badge -->
            <div class="flex items-center justify-between gap-2 font-mono text-[10px] border-b border-paper-line pb-2 mb-3">
              <span class="text-gold font-bold uppercase tracking-wider">
                <?php echo html_escape($ev->event_date); ?>
              </span>
              <?php if (!empty($ev->is_approximate)): ?>
                <span class="px-1.5 py-0.5 bg-paper-deep border border-copper/50 text-copper text-[9px] uppercase">
                  ~ APPROX
                </span>
              <?php else: ?>
                <span class="px-1.5 py-0.5 bg-paper-deep border border-gold/40 text-gold text-[9px] uppercase">
                  EXACT
                </span>
              <?php endif; ?>
            </div>

            <div class="font-mono text-[10px] text-copper uppercase tracking-widest mb-1">
              <?php echo html_escape($ev->era ? $ev->era : 'RECORDED ERA'); ?>
            </div>

            <h3 class="font-display font-bold text-xl text-parchment uppercase leading-snug mb-2">
              <?php echo html_escape($ev->title); ?>
            </h3>

            <p class="font-prose text-xs text-parchment-dim leading-relaxed">
              <?php echo html_escape($ev->summary); ?>
            </p>
          </div>

          <!-- Linked Entry Link if available -->
          <div class="mt-4 pt-2.5 border-t border-paper-line flex items-center justify-between font-mono text-[10px]">
            <span class="text-ash">YEAR AXIS: <?php echo ($ev->sort_year !== NULL) ? (int)$ev->sort_year : 'MYTHIC'; ?></span>
            <?php if (!empty($ev->entry_id)): ?>
              <a href="<?php echo base_url('entries/view/' . (int)$ev->entry_id); ?>" class="text-gold hover:underline uppercase font-bold">
                READ RECORD &rarr;
              </a>
            <?php endif; ?>
          </div>

        </div>
      <?php endforeach; ?>
    </div>

  </section>

</div>
