<?php
  $world_name = isset($active_world->name) ? $active_world->name : 'Canaan';

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

<div class="max-w-5xl mx-auto flex flex-col gap-8">

  <!-- TOP RETURN BAR & BREADCRUMB -->
  <div class="flex items-center justify-between border-b-2 border-paper-line pb-4 font-mono text-xs">
    <div class="flex items-center gap-2">
      <span class="w-2 h-2 bg-gold rotate-45"></span>
      <a href="<?php echo base_url('dashboard'); ?>" class="text-parchment-dim hover:text-gold uppercase tracking-widest transition">
        &larr; Back to Dashboard
      </a>
      <span class="text-paper-line">/</span>
      <span class="text-gold font-bold uppercase tracking-wider">World Settings</span>
    </div>
    <span class="text-ash uppercase text-[10px]">
      REALM: <?php echo strtoupper(html_escape($world_name)); ?>
    </span>
  </div>

  <?php if ($this->session->flashdata('success')): ?>
    <div class="p-4 border-2 border-gold bg-paper-panel font-mono text-xs text-gold flex items-center justify-between shadow-ink-sm">
      <div class="flex items-center gap-2">
        <span class="text-base font-bold">✦</span>
        <span><?php echo html_escape($this->session->flashdata('success')); ?></span>
      </div>
      <a href="<?php echo base_url('dashboard#world-compendium'); ?>" class="text-copper hover:underline uppercase text-[10px] font-bold">
        View on Dashboard &rarr;
      </a>
    </div>
  <?php endif; ?>

  <form action="<?php echo base_url('dashboard/settings'); ?>" method="POST" class="flex flex-col gap-8">
    
    <!-- SECTION A: PRIMARY ANNALS & HISTORY PROSE -->
    <div class="bg-paper-panel border-2 border-paper-line shadow-ink overflow-hidden">
      <div class="bg-paper-ink border-b-2 border-paper-line px-5 py-3 flex items-center justify-between text-xs font-mono">
        <div class="flex items-center gap-2">
          <span class="w-2 h-2 bg-copper rotate-45"></span>
          <span class="text-gold font-bold tracking-widest uppercase">History &amp; Lore</span>
        </div>
        <span class="text-ash text-[10px]">left column</span>
      </div>

      <div class="p-6 flex flex-col gap-6">
        
        <!-- Header Ribbon Label -->
        <div class="flex flex-col gap-1.5 font-mono text-xs">
          <label for="compendium_annals_label" class="text-copper uppercase font-bold tracking-wider">
            Section Label
          </label>
          <input
            type="text"
            name="compendium_annals_label"
            id="compendium_annals_label"
            value="<?php echo html_escape(isset($world_settings['compendium_annals_label']) ? $world_settings['compendium_annals_label'] : 'I. ANNALS OF THE SHATTERED NORTH'); ?>"
            class="bg-paper-base border-2 border-paper-line focus:border-gold px-3.5 py-2.5 text-parchment font-mono text-xs outline-none transition"
            placeholder="e.g. I. ANNALS OF THE SHATTERED NORTH"
          >
        </div>

        <!-- History Paragraph 1 (Illuminated Drop-Cap) -->
        <div class="flex flex-col gap-1.5 font-mono text-xs">
          <label for="compendium_history_p1" class="text-copper uppercase font-bold tracking-wider flex items-center justify-between">
            <span>First History Paragraph</span>
            <span class="text-ash text-[10px]">Para 1</span>
          </label>
          <textarea
            name="compendium_history_p1"
            id="compendium_history_p1"
            rows="4"
            class="bg-paper-base border-2 border-paper-line focus:border-gold p-3.5 text-parchment font-prose text-sm leading-relaxed outline-none transition"
            placeholder="Long before the southern synods raised their marble courts..."
          ><?php echo html_escape(isset($world_settings['compendium_history_p1']) ? $world_settings['compendium_history_p1'] : ''); ?></textarea>
        </div>

        <!-- History Paragraph 2 -->
        <div class="flex flex-col gap-1.5 font-mono text-xs">
          <label for="compendium_history_p2" class="text-copper uppercase font-bold tracking-wider flex items-center justify-between">
            <span>Second History Paragraph</span>
            <span class="text-ash text-[10px]">Para 2</span>
          </label>
          <textarea
            name="compendium_history_p2"
            id="compendium_history_p2"
            rows="3"
            class="bg-paper-base border-2 border-paper-line focus:border-gold p-3.5 text-parchment font-prose text-sm leading-relaxed outline-none transition"
            placeholder="When the sun retreats during the high solstice cycles..."
          ><?php echo html_escape(isset($world_settings['compendium_history_p2']) ? $world_settings['compendium_history_p2'] : ''); ?></textarea>
        </div>

      </div>
    </div>

    <!-- SECTION B: THE THREE LORE PILLARS -->
    <div class="bg-paper-panel border-2 border-paper-line shadow-ink overflow-hidden">
      <div class="bg-paper-ink border-b-2 border-paper-line px-5 py-3 flex items-center justify-between text-xs font-mono">
        <div class="flex items-center gap-2">
          <span class="w-2 h-2 bg-gold rotate-45"></span>
          <span class="text-gold font-bold tracking-widest uppercase">The Three Pillars</span>
        </div>
        <span class="text-ash text-[10px]">3 pillars</span>
      </div>

      <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Pillar 1 -->
        <div class="bg-paper-base border-2 border-paper-line p-4 flex flex-col gap-3">
          <div class="font-mono text-[11px] text-copper uppercase font-bold border-b border-paper-line pb-1">
            PILLAR 1
          </div>
          <div class="flex flex-col gap-1 font-mono text-[11px]">
            <label class="text-ash uppercase">Tag Label</label>
            <input
              type="text"
              name="pillar_1_label"
              value="<?php echo html_escape(isset($world_settings['pillar_1_label']) ? $world_settings['pillar_1_label'] : 'PILLAR I // MYTHOS'); ?>"
              class="bg-paper-panel border border-paper-line focus:border-gold px-2.5 py-1.5 text-parchment text-xs outline-none"
            >
          </div>
          <div class="flex flex-col gap-1 font-mono text-[11px]">
            <label class="text-ash uppercase">Title</label>
            <input
              type="text"
              name="pillar_1_title"
              value="<?php echo html_escape(isset($world_settings['pillar_1_title']) ? $world_settings['pillar_1_title'] : 'The Pale Flame'); ?>"
              class="bg-paper-panel border border-paper-line focus:border-gold px-2.5 py-1.5 text-gold font-display font-bold text-sm outline-none"
            >
          </div>
          <div class="flex flex-col gap-1 font-mono text-[11px]">
            <label class="text-ash uppercase">Description</label>
            <textarea
              name="pillar_1_body"
              rows="3"
              class="bg-paper-panel border border-paper-line focus:border-gold p-2.5 text-parchment font-prose text-xs leading-relaxed outline-none"
            ><?php echo html_escape(isset($world_settings['pillar_1_body']) ? $world_settings['pillar_1_body'] : ''); ?></textarea>
          </div>
        </div>

        <!-- Pillar 2 -->
        <div class="bg-paper-base border-2 border-paper-line p-4 flex flex-col gap-3">
          <div class="font-mono text-[11px] text-copper uppercase font-bold border-b border-paper-line pb-1">
            PILLAR 2
          </div>
          <div class="flex flex-col gap-1 font-mono text-[11px]">
            <label class="text-ash uppercase">Tag Label</label>
            <input
              type="text"
              name="pillar_2_label"
              value="<?php echo html_escape(isset($world_settings['pillar_2_label']) ? $world_settings['pillar_2_label'] : 'PILLAR II // GEOGRAPHY'); ?>"
              class="bg-paper-panel border border-paper-line focus:border-gold px-2.5 py-1.5 text-parchment text-xs outline-none"
            >
          </div>
          <div class="flex flex-col gap-1 font-mono text-[11px]">
            <label class="text-ash uppercase">Title</label>
            <input
              type="text"
              name="pillar_2_title"
              value="<?php echo html_escape(isset($world_settings['pillar_2_title']) ? $world_settings['pillar_2_title'] : 'The Iron Pass'); ?>"
              class="bg-paper-panel border border-paper-line focus:border-gold px-2.5 py-1.5 text-gold font-display font-bold text-sm outline-none"
            >
          </div>
          <div class="flex flex-col gap-1 font-mono text-[11px]">
            <label class="text-ash uppercase">Description</label>
            <textarea
              name="pillar_2_body"
              rows="3"
              class="bg-paper-panel border border-paper-line focus:border-gold p-2.5 text-parchment font-prose text-xs leading-relaxed outline-none"
            ><?php echo html_escape(isset($world_settings['pillar_2_body']) ? $world_settings['pillar_2_body'] : ''); ?></textarea>
          </div>
        </div>

        <!-- Pillar 3 -->
        <div class="bg-paper-base border-2 border-paper-line p-4 flex flex-col gap-3">
          <div class="font-mono text-[11px] text-copper uppercase font-bold border-b border-paper-line pb-1">
            PILLAR 3
          </div>
          <div class="flex flex-col gap-1 font-mono text-[11px]">
            <label class="text-ash uppercase">Tag Label</label>
            <input
              type="text"
              name="pillar_3_label"
              value="<?php echo html_escape(isset($world_settings['pillar_3_label']) ? $world_settings['pillar_3_label'] : 'PILLAR III // POLITICS'); ?>"
              class="bg-paper-panel border border-paper-line focus:border-gold px-2.5 py-1.5 text-parchment text-xs outline-none"
            >
          </div>
          <div class="flex flex-col gap-1 font-mono text-[11px]">
            <label class="text-ash uppercase">Title</label>
            <input
              type="text"
              name="pillar_3_title"
              value="<?php echo html_escape(isset($world_settings['pillar_3_title']) ? $world_settings['pillar_3_title'] : 'The Synod Split'); ?>"
              class="bg-paper-panel border border-paper-line focus:border-gold px-2.5 py-1.5 text-gold font-display font-bold text-sm outline-none"
            >
          </div>
          <div class="flex flex-col gap-1 font-mono text-[11px]">
            <label class="text-ash uppercase">Description</label>
            <textarea
              name="pillar_3_body"
              rows="3"
              class="bg-paper-panel border border-paper-line focus:border-gold p-2.5 text-parchment font-prose text-xs leading-relaxed outline-none"
            ><?php echo html_escape(isset($world_settings['pillar_3_body']) ? $world_settings['pillar_3_body'] : ''); ?></textarea>
          </div>
        </div>

      </div>
    </div>

    <!-- SECTION C: REALM TELEMETRY & CARTOGRAPHIC PLATES -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
      
      <!-- Realm Ledger Metadata -->
      <div class="bg-paper-panel border-2 border-paper-line shadow-ink overflow-hidden">
        <div class="bg-paper-ink border-b-2 border-paper-line px-5 py-3 flex items-center justify-between text-xs font-mono">
          <span class="text-gold font-bold tracking-widest uppercase">World Details</span>
          <span class="text-ash text-[10px]">metadata</span>
        </div>
        <div class="p-6 flex flex-col gap-4 font-mono text-xs">
          
          <div class="flex flex-col gap-1">
            <label class="text-copper uppercase font-bold">Capital / Main City</label>
            <input
              type="text"
              name="dominant_seat"
              value="<?php echo html_escape(isset($world_settings['dominant_seat']) ? $world_settings['dominant_seat'] : 'The Frost Keep'); ?>"
              class="bg-paper-base border border-paper-line focus:border-gold px-3 py-2 text-parchment outline-none"
            >
          </div>

          <div class="flex flex-col gap-1">
            <label class="text-copper uppercase font-bold">Calendar System</label>
            <input
              type="text"
              name="calendar_system"
              value="<?php echo html_escape(isset($world_settings['calendar_system']) ? $world_settings['calendar_system'] : 'BV / AV / 2A'); ?>"
              class="bg-paper-base border border-paper-line focus:border-gold px-3 py-2 text-gold outline-none"
            >
          </div>

          <div class="flex flex-col gap-1">
            <label class="text-copper uppercase font-bold">Current Year</label>
            <input
              type="text"
              name="current_cycle"
              value="<?php echo html_escape(isset($world_settings['current_cycle']) ? $world_settings['current_cycle'] : '842 2A'); ?>"
              class="bg-paper-base border border-paper-line focus:border-gold px-3 py-2 text-parchment outline-none"
            >
          </div>

          <div class="flex flex-col gap-1">
            <label class="text-copper uppercase font-bold">World Status</label>
            <input
              type="text"
              name="realm_status"
              value="<?php echo html_escape(isset($world_settings['realm_status']) ? $world_settings['realm_status'] : 'SOLSTICE ALERT'); ?>"
              class="bg-paper-base border border-paper-line focus:border-gold px-3 py-2 text-copper outline-none"
            >
          </div>

        </div>
      </div>

      <!-- Plate II & Plate III Cartography & Engravings Section -->
      <div class="bg-paper-panel border-2 border-paper-line shadow-ink overflow-hidden">
        <div class="bg-paper-ink border-b-2 border-paper-line px-5 py-3 flex items-center justify-between text-xs font-mono">
          <span class="text-gold font-bold tracking-widest uppercase">Images &amp; Maps</span>
          <span class="text-ash text-[10px]">images</span>
        </div>
        <div class="p-6 flex flex-col gap-6 font-mono text-xs">
          
          <!-- ============================================================= -->
          <!-- PLATE II: CARTOGRAPHIC MAP SURVEY PLATE                      -->
          <!-- ============================================================= -->
          <div class="border-2 border-paper-line bg-paper-base p-4 shadow-ink-sm flex flex-col gap-4">
            
            <div class="flex items-center justify-between border-b border-paper-line pb-2">
              <div class="flex items-center gap-2">
                <span class="w-1.5 h-1.5 bg-gold rotate-45"></span>
                <span class="text-gold font-bold uppercase tracking-wider">Map Image</span>
              </div>
              <span class="text-[10px] text-ash">world map</span>
            </div>

            <!-- Map Plate Visual Preview Viewport -->
            <div id="map-plate-preview-box" class="relative min-h-[200px] max-h-[320px] bg-paper-deep border-2 border-dashed border-gold/40 flex flex-col items-center justify-center p-3 corner-brackets overflow-hidden group cursor-pointer transition hover:border-gold">
              <span class="absolute top-1 left-1 text-[10px] font-mono text-gold/60 pointer-events-none">+</span>
              <span class="absolute top-1 right-1 text-[10px] font-mono text-gold/60 pointer-events-none">+</span>
              <span class="absolute bottom-1 left-1 text-[10px] font-mono text-gold/60 pointer-events-none">+</span>
              <span class="absolute bottom-1 right-1 text-[10px] font-mono text-gold/60 pointer-events-none">+</span>

              <!-- Live Uploading Spinner Overlay -->
              <div id="map-upload-status" class="absolute inset-0 bg-paper-ink/90 flex flex-col items-center justify-center gap-2 z-20 hidden">
                <span class="w-4 h-4 border-2 border-gold border-t-transparent animate-spin inline-block"></span>
                <span class="text-gold font-bold text-[10px] uppercase tracking-widest">Uploading map...</span>
              </div>

              <!-- Map Image (if present) -->
              <img
                id="map-preview-img"
                src="<?php echo html_escape($map_plate_url ? $map_plate_url : ''); ?>"
                alt="Cartographic Survey Plate"
                class="max-w-full max-h-[290px] object-contain transition duration-500 group-hover:scale-[1.01] <?php echo empty($map_plate_url) ? 'hidden' : ''; ?>"
                onclick="if(this.src && typeof openLightbox==='function') openLightbox(this.src, 'Cartographic Survey Map');"
              >

              <!-- Map Placeholder State -->
              <div id="map-preview-placeholder" class="flex flex-col items-center justify-center text-center p-4 <?php echo !empty($map_plate_url) ? 'hidden' : ''; ?>">
                <svg class="w-12 h-12 text-gold/40 mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                  <circle cx="12" cy="12" r="10"/>
                  <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/>
                </svg>
                <span class="font-display italic text-sm text-copper mb-0.5">No map uploaded</span>
                <span class="font-mono text-[10px] text-ash">Drag &amp; drop a map image, or click Upload below</span>
              </div>

              <div id="map-enlarge-hint" class="absolute bottom-2 right-2 bg-paper-ink/85 border border-gold/60 text-gold px-2 py-0.5 text-[9px] uppercase opacity-0 group-hover:opacity-100 transition shadow-ink-sm <?php echo empty($map_plate_url) ? 'hidden' : ''; ?>">
                <span>⤢</span> ENLARGE
              </div>
            </div>

            <!-- Upload Action Bar -->
            <div class="flex flex-wrap items-center justify-between gap-2 pt-1 border-t border-paper-line/50">
              <input type="hidden" name="map_plate_file" id="map_plate_file" value="<?php echo html_escape($map_plate_file); ?>">
              <input type="file" id="map_plate_upload_input" accept="image/*" class="hidden" onchange="uploadWorldPlateFile(this, 'map')">
              
              <div class="flex items-center gap-2">
                <button type="button" onclick="document.getElementById('map_plate_upload_input').click()" class="border-2 border-gold/80 hover:border-gold px-3 py-1 bg-paper-panel text-gold font-bold hover:bg-gold hover:text-paper-ink transition uppercase text-[10px] flex items-center gap-1.5 shadow-ink-sm">
                  <span>↑</span> UPLOAD MAP PLATE
                </button>
                <button type="button" onclick="clearWorldPlate('map')" class="border border-paper-line hover:border-crimson px-2.5 py-1 bg-paper-panel text-ash hover:text-crimson transition uppercase text-[10px]">
                  ✕ REMOVE
                </button>
              </div>

              <span class="text-[10px] text-ash truncate max-w-[200px]" id="map-filename-display">
                <?php echo !empty($map_plate_file) ? html_escape(basename($map_plate_file)) : 'Default map'; ?>
              </span>
            </div>

            <!-- Survey Label & Landmark Nodes Form Inputs -->
            <div class="flex flex-col gap-3 pt-2 border-t border-paper-line">
              <div class="flex flex-col gap-1">
                <label class="text-copper uppercase font-bold text-[10px]">Map Label</label>
                <input
                  type="text"
                  name="map_plate_label"
                  value="<?php echo html_escape(isset($world_settings['map_plate_label']) ? $world_settings['map_plate_label'] : 'PLATE II // CARTOGRAPHIC SURVEY'); ?>"
                  class="bg-paper-panel border border-paper-line focus:border-gold px-3 py-1.5 text-parchment outline-none text-xs"
                >
              </div>

              <div class="flex flex-col gap-1.5">
                <label class="text-ash uppercase text-[10px]">Map Landmarks (up to 3)</label>
                <input
                  type="text"
                  name="map_node_1"
                  value="<?php echo html_escape(isset($world_settings['map_node_1']) ? $world_settings['map_node_1'] : 'THE FROST KEEP (High Crags)'); ?>"
                  class="bg-paper-panel border border-paper-line focus:border-gold px-3 py-1.5 text-gold text-xs outline-none"
                  placeholder="Main city / capital"
                >
                <input
                  type="text"
                  name="map_node_2"
                  value="<?php echo html_escape(isset($world_settings['map_node_2']) ? $world_settings['map_node_2'] : 'THE IRON PASS (Ward Gate)'); ?>"
                  class="bg-paper-panel border border-paper-line focus:border-gold px-3 py-1.5 text-copper text-xs outline-none"
                  placeholder="Border / gateway"
                >
                <input
                  type="text"
                  name="map_node_3"
                  value="<?php echo html_escape(isset($world_settings['map_node_3']) ? $world_settings['map_node_3'] : 'VALLEY OF VALORIA'); ?>"
                  class="bg-paper-panel border border-paper-line focus:border-gold px-3 py-1.5 text-parchment-dim text-xs outline-none"
                  placeholder="Outlying areas"
                >
              </div>
            </div>

          </div>


          <!-- ============================================================= -->
          <!-- PLATE III: ARCHITECTURAL ETCHING & WOODCUT                   -->
          <!-- ============================================================= -->
          <div class="border-2 border-paper-line bg-paper-base p-4 shadow-ink-sm flex flex-col gap-4">
            
            <div class="flex items-center justify-between border-b border-paper-line pb-2">
              <div class="flex items-center gap-2">
                <span class="w-1.5 h-1.5 bg-copper rotate-45"></span>
                <span class="text-copper font-bold uppercase tracking-wider">Secondary Image</span>
              </div>
              <span class="text-[10px] text-ash">illustration</span>
            </div>

            <!-- Etching Plate Visual Preview Viewport -->
            <div id="arch-plate-preview-box" class="relative min-h-[160px] max-h-[260px] bg-paper-deep border-2 border-dashed border-copper/40 flex flex-col items-center justify-center p-3 corner-brackets overflow-hidden group cursor-pointer transition hover:border-copper">
              <span class="absolute top-1 left-1 text-[10px] font-mono text-copper/60 pointer-events-none">+</span>
              <span class="absolute top-1 right-1 text-[10px] font-mono text-copper/60 pointer-events-none">+</span>
              <span class="absolute bottom-1 left-1 text-[10px] font-mono text-copper/60 pointer-events-none">+</span>
              <span class="absolute bottom-1 right-1 text-[10px] font-mono text-copper/60 pointer-events-none">+</span>

              <!-- Live Uploading Spinner Overlay -->
              <div id="arch-upload-status" class="absolute inset-0 bg-paper-ink/90 flex flex-col items-center justify-center gap-2 z-20 hidden">
                <span class="w-4 h-4 border-2 border-copper border-t-transparent animate-spin inline-block"></span>
                <span class="text-copper font-bold text-[10px] uppercase tracking-widest">Uploading image...</span>
              </div>

              <!-- Etching Image (if present) -->
              <img
                id="arch-preview-img"
                src="<?php echo html_escape($arch_etching_url ? $arch_etching_url : ''); ?>"
                alt="Architectural Etching Plate"
                class="max-w-full max-h-[230px] object-contain transition duration-500 group-hover:scale-[1.01] <?php echo empty($arch_etching_url) ? 'hidden' : ''; ?>"
                onclick="if(this.src && typeof openLightbox==='function') openLightbox(this.src, 'Architectural Etching');"
              >

              <!-- Etching Placeholder State -->
              <div id="arch-preview-placeholder" class="flex flex-col items-center justify-center text-center p-4 <?php echo !empty($arch_etching_url) ? 'hidden' : ''; ?>">
                <svg class="w-10 h-10 text-copper/40 mb-2" viewBox="0 0 100 100" fill="none" stroke="currentColor" stroke-width="1.5">
                  <path d="M15,90 L15,45 A35,35 0 0,1 85,45 L85,90"/>
                  <path d="M28,90 L28,48 A22,22 0 0,1 72,48 L72,90"/>
                  <line x1="5" y1="90" x2="95" y2="90"/>
                  <circle cx="50" cy="28" r="5"/>
                </svg>
                <span class="font-display italic text-sm text-copper mb-0.5">No image uploaded</span>
                <span class="font-mono text-[10px] text-ash">Drag &amp; drop an image, or click Upload below</span>
              </div>

              <div id="arch-enlarge-hint" class="absolute bottom-2 right-2 bg-paper-ink/85 border border-copper/60 text-copper px-2 py-0.5 text-[9px] uppercase opacity-0 group-hover:opacity-100 transition shadow-ink-sm <?php echo empty($arch_etching_url) ? 'hidden' : ''; ?>">
                <span>⤢</span> ENLARGE
              </div>
            </div>

            <!-- Upload Action Bar -->
            <div class="flex flex-wrap items-center justify-between gap-2 pt-1 border-t border-paper-line/50">
              <input type="hidden" name="arch_etching_file" id="arch_etching_file" value="<?php echo html_escape($arch_etching_file); ?>">
              <input type="file" id="arch_plate_upload_input" accept="image/*" class="hidden" onchange="uploadWorldPlateFile(this, 'arch')">
              
              <div class="flex items-center gap-2">
                <button type="button" onclick="document.getElementById('arch_plate_upload_input').click()" class="border-2 border-copper/80 hover:border-copper px-3 py-1 bg-paper-panel text-copper font-bold hover:bg-copper hover:text-paper-ink transition uppercase text-[10px] flex items-center gap-1.5 shadow-ink-sm">
                  <span>↑</span> UPLOAD ETCHING
                </button>
                <button type="button" onclick="clearWorldPlate('arch')" class="border border-paper-line hover:border-crimson px-2.5 py-1 bg-paper-panel text-ash hover:text-crimson transition uppercase text-[10px]">
                  ✕ REMOVE
                </button>
              </div>

              <span class="text-[10px] text-ash truncate max-w-[200px]" id="arch-filename-display">
                <?php echo !empty($arch_etching_file) ? html_escape(basename($arch_etching_file)) : 'Default image'; ?>
              </span>
            </div>

            <!-- Title & Caption Inputs -->
            <div class="flex flex-col gap-2 pt-2 border-t border-paper-line">
              <div class="flex flex-col gap-1">
                <label class="text-copper uppercase font-bold text-[10px]">Image Label</label>
                <input
                  type="text"
                  name="arch_etching_title"
                  value="<?php echo html_escape(isset($world_settings['arch_etching_title']) ? $world_settings['arch_etching_title'] : 'Secondary Image'); ?>"
                  class="bg-paper-panel border border-paper-line focus:border-gold px-3 py-1.5 text-copper text-xs outline-none"
                >
              </div>
              <div class="flex flex-col gap-1">
                <label class="text-ash uppercase text-[10px]">Image Caption</label>
                <input
                  type="text"
                  name="arch_etching_caption"
                  value="<?php echo html_escape(isset($world_settings['arch_etching_caption']) ? $world_settings['arch_etching_caption'] : 'THE GREAT BRAZIER OF THE FROST KEEP (ETCHING_014.WEBP)'); ?>"
                  class="bg-paper-panel border border-paper-line focus:border-gold px-3 py-1.5 text-parchment text-xs outline-none"
                >
              </div>
            </div>

          </div>


          <!-- ============================================================= -->
          <!-- PLATE I: HERO FRONTISPIECE PANORAMA (BONUS)                  -->
          <!-- ============================================================= -->
          <div class="border-2 border-paper-line bg-paper-base p-4 shadow-ink-sm flex flex-col gap-4">
            
            <div class="flex items-center justify-between border-b border-paper-line pb-2">
              <div class="flex items-center gap-2">
                <span class="w-1.5 h-1.5 bg-gold rotate-45"></span>
                <span class="text-gold font-bold uppercase tracking-wider">Banner Image</span>
              </div>
              <span class="text-[10px] text-ash">hero banner</span>
            </div>

            <!-- Hero Plate Visual Preview Viewport -->
            <div id="hero-plate-preview-box" class="relative min-h-[140px] max-h-[220px] bg-paper-deep border-2 border-dashed border-gold/40 flex flex-col items-center justify-center p-3 corner-brackets overflow-hidden group cursor-pointer transition hover:border-gold">
              <span class="absolute top-1 left-1 text-[10px] font-mono text-gold/60 pointer-events-none">+</span>
              <span class="absolute top-1 right-1 text-[10px] font-mono text-gold/60 pointer-events-none">+</span>
              <span class="absolute bottom-1 left-1 text-[10px] font-mono text-gold/60 pointer-events-none">+</span>
              <span class="absolute bottom-1 right-1 text-[10px] font-mono text-gold/60 pointer-events-none">+</span>

              <!-- Live Uploading Spinner Overlay -->
              <div id="hero-upload-status" class="absolute inset-0 bg-paper-ink/90 flex flex-col items-center justify-center gap-2 z-20 hidden">
                <span class="w-4 h-4 border-2 border-gold border-t-transparent animate-spin inline-block"></span>
                <span class="text-gold font-bold text-[10px] uppercase tracking-widest">Uploading banner...</span>
              </div>

              <!-- Hero Image (if present) -->
              <img
                id="hero-preview-img"
                src="<?php echo html_escape($hero_panorama_url ? $hero_panorama_url : ''); ?>"
                alt="Hero Panorama Plate"
                class="w-full max-h-[200px] object-cover transition duration-500 group-hover:scale-[1.01] <?php echo empty($hero_panorama_url) ? 'hidden' : ''; ?>"
                onclick="if(this.src && typeof openLightbox==='function') openLightbox(this.src, 'Hero Panorama Frontispiece');"
              >

              <!-- Hero Placeholder State -->
              <div id="hero-preview-placeholder" class="flex flex-col items-center justify-center text-center p-4 <?php echo !empty($hero_panorama_url) ? 'hidden' : ''; ?>">
                <svg class="w-10 h-10 text-gold/40 mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                  <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                  <circle cx="8.5" cy="8.5" r="1.5"/>
                  <polyline points="21 15 16 10 5 21"/>
                </svg>
                <span class="font-display italic text-sm text-copper mb-0.5">Default banner</span>
                <span class="font-mono text-[10px] text-ash">Drag &amp; drop a banner image, or click Upload</span>
              </div>

              <div id="hero-enlarge-hint" class="absolute bottom-2 right-2 bg-paper-ink/85 border border-gold/60 text-gold px-2 py-0.5 text-[9px] uppercase opacity-0 group-hover:opacity-100 transition shadow-ink-sm <?php echo empty($hero_panorama_url) ? 'hidden' : ''; ?>">
                <span>⤢</span> ENLARGE
              </div>
            </div>

            <!-- Upload Action Bar -->
            <div class="flex flex-wrap items-center justify-between gap-2 pt-1 border-t border-paper-line/50">
              <input type="hidden" name="hero_panorama_file" id="hero_panorama_file" value="<?php echo html_escape($hero_panorama_file); ?>">
              <input type="file" id="hero_plate_upload_input" accept="image/*" class="hidden" onchange="uploadWorldPlateFile(this, 'hero')">
              
              <div class="flex items-center gap-2">
                <button type="button" onclick="document.getElementById('hero_plate_upload_input').click()" class="border-2 border-gold/80 hover:border-gold px-3 py-1 bg-paper-panel text-gold font-bold hover:bg-gold hover:text-paper-ink transition uppercase text-[10px] flex items-center gap-1.5 shadow-ink-sm">
                  <span>↑</span> UPLOAD PANORAMA
                </button>
                <button type="button" onclick="clearWorldPlate('hero')" class="border border-paper-line hover:border-crimson px-2.5 py-1 bg-paper-panel text-ash hover:text-crimson transition uppercase text-[10px]">
                  ✕ REMOVE
                </button>
              </div>

              <span class="text-[10px] text-ash truncate max-w-[200px]" id="hero-filename-display">
                <?php echo !empty($hero_panorama_file) ? html_escape(basename($hero_panorama_file)) : 'Default banner'; ?>
              </span>
            </div>

          </div>

        </div>
      </div>

    </div>

    <!-- ACTION BUTTONS -->
    <div class="flex items-center justify-between border-t-2 border-paper-line pt-6">
      <a href="<?php echo base_url('dashboard'); ?>" class="px-5 py-3 border-2 border-paper-line hover:border-parchment text-parchment-dim hover:text-parchment font-mono text-xs uppercase tracking-widest transition">
        &larr; Cancel
      </a>
      <button type="submit" class="px-8 py-3 bg-gold hover:bg-gold-light text-paper-ink border-2 border-gold font-mono font-bold text-xs uppercase tracking-widest shadow-ink transition">
        ✦ Save Settings
      </button>
    </div>

  </form>

