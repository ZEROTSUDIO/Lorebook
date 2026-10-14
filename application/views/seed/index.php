<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="flex flex-col gap-8">

  <!-- FLASH ALERTS -->
  <?php if ($this->session->flashdata('success_msg')): ?>
    <div class="border-2 border-gold bg-paper-deep p-4 shadow-ink flex items-center justify-between">
      <div class="flex items-center gap-3">
        <span class="w-3 h-3 bg-gold rotate-45 flex-shrink-0"></span>
        <span class="font-mono text-xs text-parchment uppercase tracking-wider">
          <?php echo html_escape($this->session->flashdata('success_msg')); ?>
        </span>
      </div>
      <a href="<?php echo base_url('dashboard'); ?>" class="font-mono text-xs text-gold hover:underline font-bold tracking-widest uppercase">
        VIEW ATLAS →
      </a>
    </div>
  <?php endif; ?>

  <?php if ($this->session->flashdata('error_msg')): ?>
    <div class="border-2 border-wax bg-paper-deep p-4 shadow-ink flex items-center gap-3">
      <span class="w-3 h-3 bg-wax rotate-45 flex-shrink-0"></span>
      <span class="font-mono text-xs text-wax-light uppercase tracking-wider">
        <?php echo html_escape($this->session->flashdata('error_msg')); ?>
      </span>
    </div>
  <?php endif; ?>

  <!-- VAULT INTRO & ARCHIVAL DOSSIER STRIP -->
  <div class="border-2 border-paper-line bg-paper-panel p-6 shadow-ink relative overflow-hidden">
    <div class="absolute -right-6 -bottom-6 w-32 h-32 border-2 border-paper-line/30 rotate-12 pointer-events-none"></div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <div class="flex items-center gap-2 font-mono text-[10px] text-copper uppercase tracking-[0.25em] mb-1">
          <span class="w-1.5 h-1.5 bg-copper rotate-45"></span>
          <span>SYSTEM // REPOSITORY OF SEED TEMPLATES</span>
        </div>
        <h2 class="font-display font-bold text-2xl sm:text-3xl uppercase tracking-wider text-parchment">
          Data Seeder Folio &amp; World Archetypes
        </h2>
        <p class="font-newsreader text-sm sm:text-base text-parchment-dim mt-1 max-w-2xl">
          Instantly populate your universe with interconnected characters, realms, relics, directed bonds, and signed-year timeline records across the 9 canonical archetypes.
        </p>
      </div>

      <div class="flex items-center gap-3 flex-shrink-0">
        <a href="<?php echo base_url('application/seeds/World_seeder_template.php'); ?>" target="_blank" class="px-3.5 py-2 border-2 border-paper-line bg-paper-base hover:border-gold text-parchment-dim hover:text-gold font-mono text-xs uppercase tracking-wider transition shadow-ink-sm flex items-center gap-2">
          <span>❖</span> BLUEPRINT SCHEMA
        </a>
      </div>
    </div>
  </div>

  <!-- SEEDER TEMPLATES GRID -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <?php foreach ($templates as $tpl): ?>
      <div class="border-2 border-paper-line bg-paper-panel shadow-ink flex flex-col justify-between overflow-hidden group hover:border-gold transition">
        
        <!-- CARD DOSSIER TITLE BAR -->
        <div>
          <div class="border-b-2 border-paper-line bg-paper-ink px-4 py-2 flex items-center justify-between">
            <div class="flex items-center gap-2">
              <span class="w-2 h-2 bg-gold rotate-45"></span>
              <span class="font-mono text-[11px] font-bold uppercase tracking-wider text-parchment">
                SEEDER // <?php echo html_escape(strtoupper($tpl['key'])); ?>
              </span>
            </div>
            <div class="flex items-center gap-2">
              <span class="font-mono text-[9px] uppercase px-2 py-0.5 border border-copper text-copper font-bold">
                <?php echo html_escape($tpl['category']); ?>
              </span>
            </div>
          </div>

          <!-- CARD BODY -->
          <div class="p-5 flex flex-col gap-4">
            <div>
              <div class="flex items-center justify-between gap-2 mb-1">
                <h3 class="font-display font-bold text-xl uppercase tracking-wide text-gold group-hover:text-gold-light transition">
                  <?php echo html_escape($tpl['name']); ?>
                </h3>
                <span class="font-mono text-[10px] text-ash">
                  [<?php echo html_escape($tpl['file_name']); ?>]
                </span>
              </div>
              <p class="font-newsreader text-xs sm:text-sm text-parchment-dim leading-relaxed">
                <?php echo html_escape($tpl['description']); ?>
              </p>
            </div>

            <!-- 9-ARCHETYPE COVERAGE PILLS -->
            <?php if (!empty($tpl['archetype_counts'])): ?>
              <div>
                <div class="font-mono text-[9px] uppercase tracking-wider text-copper mb-1.5">
                  ARCHETYPE BREAKDOWN
                </div>
                <div class="flex flex-wrap gap-1.5">
                  <?php foreach ($tpl['archetype_counts'] as $arc => $cnt): ?>
                    <span class="font-mono text-[10px] px-2 py-0.5 border border-paper-line bg-paper-base text-parchment-dim flex items-center gap-1">
                      <span class="w-1 h-1 bg-gold rounded-full"></span>
                      <span class="uppercase"><?php echo html_escape($arc); ?>:</span>
                      <strong class="text-gold"><?php echo (int)$cnt; ?></strong>
                    </span>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endif; ?>

            <!-- STATS STRIP -->
            <div class="grid grid-cols-3 gap-2 border-2 border-paper-line bg-paper-base p-3 text-center">
              <div>
                <div class="font-mono text-[9px] uppercase text-ash tracking-wider">ENTRIES</div>
                <div class="font-mono font-bold text-lg text-parchment"><?php echo (int)$tpl['entry_count']; ?></div>
              </div>
              <div class="border-x border-paper-line">
                <div class="font-mono text-[9px] uppercase text-ash tracking-wider">BONDS</div>
                <div class="font-mono font-bold text-lg text-copper"><?php echo (int)$tpl['relation_count']; ?></div>
              </div>
              <div>
                <div class="font-mono text-[9px] uppercase text-ash tracking-wider">TIMELINE</div>
                <div class="font-mono font-bold text-lg text-gold"><?php echo (int)$tpl['timeline_count']; ?></div>
              </div>
            </div>

            <!-- TARGET REALM STATUS -->
            <div class="flex items-center justify-between text-[11px] font-mono border-t border-paper-line pt-3">
              <span class="text-ash uppercase">TARGET REALM:</span>
              <?php if ($tpl['target_exists']): ?>
                <span class="text-gold font-bold flex items-center gap-1.5">
                  <span class="w-1.5 h-1.5 bg-gold rounded-full"></span>
                  <?php echo strtoupper(html_escape($tpl['target_slug'])); ?> (EXISTS)
                </span>
              <?php else: ?>
                <span class="text-copper font-bold flex items-center gap-1.5">
                  <span class="w-1.5 h-1.5 bg-copper rotate-45"></span>
                  <?php echo strtoupper(html_escape($tpl['target_slug'])); ?> (WILL GENESIS)
                </span>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- ACTION FOOTER -->
        <div class="p-4 border-t-2 border-paper-line bg-paper-base flex items-center justify-between gap-3">
          <div class="text-[10px] font-mono text-parchment-dim">
            IDEMPOTENT · SAFE RE-RUN
          </div>
          <a 
            href="<?php echo base_url('seed/run/' . $tpl['key']); ?>" 
            onclick="return confirm('Inscribe data seeder \'<?php echo addslashes($tpl['name']); ?>\' into realm \'<?php echo addslashes($tpl['target_slug']); ?>\'? Existing entries will be updated without duplicates.');"
            class="px-4 py-2 border-2 border-gold bg-gold hover:bg-gold-light text-paper-ink font-mono text-xs uppercase font-bold tracking-wider transition shadow-ink-sm flex items-center gap-2"
          >
            <span>⚡</span> RUN SEEDER
          </a>
        </div>

      </div>
    <?php endforeach; ?>
  </div>

  <!-- HOW TO WRITE A SEEDER DOSSIER -->
  <div class="border-2 border-paper-line bg-paper-panel p-6 shadow-ink">
    <div class="border-b border-paper-line pb-3 mb-4 flex items-center justify-between">
      <div class="flex items-center gap-2">
        <span class="w-2 h-2 bg-copper rotate-45"></span>
        <h3 class="font-mono text-xs uppercase font-bold tracking-widest text-copper">
          HOW TO CRAFT CUSTOM WORLD SEEDERS
        </h3>
      </div>
      <span class="font-mono text-[10px] text-ash">application/seeds/</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 font-newsreader text-xs sm:text-sm text-parchment-dim leading-relaxed">
      <div class="border border-paper-line/60 bg-paper-base p-4">
        <div class="font-mono text-xs font-bold text-gold uppercase tracking-wider mb-2">
          1. DUPLICATE BLUEPRINT
        </div>
        <p>
          Copy <code class="font-mono text-[11px] text-parchment bg-paper-ink px-1 py-0.5 border border-paper-line">World_seeder_template.php</code> and rename it to your world (e.g. <code class="font-mono text-[11px] text-parchment bg-paper-ink px-1 py-0.5 border border-paper-line">Solaria_seeder.php</code>).
        </p>
      </div>

      <div class="border border-paper-line/60 bg-paper-base p-4">
        <div class="font-mono text-xs font-bold text-gold uppercase tracking-wider mb-2">
          2. DEFINE THE 6 LAYERS
        </div>
        <p>
          Fill in <code class="font-mono text-[11px] text-parchment bg-paper-ink px-1 py-0.5 border border-paper-line">get_world_meta()</code>, <code class="font-mono text-[11px] text-parchment bg-paper-ink px-1 py-0.5 border border-paper-line">get_entries()</code> across the 9 archetypes, directed bonds in <code class="font-mono text-[11px] text-parchment bg-paper-ink px-1 py-0.5 border border-paper-line">get_relationships()</code>, and signed-year eras.
        </p>
      </div>

      <div class="border border-paper-line/60 bg-paper-base p-4">
        <div class="font-mono text-xs font-bold text-gold uppercase tracking-wider mb-2">
          3. EXECUTE SAFELY
        </div>
        <p>
          Register the class in <code class="font-mono text-[11px] text-parchment bg-paper-ink px-1 py-0.5 border border-paper-line">Seed.php</code> and click Run Seeder. It will atomically genesis the world, property definitions, and graph connections without duplicates.
        </p>
      </div>
    </div>
  </div>

</div>
