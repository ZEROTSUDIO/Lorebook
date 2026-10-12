<!-- INSCRIBE ENTRY FORM -->
<div class="max-w-6xl mx-auto">
  
  <?php if (validation_errors()): ?>
    <div class="mb-6 p-4 border-2 border-crimson bg-crimson-dark/40 font-mono text-xs text-parchment shadow-ink-sm flex items-start gap-3">
      <span class="text-crimson font-bold text-base">⚠️</span>
      <div>
        <div class="font-bold uppercase tracking-wider text-crimson-seal mb-1">REGISTRY VALIDATION ERROR</div>
        <div class="leading-relaxed"><?php echo validation_errors(); ?></div>
      </div>
    </div>
  <?php endif; ?>

  <form action="<?php echo base_url('entries/store'); ?>" method="POST" class="flex flex-col gap-8">
    
    <!-- 2-COLUMN DOSSIER GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
      
      <!-- LEFT COLUMN: STRUCTURED METADATA & ATTRIBUTES (4 COLS) -->
      <aside class="lg:col-span-4 flex flex-col gap-6">

        <section class="bg-paper-panel border-2 border-paper-line shadow-ink overflow-hidden">
          
          <!-- DOSSIER TITLE BAR -->
          <div class="bg-paper-ink border-b-2 border-paper-line px-4 py-2.5 flex items-center justify-between text-xs font-mono">
            <div class="flex items-center gap-2">
              <span class="w-2 h-2 bg-gold rotate-45"></span>
              <span class="text-gold tracking-widest font-bold">METADATA // SPECIFICATION</span>
            </div>
            <span class="text-ash text-[10px]">RECORD ATTR</span>
          </div>

          <div class="p-5 flex flex-col gap-5">
            
            <!-- 1. ENTRY TYPE SELECTOR -->
            <div class="flex flex-col gap-1.5 font-mono text-xs">
              <label for="entry_type_id" class="text-copper uppercase font-bold tracking-wider flex items-center justify-between">
                <span>ENTRY TYPE *</span>
                <span class="text-ash text-[10px]">[TEMPLATE]</span>
              </label>
              <select name="entry_type_id" id="entry_type_id" onchange="switchEntryTypeProps(this.value)" class="w-full bg-paper-base border-2 border-paper-line focus:border-gold px-3 py-2 text-parchment font-mono text-xs outline-none transition cursor-pointer">
                <?php foreach ($entry_types as $type): ?>
                  <option value="<?php echo $type->id; ?>" <?php echo set_select('entry_type_id', $type->id); ?>>
                    <?php echo html_escape($type->name); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- 2. TITLE -->
            <div class="flex flex-col gap-1.5 font-mono text-xs">
              <label for="title" class="text-copper uppercase font-bold tracking-wider">
                ENTRY TITLE / NAME *
              </label>
              <input type="text" name="title" id="title" required value="<?php echo set_value('title'); ?>" placeholder="e.g. Ilsabet Voss, The Frost Keep..." class="w-full bg-paper-base border-2 border-paper-line focus:border-gold px-3 py-2 text-parchment font-display text-lg tracking-wide outline-none transition placeholder:text-ash/40">
            </div>

            <!-- 3. SLUG -->
            <div class="flex flex-col gap-1 font-mono text-xs">
              <label for="slug" class="text-ash uppercase text-[11px] flex items-center justify-between">
                <span>URL SLUG</span>
                <span class="text-[10px] text-ash/70">[OPTIONAL]</span>
              </label>
              <input type="text" name="slug" id="slug" value="<?php echo set_value('slug'); ?>" placeholder="auto-generated-from-title" class="w-full bg-paper-base border border-paper-line focus:border-gold px-2.5 py-1.5 text-parchment text-xs outline-none transition placeholder:text-ash/40">
            </div>

            <!-- 4. CANON STATUS RADIO PILLS -->
            <div class="flex flex-col gap-1.5 font-mono text-xs border-t border-paper-line pt-4">
              <span class="text-copper uppercase font-bold tracking-wider">CANON STATUS *</span>
              <div class="grid grid-cols-3 gap-1.5 text-center text-[11px]">
                
                <label class="cursor-pointer">
                  <input type="radio" name="status" value="canon" class="peer sr-only" checked>
                  <div class="border-2 border-paper-line peer-checked:border-gold peer-checked:bg-paper-deep peer-checked:text-gold py-1.5 px-1 bg-paper-base transition text-ash font-bold">
                    CANON
                  </div>
                </label>

                <label class="cursor-pointer">
                  <input type="radio" name="status" value="draft" class="peer sr-only">
                  <div class="border-2 border-paper-line peer-checked:border-copper peer-checked:bg-paper-deep peer-checked:text-copper py-1.5 px-1 bg-paper-base transition text-ash font-bold">
                    DRAFT
                  </div>
                </label>

                <label class="cursor-pointer">
                  <input type="radio" name="status" value="archived" class="peer sr-only">
                  <div class="border-2 border-paper-line peer-checked:border-ash peer-checked:bg-paper-deep peer-checked:text-parchment-dim py-1.5 px-1 bg-paper-base transition text-ash font-bold">
                    ARCHIVE
                  </div>
                </label>

              </div>
            </div>

            <!-- 5. PORTRAIT / COVER IMAGE -->
            <div class="flex flex-col gap-1.5 font-mono text-xs border-t border-paper-line pt-4">
              <label for="cover_image" class="text-ash uppercase text-[11px] flex items-center justify-between">
                <span>PORTRAIT / COVER ART</span>
                <span class="text-[10px] text-ash/70">[FILENAME/URL]</span>
              </label>
              <input type="text" name="cover_image" id="cover_image" value="<?php echo set_value('cover_image'); ?>" placeholder="e.g. ilsabet_voss_portrait.webp" class="w-full bg-paper-base border border-paper-line focus:border-gold px-2.5 py-1.5 text-parchment text-xs outline-none transition placeholder:text-ash/40">
            </div>

            <!-- 6. DYNAMIC STRUCTURED ATTRIBUTES PER ENTRY TYPE -->
            <div class="border-t-2 border-paper-line pt-4 flex flex-col gap-3 font-mono text-xs">
              <div class="text-gold uppercase font-bold tracking-wider flex items-center gap-2">
                <span class="w-1.5 h-1.5 bg-gold rotate-45 inline-block"></span>
                <span>STRUCTURED ATTRIBUTES</span>
              </div>
              
              <?php foreach ($properties_by_type as $type_id => $props): ?>
                <div id="props-container-<?php echo $type_id; ?>" class="type-props-group flex flex-col gap-3 <?php echo ($type_id == $entry_types[0]->id) ? '' : 'hidden'; ?>">
                  <?php if (empty($props)): ?>
                    <p class="text-ash text-[11px] italic">No custom fields configured for this type yet.</p>
                  <?php else: ?>
                    <?php foreach ($props as $p): ?>
                      <div class="flex flex-col gap-1">
                        <label class="text-ash uppercase text-[10px] tracking-wider"><?php echo html_escape($p->label); ?></label>
                        <input type="text" name="properties[<?php echo $p->id; ?>]" placeholder="Enter <?php echo strtolower(html_escape($p->label)); ?>..." class="w-full bg-paper-base border border-paper-line focus:border-gold px-2.5 py-1.5 text-parchment text-xs outline-none transition placeholder:text-ash/40">
                      </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>

            <!-- 7. TAGS -->
            <div class="border-t border-paper-line pt-4 flex flex-col gap-1.5 font-mono text-xs">
              <label for="tags" class="text-ash uppercase text-[11px] flex items-center justify-between">
                <span>CATEGORICAL TAGS</span>
                <span class="text-[10px] text-copper">COMMA-SEPARATED</span>
              </label>
              <input type="text" name="tags" id="tags" value="<?php echo set_value('tags'); ?>" placeholder="#northmen, #draugar, #iron-pass" class="w-full bg-paper-base border border-paper-line focus:border-gold px-2.5 py-1.5 text-parchment text-xs outline-none transition placeholder:text-ash/40">
            </div>

          </div>
        </section>

      </aside>


      <!-- RIGHT COLUMN: ARTICLE PROSE & EDITORIAL MANUSCRIPT (8 COLS) -->
      <main class="lg:col-span-8 flex flex-col gap-6">

        <article class="bg-paper-panel border-2 border-paper-line shadow-ink overflow-hidden">
          
          <!-- DOSSIER TITLE BAR WITH SCRIBE TOOLS -->
          <div class="bg-paper-ink border-b-2 border-paper-line px-5 py-3 flex flex-wrap items-center justify-between text-xs font-mono gap-2">
            <div class="flex items-center gap-2">
              <span class="text-gold">✦</span>
              <span class="tracking-widest uppercase font-bold text-parchment">CHRONICLE MANUSCRIPT</span>
              <span class="text-paper-line">|</span>
              <span class="text-ash">MARKDOWN SCRIBE</span>
            </div>
            
            <!-- Quick Toolbar Hints -->
            <div class="flex items-center gap-1.5 text-[11px]">
              <span class="border border-paper-line px-1.5 py-0.5 bg-paper-deep text-ash"># H1</span>
              <span class="border border-paper-line px-1.5 py-0.5 bg-paper-deep text-ash">## H2</span>
              <span class="border border-paper-line px-1.5 py-0.5 bg-paper-deep text-ash">**B**</span>
              <span class="border border-paper-line px-1.5 py-0.5 bg-paper-deep text-ash">&gt; Quote</span>
              <span class="border border-gold/50 px-1.5 py-0.5 bg-paper-deep text-gold font-bold">[[Wiki Link]]</span>
            </div>
          </div>

          <div class="p-6 sm:p-8 flex flex-col gap-6">
            
            <!-- SUMMARY / ABSTRACT -->
            <div class="flex flex-col gap-2 font-mono text-xs">
              <label for="summary" class="text-copper uppercase font-bold tracking-wider flex items-center justify-between">
                <span>BRIEF SUMMARY / SYNOPSIS</span>
                <span class="text-ash text-[10px]">1-2 SENTENCE EXCERPT FOR CARDS</span>
              </label>
              <textarea name="summary" id="summary" rows="2" placeholder="A concise overview of the character, realm, or artifact..." class="w-full bg-paper-base border-2 border-paper-line focus:border-gold p-3 text-parchment font-prose text-base leading-relaxed outline-none transition placeholder:text-ash/40 resize-y"><?php echo set_value('summary'); ?></textarea>
            </div>

            <!-- FULL ARTICLE BODY (MARKDOWN) -->
            <div class="flex flex-col gap-2 font-mono text-xs">
              <label for="content_markdown" class="text-gold uppercase font-bold tracking-wider flex items-center justify-between">
                <span>FULL ARTICLE BODY (MARKDOWN) *</span>
                <span class="text-ash text-[10px]">CANONICAL PROSE</span>
              </label>
              <textarea name="content_markdown" id="content_markdown" rows="18" placeholder="Inscribe your detailed lore, backstory, relationships, and historical records here using Markdown...

