<!-- EDIT ENTRY FORM (THE CODEX EDITING FOLIO) -->
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

  <?php if ($this->session->flashdata('error_msg')): ?>
    <div class="mb-6 p-4 border-2 border-crimson bg-crimson-dark/40 font-mono text-xs text-parchment shadow-ink-sm flex items-start gap-3">
      <span class="text-crimson font-bold text-base">⚠️</span>
      <div>
        <div class="font-bold uppercase tracking-wider text-crimson-seal mb-1">OPERATION ERROR</div>
        <div class="leading-relaxed"><?php echo html_escape($this->session->flashdata('error_msg')); ?></div>
      </div>
    </div>
  <?php endif; ?>

  <form action="<?php echo base_url('entries/update/' . $entry->id); ?>" method="POST" class="flex flex-col gap-8">
    
    <!-- 2-COLUMN DOSSIER GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
      
      <!-- LEFT COLUMN: STRUCTURED METADATA & ATTRIBUTES (4 COLS) -->
      <aside class="lg:col-span-4 flex flex-col gap-6">

        <section class="bg-paper-panel border-2 border-paper-line shadow-ink overflow-hidden">
          
          <!-- DOSSIER TITLE BAR -->
          <div class="bg-paper-ink border-b-2 border-paper-line px-4 py-2.5 flex items-center justify-between text-xs font-mono">
            <div class="flex items-center gap-2">
              <span class="w-2 h-2 bg-gold rotate-45"></span>
              <span class="text-gold tracking-widest font-bold">REVISION // DOSSIER METADATA</span>
            </div>
            <span class="text-ash text-[10px]">ID #<?php echo sprintf('%03d', (int)$entry->id); ?></span>
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
                  <option value="<?php echo $type->id; ?>" <?php echo set_select('entry_type_id', $type->id, ($entry->entry_type_id == $type->id)); ?>>
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
              <input type="text" name="title" id="title" required value="<?php echo set_value('title', $entry->title); ?>" placeholder="e.g. Ilsabet Voss, The Frost Keep..." class="w-full bg-paper-base border-2 border-paper-line focus:border-gold px-3 py-2 text-parchment font-display text-lg tracking-wide outline-none transition placeholder:text-ash/40">
            </div>

            <!-- 3. SLUG -->
            <div class="flex flex-col gap-1 font-mono text-xs">
              <label for="slug" class="text-ash uppercase text-[11px] flex items-center justify-between">
                <span>URL SLUG</span>
                <span class="text-[10px] text-ash/70">[CANONICAL IDENTIFIER]</span>
              </label>
              <input type="text" name="slug" id="slug" value="<?php echo set_value('slug', $entry->slug); ?>" placeholder="ilsabet-voss" class="w-full bg-paper-base border border-paper-line focus:border-gold px-2.5 py-1.5 text-parchment text-xs outline-none transition placeholder:text-ash/40">
            </div>

            <!-- 4. CANON STATUS RADIO PILLS -->
            <div class="flex flex-col gap-1.5 font-mono text-xs border-t border-paper-line pt-4">
              <span class="text-copper uppercase font-bold tracking-wider">CANON STATUS *</span>
              <div class="grid grid-cols-2 gap-2 text-center text-[11px]">
                
                <?php $current_status = set_value('status', $entry->status); ?>
                <label class="cursor-pointer">
                  <input type="radio" name="status" value="canon" class="peer sr-only" <?php echo ($current_status === 'canon') ? 'checked' : ''; ?>>
                  <div class="border-2 border-paper-line peer-checked:border-gold peer-checked:bg-paper-deep peer-checked:text-gold py-1.5 px-1 bg-paper-base transition text-ash font-bold">
                    CANON
                  </div>
                </label>

                <label class="cursor-pointer">
                  <input type="radio" name="status" value="draft" class="peer sr-only" <?php echo ($current_status === 'draft') ? 'checked' : ''; ?>>
                  <div class="border-2 border-paper-line peer-checked:border-copper peer-checked:bg-paper-deep peer-checked:text-copper py-1.5 px-1 bg-paper-base transition text-ash font-bold">
                    DRAFT
                  </div>
                </label>

                <label class="cursor-pointer">
                  <input type="radio" name="status" value="apocrypha" class="peer sr-only" <?php echo ($current_status === 'apocrypha') ? 'checked' : ''; ?>>
                  <div class="border-2 border-paper-line peer-checked:border-purple-400 peer-checked:bg-paper-deep peer-checked:text-purple-300 py-1.5 px-1 bg-paper-base transition text-ash font-bold">
                    APOCRYPHA
                  </div>
                </label>

                <label class="cursor-pointer">
                  <input type="radio" name="status" value="retconned" class="peer sr-only" <?php echo ($current_status === 'retconned') ? 'checked' : ''; ?>>
                  <div class="border-2 border-paper-line peer-checked:border-ash peer-checked:bg-paper-deep peer-checked:text-parchment-dim py-1.5 px-1 bg-paper-base transition text-ash font-bold">
                    RETCONNED
                  </div>
                </label>

              </div>
            </div>

            <!-- 5. PORTRAIT / COVER IMAGE -->
            <div class="flex flex-col gap-2 font-mono text-xs border-t border-paper-line pt-4">
              <label for="cover_image" class="text-ash uppercase text-[11px] flex items-center justify-between">
                <span>PORTRAIT / COVER ART PLATE</span>
                <span class="text-[10px] text-copper">[LOCAL/URL]</span>
              </label>

              <!-- Live Preview Container -->
              <div id="cover-preview-box" class="relative border-2 border-paper-line bg-paper-deep p-2 flex items-center gap-3 shadow-ink-sm">
                <div class="w-16 h-16 bg-paper-base border border-paper-line/80 flex items-center justify-center overflow-hidden shrink-0">
                  <img id="cover-preview-img" src="<?php echo !empty($entry->cover_image) ? (strpos($entry->cover_image, 'http') === 0 ? html_escape($entry->cover_image) : base_url(html_escape($entry->cover_image))) : ''; ?>" alt="Preview" class="<?php echo !empty($entry->cover_image) ? '' : 'hidden'; ?> w-full h-full object-cover">
                  <span id="cover-preview-placeholder" class="<?php echo !empty($entry->cover_image) ? 'hidden' : ''; ?> text-ash text-xl font-bold font-mono">✦</span>
                </div>
                <div class="flex flex-col gap-1.5 flex-1 min-w-0">
                  <input type="text" name="cover_image" id="cover_image" value="<?php echo set_value('cover_image', $entry->cover_image); ?>" oninput="updateCoverPreview(this.value)" placeholder="e.g. storage/media/portrait.png or URL" class="w-full bg-paper-base border border-paper-line focus:border-gold px-2.5 py-1 text-parchment text-xs outline-none transition placeholder:text-ash/40">
                  <div class="flex items-center gap-2">
                    <button type="button" onclick="document.getElementById('edit-cover-file-input').click()" class="px-2 py-0.5 border border-gold bg-paper-panel hover:bg-gold hover:text-paper-ink text-gold text-[10px] uppercase font-bold tracking-wider transition">
                      ↑ UPLOAD FILE
                    </button>
                    <button type="button" onclick="clearCoverImage()" class="text-ash hover:text-wax text-[10px] uppercase transition">
                      CLEAR
                    </button>
                    <span id="cover-upload-status" class="text-gold text-[10px] hidden font-mono animate-pulse">UPLOADING...</span>
                  </div>
                </div>
              </div>
              <input type="file" id="edit-cover-file-input" accept="image/*" class="hidden" onchange="uploadEditCover(this)">
            </div>

            <!-- 6. DYNAMIC STRUCTURED ATTRIBUTES PER ENTRY TYPE -->
            <div class="border-t-2 border-paper-line pt-4 flex flex-col gap-3 font-mono text-xs">
              <div class="text-gold uppercase font-bold tracking-wider flex items-center gap-2">
                <span class="w-1.5 h-1.5 bg-gold rotate-45 inline-block"></span>
                <span>STRUCTURED ATTRIBUTES</span>
              </div>
              
              <?php foreach ($properties_by_type as $type_id => $props): ?>
                <div id="props-container-<?php echo $type_id; ?>" class="type-props-group flex flex-col gap-3 <?php echo ($type_id == $entry->entry_type_id) ? '' : 'hidden'; ?>">
                  <?php if (empty($props)): ?>
                    <p class="text-ash text-[11px] italic">No custom fields configured for this type yet.</p>
                  <?php else: ?>
                    <?php foreach ($props as $p): ?>
                      <?php 
                        $val = isset($saved_properties[$p->id]) ? $saved_properties[$p->id] : '';
                      ?>
                      <div class="flex flex-col gap-1">
                        <label class="text-ash uppercase text-[10px] tracking-wider"><?php echo html_escape($p->label); ?></label>
                        <input type="text" name="properties[<?php echo $p->id; ?>]" value="<?php echo set_value("properties[{$p->id}]", $val); ?>" placeholder="Enter <?php echo strtolower(html_escape($p->label)); ?>..." class="w-full bg-paper-base border border-paper-line focus:border-gold px-2.5 py-1.5 text-parchment text-xs outline-none transition placeholder:text-ash/40">
                      </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>

            <!-- 7. CATEGORICAL TAGS -->
            <div class="border-t border-paper-line pt-4 flex flex-col gap-1.5 font-mono text-xs">
              <label for="tags" class="text-ash uppercase text-[11px] flex items-center justify-between">
                <span>CATEGORICAL TAGS</span>
                <span class="text-[10px] text-copper">COMMA-SEPARATED</span>
              </label>
              <input type="text" name="tags" id="tags" value="<?php echo set_value('tags', $saved_tags); ?>" placeholder="#northmen, #draugar, #iron-pass" class="w-full bg-paper-base border border-paper-line focus:border-gold px-2.5 py-1.5 text-parchment text-xs outline-none transition placeholder:text-ash/40">
            </div>

          </div>
        </section>

        <!-- DANGER ZONE: ARCHIVAL / SEALING PANEL -->
        <section class="bg-paper-panel border-2 border-paper-line p-5 shadow-ink flex flex-col gap-3 font-mono text-xs">
          <div class="flex items-center justify-between text-ash border-b border-paper-line pb-2 font-bold tracking-wider uppercase">
            <span>ARCHIVAL CONTROL</span>
            <span>[REVERSIBLE]</span>
          </div>

          <div class="text-parchment-dim text-[11px] leading-relaxed">
            Public ID: <code class="text-gold font-mono text-[10px]"><?php echo html_escape($entry->public_id); ?></code><br>
            Last Modified: <span class="text-ash"><?php echo html_escape($entry->updated_at); ?></span>
          </div>

          <?php if (empty($entry->is_archived)): ?>
            <p class="text-[11px] text-ash leading-relaxed">
              Sealing this record moves it to the imperial archives. It will be hidden from the active registry and timeline, but its links and history are preserved.
            </p>
            <a
              href="<?php echo base_url('entries/archive/' . $entry->id); ?>"
              onclick="return confirm('Are you sure you want to seal this record into the archives? You can restore it at any time.');"
              class="w-full border-2 border-crimson/80 hover:border-crimson py-2 text-center text-crimson hover:bg-crimson/10 font-bold uppercase tracking-wider transition"
            >
              ⚠ SEAL / ARCHIVE RECORD
            </a>
          <?php else: ?>
            <div class="p-2 border border-copper/50 bg-paper-deep text-copper text-[11px]">
              This record is currently <strong>ARCHIVED / SEALED</strong>.
            </div>
            <a
              href="<?php echo base_url('entries/restore/' . $entry->id); ?>"
              class="w-full border-2 border-gold py-2 text-center text-gold hover:bg-gold/10 font-bold uppercase tracking-wider transition"
            >
              ✦ UNSEAL &amp; RESTORE RECORD
            </a>
          <?php endif; ?>
        </section>

      </aside>


      <!-- RIGHT COLUMN: ARTICLE PROSE & EDITORIAL MANUSCRIPT (8 COLS) -->
      <main class="lg:col-span-8 flex flex-col gap-6">

        <article class="bg-paper-panel border-2 border-paper-line shadow-ink overflow-hidden">
          
          <!-- DOSSIER TITLE BAR WITH SCRIBE TOOLS & TABS -->
          <div class="bg-paper-ink border-b-2 border-paper-line px-5 py-3 flex flex-wrap items-center justify-between text-xs font-mono gap-3">
            <div class="flex items-center gap-3">
              <div class="flex items-center gap-2">
                <span class="text-gold">✦</span>
                <span class="tracking-widest uppercase font-bold text-parchment">CHRONICLE MANUSCRIPT</span>
              </div>

              <!-- View/Edit Tabs -->
              <div class="flex items-center border border-paper-line p-0.5 bg-paper-deep text-[11px]">
                <button type="button" id="tab-write" onclick="toggleEditorTab('write')" class="px-2.5 py-0.5 font-bold bg-gold text-paper-ink uppercase transition">
                  [✎ WRITE]
                </button>
                <button type="button" id="tab-preview" onclick="toggleEditorTab('preview')" class="px-2.5 py-0.5 text-ash hover:text-parchment uppercase transition">
                  [👁 PREVIEW]
                </button>
              </div>
            </div>
            
            <!-- Interactive Formatting Toolbar -->
            <div class="flex flex-wrap items-center gap-1 text-[11px]" id="editor-toolbar">
              <button type="button" onclick="insertSyntax('## ', '')" title="Section Heading" class="border border-paper-line hover:border-gold px-1.5 py-0.5 bg-paper-deep text-ash hover:text-gold transition">## H2</button>
              <button type="button" onclick="insertSyntax('### ', '')" title="Subsection Heading" class="border border-paper-line hover:border-gold px-1.5 py-0.5 bg-paper-deep text-ash hover:text-gold transition">### H3</button>
              <button type="button" onclick="wrapSelection('**', '**')" title="Bold" class="border border-paper-line hover:border-gold px-1.5 py-0.5 bg-paper-deep text-ash hover:text-gold font-bold transition">B</button>
              <button type="button" onclick="wrapSelection('*', '*')" title="Italic" class="border border-paper-line hover:border-gold px-1.5 py-0.5 bg-paper-deep text-ash hover:text-gold italic transition">I</button>
              <button type="button" onclick="insertSyntax('> ', '')" title="Blockquote" class="border border-paper-line hover:border-gold px-1.5 py-0.5 bg-paper-deep text-ash hover:text-gold transition">&gt; Quote</button>
              <button type="button" onclick="insertSyntax('- ', '')" title="Bullet List" class="border border-paper-line hover:border-gold px-1.5 py-0.5 bg-paper-deep text-ash hover:text-gold transition">• List</button>
              <button type="button" onclick="insertWikiLink()" title="Insert Wiki Link to another entry" class="border border-gold/60 hover:border-gold px-2 py-0.5 bg-paper-deep text-gold font-bold transition">✦ [[Wiki Link]]</button>
              <button type="button" onclick="triggerPlateUpload()" title="Inscribe Image Plate into Manuscript" class="border border-gold/60 hover:border-gold px-2 py-0.5 bg-paper-deep text-gold font-bold transition flex items-center gap-1"><span>🖼</span> +Plate</button>
            </div>
          </div>

          <div class="p-6 sm:p-8 flex flex-col gap-6">
            
            <!-- SUMMARY / ABSTRACT -->
            <div class="flex flex-col gap-2 font-mono text-xs">
              <label for="summary" class="text-copper uppercase font-bold tracking-wider flex items-center justify-between">
                <span>BRIEF SUMMARY / SYNOPSIS</span>
                <span class="text-ash text-[10px]">1-2 SENTENCE EXCERPT FOR CARDS</span>
              </label>
              <textarea name="summary" id="summary" rows="2" placeholder="A concise overview of the character, realm, or artifact..." class="w-full bg-paper-base border-2 border-paper-line focus:border-gold p-3 text-parchment font-prose text-base leading-relaxed outline-none transition placeholder:text-ash/40 resize-y"><?php echo set_value('summary', $entry->summary); ?></textarea>
            </div>

            <!-- FULL ARTICLE BODY (MARKDOWN EDITOR CONTAINER) -->
            <div class="flex flex-col gap-2 font-mono text-xs" id="editor-write-container">
              <label for="content_markdown" class="text-gold uppercase font-bold tracking-wider flex items-center justify-between">
                <span>FULL ARTICLE BODY (MARKDOWN) *</span>
                <span class="text-ash text-[10px]">CANONICAL PROSE // USE [[ENTRY NAME]] TO CROSS-REFERENCE</span>
              </label>

              <!-- Live Plate Inscription Status Banner -->
              <div id="editor-plate-status" class="hidden font-mono text-xs text-gold bg-paper-ink border border-gold/60 p-2 shadow-ink-sm flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <span class="w-2 h-2 bg-gold animate-spin"></span>
                  <span id="editor-plate-status-text" class="font-bold tracking-wider">INSCRIBING ILLUMINATION INTO MEDIA VAULT...</span>
                </div>
                <span class="text-[10px] text-ash">PASTE (CTRL+V) / DRAG &amp; DROP ACTIVE</span>
              </div>

              <textarea name="content_markdown" id="content_markdown" rows="20" placeholder="Inscribe your detailed lore, backstory, relationships, and historical records here using Markdown..." class="w-full bg-paper-base border-2 border-paper-line focus:border-gold p-4 text-parchment font-prose text-base sm:text-lg leading-relaxed outline-none transition placeholder:text-ash/40 resize-y font-mono text-sm"><?php echo set_value('content_markdown', $entry->content_markdown); ?></textarea>
            </div>

            <!-- LIVE PREVIEW CONTAINER (HIDDEN INITIALLY) -->
            <div id="editor-preview-container" class="hidden flex flex-col gap-2">
              <div class="font-mono text-xs text-gold uppercase tracking-wider flex items-center justify-between border-b border-paper-line pb-2">
                <span>ILLUMINATED CODEX PREVIEW</span>
                <span class="text-[10px] text-ash">RESOLVED [[WIKI LINKS]] &amp; TYPOGRAPHY</span>
              </div>
              <div id="preview-render-target" class="p-5 bg-paper-deep border-2 border-paper-line min-h-[350px] shadow-ink-sm prose-grimoire">
                <!-- Rendered output appears here -->
              </div>
            </div>

            <!-- ACTION BAR -->
            <div class="border-t-2 border-paper-line pt-6 flex flex-wrap items-center justify-between gap-4">
              <a href="<?php echo base_url('entries/view/' . $entry->id); ?>" class="border-2 border-paper-line hover:border-parchment-dark px-5 py-2.5 font-mono text-xs uppercase tracking-widest text-parchment-dim bg-paper-base transition">
                &larr; CANCEL &amp; RETURN TO DOSSIER
              </a>
              
              <button type="submit" class="border-2 border-gold bg-gold hover:bg-gold-light text-paper-ink px-8 py-2.5 font-mono text-xs font-bold uppercase tracking-widest shadow-ink transition flex items-center gap-2">
                <span>✦</span> INSCRIBE AMENDMENTS / UPDATE RECORD
              </button>
            </div>

          </div>

        </article>

      </main>

    </div>

  </form>

