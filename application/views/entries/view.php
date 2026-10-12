<!-- FLASH MESSAGE NOTIFICATION -->
<?php if ($this->session->flashdata('success_msg')): ?>
  <div class="mb-6 p-4 border-2 border-gold bg-paper-panel font-mono text-xs text-gold shadow-ink flex items-center justify-between">
    <div class="flex items-center gap-3">
      <span class="w-2 h-2 bg-gold rotate-45 inline-block"></span>
      <span class="font-bold tracking-wider uppercase"><?php echo html_escape($this->session->flashdata('success_msg')); ?></span>
    </div>
    <span class="text-ash text-[10px] uppercase">CODEX ARCHIVED</span>
  </div>
<?php endif; ?>

<!-- 2-COLUMN DOSSIER VIEW GRID -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

  <!-- LEFT COLUMN: CHARACTER / ENTITY SHEET (4 COLS) -->
  <aside class="lg:col-span-4 flex flex-col gap-6">

    <section class="bg-paper-panel border-2 border-paper-line shadow-ink overflow-hidden">
      
      <!-- DOSSIER TITLE BAR -->
      <div class="bg-paper-ink border-b-2 border-paper-line px-4 py-2.5 flex items-center justify-between text-xs font-mono">
        <div class="flex items-center gap-2">
          <span class="w-2 h-2 bg-gold rotate-45"></span>
          <span class="text-gold tracking-widest font-bold">DOSSIER // <?php echo html_escape(strtoupper($entry->type_slug)); ?></span>
        </div>
        <span class="text-ash text-[10px]">RECORD #<?php echo (int)$entry->id; ?></span>
      </div>

      <div class="p-5 flex flex-col gap-5">
        
        <!-- PORTRAIT CONTAINER -->
        <div class="relative bg-paper-base border-2 border-paper-line p-2 shadow-ink-sm corner-brackets">
          <div class="h-64 sm:h-72 bg-paper-deep flex flex-col items-center justify-end pb-4 border border-dashed border-paper-line relative overflow-hidden">
            
            <!-- Watermark Rune -->
            <svg class="absolute inset-0 m-auto w-40 h-40 opacity-10 text-gold" viewBox="0 0 100 100" fill="currentColor">
              <polygon points="50,5 90,25 90,75 50,95 10,75 10,25" fill="none" stroke="currentColor" stroke-width="2"/>
              <circle cx="50" cy="50" r="28" fill="none" stroke="currentColor" stroke-width="1.5"/>
              <line x1="50" y1="5" x2="50" y2="95" stroke="currentColor" stroke-width="1"/>
              <line x1="10" y1="50" x2="90" y2="50" stroke="currentColor" stroke-width="1"/>
            </svg>

            <span class="absolute top-2 left-2 text-[11px] font-mono text-gold/60">+</span>
            <span class="absolute top-2 right-2 text-[11px] font-mono text-gold/60">+</span>
            <span class="absolute bottom-2 left-2 text-[11px] font-mono text-gold/60">+</span>
            <span class="absolute bottom-2 right-2 text-[11px] font-mono text-gold/60">+</span>
            
            <span class="font-display italic text-lg text-copper mb-1">[Illuminated Art]</span>
            <span class="font-mono text-[10px] text-ash tracking-widest uppercase">
              <?php echo !empty($entry->cover_image) ? html_escape($entry->cover_image) : 'NO_PORTRAIT_SPECIFIED'; ?>
            </span>
          </div>
        </div>

        <!-- NAME & SUMMARY -->
        <div class="text-center">
          <div class="font-mono text-[11px] uppercase tracking-widest text-copper mb-1"><?php echo html_escape($entry->type_name); ?></div>
          <h2 class="font-display font-bold text-3xl sm:text-4xl tracking-wider uppercase text-gold leading-tight">
            <?php echo html_escape($entry->title); ?>
          </h2>
          <?php if (!empty($entry->summary)): ?>
            <div class="font-prose italic text-parchment-dim text-base mt-1"><?php echo html_escape($entry->summary); ?></div>
          <?php endif; ?>
        </div>

        <!-- INK STAMPS & STATUS BADGES -->
        <div class="flex flex-wrap justify-center items-center gap-2.5 py-1">
          <?php if ($entry->status === 'canon'): ?>
            <span class="font-mono font-bold text-xs uppercase tracking-widest text-gold border-2 border-gold px-3 py-0.5 -rotate-2 shadow-ink-sm bg-paper-base">
              CANON VERIFIED
            </span>
          <?php elseif ($entry->status === 'draft'): ?>
            <span class="font-mono font-bold text-xs uppercase tracking-widest text-copper border-2 border-copper px-3 py-0.5 rotate-2 shadow-ink-sm bg-paper-base">
              DRAFT RECORD
            </span>
          <?php else: ?>
            <span class="font-mono font-bold text-xs uppercase tracking-widest text-ash border-2 border-ash px-3 py-0.5 shadow-ink-sm bg-paper-base">
              ARCHIVED
            </span>
          <?php endif; ?>

          <span class="wax-seal text-parchment font-cinzel text-[11px] font-bold px-3 py-0.5 rounded-sm tracking-wider uppercase flex items-center gap-1.5">
            <span>✦</span> SEAL OF CANAAN
          </span>
        </div>

        <!-- STRUCTURED ATTRIBUTES -->
        <?php if (!empty($properties)): ?>
          <div class="border-t-2 border-paper-line pt-3 font-mono text-xs divide-y divide-paper-line">
            <?php foreach ($properties as $prop): ?>
              <div class="flex justify-between py-2">
                <span class="text-ash uppercase"><?php echo html_escape($prop->label); ?></span>
                <span class="text-parchment font-bold"><?php echo html_escape($prop->value_text); ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <!-- CONTROLS -->
        <div class="grid grid-cols-2 gap-2 pt-2 border-t border-paper-line">
          <a href="<?php echo base_url('entries/create'); ?>" class="border-2 border-paper-line hover:border-gold py-2 text-center font-mono text-xs uppercase tracking-wider text-parchment bg-paper-base transition">
            [＋ NEW ENTRY]
          </a>
          <a href="<?php echo base_url('dashboard'); ?>" class="border-2 border-gold py-2 text-center font-mono text-xs uppercase tracking-wider text-paper-ink font-bold bg-gold hover:bg-gold-light transition shadow-ink-sm">
            [CODEX INDEX]
          </a>
        </div>

      </div>
    </section>

  </aside>


  <!-- RIGHT COLUMN: ARTICLE PROSE (8 COLS) -->
  <main class="lg:col-span-8 flex flex-col gap-6">

    <article class="bg-paper-panel border-2 border-paper-line shadow-ink overflow-hidden">
      
      <!-- DOSSIER TITLE BAR -->
      <div class="bg-paper-ink border-b-2 border-paper-line px-5 py-3 flex flex-wrap items-center justify-between text-xs font-mono gap-2">
        <div class="flex items-center gap-2">
          <span class="text-gold">✦</span>
          <span class="tracking-widest uppercase font-bold text-parchment">CHRONICLE FOLIO // <?php echo html_escape($entry->slug); ?></span>
          <span class="text-paper-line">|</span>
          <span class="text-ash"><?php echo html_escape($entry->type_name); ?></span>
        </div>
        <div class="flex items-center gap-2 text-ash text-[11px]">
          <span>RECORDED: <?php echo date('M d, Y', strtotime($entry->created_at)); ?></span>
          <span class="text-paper-line">|</span>
          <span class="text-copper font-bold uppercase"><?php echo html_escape($entry->status); ?></span>
        </div>
      </div>

      <div class="p-6 sm:p-8 flex flex-col gap-6">
        
        <!-- ARTICLE HEADER -->
        <div class="border-b-2 border-paper-line pb-6">
          <div class="font-mono text-xs uppercase tracking-widest text-copper mb-1">
            RECORD OF CANAAN · PUBLIC ID: <?php echo html_escape($entry->public_id); ?>
          </div>
          <h1 class="font-display font-bold text-3xl sm:text-5xl text-gold tracking-wide uppercase leading-tight">
            <?php echo html_escape($entry->title); ?>
          </h1>
          <?php if (!empty($entry->summary)): ?>
            <div class="font-prose italic text-parchment-dim text-lg mt-1">
              <?php echo html_escape($entry->summary); ?>
            </div>
          <?php endif; ?>
        </div>

        <!-- ARTICLE PROSE (CANONICAL MARKDOWN) -->
        <div class="font-prose text-base sm:text-lg leading-relaxed text-parchment flex flex-col gap-5 whitespace-pre-wrap">
          <?php echo html_escape($entry->content_markdown); ?>
        </div>

        <!-- ARTICLE FOOTER & TAGS -->
        <?php if (!empty($tags)): ?>
          <div class="border-t-2 border-paper-line pt-4 flex flex-wrap items-center justify-between font-mono text-xs text-ash gap-3">
            <div class="flex items-center gap-2">
              <span class="text-gold font-bold">TAGS:</span>
              <?php foreach ($tags as $t): ?>
                <span class="border border-paper-line px-2 py-0.5 bg-paper-base text-parchment">#<?php echo html_escape($t->name); ?></span>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

      </div>

    </article>

  </main>

</div>
