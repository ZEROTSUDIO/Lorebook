<!-- TOP MECHANICAL ARCHIVE STRIP -->
<div class="border-b-2 border-paper-ink bg-paper-deep/95 backdrop-blur px-4 sm:px-8 py-2 flex flex-wrap items-center justify-between text-xs font-mono text-ash gap-2">
  <div class="flex items-center gap-3">
    <!-- In-world sigil icon -->
    <a href="<?php echo base_url(); ?>" class="w-3.5 h-3.5 border border-gold rotate-45 flex items-center justify-center hover:bg-gold transition group" title="Return to Codex Home">
      <span class="w-1 h-1 bg-gold group-hover:bg-paper-ink"></span>
    </a>

    <!-- WORLD SWITCHER SELECTOR -->
    <div class="relative group">
      <button type="button" class="flex items-center gap-1.5 font-bold tracking-widest uppercase text-parchment hover:text-gold border border-paper-line hover:border-gold px-2.5 py-1 bg-paper-panel transition text-xs shadow-ink-sm">
        <span class="w-1.5 h-1.5 bg-copper rotate-45 inline-block"></span>
        <span>World: <?php echo isset($active_world) ? html_escape(strtoupper($active_world->name)) : 'CANAAN'; ?></span>
        <span class="text-[9px] text-copper">▼</span>
      </button>

      <!-- DROPDOWN FOLIO -->
      <div class="absolute left-0 top-full mt-1.5 w-64 bg-paper-panel border-2 border-gold shadow-ink hidden group-hover:block z-50 p-2">
        <div class="font-mono text-[10px] text-copper uppercase tracking-wider px-2 py-1 border-b border-paper-line mb-1 flex justify-between">
          <span>Switch World</span>
          <span>CODEX</span>
        </div>
        
        <?php 
          $all_realms = get_instance()->db->order_by('name', 'ASC')->get('worlds')->result();
          $cur_wid = isset($active_world->id) ? (int)$active_world->id : 0;
        ?>

        <div class="flex flex-col gap-1 max-h-48 overflow-y-auto">
          <?php foreach ($all_realms as $rw): ?>
            <a 
              href="<?php echo base_url('worlds/switch_world/' . $rw->id); ?>" 
              class="px-2.5 py-1.5 text-xs font-mono uppercase flex items-center justify-between border <?php echo ((int)$rw->id === $cur_wid) ? 'border-gold bg-paper-base text-gold font-bold' : 'border-transparent hover:border-paper-line text-parchment-dim hover:text-parchment hover:bg-paper-deep'; ?> transition"
            >
              <span><?php echo html_escape($rw->name); ?></span>
              <?php if ((int)$rw->id === $cur_wid): ?>
                <span class="text-[9px] text-gold">● Active</span>
              <?php endif; ?>
            </a>
          <?php endforeach; ?>
        </div>

        <div class="border-t border-paper-line mt-2 pt-2">
          <a href="<?php echo base_url('worlds/create'); ?>" class="block text-center font-mono text-[10px] uppercase tracking-wider py-1.5 bg-gold hover:bg-gold-light text-paper-ink font-bold transition">
            ＋ New World
          </a>
        </div>
      </div>
    </div>

    <span class="text-paper-line hidden sm:inline">|</span>
    <span class="text-gold hidden sm:inline">Year: <?php echo isset($current_cycle) ? html_escape($current_cycle) : '842 2A'; ?></span>
  </div>
  
  <!-- Archival Status & Quick Controls -->
  <div class="flex items-center gap-3 sm:gap-4 text-[11px]">
    <!-- Scribe / Archivist Badge -->
    <?php if (isset($current_user) && !empty($current_user)): ?>
      <div class="flex items-center gap-1.5 border border-gold/60 px-2 py-0.5 bg-paper-panel text-gold shadow-ink-sm" title="Logged in as <?php echo html_escape($current_user->username); ?>">
        <span class="w-1.5 h-1.5 bg-gold rotate-45"></span>
        <span class="uppercase tracking-wider font-bold">
          Author: <?php echo html_escape($current_user->display_name ? $current_user->display_name : $current_user->username); ?>
        </span>
        <span class="text-[9px] text-copper px-1 border border-copper/50 hidden lg:inline">
          <?php echo strtoupper(html_escape($current_user->role ? $current_user->role : 'SCRIBE')); ?>
        </span>
      </div>
    <?php endif; ?>

    <span class="hidden md:inline text-parchment-dim">
      Canon: <strong class="text-parchment"><?php echo isset($canon_count) ? (int)$canon_count : 0; ?> ENTRIES</strong>
    </span>
    <span class="hidden md:inline text-parchment-dim">
      Drafts: <strong class="text-copper"><?php echo isset($draft_count) ? (int)$draft_count : 0; ?></strong>
    </span>
    
    <div class="flex items-center gap-1.5 border border-gold/40 px-2 py-0.5 bg-paper-base shadow-ink-sm text-gold">
      <span class="w-1.5 h-1.5 bg-gold rounded-full"></span>
      <span class="font-bold tracking-wider">Live</span>
    </div>
    
    <!-- Global Query Search Modal Trigger -->
    <button type="button" onclick="alert('Global search coming soon!')" class="border border-paper-line hover:border-gold px-2.5 py-0.5 bg-paper-panel text-parchment transition">
      Search [CMD+K]
    </button>
  </div>
</div>