</div>

<!-- JAVASCRIPT: DYNAMIC PROPERTY TOGGLE & MARKDOWN TOOLBAR -->
<script>
function switchEntryTypeProps(typeId) {
  const groups = document.querySelectorAll('.type-props-group');
  groups.forEach(g => g.classList.add('hidden'));
  
  const activeContainer = document.getElementById('props-container-' + typeId);
  if (activeContainer) {
    activeContainer.classList.remove('hidden');
  }
}

// Markdown Toolbar Helpers
function getEditor() {
  return document.getElementById('content_markdown');
}

function wrapSelection(prefix, suffix) {
  const editor = getEditor();
  const start = editor.selectionStart;
  const end = editor.selectionEnd;
  const text = editor.value;
  const selected = text.substring(start, end) || 'text';
  
  editor.value = text.substring(0, start) + prefix + selected + suffix + text.substring(end);
  editor.focus();
  editor.setSelectionRange(start + prefix.length, start + prefix.length + selected.length);
}

function insertSyntax(prefix, suffix) {
  const editor = getEditor();
  const start = editor.selectionStart;
  const end = editor.selectionEnd;
  const text = editor.value;
  
  editor.value = text.substring(0, start) + prefix + suffix + text.substring(start);
  editor.focus();
  editor.setSelectionRange(start + prefix.length, start + prefix.length);
}