## The Origin
Before the winter solstice...

## Deeds & Legacies
- Rebuilt the ancient gate
- Sealed the southern boundary" class="w-full bg-paper-base border-2 border-paper-line focus:border-gold p-4 text-parchment font-prose text-base sm:text-lg leading-relaxed outline-none transition placeholder:text-ash/40 resize-y font-mono text-sm"><?php echo set_value('content_markdown'); ?></textarea>
            </div>

            <!-- ACTION BAR -->
            <div class="border-t-2 border-paper-line pt-6 flex flex-wrap items-center justify-between gap-4">
              <a href="<?php echo base_url('dashboard'); ?>" class="border-2 border-paper-line hover:border-parchment-dark px-5 py-2.5 font-mono text-xs uppercase tracking-widest text-parchment-dim bg-paper-base transition">
                &larr; DISCARD &amp; RETURN
              </a>
              
              <button type="submit" class="border-2 border-gold bg-gold hover:bg-gold-light text-paper-ink px-8 py-2.5 font-mono text-xs font-bold uppercase tracking-widest shadow-ink transition flex items-center gap-2">
                <span>✦</span> INSCRIBE ENTRY INTO CODEX
              </button>
            </div>

          </div>

        </article>

      </main>

    </div>

  </form>

</div>

<!-- JAVASCRIPT: DYNAMIC PROPERTY TOGGLE -->
<script>
function switchEntryTypeProps(typeId) {
  const groups = document.querySelectorAll('.type-props-group');
  groups.forEach(g => g.classList.add('hidden'));
  
  const activeContainer = document.getElementById('props-container-' + typeId);
  if (activeContainer) {
    activeContainer.classList.remove('hidden');
  }
}
</script>
