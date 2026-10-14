<!-- HEADER / NAVIGATION (Dossier Title Bar with Ancient Regalia) -->
<header class="flex flex-col items-center gap-5 text-center <?php echo !empty($hide_header_banner) ? 'pb-2' : 'border-b-2 border-paper-line pb-8'; ?>">
  
  <!-- SUB-NAVIGATION BAR WITH SHARP TABS -->
  <nav class="flex flex-wrap justify-center gap-2 font-mono text-xs uppercase tracking-widest text-ash">
    <?php 
      $current_tab = isset($active_tab) ? $active_tab : 'dashboard';
    ?>
    <a href="<?php echo base_url('dashboard'); ?>" class="px-3 py-1.5 border-2 <?php echo ($current_tab === 'dashboard') ? 'border-gold text-gold font-bold shadow-ink-sm bg-paper-panel' : 'border-paper-line hover:border-parchment-dark text-parchment-dim hover:text-parchment bg-paper-panel'; ?> flex items-center gap-2 transition">
      <span class="w-1.5 h-1.5 bg-gold rotate-45 inline-block"></span> ATLAS
    </a>
    <a href="<?php echo base_url('entries'); ?>" class="px-3 py-1.5 border-2 <?php echo ($current_tab === 'encyclopedia') ? 'border-gold text-gold font-bold shadow-ink-sm bg-paper-panel' : 'border-paper-line hover:border-parchment-dark text-parchment-dim hover:text-parchment bg-paper-panel'; ?> transition">
      ALL RECORDS
    </a>
    <a href="<?php echo base_url('entries?type=characters'); ?>" class="px-3 py-1.5 border-2 <?php echo ($current_tab === 'characters' || $current_tab === 'persons') ? 'border-gold text-gold font-bold shadow-ink-sm bg-paper-panel' : 'border-paper-line hover:border-parchment-dark text-parchment-dim hover:text-parchment bg-paper-panel'; ?> transition">
      PERSONAE
    </a>
    <a href="<?php echo base_url('entries?type=nations'); ?>" class="px-3 py-1.5 border-2 <?php echo ($current_tab === 'nations' || $current_tab === 'realms') ? 'border-gold text-gold font-bold shadow-ink-sm bg-paper-panel' : 'border-paper-line hover:border-parchment-dark text-parchment-dim hover:text-parchment bg-paper-panel'; ?> transition">
      NATIONS
    </a>
    <a href="<?php echo base_url('entries?type=artifacts'); ?>" class="px-3 py-1.5 border-2 <?php echo ($current_tab === 'artifacts') ? 'border-gold text-gold font-bold shadow-ink-sm bg-paper-panel' : 'border-paper-line hover:border-parchment-dark text-parchment-dim hover:text-parchment bg-paper-panel'; ?> transition">
      ARTIFACTS
    </a>
    <a href="<?php echo base_url('entries?type=events'); ?>" class="px-3 py-1.5 border-2 <?php echo ($current_tab === 'events' || $current_tab === 'chronicle' || $current_tab === 'timeline') ? 'border-gold text-gold font-bold shadow-ink-sm bg-paper-panel' : 'border-paper-line hover:border-parchment-dark text-parchment-dim hover:text-parchment bg-paper-panel'; ?> transition">
      ANNALS
    </a>
    <a href="<?php echo base_url('entries?type=concepts'); ?>" class="px-3 py-1.5 border-2 <?php echo ($current_tab === 'concepts') ? 'border-gold text-gold font-bold shadow-ink-sm bg-paper-panel' : 'border-paper-line hover:border-parchment-dark text-parchment-dim hover:text-parchment bg-paper-panel'; ?> transition">
      ARCANA
    </a>

    <!-- Secondary Volumes Dropdown -->
    <div class="relative group">
      <button type="button" class="px-3 py-1.5 border-2 <?php echo in_array($current_tab, array('orders', 'species', 'bestiary', 'locations', 'magic')) ? 'border-gold text-gold font-bold bg-paper-panel' : 'border-paper-line hover:border-gold text-parchment-dim hover:text-gold bg-paper-panel'; ?> flex items-center gap-1.5 transition">
        MORE VOLUMES <span class="text-[9px] text-gold">▼</span>
      </button>
      <div class="absolute left-0 top-full mt-1 w-60 bg-paper-ink border-2 border-paper-line shadow-ink-lg hidden group-hover:block z-50 py-1 text-left">
        <a href="<?php echo base_url('entries?type=orders'); ?>" class="block px-3 py-2 text-[11px] font-mono text-parchment-dim hover:text-gold hover:bg-paper-panel/80 border-b border-paper-line/50 transition">
          <span class="text-copper font-bold block text-[9px]">VOL. VI // SYNOD</span>
          ORDERS &amp; GUILDS
        </a>
        <a href="<?php echo base_url('entries?type=species'); ?>" class="block px-3 py-2 text-[11px] font-mono text-parchment-dim hover:text-gold hover:bg-paper-panel/80 border-b border-paper-line/50 transition">
          <span class="text-copper font-bold block text-[9px]">VOL. VII // BESTIARIUM</span>
          PRIMAL BEASTS &amp; SPECIES
        </a>
        <a href="<?php echo base_url('entries?type=locations'); ?>" class="block px-3 py-2 text-[11px] font-mono text-parchment-dim hover:text-gold hover:bg-paper-panel/80 border-b border-paper-line/50 transition">
          <span class="text-copper font-bold block text-[9px]">VOL. VIII // TABULA</span>
          LANDMARKS, SITES &amp; RUINS
        </a>
        <a href="<?php echo base_url('entries?type=magic'); ?>" class="block px-3 py-2 text-[11px] font-mono text-parchment-dim hover:text-gold hover:bg-paper-panel/80 transition">
          <span class="text-copper font-bold block text-[9px]">VOL. IX // ARS OCCULTA</span>
          CODEX OF ARCANE ARTS
        </a>
      </div>
    </div>

    <a href="<?php echo base_url('entries/create'); ?>" class="px-3.5 py-1.5 border-2 <?php echo ($current_tab === 'create') ? 'border-gold text-paper-ink bg-gold font-bold shadow-ink-sm' : 'border-gold/70 text-gold-light hover:border-gold hover:text-white bg-paper-deep shadow-ink-sm'; ?> transition flex items-center gap-1.5">
      <span class="font-bold">＋</span> INSCRIBE ENTRY
    </a>
  </nav>

  <?php if (empty($hide_header_banner)): ?>
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
  <?php endif; ?>
</header>