function insertWikiLink() {
  const editor = getEditor();
  const start = editor.selectionStart;
  const end = editor.selectionEnd;
  const text = editor.value;
  const selected = text.substring(start, end);
  
  if (selected) {
    wrapSelection('[[', ']]');
  } else {
    const title = prompt('Enter record name to cross-reference (e.g. Ilsabet Voss, The Frost Keep):');
    if (title) {
      editor.value = text.substring(0, start) + '[[' + title + ']]' + text.substring(start);
      editor.focus();
    }
  }
}

// Write vs Live Preview Tabs
function toggleEditorTab(mode) {
  const writeTab = document.getElementById('tab-write');
  const previewTab = document.getElementById('tab-preview');
  const writeContainer = document.getElementById('editor-write-container');
  const previewContainer = document.getElementById('editor-preview-container');
  const renderTarget = document.getElementById('preview-render-target');
  const toolbar = document.getElementById('editor-toolbar');

  if (mode === 'preview') {
    writeTab.className = 'px-2.5 py-0.5 text-ash hover:text-parchment uppercase transition';
    previewTab.className = 'px-2.5 py-0.5 font-bold bg-gold text-paper-ink uppercase transition';
    writeContainer.classList.add('hidden');
    previewContainer.classList.remove('hidden');
    toolbar.classList.add('opacity-40', 'pointer-events-none');

    renderTarget.innerHTML = '<div class="flex items-center gap-2 text-ash font-mono text-xs"><span class="w-2 h-2 bg-gold animate-spin"></span> Consulting archives & rendering manuscript...</div>';

    const markdown = getEditor().value;
    const formData = new FormData();
    formData.append('markdown', markdown);

    fetch('<?php echo base_url("entries/preview"); ?>', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      renderTarget.innerHTML = data.html || '<p class="text-ash italic">No content to preview.</p>';
    })
    .catch(() => {
      renderTarget.innerHTML = '<p class="text-crimson font-mono text-xs">Failed to load manuscript preview.</p>';
    });

  } else {
    previewTab.className = 'px-2.5 py-0.5 text-ash hover:text-parchment uppercase transition';
    writeTab.className = 'px-2.5 py-0.5 font-bold bg-gold text-paper-ink uppercase transition';
    previewContainer.classList.add('hidden');
    writeContainer.classList.remove('hidden');
    toolbar.classList.remove('opacity-40', 'pointer-events-none');
    getEditor().focus();
  }
}