</div>

<!-- JAVASCRIPT: WORLD CARTOGRAPHY & ETCHING UPLOADER -->
<script>
function uploadWorldPlateFile(input, plateType) {
  if (!input.files || input.files.length === 0) return;
  const file = input.files[0];
  processWorldPlateUpload(file, plateType);
}

function processWorldPlateUpload(file, plateType) {
  if (!file || !file.type.startsWith('image/')) {
    alert('Please select an image file (PNG, JPG, WEBP, SVG).');
    return;
  }

  const statusEl = document.getElementById(plateType + '-upload-status');
  if (statusEl) statusEl.classList.remove('hidden');

  const formData = new FormData();
  formData.append('file', file);
  formData.append('world_id', '<?php echo (int)$active_world->id; ?>');
  formData.append('caption', 'World ' + plateType.toUpperCase() + ' Plate');

  fetch('<?php echo base_url("media/upload"); ?>', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (statusEl) statusEl.classList.add('hidden');
    if (data.success) {
      // 1. Update hidden input
      const inputEl = document.getElementById(plateType === 'map' ? 'map_plate_file' : (plateType === 'arch' ? 'arch_etching_file' : 'hero_panorama_file'));
      if (inputEl) inputEl.value = data.file_path;

      // 2. Update preview image
      const imgEl = document.getElementById(plateType + '-preview-img');
      const placeholderEl = document.getElementById(plateType + '-preview-placeholder');
      const hintEl = document.getElementById(plateType + '-enlarge-hint');
      const filenameEl = document.getElementById(plateType + '-filename-display');

      if (imgEl) {
        imgEl.src = data.url;
        imgEl.classList.remove('hidden');
      }
      if (placeholderEl) placeholderEl.classList.add('hidden');
      if (hintEl) hintEl.classList.remove('hidden');
      if (filenameEl) filenameEl.textContent = data.stored_filename;

      if (typeof showArchivalToast === 'function') {
        showArchivalToast('✦ Image uploaded: ' + plateType.toUpperCase());
      }
    } else {
      alert(data.message || 'Upload failed.');
    }
  })
  .catch(err => {
    if (statusEl) statusEl.classList.add('hidden');
    alert('Network error. Please try again.');
    console.error(err);
  });
}

