<!-- TOP MECHANICAL ARCHIVE STRIP -->
<div class="border-b-2 border-paper-ink bg-paper-deep/95 backdrop-blur px-4 sm:px-8 py-2 flex flex-wrap items-center justify-between text-xs font-mono text-ash gap-2">
  <div class="flex items-center gap-3">
    <!-- In-world sigil icon -->
    <a href="<?php echo base_url(); ?>" class="w-3.5 h-3.5 border border-gold rotate-45 flex items-center justify-center hover:bg-gold transition group" title="Return to Codex Home">
      <span class="w-1 h-1 bg-gold group-hover:bg-paper-ink"></span>
    </a>
    <span class="tracking-widest uppercase font-bold text-parchment">
      CODEX ARCHIVIST // REALM OF <?php echo isset($active_world) ? html_escape(strtoupper($active_world->name)) : 'CANAAN'; ?>
    </span>
    <span class="text-paper-line hidden sm:inline">|</span>
    <span class="text-gold hidden sm:inline">CYCLE: <?php echo isset($current_cycle) ? html_escape($current_cycle) : '842 2A'; ?></span>
  </div>
  
  <!-- Archival Status & Quick Controls -->
  <div class="flex items-center gap-3 sm:gap-4 text-[11px]">
    <!-- Scribe / Archivist Badge -->
    <?php if (isset($current_user) && !empty($current_user)): ?>
      <div class="flex items-center gap-1.5 border border-gold/60 px-2 py-0.5 bg-paper-panel text-gold shadow-ink-sm" title="Logged in as <?php echo html_escape($current_user->username); ?>">
        <span class="w-1.5 h-1.5 bg-gold rotate-45"></span>
        <span class="uppercase tracking-wider font-bold">
          SCRIBE: <?php echo html_escape($current_user->display_name ? $current_user->display_name : $current_user->username); ?>
        </span>
        <span class="text-[9px] text-copper px-1 border border-copper/50 hidden lg:inline">
          <?php echo strtoupper(html_escape($current_user->role ? $current_user->role : 'SCRIBE')); ?>
        </span>
      </div>
    <?php endif; ?>

    <span class="hidden md:inline text-parchment-dim">
      CANON INDEX: <strong class="text-parchment"><?php echo isset($canon_count) ? (int)$canon_count : 0; ?> ENTRIES</strong>
    </span>
    <span class="hidden md:inline text-parchment-dim">
      DRAFTS: <strong class="text-copper"><?php echo isset($draft_count) ? (int)$draft_count : 0; ?></strong>
    </span>
    
    <div class="flex items-center gap-1.5 border border-gold/40 px-2 py-0.5 bg-paper-base shadow-ink-sm text-gold">
      <span class="w-1.5 h-1.5 bg-gold rounded-full"></span>
      <span class="font-bold tracking-wider">SEALED CANON</span>
    </div>
    
    <!-- Global Query Search Modal Trigger -->
    <button type="button" onclick="alert('Global search [CMD+K] palette coming in Phase 2!')" class="border border-paper-line hover:border-gold px-2.5 py-0.5 bg-paper-panel text-parchment transition">
      [CMD+K] QUERY
    </button>
  </div>
</div>