function updateCoverPreview(val) {
  const img = document.getElementById('cover-preview-img');
  const placeholder = document.getElementById('cover-preview-placeholder');
  if (!val || val.trim() === '') {
    img.src = '';
    img.classList.add('hidden');
    placeholder.classList.remove('hidden');
    return;
  }
  let src = val.trim();
  if (!src.startsWith('http://') && !src.startsWith('https://')) {
    src = '<?php echo base_url(); ?>' + src;
  }
  img.src = src;
  img.classList.remove('hidden');
  placeholder.classList.add('hidden');
}

function clearCoverImage() {
  document.getElementById('cover_image').value = '';
  updateCoverPreview('');
}

function uploadEditCover(input) {
  if (!input.files || input.files.length === 0) return;
  const file = input.files[0];
  const status = document.getElementById('cover-upload-status');
  if (status) status.classList.remove('hidden');

  const formData = new FormData();
  formData.append('portrait', file);
  formData.append('world_id', '<?php echo (int)$active_world->id; ?>');
  <?php if (isset($entry->id)): ?>
  formData.append('entry_id', '<?php echo (int)$entry->id; ?>');
  <?php endif; ?>

  fetch('<?php echo base_url('media/upload'); ?>', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (status) status.classList.add('hidden');
    if (data.success) {
      document.getElementById('cover_image').value = data.file_path;
      updateCoverPreview(data.file_path);
    } else {
      alert(data.message || 'Upload failed');
    }
  })
  .catch(err => {
    if (status) status.classList.add('hidden');
    alert('Upload error.');
    console.error(err);
  });
}
</script>

<?php
// Shared Markdown Editor Inscriber (Paste, Drag & Drop, Toolbar +Plate Button)
$this->load->view('partials/editor_inscriber_js', $data ?? get_defined_vars());
?>