function clearWorldPlate(plateType) {
  const inputEl = document.getElementById(plateType === 'map' ? 'map_plate_file' : (plateType === 'arch' ? 'arch_etching_file' : 'hero_panorama_file'));
  if (inputEl) inputEl.value = '';

  const imgEl = document.getElementById(plateType + '-preview-img');
  const placeholderEl = document.getElementById(plateType + '-preview-placeholder');
  const hintEl = document.getElementById(plateType + '-enlarge-hint');
  const filenameEl = document.getElementById(plateType + '-filename-display');

  if (imgEl) {
    imgEl.src = '';
    imgEl.classList.add('hidden');
  }
  if (placeholderEl) placeholderEl.classList.remove('hidden');
  if (hintEl) hintEl.classList.add('hidden');
  if (filenameEl) filenameEl.textContent = 'Default ' + plateType.toUpperCase();
}

// Drag & Drop Setup on each preview container
document.addEventListener('DOMContentLoaded', function() {
  ['map', 'arch', 'hero'].forEach(plateType => {
    const box = document.getElementById(plateType + '-plate-preview-box');
    if (!box) return;

    box.addEventListener('dragover', function(e) {
      e.preventDefault();
      e.dataTransfer.dropEffect = 'copy';
      box.classList.add('border-gold', 'bg-paper-deep/80', 'ring-2', 'ring-gold/40');
    });

    box.addEventListener('dragleave', function(e) {
      e.preventDefault();
      box.classList.remove('border-gold', 'bg-paper-deep/80', 'ring-2', 'ring-gold/40');
    });

    box.addEventListener('drop', function(e) {
      e.preventDefault();
      box.classList.remove('border-gold', 'bg-paper-deep/80', 'ring-2', 'ring-gold/40');
      if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
        processWorldPlateUpload(e.dataTransfer.files[0], plateType);
      }
    });
  });
});
</script>
