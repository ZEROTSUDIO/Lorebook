<!-- ENCYCLOPEDIA BROWSER & FILTER MATRIX -->
<div class="flex flex-col gap-8">

  <!-- FLASH MESSAGE NOTIFICATION -->
  <?php if ($this->session->flashdata('success_msg')): ?>
    <div class="p-4 border-2 border-gold bg-paper-panel font-mono text-xs text-gold shadow-ink flex items-center justify-between">
      <div class="flex items-center gap-3">
        <span class="w-2 h-2 bg-gold rotate-45 inline-block"></span>
        <span class="font-bold tracking-wider uppercase"><?php echo html_escape($this->session->flashdata('success_msg')); ?></span>
      </div>
      <span class="text-ash text-[10px] uppercase">CODEX ARCHIVE</span>
    </div>
  <?php endif; ?>

  <?php if ($this->session->flashdata('error_msg')): ?>
    <div class="p-4 border-2 border-crimson bg-crimson-dark/40 font-mono text-xs text-parchment shadow-ink-sm flex items-start gap-3">
      <span class="text-crimson font-bold text-base">⚠️</span>
      <div>
        <div class="font-bold uppercase tracking-wider text-crimson-seal mb-1">OPERATION ERROR</div>
        <div class="leading-relaxed"><?php echo html_escape($this->session->flashdata('error_msg')); ?></div>
      </div>
    </div>
  <?php endif; ?>

  <!-- 1. SEARCH & FILTER CONTROL PANEL -->
  <section class="bg-paper-panel border-2 border-paper-line shadow-ink overflow-hidden">
    
    <!-- DOSSIER TITLE BAR WITH VIEW MODE TOGGLE -->
    <div class="bg-paper-ink border-b-2 border-paper-line px-4 sm:px-6 py-2.5 flex flex-wrap items-center justify-between text-xs font-mono gap-3">
      <div class="flex items-center gap-2">
        <span class="w-2 h-2 bg-gold rotate-45"></span>
        <span class="text-gold tracking-widest font-bold uppercase">ENCYCLOPEDIA INDEX // FILTER MATRIX</span>
        <span class="text-paper-line">|</span>
        <span class="text-parchment-dim"><?php echo count($entries); ?> RECORDS FOUND</span>
      </div>

      <!-- View Switcher: Cards vs Table -->
      <div class="flex items-center gap-1.5">
        <span class="text-ash text-[10px] uppercase mr-1 hidden sm:inline">DISPLAY:</span>
        <button type="button" id="btn-view-grid" onclick="setEncyclopediaView('grid')" class="px-2.5 py-1 border border-gold bg-paper-panel text-gold font-bold text-[11px] uppercase tracking-wider transition">
          [❖ DOSSIER CARDS]
        </button>
        <button type="button" id="btn-view-table" onclick="setEncyclopediaView('table')" class="px-2.5 py-1 border border-paper-line bg-paper-base text-ash hover:text-parchment text-[11px] uppercase tracking-wider transition">
          [≡ REGISTRY TABLE]
        </button>
      </div>
    </div>

    <!-- SEARCH & FILTER FORM -->
    <form action="<?php echo base_url('entries'); ?>" method="GET" class="p-5 flex flex-col gap-4">
      
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 font-mono text-xs">
        
        <!-- Search Input (5 cols) -->
        <div class="lg:col-span-5 flex flex-col gap-1">
          <label for="q" class="text-[10px] text-copper uppercase tracking-wider font-bold">SEARCH ARCHIVES</label>
          <input type="text" name="q" id="q" value="<?php echo html_escape($search_query); ?>" placeholder="Search by title, synopsis, or chronicle text..." class="w-full bg-paper-base border-2 border-paper-line focus:border-gold px-3 py-2 text-parchment outline-none transition placeholder:text-ash/50">
        </div>

        <!-- Category Select (3 cols) -->
        <div class="lg:col-span-3 flex flex-col gap-1">
          <label for="type" class="text-[10px] text-ash uppercase tracking-wider">CATEGORY / TEMPLATE</label>
          <select name="type" id="type" class="w-full bg-paper-base border-2 border-paper-line focus:border-gold px-3 py-2 text-parchment outline-none transition cursor-pointer">
            <option value="">All Categories</option>
            <?php foreach ($entry_types as $et): ?>
              <option value="<?php echo html_escape($et->slug); ?>" <?php echo ($selected_type === $et->slug) ? 'selected' : ''; ?>>
                <?php echo html_escape($et->name); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Canon Status Select (2 cols) -->
        <div class="lg:col-span-2 flex flex-col gap-1">
          <label for="status" class="text-[10px] text-ash uppercase tracking-wider">CANON STATUS</label>
          <select name="status" id="status" class="w-full bg-paper-base border-2 border-paper-line focus:border-gold px-3 py-2 text-parchment outline-none transition cursor-pointer">
            <option value="">Active (Canon + Draft)</option>
            <option value="canon" <?php echo ($selected_status === 'canon') ? 'selected' : ''; ?>>Canon Verified</option>
            <option value="draft" <?php echo ($selected_status === 'draft') ? 'selected' : ''; ?>>Draft In Progress</option>
            <option value="archived" <?php echo ($selected_status === 'archived') ? 'selected' : ''; ?>>Archived / Legend</option>
          </select>
        </div>

        <!-- Sort Select (2 cols) -->
        <div class="lg:col-span-2 flex flex-col gap-1">
          <label for="sort" class="text-[10px] text-ash uppercase tracking-wider">SORT ORDER</label>
          <select name="sort" id="sort" class="w-full bg-paper-base border-2 border-paper-line focus:border-gold px-3 py-2 text-parchment outline-none transition cursor-pointer">
            <option value="updated_desc" <?php echo ($selected_sort === 'updated_desc') ? 'selected' : ''; ?>>Recently Updated</option>
            <option value="created_desc" <?php echo ($selected_sort === 'created_desc') ? 'selected' : ''; ?>>Recently Inscribed</option>
            <option value="title_asc" <?php echo ($selected_sort === 'title_asc') ? 'selected' : ''; ?>>Alphabetical (A–Z)</option>
          </select>
        </div>

      </div>

      <!-- QUICK CATEGORY PILLS & SUBMIT CONTROLS -->
      <div class="border-t border-paper-line pt-4 flex flex-wrap items-center justify-between gap-3 font-mono text-xs">
        
        <!-- Category Quick Filter Chips -->
        <div class="flex flex-wrap items-center gap-1.5 text-[11px]">
          <span class="text-ash mr-1 uppercase text-[10px]">QUICK FILTER:</span>
          <a href="<?php echo base_url('entries'); ?>" class="px-2.5 py-1 border <?php echo empty($selected_type) ? 'border-gold text-gold bg-paper-deep font-bold' : 'border-paper-line text-ash hover:text-parchment bg-paper-base'; ?> transition">
            ALL
          </a>
          <?php foreach ($entry_types as $et): ?>
            <a href="<?php echo base_url('entries?type=' . urlencode($et->slug)); ?>" class="px-2.5 py-1 border <?php echo ($selected_type === $et->slug) ? 'border-gold text-gold bg-paper-deep font-bold' : 'border-paper-line text-ash hover:text-parchment bg-paper-base'; ?> transition uppercase">
              <?php echo html_escape($et->name); ?>
            </a>
          <?php endforeach; ?>
        </div>

        <!-- Submit & Reset Buttons -->
        <div class="flex items-center gap-2">
          <?php if (!empty($search_query) || !empty($selected_type) || !empty($selected_status) || !empty($selected_tag)): ?>
            <a href="<?php echo base_url('entries'); ?>" class="border border-paper-line hover:border-copper px-3 py-1.5 text-copper bg-paper-base text-[11px] uppercase tracking-wider transition">
              [✕ CLEAR]
            </a>
          <?php endif; ?>
          <button type="submit" class="border-2 border-gold bg-gold hover:bg-gold-light text-paper-ink font-bold px-5 py-1.5 text-[11px] uppercase tracking-widest shadow-ink-sm transition">
            APPLY FILTER
          </button>
        </div>

      </div>

      <!-- TAG FILTER ROW (If tags exist in world) -->
      <?php if (!empty($all_tags)): ?>
        <div class="border-t border-paper-line/60 pt-3 flex flex-wrap items-center gap-1.5 font-mono text-[11px]">
          <span class="text-copper uppercase text-[10px] font-bold mr-1">TAGS:</span>
          <?php foreach ($all_tags as $tag): ?>
            <a href="<?php echo base_url('entries?tag=' . urlencode($tag->slug)); ?>" class="px-2 py-0.5 border <?php echo ($selected_tag === $tag->slug) ? 'border-gold text-gold bg-paper-deep font-bold' : 'border-paper-line text-parchment-dim hover:border-gold bg-paper-base'; ?> transition">
              #<?php echo html_escape(strtoupper($tag->name)); ?>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

    </form>
  </section>


  <!-- 2. ENTRIES DISPLAY AREA -->
  <?php if (empty($entries)): ?>
    
    <!-- EMPTY STATE -->
    <div class="bg-paper-panel border-2 border-paper-line p-12 text-center shadow-ink flex flex-col items-center gap-4">
      <div class="w-12 h-12 border-2 border-gold rotate-45 flex items-center justify-center mb-2">
        <span class="w-4 h-4 bg-gold/40"></span>
      </div>
      <h2 class="font-display font-bold text-3xl text-gold uppercase tracking-wider">No Recorded Chronicles Found</h2>
      <p class="font-prose text-parchment-dim max-w-md text-base">
        No lore entries match your current query parameters, or this category of the Codex has not yet been inscribed.
      </p>
      <div class="flex flex-wrap justify-center gap-3 mt-2 font-mono text-xs">
        <a href="<?php echo base_url('entries'); ?>" class="border-2 border-paper-line hover:border-parchment px-4 py-2 text-parchment-dim bg-paper-base uppercase tracking-wider transition">
          RESET FILTERS
        </a>
        <a href="<?php echo base_url('entries/create'); ?>" class="border-2 border-gold bg-gold hover:bg-gold-light text-paper-ink font-bold px-5 py-2 uppercase tracking-widest shadow-ink-sm transition">
          ＋ INSCRIBE FIRST ENTRY
        </a>
      </div>
    </div>

  <?php else: ?>

    <!-- A. DOSSIER CARD GRID VIEW -->
    <div id="encyclopedia-grid-view" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php foreach ($entries as $entry): ?>
        <article class="bg-paper-panel border-2 border-paper-line hover:border-gold/80 shadow-ink flex flex-col justify-between transition group overflow-hidden">
          
          <div>
            <!-- FLUSH DOSSIER TITLE BAR -->
            <div class="bg-paper-ink border-b-2 border-paper-line px-4 py-2 flex items-center justify-between text-[11px] font-mono">
              <div class="flex items-center gap-2">
                <span class="w-1.5 h-1.5 bg-gold rotate-45"></span>
                <span class="text-gold font-bold uppercase tracking-wider"><?php echo html_escape($entry->type_name); ?></span>
              </div>
              <span class="text-ash text-[10px]">REF #<?php echo str_pad($entry->id, 3, '0', STR_PAD_LEFT); ?></span>
            </div>

            <div class="p-5 flex flex-col gap-4">
              
              <!-- STATUS STAMP & PORTRAIT PLATE HEADER -->
              <div class="bg-paper-base border border-paper-line p-3 corner-brackets flex items-center justify-between">
                <span class="font-mono text-[10px] text-copper uppercase tracking-widest">
                  <?php echo !empty($entry->cover_image) ? html_escape($entry->cover_image) : 'FOLIO // ' . strtoupper($entry->type_slug); ?>
                </span>

                <?php if ($entry->status === 'canon'): ?>
                  <span class="font-mono font-bold text-[10px] uppercase tracking-widest text-gold border border-gold px-2 py-0.5 bg-paper-deep">
                    CANON
                  </span>
                <?php elseif ($entry->status === 'draft'): ?>
                  <span class="font-mono font-bold text-[10px] uppercase tracking-widest text-copper border border-copper px-2 py-0.5 bg-paper-deep">
                    DRAFT
                  </span>
                <?php else: ?>
                  <span class="font-mono font-bold text-[10px] uppercase tracking-widest text-ash border border-ash px-2 py-0.5 bg-paper-deep">
                    ARCHIVED
                  </span>
                <?php endif; ?>
              </div>

              <!-- ENTRY TITLE & SUMMARY -->
              <div>
                <h2 class="font-display font-bold text-2xl sm:text-3xl text-gold group-hover:text-gold-light uppercase tracking-wide leading-tight transition">
                  <a href="<?php echo base_url('entries/view/' . $entry->id); ?>">
                    <?php echo html_escape($entry->title); ?>
                  </a>
                </h2>
                <p class="font-prose text-parchment-dim text-sm sm:text-base mt-2 line-clamp-3 leading-relaxed">
                  <?php 
                    if (!empty($entry->summary)) {
                        echo html_escape($entry->summary);
                    } else {
                        echo html_escape(mb_strimwidth(strip_tags($entry->content_markdown), 0, 140, '...'));
                    }
                  ?>
                </p>
              </div>

              <!-- TAG CHIPS -->
              <?php if (!empty($entry->tags)): ?>
                <div class="flex flex-wrap gap-1.5 pt-1 font-mono text-[10px]">
                  <?php foreach ($entry->tags as $t): ?>
                    <a href="<?php echo base_url('entries?tag=' . urlencode($t->slug)); ?>" class="border border-paper-line hover:border-gold px-2 py-0.5 bg-paper-base text-ash hover:text-parchment transition">
                      #<?php echo html_escape(strtoupper($t->name)); ?>
                    </a>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>

            </div>
          </div>

          <!-- CARD FOOTER -->
          <div class="border-t-2 border-paper-line px-5 py-3 bg-paper-base/50 flex items-center justify-between font-mono text-[11px]">
            <span class="text-ash">UPDATED: <?php echo date('M d, Y', strtotime($entry->updated_at)); ?></span>
            <a href="<?php echo base_url('entries/view/' . $entry->id); ?>" class="text-gold font-bold hover:underline uppercase tracking-wider">
              OPEN DOSSIER &rarr;
            </a>
          </div>

        </article>
      <?php endforeach; ?>
    </div>


    <!-- B. COMPACT REGISTRY TABLE VIEW (Toggled via JS) -->
    <div id="encyclopedia-table-view" class="hidden bg-paper-panel border-2 border-paper-line shadow-ink overflow-x-auto">
      <table class="w-full text-left border-collapse font-mono text-xs">
        <thead>
          <tr class="bg-paper-ink border-b-2 border-paper-line text-gold uppercase tracking-wider text-[11px]">
            <th class="py-3 px-4">REF ID</th>
            <th class="py-3 px-4">ENTRY TITLE</th>
            <th class="py-3 px-4">CATEGORY</th>
            <th class="py-3 px-4">STATUS</th>
            <th class="py-3 px-4">LAST UPDATED</th>
            <th class="py-3 px-4 text-right">ACTION</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-paper-line">
          <?php foreach ($entries as $entry): ?>
            <tr class="hover:bg-paper-base/80 transition">
              <td class="py-3 px-4 text-ash">#<?php echo str_pad($entry->id, 3, '0', STR_PAD_LEFT); ?></td>
              <td class="py-3 px-4">
                <a href="<?php echo base_url('entries/view/' . $entry->id); ?>" class="font-display font-bold text-lg text-parchment hover:text-gold tracking-wide">
                  <?php echo html_escape($entry->title); ?>
                </a>
                <?php if (!empty($entry->summary)): ?>
                  <div class="font-prose text-xs text-ash truncate max-w-md"><?php echo html_escape($entry->summary); ?></div>
                <?php endif; ?>
              </td>
              <td class="py-3 px-4 text-copper uppercase"><?php echo html_escape($entry->type_name); ?></td>
              <td class="py-3 px-4">
                <?php if ($entry->status === 'canon'): ?>
                  <span class="border border-gold text-gold px-2 py-0.5 text-[10px] font-bold uppercase bg-paper-deep">CANON</span>
                <?php elseif ($entry->status === 'draft'): ?>
                  <span class="border border-copper text-copper px-2 py-0.5 text-[10px] font-bold uppercase bg-paper-deep">DRAFT</span>
                <?php else: ?>
                  <span class="border border-ash text-ash px-2 py-0.5 text-[10px] font-bold uppercase bg-paper-deep">ARCHIVED</span>
                <?php endif; ?>
              </td>
              <td class="py-3 px-4 text-ash"><?php echo date('M d, Y', strtotime($entry->updated_at)); ?></td>
              <td class="py-3 px-4 text-right">
                <a href="<?php echo base_url('entries/view/' . $entry->id); ?>" class="border border-paper-line hover:border-gold px-2.5 py-1 bg-paper-base text-gold font-bold uppercase text-[10px] transition">
                  [VIEW]
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  <?php endif; ?>

