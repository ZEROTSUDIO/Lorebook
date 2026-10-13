<?php
  $current_world_id = isset($active_world->id) ? $active_world->id : 0;
?>

<div class="max-w-4xl mx-auto flex flex-col gap-8">

  <!-- TOP BREADCRUMB / RETURN STRIP -->
  <div class="flex items-center justify-between border-b-2 border-paper-line pb-4 font-mono text-xs">
    <div class="flex items-center gap-2">
      <span class="w-2 h-2 bg-gold rotate-45"></span>
      <a href="<?php echo base_url('dashboard'); ?>" class="text-parchment-dim hover:text-gold uppercase tracking-widest transition">
        &larr; RETURN TO ATLAS
      </a>
      <span class="text-paper-line">/</span>
      <span class="text-gold font-bold uppercase tracking-wider">REALM GENESIS FOLIO</span>
    </div>
    <span class="text-ash uppercase text-[10px]">
      TOTAL REALMS: <?php echo count($all_worlds); ?>
    </span>
  </div>

  <?php if (validation_errors()): ?>
    <div class="p-4 border-2 border-crimson bg-crimson-dark/40 font-mono text-xs text-parchment shadow-ink-sm flex items-start gap-3">
      <span class="text-crimson font-bold text-base">⚠️</span>
      <div>
        <div class="font-bold uppercase tracking-wider text-crimson-seal mb-1">REALM GENESIS VALIDATION ERROR</div>
        <div class="leading-relaxed"><?php echo validation_errors(); ?></div>
      </div>
    </div>
  <?php endif; ?>

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    
    <!-- LEFT COLUMN: NEW REALM CREATION FORM (8 COLS) -->
    <div class="lg:col-span-8 flex flex-col gap-6">
      
      <div class="bg-paper-panel border-2 border-paper-line shadow-ink overflow-hidden">
        
        <div class="bg-paper-ink border-b-2 border-paper-line px-5 py-3 flex items-center justify-between text-xs font-mono">
          <div class="flex items-center gap-2">
            <span class="w-2 h-2 bg-gold rotate-45"></span>
            <span class="text-gold font-bold tracking-widest uppercase">INSCRIBE NEW REALM SOVEREIGNTY</span>
          </div>
          <span class="text-ash text-[10px]">GENESIS PROTOCOL</span>
        </div>

        <form action="<?php echo base_url('worlds/create'); ?>" method="POST" class="p-6 flex flex-col gap-6">
          
          <!-- REALM NAME -->
          <div class="flex flex-col gap-1.5 font-mono text-xs">
            <label for="name" class="text-copper uppercase font-bold tracking-wider flex items-center justify-between">
              <span>REALM / WORLD NAME *</span>
              <span class="text-ash text-[10px]">[UNIQUE CODEX DOMAIN]</span>
            </label>
            <input
              type="text"
              name="name"
              id="name"
              required
              value="<?php echo set_value('name'); ?>"
              placeholder="e.g. Aethelgard, Solaria, Valoria..."
              class="bg-paper-base border-2 border-paper-line focus:border-gold px-4 py-3 text-gold font-display font-bold text-2xl uppercase tracking-wider outline-none transition placeholder:text-ash/40"
            >
          </div>

          <!-- LORE DESCRIPTION / EPIGRAPH -->
          <div class="flex flex-col gap-1.5 font-mono text-xs">
            <label for="description" class="text-copper uppercase font-bold tracking-wider flex items-center justify-between">
              <span>FOUNDATIONAL EPIGRAPH / LORE DESCRIPTION</span>
              <span class="text-ash text-[10px]">[DISPLAYS ON FRONTISPIECE]</span>
            </label>
            <textarea
              name="description"
              id="description"
              rows="4"
              class="bg-paper-base border-2 border-paper-line focus:border-gold p-3.5 text-parchment font-prose text-base leading-relaxed outline-none transition placeholder:text-ash/40"
              placeholder="A brief mythic summary of the world's themes, climate, and ancient covenants..."
            ><?php echo set_value('description'); ?></textarea>
          </div>

          <!-- VISIBILITY & MEMBERSHIP -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 font-mono text-xs">
            <div class="flex flex-col gap-1">
              <label class="text-ash uppercase">ARCHIVE VISIBILITY</label>
              <select name="visibility" class="bg-paper-base border border-paper-line focus:border-gold px-3 py-2 text-parchment text-xs outline-none">
                <option value="private" selected>Private (Sole Archivist Sanctum)</option>
                <option value="public">Public (Open Imperial Folio)</option>
              </select>
            </div>
            <div class="flex flex-col gap-1">
              <label class="text-ash uppercase">FOUNDING SCRIBE</label>
              <div class="bg-paper-deep border border-paper-line px-3 py-2 text-gold font-bold text-xs flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 bg-gold rotate-45"></span>
                <span><?php echo html_escape(isset($current_user->display_name) ? $current_user->display_name : 'Archivist Zerotsu'); ?></span>
              </div>
            </div>
          </div>

          <!-- PROVISIONING NOTICE -->
          <div class="bg-paper-deep border border-dashed border-gold/40 p-4 font-mono text-[11px] text-parchment-dim flex items-start gap-3">
            <span class="text-gold font-bold text-sm">✦</span>
            <div class="leading-relaxed">
              Upon inscription, this realm will be automatically provisioned with the <strong>5 Canonical Book Tomes</strong> (Persons, Realms, Orders, Bestiary, Chronicle) and its own independent <strong>World Compendium &amp; Atlas</strong> settings.
            </div>
          </div>

          <!-- ACTION BUTTONS -->
          <div class="flex items-center justify-between border-t border-paper-line pt-4">
            <a href="<?php echo base_url('dashboard'); ?>" class="px-4 py-2 border border-paper-line hover:border-parchment text-parchment-dim hover:text-parchment font-mono text-xs uppercase tracking-wider transition">
              CANCEL
            </a>
            <button type="submit" class="px-6 py-2.5 bg-gold hover:bg-gold-light text-paper-ink border-2 border-gold font-mono font-bold text-xs uppercase tracking-widest shadow-ink transition">
              ✦ FORGE &amp; ENTER REALM
            </button>
          </div>

        </form>

      </div>

    </div>

    <!-- RIGHT COLUMN: EXISTING REALMS VAULT (4 COLS) -->
    <aside class="lg:col-span-4 flex flex-col gap-6">
      
      <div class="bg-paper-panel border-2 border-paper-line shadow-ink overflow-hidden">
        
        <div class="bg-paper-ink border-b-2 border-paper-line px-4 py-2.5 flex items-center justify-between text-xs font-mono">
          <div class="flex items-center gap-2">
            <span class="w-2 h-2 bg-copper rotate-45"></span>
            <span class="text-copper font-bold tracking-widest uppercase">EXISTING REALMS</span>
          </div>
          <span class="text-ash text-[10px]"><?php echo count($all_worlds); ?> INSCRIBED</span>
        </div>

        <div class="p-4 flex flex-col gap-3">
          <?php foreach ($all_worlds as $w): ?>
            <?php $is_active = ((int)$w->id === (int)$current_world_id); ?>
            <div class="p-3 border-2 <?php echo $is_active ? 'border-gold bg-paper-base shadow-ink-sm' : 'border-paper-line bg-paper-panel hover:border-parchment-dark'; ?> flex flex-col gap-2 transition">
              <div class="flex items-center justify-between">
                <h4 class="font-display font-bold text-lg <?php echo $is_active ? 'text-gold' : 'text-parchment'; ?> uppercase tracking-wide">
                  <?php echo html_escape($w->name); ?>
                </h4>
                <?php if ($is_active): ?>
                  <span class="font-mono text-[9px] uppercase tracking-wider px-1.5 py-0.5 border border-gold text-gold font-bold">
                    ACTIVE
                  </span>
                <?php else: ?>
                  <a href="<?php echo base_url('worlds/switch_world/' . $w->id); ?>" class="font-mono text-[10px] uppercase tracking-wider text-copper hover:text-gold transition">
                    SWITCH &rarr;
                  </a>
                <?php endif; ?>
              </div>

              <?php if (!empty($w->description)): ?>
                <p class="font-prose text-xs text-parchment-dim line-clamp-2 italic leading-relaxed">
                  “<?php echo html_escape($w->description); ?>”
                </p>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>

      </div>

    </aside>

  </div>

</div>
