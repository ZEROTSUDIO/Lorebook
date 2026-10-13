<!-- HEADER / NAVIGATION (Dossier Title Bar with Ancient Regalia) -->
<header class="flex flex-col items-center gap-5 text-center border-b-2 border-paper-line pb-8">
  
  <!-- SUB-NAVIGATION BAR WITH SHARP TABS -->
  <nav class="flex flex-wrap justify-center gap-2 font-mono text-xs uppercase tracking-widest text-ash">
    <?php 
      $current_tab = isset($active_tab) ? $active_tab : 'dashboard';
    ?>
    <a href="<?php echo base_url('dashboard'); ?>" class="px-3.5 py-1.5 border-2 <?php echo ($current_tab === 'dashboard') ? 'border-gold text-gold font-bold shadow-ink-sm bg-paper-panel' : 'border-paper-line hover:border-parchment-dark text-parchment-dim hover:text-parchment bg-paper-panel'; ?> flex items-center gap-2 transition">
      <span class="w-1.5 h-1.5 bg-gold rotate-45 inline-block"></span> FIELD JOURNAL
    </a>
    <a href="<?php echo base_url('entries'); ?>" class="px-3.5 py-1.5 border-2 <?php echo ($current_tab === 'encyclopedia') ? 'border-gold text-gold font-bold shadow-ink-sm bg-paper-panel' : 'border-paper-line hover:border-parchment-dark text-parchment-dim hover:text-parchment bg-paper-panel'; ?> transition">
      ALL RECORDS
    </a>
    <a href="<?php echo base_url('entries?type=persons'); ?>" class="px-3.5 py-1.5 border-2 <?php echo ($current_tab === 'persons') ? 'border-gold text-gold font-bold shadow-ink-sm bg-paper-panel' : 'border-paper-line hover:border-parchment-dark text-parchment-dim hover:text-parchment bg-paper-panel'; ?> transition">
      PERSONS &amp; CLANS
    </a>
    <a href="<?php echo base_url('entries?type=realms'); ?>" class="px-3.5 py-1.5 border-2 <?php echo ($current_tab === 'realms') ? 'border-gold text-gold font-bold shadow-ink-sm bg-paper-panel' : 'border-paper-line hover:border-parchment-dark text-parchment-dim hover:text-parchment bg-paper-panel'; ?> transition">
      REALMS &amp; SEATS
    </a>
    <a href="<?php echo base_url('entries?type=orders'); ?>" class="px-3.5 py-1.5 border-2 <?php echo ($current_tab === 'orders') ? 'border-gold text-gold font-bold shadow-ink-sm bg-paper-panel' : 'border-paper-line hover:border-parchment-dark text-parchment-dim hover:text-parchment bg-paper-panel'; ?> transition">
      SACRED ORDERS
    </a>
    <a href="<?php echo base_url('entries?type=bestiary'); ?>" class="px-3.5 py-1.5 border-2 <?php echo ($current_tab === 'bestiary') ? 'border-gold text-gold font-bold shadow-ink-sm bg-paper-panel' : 'border-paper-line hover:border-parchment-dark text-parchment-dim hover:text-parchment bg-paper-panel'; ?> transition">
      BESTIARY &amp; RELICS
    </a>
    <a href="<?php echo base_url('entries?type=chronicle'); ?>" class="px-3.5 py-1.5 border-2 <?php echo ($current_tab === 'chronicle' || $current_tab === 'timeline') ? 'border-gold text-gold font-bold shadow-ink-sm bg-paper-panel' : 'border-paper-line hover:border-parchment-dark text-parchment-dim hover:text-parchment bg-paper-panel'; ?> transition">
      CHRONICLE &amp; ERAS
    </a>
    <a href="<?php echo base_url('entries/create'); ?>" class="px-3.5 py-1.5 border-2 <?php echo ($current_tab === 'create') ? 'border-gold text-paper-ink bg-gold font-bold shadow-ink-sm' : 'border-gold/70 text-gold-light hover:border-gold hover:text-white bg-paper-deep shadow-ink-sm'; ?> transition flex items-center gap-1.5">
      <span class="font-bold">＋</span> INSCRIBE ENTRY
    </a>
  </nav>

  <!-- HEADLINE & ANCIENT HERALDRY -->
  <div class="mt-2 flex flex-col items-center">
    <div class="font-mono text-[11px] uppercase tracking-[0.35em] text-copper mb-2 flex items-center gap-2">
      <span>◆</span> <?php echo isset($sub_heading) ? html_escape($sub_heading) : 'LIBER PERSONARUM // CHRONICLES OF CANAAN'; ?> <span>◆</span>
    </div>
    <h1 class="font-display font-bold text-4xl sm:text-6xl lg:text-7xl tracking-widest uppercase text-gold leading-none drop-shadow-sm">
      <?php echo isset($header_title) ? html_escape($header_title) : 'The Field Journal'; ?>
    </h1>
    <p class="font-cinzel text-xs sm:text-sm tracking-[0.25em] text-parchment-dim uppercase mt-2">
      <?php echo isset($header_caption) ? html_escape($header_caption) : 'Imperial Vault of Recorded Histories · Scribe Dossier 014'; ?>
    </p>
  </div>

  <!-- FANTASY ORNAMENTAL DIVIDER -->
  <div class="flex items-center gap-3 w-80 max-w-full">
    <span class="flex-1 h-px bg-paper-line"></span>
    <span class="w-2 h-2 border border-gold rotate-45"></span>
    <span class="w-3.5 h-3.5 border-2 border-gold rotate-45 flex items-center justify-center">
      <span class="w-1.5 h-1.5 bg-gold"></span>
    </span>
    <span class="w-2 h-2 border border-gold rotate-45"></span>
    <span class="flex-1 h-px bg-paper-line"></span>
  </div>
</header>