</div>

<!-- VIEW SWITCHER SCRIPT -->
<script>
function setEncyclopediaView(mode) {
  const gridView = document.getElementById('encyclopedia-grid-view');
  const tableView = document.getElementById('encyclopedia-table-view');
  const btnGrid = document.getElementById('btn-view-grid');
  const btnTable = document.getElementById('btn-view-table');

  if (!gridView || !tableView) return;

  if (mode === 'table') {
    gridView.classList.add('hidden');
    tableView.classList.remove('hidden');
    btnTable.className = 'px-2.5 py-1 border border-gold bg-paper-panel text-gold font-bold text-[11px] uppercase tracking-wider transition';
    btnGrid.className = 'px-2.5 py-1 border border-paper-line bg-paper-base text-ash hover:text-parchment text-[11px] uppercase tracking-wider transition';
    localStorage.setItem('lorekeeper_view_mode', 'table');
  } else {
    tableView.classList.add('hidden');
    gridView.classList.remove('hidden');
    btnGrid.className = 'px-2.5 py-1 border border-gold bg-paper-panel text-gold font-bold text-[11px] uppercase tracking-wider transition';
    btnTable.className = 'px-2.5 py-1 border border-paper-line bg-paper-base text-ash hover:text-parchment text-[11px] uppercase tracking-wider transition';
    localStorage.setItem('lorekeeper_view_mode', 'grid');
  }
}

document.addEventListener('DOMContentLoaded', function() {
  const savedMode = localStorage.getItem('lorekeeper_view_mode');
  if (savedMode === 'table') {
    setEncyclopediaView('table');
  }
});
</script>
