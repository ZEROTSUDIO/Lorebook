<?php
  $world_name = isset($active_world->name) ? $active_world->name : 'Canaan';
?>

<div class="max-w-5xl mx-auto flex flex-col gap-8">

  <!-- TOP RETURN BAR & BREADCRUMB -->
  <div class="flex items-center justify-between border-b-2 border-paper-line pb-4 font-mono text-xs">
    <div class="flex items-center gap-2">
      <span class="w-2 h-2 bg-gold rotate-45"></span>
      <a href="<?php echo base_url('dashboard'); ?>" class="text-parchment-dim hover:text-gold uppercase tracking-widest transition">
        &larr; RETURN TO ATLAS
      </a>
      <span class="text-paper-line">/</span>
      <span class="text-gold font-bold uppercase tracking-wider">WORLD COMPENDIUM PREFERENCES</span>
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
        [VIEW ON ATLAS &rarr;]
      </a>
    </div>
  <?php endif; ?>

  <form action="<?php echo base_url('dashboard/settings'); ?>" method="POST" class="flex flex-col gap-8">
    
    <!-- SECTION A: PRIMARY ANNALS & HISTORY PROSE -->
    <div class="bg-paper-panel border-2 border-paper-line shadow-ink overflow-hidden">
      <div class="bg-paper-ink border-b-2 border-paper-line px-5 py-3 flex items-center justify-between text-xs font-mono">
        <div class="flex items-center gap-2">
          <span class="w-2 h-2 bg-copper rotate-45"></span>
          <span class="text-gold font-bold tracking-widest uppercase">I. ANNALS &amp; FOUNDATIONAL CHRONICLES</span>
        </div>
        <span class="text-ash text-[10px]">SECTION II LEFT PAGE</span>
      </div>

      <div class="p-6 flex flex-col gap-6">
        
        <!-- Header Ribbon Label -->
        <div class="flex flex-col gap-1.5 font-mono text-xs">
          <label for="compendium_annals_label" class="text-copper uppercase font-bold tracking-wider">
            Compendium Section Ribbon Tag
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
            <span>Primary History Paragraph [Rendered with Illuminated Drop-Cap]</span>
            <span class="text-ash text-[10px]">PARAGRAPH 1</span>
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
            <span>Secondary History Paragraph</span>
            <span class="text-ash text-[10px]">PARAGRAPH 2</span>
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
          <span class="text-gold font-bold tracking-widest uppercase">II. THE THREE FOUNDATIONAL PILLARS</span>
        </div>
        <span class="text-ash text-[10px]">TRIPTYCH TRIAD</span>
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
          <span class="text-gold font-bold tracking-widest uppercase">III. REALM LEDGER METADATA</span>
          <span class="text-ash text-[10px]">LEDGER STRIP</span>
        </div>
        <div class="p-6 flex flex-col gap-4 font-mono text-xs">
          
          <div class="flex flex-col gap-1">
            <label class="text-copper uppercase font-bold">Dominant Seat / Citadel</label>
            <input
              type="text"
              name="dominant_seat"
              value="<?php echo html_escape(isset($world_settings['dominant_seat']) ? $world_settings['dominant_seat'] : 'The Frost Keep'); ?>"
              class="bg-paper-base border border-paper-line focus:border-gold px-3 py-2 text-parchment outline-none"
            >
          </div>

          <div class="flex flex-col gap-1">
            <label class="text-copper uppercase font-bold">Calendar System Notation</label>
            <input
              type="text"
              name="calendar_system"
              value="<?php echo html_escape(isset($world_settings['calendar_system']) ? $world_settings['calendar_system'] : 'BV / AV / 2A'); ?>"
              class="bg-paper-base border border-paper-line focus:border-gold px-3 py-2 text-gold outline-none"
            >
          </div>

          <div class="flex flex-col gap-1">
            <label class="text-copper uppercase font-bold">Current Cycle / Year</label>
            <input
              type="text"
              name="current_cycle"
              value="<?php echo html_escape(isset($world_settings['current_cycle']) ? $world_settings['current_cycle'] : '842 2A'); ?>"
              class="bg-paper-base border border-paper-line focus:border-gold px-3 py-2 text-parchment outline-none"
            >
          </div>

          <div class="flex flex-col gap-1">
            <label class="text-copper uppercase font-bold">Realm Status Badge</label>
            <input
              type="text"
              name="realm_status"
              value="<?php echo html_escape(isset($world_settings['realm_status']) ? $world_settings['realm_status'] : 'SOLSTICE ALERT'); ?>"
              class="bg-paper-base border border-paper-line focus:border-gold px-3 py-2 text-copper outline-none"
            >
          </div>

        </div>
      </div>

      <!-- Plate II & Plate III Cartography Captions -->
      <div class="bg-paper-panel border-2 border-paper-line shadow-ink overflow-hidden">
        <div class="bg-paper-ink border-b-2 border-paper-line px-5 py-3 flex items-center justify-between text-xs font-mono">
          <span class="text-gold font-bold tracking-widest uppercase">IV. CARTOGRAPHY &amp; ENGRAVINGS</span>
          <span class="text-ash text-[10px]">PLATES II &amp; III</span>
        </div>
        <div class="p-6 flex flex-col gap-4 font-mono text-xs">
          
          <div class="flex flex-col gap-1">
            <label class="text-copper uppercase font-bold">Plate II Survey Header</label>
            <input
              type="text"
              name="map_plate_label"
              value="<?php echo html_escape(isset($world_settings['map_plate_label']) ? $world_settings['map_plate_label'] : 'PLATE II // CARTOGRAPHIC SURVEY'); ?>"
              class="bg-paper-base border border-paper-line focus:border-gold px-3 py-2 text-parchment outline-none"
            >
          </div>

          <div class="flex flex-col gap-1">
            <label class="text-copper uppercase font-bold">Plate II Image Reference</label>
            <input
              type="text"
              name="map_plate_file"
              value="<?php echo html_escape(isset($world_settings['map_plate_file']) ? $world_settings['map_plate_file'] : 'MAP_OF_CANAAN_NORTH.WEBP'); ?>"
              class="bg-paper-base border border-paper-line focus:border-gold px-3 py-2 text-parchment outline-none"
            >
          </div>

          <div class="grid grid-cols-1 gap-2 pt-1 border-t border-paper-line">
            <label class="text-ash uppercase text-[10px]">Survey Map Landmarks (Nodes 1–3)</label>
            <input
              type="text"
              name="map_node_1"
              value="<?php echo html_escape(isset($world_settings['map_node_1']) ? $world_settings['map_node_1'] : 'THE FROST KEEP (High Crags)'); ?>"
              class="bg-paper-base border border-paper-line focus:border-gold px-3 py-1.5 text-gold text-xs outline-none"
              placeholder="Node 1"
            >
            <input
              type="text"
              name="map_node_2"
              value="<?php echo html_escape(isset($world_settings['map_node_2']) ? $world_settings['map_node_2'] : 'THE IRON PASS (Ward Gate)'); ?>"
              class="bg-paper-base border border-paper-line focus:border-gold px-3 py-1.5 text-copper text-xs outline-none"
              placeholder="Node 2"
            >
            <input
              type="text"
              name="map_node_3"
              value="<?php echo html_escape(isset($world_settings['map_node_3']) ? $world_settings['map_node_3'] : 'VALLEY OF VALORIA'); ?>"
              class="bg-paper-base border border-paper-line focus:border-gold px-3 py-1.5 text-parchment-dim text-xs outline-none"
              placeholder="Node 3"
            >
          </div>

          <div class="flex flex-col gap-1 pt-2 border-t border-paper-line">
            <label class="text-copper uppercase font-bold">Plate III Architectural Etching Caption</label>
            <input
              type="text"
              name="arch_etching_caption"
              value="<?php echo html_escape(isset($world_settings['arch_etching_caption']) ? $world_settings['arch_etching_caption'] : 'THE GREAT BRAZIER OF THE FROST KEEP (ETCHING_014.WEBP)'); ?>"
              class="bg-paper-base border border-paper-line focus:border-gold px-3 py-2 text-parchment outline-none"
            >
          </div>

        </div>
      </div>

    </div>

    <!-- ACTION BUTTONS -->
    <div class="flex items-center justify-between border-t-2 border-paper-line pt-6">
      <a href="<?php echo base_url('dashboard'); ?>" class="px-5 py-3 border-2 border-paper-line hover:border-parchment text-parchment-dim hover:text-parchment font-mono text-xs uppercase tracking-widest transition">
        &larr; CANCEL
      </a>
      <button type="submit" class="px-8 py-3 bg-gold hover:bg-gold-light text-paper-ink border-2 border-gold font-mono font-bold text-xs uppercase tracking-widest shadow-ink transition">
        ✦ PRESERVE IN CHRONICLES
      </button>
    </div>

  </form>

</div>
