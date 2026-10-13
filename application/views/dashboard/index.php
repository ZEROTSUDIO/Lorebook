<!-- WORKSPACE 3-COLUMN / GRID LAYOUT -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

  <!-- LEFT COLUMN: CHARACTER DOSSIER & ARCANE ATTRIBUTES (4 COLS) -->
  <aside class="lg:col-span-4 flex flex-col gap-6">

    <!-- 1. MAIN CHARACTER SHEET CARD -->
    <section class="bg-paper-panel border-2 border-paper-line shadow-ink relative overflow-hidden">
      
      <!-- ZEROSTUDIOS FLUSH TITLE BAR -->
      <div class="bg-paper-ink border-b-2 border-paper-line px-4 py-2.5 flex items-center justify-between text-xs font-mono">
        <div class="flex items-center gap-2">
          <span class="w-2 h-2 bg-gold rotate-45"></span>
          <span class="text-gold tracking-widest font-bold">DOSSIER // CAN-014</span>
        </div>
        <span class="text-ash text-[10px]">FEATURED RECORD</span>
      </div>

      <div class="p-5 flex flex-col gap-5">
        
        <!-- PORTRAIT CONTAINER (Architectural Corner Marks + Gold Frame) -->
        <div class="relative bg-paper-base border-2 border-paper-line p-2 shadow-ink-sm corner-brackets">
          <div class="h-64 sm:h-72 bg-paper-deep flex flex-col items-center justify-end pb-4 border border-dashed border-paper-line relative overflow-hidden">
            
            <!-- Background Heraldic Watermark Rune -->
            <svg class="absolute inset-0 m-auto w-40 h-40 opacity-10 text-gold" viewBox="0 0 100 100" fill="currentColor">
              <polygon points="50,5 90,25 90,75 50,95 10,75 10,25" fill="none" stroke="currentColor" stroke-width="2"/>
              <circle cx="50" cy="50" r="28" fill="none" stroke="currentColor" stroke-width="1.5"/>
              <line x1="50" y1="5" x2="50" y2="95" stroke="currentColor" stroke-width="1"/>
              <line x1="10" y1="50" x2="90" y2="50" stroke="currentColor" stroke-width="1"/>
            </svg>

            <!-- Corner Crosshairs -->
            <span class="absolute top-2 left-2 text-[11px] font-mono text-gold/60">+</span>
            <span class="absolute top-2 right-2 text-[11px] font-mono text-gold/60">+</span>
            <span class="absolute bottom-2 left-2 text-[11px] font-mono text-gold/60">+</span>
            <span class="absolute bottom-2 right-2 text-[11px] font-mono text-gold/60">+</span>
            
            <span class="font-display italic text-lg text-copper mb-1">[Illuminated Portrait]</span>
            <span class="font-mono text-[10px] text-ash tracking-widest uppercase">PLATE: ILSABET_VOSS_PORTRAIT.WEBP</span>
          </div>
        </div>

        <!-- NAME & TITLES -->
        <div class="text-center">
          <div class="font-mono text-[11px] uppercase tracking-widest text-copper mb-1">NORTHMEN CLAN COHORT</div>
          <h2 class="font-display font-bold text-3xl sm:text-4xl tracking-wider uppercase text-gold leading-tight">
            Ilsabet Voss
          </h2>
          <div class="font-prose italic text-parchment-dim text-lg">“The Lamplighter of Canaan”</div>
        </div>

        <!-- INK STAMPS & REALM STATUS BADGES -->
        <div class="flex flex-wrap justify-center items-center gap-2.5 py-1">
          <span class="font-mono font-bold text-xs uppercase tracking-widest text-gold border-2 border-gold px-3 py-0.5 -rotate-2 shadow-ink-sm bg-paper-base">
            CANON VERIFIED
          </span>
          <span class="font-mono font-bold text-xs uppercase tracking-widest text-copper border-2 border-copper px-3 py-0.5 rotate-2 shadow-ink-sm bg-paper-base">
            RESTRICTED
          </span>
          <!-- Wax Seal Badge -->
          <span class="wax-seal text-parchment font-cinzel text-[11px] font-bold px-3 py-0.5 rounded-sm tracking-wider uppercase flex items-center gap-1.5">
            <span>✦</span> SEAL OF HIGH KEEP
          </span>
        </div>

        <!-- STRUCTURED LORE ATTRIBUTES TABLE -->
        <div class="border-t-2 border-paper-line pt-3 font-mono text-xs divide-y divide-paper-line">
          <div class="flex justify-between py-2">
            <span class="text-ash uppercase">Origin Seat</span>
            <span class="text-parchment font-bold">Northern Highlands</span>
          </div>
          <div class="flex justify-between py-2">
            <span class="text-ash uppercase">Cohort / Clan</span>
            <span class="text-gold font-bold">Draugar Bloodline</span>
          </div>
          <div class="flex justify-between py-2">
            <span class="text-ash uppercase">Arcane Aspect</span>
            <span class="text-parchment">Pale Flame // Pyromancy</span>
          </div>
          <div class="flex justify-between py-2">
            <span class="text-ash uppercase">Primary Relic</span>
            <span class="text-parchment font-bold">Censer of the North</span>
          </div>
          <div class="flex justify-between py-2">
            <span class="text-ash uppercase">Current Epoch</span>
            <span class="text-ash font-bold">Cycle 842 2A</span>
          </div>
        </div>

        <!-- ACTION CONTROLS -->
        <div class="grid grid-cols-2 gap-2 pt-2">
          <a href="<?php echo base_url('entries/edit/1'); ?>" class="border-2 border-paper-line hover:border-gold py-2 text-center font-mono text-xs uppercase tracking-wider text-parchment bg-paper-base transition">
            [EDIT RECORD]
          </a>
          <a href="<?php echo base_url('entries/view/1'); ?>" class="border-2 border-gold py-2 text-center font-mono text-xs uppercase tracking-wider text-paper-ink font-bold bg-gold hover:bg-gold-light transition shadow-ink-sm">
            [FULL DOSSIER]
          </a>
        </div>

      </div>
    </section>

    <!-- 2. QUICK VAULT TELEMETRY -->
    <div class="bg-paper-panel border-2 border-paper-line p-4 font-mono text-xs flex flex-col gap-3">
      <div class="flex items-center justify-between text-copper border-b border-paper-line pb-2 font-bold tracking-wider uppercase">
        <span>ARCHIVE TELEMETRY</span>
        <span>[LIVE]</span>
      </div>
      <div class="flex justify-between text-parchment-dim">
        <span>Active World</span>
        <span class="text-gold font-bold"><?php echo isset($active_world->name) ? html_escape($active_world->name) : 'Canaan'; ?></span>
      </div>
      <div class="flex justify-between text-parchment-dim">
        <span>Total Entities</span>
        <span class="text-parchment font-bold"><?php echo isset($total_entries) ? (int)$total_entries : '142'; ?></span>
      </div>
      <div class="flex justify-between text-parchment-dim">
        <span>Verified Canon</span>
        <span class="text-gold font-bold"><?php echo isset($canon_count) ? (int)$canon_count : '128'; ?></span>
      </div>
      <div class="flex justify-between text-parchment-dim">
        <span>Draft Chronicles</span>
        <span class="text-copper font-bold"><?php echo isset($draft_count) ? (int)$draft_count : '14'; ?></span>
      </div>
    </div>

  </aside>


  <!-- RIGHT COLUMN: LITERARY CHRONICLE & CONNECTED LORE (8 COLS) -->
  <main class="lg:col-span-8 flex flex-col gap-6">

    <!-- 1. CHRONICLE MANUSCRIPT ARTICLE -->
    <article class="bg-paper-panel border-2 border-paper-line shadow-ink overflow-hidden">
      
      <!-- DOSSIER TITLE BAR -->
      <div class="bg-paper-ink border-b-2 border-paper-line px-5 py-3 flex flex-wrap items-center justify-between text-xs font-mono gap-2">
        <div class="flex items-center gap-2">
          <span class="text-gold">✦</span>
          <span class="tracking-widest uppercase font-bold text-parchment">CHRONICLE ENTRY // FOLIO 04</span>
          <span class="text-paper-line">|</span>
          <span class="text-ash">LIBER CHRONICA</span>
        </div>
        <div class="flex items-center gap-2 text-ash text-[11px]">
          <span>RECORDED BY: SCRIBE WENG</span>
          <span class="text-paper-line">|</span>
          <span class="text-copper font-bold">CANONIFIED</span>
        </div>
      </div>

      <div class="p-6 sm:p-8 flex flex-col gap-6">
        
        <!-- ARTICLE HEADER -->
        <div class="border-b-2 border-paper-line pb-6">
          <div class="font-mono text-xs uppercase tracking-widest text-copper mb-1">
            ANCIENT TESTIMONIAL · YEAR OF THE WHITE HARVEST
          </div>
          <h2 class="font-display font-bold text-3xl sm:text-5xl text-gold tracking-wide uppercase leading-tight">
            The Descent through the Iron Pass
          </h2>
          <div class="font-prose italic text-parchment-dim text-lg mt-1">
            Excerpt from the First Great Incursion across the Frost-Veil boundaries.
          </div>
        </div>

        <!-- ARTICLE PROSE WITH DROP CAP -->
        <div class="font-prose text-base sm:text-lg leading-relaxed text-parchment flex flex-col gap-5">
          <p class="first-letter:font-display first-letter:text-6xl first-letter:font-bold first-letter:text-gold first-letter:mr-3 first-letter:float-left first-letter:leading-none">
            Before the third bell of the winter solstice had finished echoing over the crags, the torches of the Draugar cohort appeared upon the crest. Ilsabet stood at the precipice, censer in hand, watching the white frost creep over the iron stones. It was whispered among the high priests of the Keep that no mortal fire could endure the breath of the Northern Pass, yet her lamp burned with an unflickering pale amber flame.
          </p>

          <p>
            The chronicles record little of what passed between the Lamplighter and the Wardens at the Gate. What remains certain is that by daybreak, the ancient wards were rekindled, and the road to the valley of Valoria lay open once more. Those who followed her reported neither slain beasts nor clashing steel—only tracks pressed deep into blackened vellum snow, and the quiet scent of burnt pine resin lingering in the air.
          </p>

          <blockquote class="border-l-4 border-gold pl-5 py-2 my-2 font-display italic text-xl sm:text-2xl text-gold-light bg-paper-base/60">
            “Let no one strike a brand upon the mountain who is not prepared to answer for the shadows it creates.”
            <footer class="font-mono text-xs not-italic text-ash mt-1 tracking-wider uppercase">— Recorded by Brother Eric, Archive of Canaan</footer>
          </blockquote>

          <p>
            Scholars continue to dispute whether her covenant was formed with the High Council or with older powers slumbering beneath the ice. Regardless of origin, her seat in the council remained unchallenged until the waning of the second moon.
          </p>
        </div>

        <!-- ARTICLE METADATA FOOTER -->
        <div class="border-t-2 border-paper-line pt-4 flex flex-wrap items-center justify-between font-mono text-xs text-ash gap-3">
          <div class="flex items-center gap-2">
            <span class="text-gold font-bold">TAGS:</span>
            <span class="border border-paper-line px-2 py-0.5 bg-paper-base text-parchment">#NORTHMEN</span>
            <span class="border border-paper-line px-2 py-0.5 bg-paper-base text-parchment">#DRAUGAR</span>
            <span class="border border-paper-line px-2 py-0.5 bg-paper-base text-parchment">#THE-IRON-PASS</span>
          </div>
          <div class="text-[11px] text-parchment-dim">
            WORD COUNT: <strong class="text-parchment">482 WORDS</strong>
          </div>
        </div>

      </div>
    </article>

    <!-- 2. KINSHIP TREE & CONNECTED LORE STRIP -->
    <section class="bg-paper-panel border-2 border-paper-line p-5 shadow-ink flex flex-col gap-4">
      <div class="flex items-center justify-between border-b border-paper-line pb-3">
        <div class="flex items-center gap-2 font-mono text-xs tracking-wider uppercase font-bold text-copper">
          <span class="w-2 h-2 bg-copper rotate-45"></span>
          <span>DIRECTED KINSHIP &amp; RELATIONSHIPS</span>
        </div>
        <a href="<?php echo base_url('relationships'); ?>" class="font-mono text-[11px] text-gold hover:underline uppercase">
          [VIEW ALL CONNECTIONS &rarr;]
        </a>
      </div>

      <!-- KINSHIP CARDS -->
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        
        <div class="border-2 border-paper-line bg-paper-base p-3.5 flex flex-col gap-1 shadow-ink-sm hover:border-gold transition">
          <div class="font-mono text-[10px] tracking-widest text-copper uppercase flex items-center justify-between">
            <span>COHORT ALLY</span>
            <span class="text-gold">✦</span>
          </div>
          <div class="font-display font-bold text-lg text-parchment">Kaelen Ward</div>
          <div class="font-mono text-[10px] text-ash">First Scout · Border Watch</div>
        </div>

        <div class="border-2 border-paper-line bg-paper-base p-3.5 flex flex-col gap-1 shadow-ink-sm hover:border-copper transition">
          <div class="font-mono text-[10px] tracking-widest text-ash uppercase flex items-center justify-between">
            <span>RIVALRY</span>
            <span class="text-copper">⚔</span>
          </div>
          <div class="font-display font-bold text-lg text-parchment">High Inquisitor Vane</div>
          <div class="font-mono text-[10px] text-ash">Order of the Silver Hand</div>
        </div>

        <div class="border-2 border-paper-line bg-paper-base p-3.5 flex flex-col gap-1 shadow-ink-sm hover:border-gold transition">
          <div class="font-mono text-[10px] tracking-widest text-gold uppercase flex items-center justify-between">
            <span>SEAT OF POWER</span>
            <span class="text-gold">⌂</span>
          </div>
          <div class="font-display font-bold text-lg text-parchment">The Frost Keep</div>
          <div class="font-mono text-[10px] text-ash">Northern Highlands Sanctuary</div>
        </div>

      </div>
    </section>

    <!-- 3. RECENTLY INSCRIBED CODEX RECORDS (LIVE FROM MYSQL) -->
    <?php if (!empty($recent_entries)): ?>
      <section class="bg-paper-panel border-2 border-paper-line shadow-ink overflow-hidden">
        <div class="bg-paper-ink border-b-2 border-paper-line px-5 py-2.5 flex items-center justify-between text-xs font-mono">
          <div class="flex items-center gap-2">
            <span class="w-2 h-2 bg-gold rotate-45"></span>
            <span class="text-gold tracking-widest font-bold uppercase">RECENTLY INSCRIBED RECORDS</span>
          </div>
          <a href="<?php echo base_url('entries'); ?>" class="text-parchment-dim hover:text-gold text-[11px] uppercase transition">
            [BROWSE FULL ENCYCLOPEDIA &rarr;]
          </a>
        </div>

        <div class="divide-y divide-paper-line font-mono text-xs">
          <?php foreach ($recent_entries as $rec): ?>
            <div class="px-5 py-3.5 hover:bg-paper-base/70 transition flex flex-wrap items-center justify-between gap-3">
              <div class="flex items-center gap-3">
                <span class="text-ash text-[11px]">#<?php echo str_pad($rec->id, 3, '0', STR_PAD_LEFT); ?></span>
                <div>
                  <a href="<?php echo base_url('entries/view/' . $rec->id); ?>" class="font-display font-bold text-xl text-gold hover:text-gold-light tracking-wide uppercase">
                    <?php echo html_escape($rec->title); ?>
                  </a>
                  <span class="ml-2 text-[10px] text-copper uppercase tracking-wider">[<?php echo html_escape($rec->type_name); ?>]</span>
                </div>
              </div>

              <div class="flex items-center gap-3">
                <?php if ($rec->status === 'canon'): ?>
                  <span class="border border-gold text-gold px-2 py-0.5 text-[10px] font-bold uppercase bg-paper-deep">CANON</span>
                <?php elseif ($rec->status === 'draft'): ?>
                  <span class="border border-copper text-copper px-2 py-0.5 text-[10px] font-bold uppercase bg-paper-deep">DRAFT</span>
                <?php else: ?>
                  <span class="border border-ash text-ash px-2 py-0.5 text-[10px] font-bold uppercase bg-paper-deep">ARCHIVED</span>
                <?php endif; ?>
                <a href="<?php echo base_url('entries/view/' . $rec->id); ?>" class="border border-paper-line hover:border-gold px-2.5 py-1 bg-paper-base text-parchment text-[10px] uppercase transition">
                  OPEN &rarr;
                </a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endif; ?>

  </main>

</div>
