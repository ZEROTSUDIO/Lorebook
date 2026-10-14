<!-- FLASH MESSAGE NOTIFICATION -->
<?php if ($this->session->flashdata('success_msg')): ?>
  <div class="mb-6 p-4 border-2 border-gold bg-paper-panel font-mono text-xs text-gold shadow-ink flex items-center justify-between">
    <div class="flex items-center gap-3">
      <span class="w-2 h-2 bg-gold rotate-45 inline-block"></span>
      <span class="font-bold tracking-wider uppercase"><?php echo html_escape($this->session->flashdata('success_msg')); ?></span>
    </div>
    <span class="text-ash text-[10px] uppercase">GRAPH UPDATED</span>
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

<div class="flex flex-col gap-8">

  <!-- ===================================================================== -->
  <!-- SECTION 1: NETWORK TELEMETRY & GRAPH METRICS                          -->
  <!-- ===================================================================== -->
  <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    
    <div class="bg-paper-panel border-2 border-paper-line p-4 shadow-ink-sm flex items-center justify-between">
      <div>
        <div class="font-mono text-[10px] text-copper uppercase tracking-wider mb-1">TOTAL BONDS</div>
        <div class="font-display font-bold text-3xl text-gold"><?php echo sprintf('%02d', (int)$total_bonds); ?></div>
        <div class="font-mono text-[9px] text-ash uppercase mt-0.5">DIRECTED TIES INSCRIBED</div>
      </div>
      <div class="w-10 h-10 rounded border border-gold/40 bg-paper-deep flex items-center justify-center text-gold">
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <circle cx="6" cy="6" r="3"/>
          <circle cx="18" cy="18" r="3"/>
          <path d="M8.5 8.5l7 7"/>
          <circle cx="18" cy="6" r="3"/>
          <path d="M15.5 8.5l-7 7"/>
        </svg>
      </div>
    </div>

    <div class="bg-paper-panel border-2 border-paper-line p-4 shadow-ink-sm flex items-center justify-between">
      <div>
        <div class="font-mono text-[10px] text-copper uppercase tracking-wider mb-1">CONNECTED ENTITIES</div>
        <div class="font-display font-bold text-3xl text-parchment"><?php echo sprintf('%02d', (int)$unique_entities); ?></div>
        <div class="font-mono text-[9px] text-ash uppercase mt-0.5">ACTIVE GRAPH NODES</div>
      </div>
      <div class="w-10 h-10 rounded border border-gold/40 bg-paper-deep flex items-center justify-center text-gold">
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <circle cx="12" cy="12" r="9"/>
          <path d="M12 3v18M3 12h18"/>
        </svg>
      </div>
    </div>

    <div class="bg-paper-panel border-2 border-paper-line p-4 shadow-ink-sm flex items-center justify-between sm:col-span-2 lg:col-span-2">
      <div class="w-full">
        <div class="font-mono text-[10px] text-copper uppercase tracking-wider mb-1 flex items-center justify-between">
          <span>TOP NEXUS ENTITIES (HIGHEST DEGREE)</span>
          <span class="text-gold font-bold">NETWORK ANCHORS</span>
        </div>
        <div class="flex flex-wrap items-center gap-1.5 mt-2">
          <?php if (!empty($top_nexuses)): ?>
            <?php foreach ($top_nexuses as $name => $count): ?>
              <span class="px-2.5 py-1 bg-paper-deep border border-paper-line font-mono text-[11px] text-parchment flex items-center gap-1.5 shadow-inner">
                <span class="text-gold font-bold">◆</span> <?php echo html_escape($name); ?>
                <span class="text-ash text-[9px] font-bold px-1 bg-paper-ink border border-paper-line rounded-sm"><?php echo (int)$count; ?></span>
              </span>
            <?php endforeach; ?>
          <?php else: ?>
            <span class="font-mono text-xs text-ash italic">No network hubs established yet.</span>
          <?php endif; ?>
        </div>
      </div>
    </div>

  </section>

  <!-- ===================================================================== -->
  <!-- SECTION 2: SEARCH & PREDICATE FILTER BAR                              -->
  <!-- ===================================================================== -->
  <section class="bg-paper-panel border-2 border-paper-line shadow-ink overflow-hidden">
    
    <div class="bg-paper-ink border-b-2 border-paper-line px-5 py-2.5 flex flex-wrap items-center justify-between gap-2 text-xs font-mono">
      <div class="flex items-center gap-2">
        <span class="w-2 h-2 bg-gold rotate-45"></span>
        <span class="text-gold font-bold tracking-widest uppercase">FILTER &amp; CONSULT GRAPH LEDGER</span>
      </div>
      <button type="button" onclick="document.getElementById('forge-matrix-modal').classList.remove('hidden')" class="px-3 py-1 bg-gold hover:bg-gold-light text-paper-ink font-bold tracking-widest uppercase transition text-[11px] shadow-ink-sm flex items-center gap-1.5">
        <span>＋</span> FORGE NEW BOND
      </button>
    </div>

    <form action="<?php echo base_url('relationships'); ?>" method="GET" class="p-5 flex flex-col gap-4 font-mono text-xs">
      <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
        
        <div class="sm:col-span-7 flex flex-col gap-1">
          <label for="q" class="text-[10px] text-copper uppercase tracking-wider font-bold">SEARCH ENTITIES OR LORE NOTES</label>
          <input type="text" name="q" id="q" value="<?php echo html_escape($selected_search); ?>" placeholder="Search by source, target, or note text..." class="w-full bg-paper-base border-2 border-paper-line focus:border-gold px-3 py-2 text-parchment outline-none transition placeholder:text-ash/50">
        </div>

        <div class="sm:col-span-5 flex flex-col gap-1">
          <label for="predicate" class="text-[10px] text-ash uppercase tracking-wider">RELATIONSHIP PREDICATE</label>
          <select name="predicate" id="predicate" class="w-full bg-paper-base border-2 border-paper-line focus:border-gold px-3 py-2 text-parchment outline-none transition cursor-pointer">
            <option value="">All Predicates (Every Connection)</option>
            <?php foreach ($predicates as $p): ?>
              <option value="<?php echo html_escape($p); ?>" <?php echo ($selected_predicate === $p) ? 'selected' : ''; ?>>
                <?php echo html_escape(strtoupper($p)); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

      </div>

      <div class="flex items-center justify-between border-t border-paper-line/70 pt-3">
        <div class="flex items-center gap-2 text-[11px]">
          <span class="text-ash uppercase text-[10px]">COMMON FILTERS:</span>
          <a href="<?php echo base_url('relationships'); ?>" class="px-2 py-0.5 border <?php echo empty($selected_predicate) ? 'border-gold text-gold font-bold bg-paper-deep' : 'border-paper-line text-ash hover:text-parchment'; ?> transition">
            ALL
          </a>
          <?php foreach (array_slice($predicates, 0, 4) as $p): ?>
            <a href="<?php echo base_url('relationships?predicate=' . urlencode($p)); ?>" class="px-2 py-0.5 border <?php echo ($selected_predicate === $p) ? 'border-gold text-gold font-bold bg-paper-deep' : 'border-paper-line text-ash hover:text-parchment'; ?> transition uppercase text-[10px]">
              <?php echo html_escape($p); ?>
            </a>
          <?php endforeach; ?>
        </div>

        <button type="submit" class="px-5 py-1.5 bg-paper-deep border-2 border-gold text-gold hover:bg-gold hover:text-paper-ink font-bold uppercase tracking-wider transition text-[11px] shadow-ink-sm">
          QUERY GRAPH ➔
        </button>
      </div>
    </form>
  </section>

  <!-- ===================================================================== -->
  <!-- SECTION 3: DIRECTED RELATIONSHIPS MATRIX LEDGER                       -->
  <!-- ===================================================================== -->
  <section class="flex flex-col gap-4">
    
    <div class="flex items-center justify-between border-b-2 border-paper-line pb-2 font-mono text-xs">
      <span class="text-copper uppercase tracking-widest font-bold">
        DISCOVERED BONDS (<?php echo count($relationships); ?> RECORDED)
      </span>
      <span class="text-ash text-[10px]">SEAT OF RECORD: <?php echo strtoupper(html_escape($active_world->name)); ?></span>
    </div>

    <?php if (empty($relationships)): ?>
      <div class="bg-paper-panel border-2 border-dashed border-paper-line p-12 text-center flex flex-col items-center justify-center">
        <div class="text-3xl text-gold mb-2">❖</div>
        <h3 class="font-display font-bold text-2xl text-parchment uppercase tracking-wider mb-2">No Bonds Discovered</h3>
        <p class="font-prose italic text-sm text-parchment-dim max-w-md mb-5">
          No relationship records matched your current query criteria. Try adjusting your search filters or forge a new connection.
        </p>
        <button type="button" onclick="document.getElementById('forge-matrix-modal').classList.remove('hidden')" class="px-6 py-2 border-2 border-gold bg-gold hover:bg-gold-light text-paper-ink font-mono font-bold text-xs uppercase tracking-wider shadow-ink-sm transition">
          [＋ FORGE NEW BOND]
        </button>
      </div>
    <?php else: ?>
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <?php foreach ($relationships as $rel): ?>
          <div class="bg-paper-panel border-2 border-paper-line hover:border-gold p-4 shadow-ink-sm flex flex-col justify-between transition group">
            
            <div>
              <!-- Header Top Bar -->
              <div class="flex items-center justify-between border-b border-paper-line/70 pb-2 mb-3 font-mono text-[10px]">
                <span class="text-ash">BOND #<?php echo sprintf('%03d', (int)$rel->id); ?></span>
                <span class="text-copper tracking-wider uppercase font-bold">
                  <?php echo date('Y-m-d', strtotime($rel->created_at)); ?>
                </span>
              </div>

              <!-- Directed Connection Bridge -->
              <div class="grid grid-cols-11 gap-2 items-center text-center my-2">
                
                <!-- Source Node (5 cols) -->
                <div class="col-span-5 bg-paper-base border border-paper-line p-3 text-left">
                  <div class="font-mono text-[9px] text-copper uppercase tracking-wider truncate mb-1">
                    <?php echo html_escape($rel->source_type_name); ?>
                  </div>
                  <a href="<?php echo base_url('entries/view/' . $rel->source_entry_id); ?>" class="font-display font-bold text-base uppercase tracking-wide text-parchment hover:text-gold transition block truncate">
                    <?php echo html_escape($rel->source_title); ?>
                  </a>
                  <span class="font-mono text-[9px] text-ash">SOURCE NODE</span>
                </div>

                <!-- Directed Arrow Centerpiece (1 col) -->
                <div class="col-span-1 flex flex-col items-center justify-center font-mono">
                  <span class="text-gold text-lg font-bold group-hover:translate-x-1 transition leading-none">➔</span>
                </div>

                <!-- Target Node (5 cols) -->
                <div class="col-span-5 bg-paper-base border border-paper-line p-3 text-right">
                  <div class="font-mono text-[9px] text-copper uppercase tracking-wider truncate mb-1">
                    <?php echo html_escape($rel->target_type_name); ?>
                  </div>
                  <a href="<?php echo base_url('entries/view/' . $rel->target_entry_id); ?>" class="font-display font-bold text-base uppercase tracking-wide text-parchment hover:text-gold transition block truncate">
                    <?php echo html_escape($rel->target_title); ?>
                  </a>
                  <span class="font-mono text-[9px] text-ash">TARGET NODE</span>
                </div>

              </div>

              <!-- Predicates Banner -->
              <div class="mt-3 p-2.5 bg-paper-deep border border-paper-line flex flex-wrap items-center justify-between gap-2 font-mono text-xs">
                <div class="flex items-center gap-1.5">
                  <span class="text-gold font-bold">FORWARD:</span>
                  <span class="px-2 py-0.5 bg-paper-ink border border-gold/40 text-gold font-bold uppercase tracking-wider text-[11px]">
                    <?php echo html_escape($rel->relationship_type); ?> &rarr;
                  </span>
                </div>
                <div class="flex items-center gap-1.5">
                  <span class="text-ash text-[10px]">INVERSE:</span>
                  <span class="px-2 py-0.5 bg-paper-ink border border-paper-line text-copper uppercase tracking-wider text-[10px]">
                    &larr; <?php echo html_escape($rel->inverse_label); ?>
                  </span>
                </div>
              </div>

              <!-- Lore Context Note -->
              <?php if (!empty($rel->description)): ?>
                <div class="mt-3 p-3 bg-paper-base/60 border-l-2 border-copper font-prose italic text-xs text-parchment-dim leading-relaxed">
                  “<?php echo html_escape($rel->description); ?>”
                </div>
              <?php endif; ?>
            </div>

            <!-- Card Bottom Bar -->
            <div class="border-t border-paper-line/70 pt-2.5 mt-4 flex items-center justify-between font-mono text-[10px]">
              <div class="flex items-center gap-3">
                <a href="<?php echo base_url('entries/view/' . $rel->source_entry_id); ?>" class="text-ash hover:text-gold uppercase tracking-wider">
                  [VIEW <?php echo html_escape($rel->source_title); ?>]
                </a>
                <span class="text-paper-line">•</span>
                <a href="<?php echo base_url('entries/view/' . $rel->target_entry_id); ?>" class="text-ash hover:text-gold uppercase tracking-wider">
                  [VIEW <?php echo html_escape($rel->target_title); ?>]
                </a>
              </div>

              <form action="<?php echo base_url('relationships/delete/' . $rel->id); ?>" method="POST" onsubmit="return confirm('Permanently sever this bond?');">
                <button type="submit" class="text-crimson hover:underline uppercase tracking-wider font-bold text-[9px]">
                  [✕ UNBIND]
                </button>
              </form>
            </div>

          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </section>

