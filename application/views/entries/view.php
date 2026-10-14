<!-- FLASH MESSAGE NOTIFICATION -->
<?php if ($this->session->flashdata('success_msg')): ?>
  <div class="mb-6 p-4 border-2 border-gold bg-paper-panel font-mono text-xs text-gold shadow-ink flex items-center justify-between">
    <div class="flex items-center gap-3">
      <span class="w-2 h-2 bg-gold rotate-45 inline-block"></span>
      <span class="font-bold tracking-wider uppercase"><?php echo html_escape($this->session->flashdata('success_msg')); ?></span>
    </div>
    <span class="text-ash text-[10px] uppercase">CODEX UPDATED</span>
  </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error_msg')): ?>
  <div class="mb-6 p-4 border-2 border-crimson bg-crimson-dark/40 font-mono text-xs text-parchment shadow-ink-sm flex items-start gap-3">
    <span class="text-crimson font-bold text-base">⚠️</span>
    <div>
      <div class="font-bold uppercase tracking-wider text-crimson-seal mb-1">OPERATION ERROR</div>
      <div class="leading-relaxed"><?php echo html_escape($this->session->flashdata('error_msg')); ?></div>
    </div>
  </div>
<?php endif; ?>

<!-- ARCHIVED WARNING BANNER -->
<?php if (!empty($entry->is_archived)): ?>
  <div class="mb-6 p-4 border-2 border-copper bg-paper-panel font-mono text-xs text-copper shadow-ink flex flex-wrap items-center justify-between gap-3">
    <div class="flex items-center gap-3">
      <span class="text-base">⚠️</span>
      <div>
        <span class="font-bold tracking-wider uppercase">THIS RECORD IS CURRENTLY ARCHIVED / SEALED</span>
        <div class="text-ash text-[11px] mt-0.5">Sealed on <?php echo html_escape($entry->deleted_at); ?>. It is hidden from the active codex.</div>
      </div>
    </div>
    <a href="<?php echo base_url('entries/restore/' . $entry->id); ?>" class="px-4 py-1.5 border border-gold bg-gold hover:bg-gold-light text-paper-ink font-bold tracking-widest uppercase transition">
      ✦ UNSEAL &amp; RESTORE RECORD
    </a>
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
          <?php elseif ($entry->status === 'apocrypha'): ?>
            <span class="font-mono font-bold text-xs uppercase tracking-widest text-purple-300 border-2 border-purple-400 px-3 py-0.5 shadow-ink-sm bg-paper-base">
              APOCRYPHA
            </span>
          <?php elseif ($entry->status === 'retconned'): ?>
            <span class="font-mono font-bold text-xs uppercase tracking-widest text-ash border-2 border-ash px-3 py-0.5 shadow-ink-sm bg-paper-base">
              RETCONNED
            </span>
          <?php else: ?>
            <span class="font-mono font-bold text-xs uppercase tracking-widest text-ash border-2 border-ash px-3 py-0.5 shadow-ink-sm bg-paper-base">
              RECORD
            </span>
          <?php endif; ?>

          <span class="wax-seal text-parchment font-cinzel text-[11px] font-bold px-3 py-0.5 rounded-sm tracking-wider uppercase flex items-center gap-1.5">
            <span>✦</span> SEAL OF CANAAN
          </span>
        </div>

        <!-- STRUCTURED ATTRIBUTES / DOSSIER TELEMETRY -->
        <?php if (!empty($properties)): ?>
          <div class="border-t-2 border-paper-line pt-3 font-mono text-xs">
            <div class="flex items-center justify-between pb-2 mb-1 border-b border-paper-line/60 text-[10px] uppercase tracking-wider text-copper">
              <span>[DOSSIER ATTRIBUTES]</span>
              <span>TELEMETRY</span>
            </div>
            <div class="divide-y divide-paper-line/60">
              <?php foreach ($properties as $prop): ?>
                <?php if (!empty($prop->value_text)): ?>
                  <div class="flex flex-col sm:flex-row sm:justify-between py-2 gap-1">
                    <span class="text-ash text-[10px] tracking-wider uppercase shrink-0"><?php echo html_escape($prop->label); ?></span>
                    <span class="text-parchment font-bold text-xs sm:text-right"><?php echo html_escape($prop->value_text); ?></span>
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- CONTROLS -->
        <div class="flex flex-col gap-2 pt-2 border-t border-paper-line">
          <div class="grid grid-cols-2 gap-2">
            <a href="<?php echo base_url('entries/edit/' . $entry->id); ?>" class="border-2 border-gold py-2 text-center font-mono text-xs uppercase tracking-wider text-paper-ink font-bold bg-gold hover:bg-gold-light transition shadow-ink-sm">
              [EDIT RECORD]
            </a>
            <a href="<?php echo base_url('entries/create'); ?>" class="border-2 border-paper-line hover:border-gold py-2 text-center font-mono text-xs uppercase tracking-wider text-parchment bg-paper-base transition">
              [＋ NEW ENTRY]
            </a>
          </div>

          <div class="grid grid-cols-2 gap-2">
            <?php if (empty($entry->is_archived)): ?>
              <a href="<?php echo base_url('entries/archive/' . $entry->id); ?>" onclick="return confirm('Seal this record into the archives?');" class="border border-crimson/70 hover:border-crimson py-1.5 text-center font-mono text-[11px] uppercase tracking-wider text-crimson hover:bg-crimson/10 transition">
                [SEAL / ARCHIVE]
              </a>
            <?php else: ?>
              <a href="<?php echo base_url('entries/restore/' . $entry->id); ?>" class="border border-gold hover:border-gold py-1.5 text-center font-mono text-[11px] uppercase tracking-wider text-gold hover:bg-gold/10 transition">
                [UNSEAL RECORD]
              </a>
            <?php endif; ?>
            
            <a href="<?php echo base_url('entries'); ?>" class="border border-paper-line hover:border-parchment-dark py-1.5 text-center font-mono text-[11px] uppercase tracking-wider text-ash hover:text-parchment transition">
              [ALL RECORDS]
            </a>
          </div>
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
        <div class="flex items-center gap-3 text-ash text-[11px]">
          <span class="text-gold font-bold">
            SCRIBE: <?php echo html_escape(!empty($entry->author_name) ? $entry->author_name : (!empty($entry->author_username) ? $entry->author_username : 'Archivist Zerotsu')); ?>
          </span>
          <span class="text-paper-line">|</span>
          <span>RECORDED: <?php echo date('M d, Y', strtotime($entry->created_at)); ?></span>
          <span class="text-paper-line">|</span>
          <span class="text-copper font-bold uppercase"><?php echo html_escape($entry->status); ?></span>
        </div>
      </div>

      <div class="p-6 sm:p-8 flex flex-col gap-6">
        
        <!-- ARTICLE HEADER -->
        <div class="border-b-2 border-paper-line pb-6">
          <div class="font-mono text-xs uppercase tracking-widest text-copper mb-1 flex items-center justify-between">
            <span>RECORD OF CANAAN · PUBLIC ID: <?php echo html_escape($entry->public_id); ?></span>
            <span class="text-ash text-[10px]">INSCRIBED BY <?php echo strtoupper(html_escape(!empty($entry->author_name) ? $entry->author_name : 'ARCHIVIST ZEROTSU')); ?></span>
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

        <!-- ARTICLE PROSE (ILLUMINATED GRIMOIRE ENGINE) -->
        <div class="prose-grimoire">
          <?php echo isset($parsed_content) ? $parsed_content : nl2br(html_escape($entry->content_markdown)); ?>
        </div>

        <!-- ARTICLE FOOTER & METADATA LEDGER -->
        <div class="border-t-2 border-paper-line pt-4 flex flex-col sm:flex-row sm:items-center justify-between font-mono text-xs text-ash gap-3">
          <div class="flex items-center gap-2">
            <span class="text-gold font-bold">TAGS:</span>
            <?php if (!empty($tags)): ?>
              <?php foreach ($tags as $t): ?>
                <a href="<?php echo base_url('entries?tag=' . urlencode($t->slug)); ?>" class="border border-paper-line hover:border-gold px-2 py-0.5 bg-paper-base text-parchment hover:text-gold transition">
                  #<?php echo html_escape($t->name); ?>
                </a>
              <?php endforeach; ?>
            <?php else: ?>
              <span class="text-ash/60 italic text-[11px]">No tags indexed</span>
            <?php endif; ?>
          </div>
          <div class="flex items-center gap-3 text-[11px] text-ash">
            <span>SCRIBE: <strong class="text-parchment"><?php echo html_escape(!empty($entry->author_name) ? $entry->author_name : 'Archivist Zerotsu'); ?></strong></span>
            <?php if (!empty($entry->updater_name) && $entry->updater_name !== $entry->author_name): ?>
              <span>• REVISED BY: <strong class="text-copper"><?php echo html_escape($entry->updater_name); ?></strong></span>
            <?php endif; ?>
            <span>• AMENDED: <?php echo date('Y-m-d H:i', strtotime($entry->updated_at)); ?></span>
          </div>
        </div>

      </div>

    </article>

    <!-- BACKLINKS / REFERENCED IN OTHER CHRONICLES -->
    <?php if (!empty($backlinks)): ?>
      <section class="bg-paper-panel border-2 border-paper-line shadow-ink overflow-hidden">
        <div class="bg-paper-ink border-b-2 border-paper-line px-5 py-2.5 flex items-center justify-between text-xs font-mono">
          <div class="flex items-center gap-2">
            <span class="w-2 h-2 bg-copper rotate-45"></span>
            <span class="text-gold font-bold tracking-widest uppercase">REFERENCED IN OTHER CHRONICLES // BACKLINKS</span>
          </div>
          <span class="text-ash text-[10px]"><?php echo count($backlinks); ?> REFERENCES DETECTED</span>
        </div>

        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-4">
          <?php foreach ($backlinks as $bl): ?>
            <a href="<?php echo base_url('entries/view/' . $bl->id); ?>" class="bg-paper-base border border-paper-line hover:border-gold p-3.5 shadow-ink-sm flex flex-col justify-between group transition">
              <div>
                <div class="flex items-center justify-between font-mono text-[10px] text-copper mb-1">
                  <span class="uppercase tracking-wider"><?php echo html_escape($bl->type_name); ?></span>
                  <span class="text-ash">FOLIO // CAN-<?php echo sprintf('%03d', (int)$bl->id); ?></span>
                </div>
                <h4 class="font-display font-bold text-xl uppercase tracking-wide text-parchment group-hover:text-gold transition">
                  <?php echo html_escape($bl->title); ?>
                </h4>
                <p class="font-prose text-xs text-parchment-dim mt-1.5 leading-relaxed italic line-clamp-2">
                  “<?php echo html_escape($bl->snippet); ?>”
                </p>
              </div>
              <div class="border-t border-paper-line/80 pt-2 mt-3 flex items-center justify-between font-mono text-[10px] text-ash">
                <span class="group-hover:text-gold transition">CONSULT RECORD &rarr;</span>
                <span class="text-gold">✦</span>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endif; ?>

  </main>

</div>