</div>

<!-- ===================================================================== -->
<!-- FORGE BOND MODAL                                                      -->
<!-- ===================================================================== -->
<div id="forge-matrix-modal" class="fixed inset-0 bg-paper-ink/80 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
  <div class="bg-paper-panel border-2 border-gold max-w-lg w-full p-6 shadow-ink-lg relative">
    <div class="flex items-center justify-between border-b-2 border-paper-line pb-3 mb-4 font-mono text-xs">
      <span class="text-gold font-bold tracking-widest uppercase flex items-center gap-2">
        <span class="w-2 h-2 bg-gold rotate-45"></span> FORGE DIRECTED RELATIONSHIP
      </span>
      <button type="button" onclick="document.getElementById('forge-matrix-modal').classList.add('hidden')" class="text-ash hover:text-gold text-base leading-none">
        ✕
      </button>
    </div>

    <form action="<?php echo base_url('relationships/store'); ?>" method="POST" class="flex flex-col gap-4 font-mono text-xs">
      
      <!-- Source Entity Select -->
      <div class="flex flex-col gap-1">
        <label for="modal_source_entry_id" class="text-[10px] text-gold uppercase tracking-wider font-bold">SOURCE ORIGIN ENTITY *</label>
        <select name="source_entry_id" id="modal_source_entry_id" required class="w-full bg-paper-base border-2 border-paper-line focus:border-gold px-3 py-2 text-parchment outline-none transition cursor-pointer">
          <option value="">-- Select Source Entity --</option>
          <?php foreach ($all_entries as $e): ?>
            <option value="<?php echo $e->id; ?>">
              <?php echo html_escape($e->title); ?> (<?php echo html_escape($e->type_name); ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Target Entity Select -->
      <div class="flex flex-col gap-1">
        <label for="modal_target_entry_id" class="text-[10px] text-copper uppercase tracking-wider font-bold">TARGET DESTINATION ENTITY *</label>
        <select name="target_entry_id" id="modal_target_entry_id" required class="w-full bg-paper-base border-2 border-paper-line focus:border-gold px-3 py-2 text-parchment outline-none transition cursor-pointer">
          <option value="">-- Select Target Entity --</option>
          <?php foreach ($all_entries as $e): ?>
            <option value="<?php echo $e->id; ?>">
              <?php echo html_escape($e->title); ?> (<?php echo html_escape($e->type_name); ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Predicate Preset Selector -->
      <div class="flex flex-col gap-1">
        <label for="modal_preset_selector" class="text-[10px] text-ash uppercase tracking-wider">PRESET TEMPLATES</label>
        <select id="modal_preset_selector" onchange="applyModalPreset(this.value)" class="w-full bg-paper-base border border-paper-line focus:border-gold px-2.5 py-1.5 text-parchment-dim outline-none transition cursor-pointer text-[11px]">
          <option value="">-- Choose Common Preset --</option>
          <option value="bearer of|wielded by">Bearer / Wielder (bearer of &harr; wielded by)</option>
          <option value="sworn ally of|sworn ally of">Alliance (sworn ally of &harr; sworn ally of)</option>
          <option value="sworn warden of|protected by">Guardian (sworn warden of &harr; protected by)</option>
          <option value="sworn scout of|scouted by">Scout (sworn scout of &harr; scouted by)</option>
          <option value="sworn comrade of|sworn comrade of">Comrade (sworn comrade of &harr; sworn comrade of)</option>
          <option value="sworn member of|has member">Membership (sworn member of &harr; has member)</option>
          <option value="rules / commands|ruled by">Sovereignty (rules / commands &harr; ruled by)</option>
          <option value="opposed to|ideological rival of">Rivalry (opposed to &harr; ideological rival of)</option>
          <option value="nemesis of|nemesis of">Nemesis (nemesis of &harr; nemesis of)</option>
          <option value="located in|seat of power for">Geography (located in &harr; seat of power for)</option>
          <option value="forged / created|crafted by">Creation (forged / created &harr; crafted by)</option>
          <option value="staging ground of|staged from">Event Staging (staging ground of &harr; staged from)</option>
        </select>
      </div>

      <!-- Forward & Inverse Predicates -->
      <div class="grid grid-cols-2 gap-3">
        <div class="flex flex-col gap-1">
          <label for="modal_relationship_type" class="text-[10px] text-gold uppercase tracking-wider font-bold">FORWARD PREDICATE *</label>
          <input type="text" name="relationship_type" id="modal_relationship_type" required placeholder="e.g. bearer of" class="w-full bg-paper-base border-2 border-paper-line focus:border-gold px-3 py-1.5 text-parchment outline-none transition text-xs">
        </div>

        <div class="flex flex-col gap-1">
          <label for="modal_inverse_label" class="text-[10px] text-ash uppercase tracking-wider">INVERSE LABEL</label>
          <input type="text" name="inverse_label" id="modal_inverse_label" placeholder="e.g. wielded by" class="w-full bg-paper-base border border-paper-line focus:border-gold px-3 py-1.5 text-parchment outline-none transition text-xs">
        </div>
      </div>

      <!-- Description / Context Note -->
      <div class="flex flex-col gap-1">
        <label for="modal_description" class="text-[10px] text-ash uppercase tracking-wider">LORE CONTEXT NOTE [OPTIONAL]</label>
        <textarea name="description" id="modal_description" rows="2" placeholder="e.g. Sanctified during the Solstice Crossing of 842 2A..." class="w-full bg-paper-base border border-paper-line focus:border-gold px-3 py-1.5 text-parchment outline-none transition text-xs resize-none"></textarea>
      </div>

      <!-- Actions -->
      <div class="flex items-center justify-end gap-2 border-t border-paper-line pt-3 mt-1">
        <button type="button" onclick="document.getElementById('forge-matrix-modal').classList.add('hidden')" class="px-4 py-2 border border-paper-line text-ash hover:text-parchment transition uppercase text-[11px]">
          CANCEL
        </button>
        <button type="submit" class="px-5 py-2 border-2 border-gold bg-gold hover:bg-gold-light text-paper-ink font-bold transition uppercase tracking-wider text-xs shadow-ink-sm">
          FORGE BOND ➔
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function applyModalPreset(val) {
    if (!val) return;
    const parts = val.split('|');
    if (parts.length === 2) {
      document.getElementById('modal_relationship_type').value = parts[0];
      document.getElementById('modal_inverse_label').value = parts[1];
    }
  }
</script>
