<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * LOREKEEPER // EDITOR INSCRIBER: CLIPBOARD PASTE, DRAG & DROP, & PLATE UPLOADER
 * Integrates directly with Grimoire Markdown Editor in create.php and edit.php
 */
$inscriber_world_id = isset($active_world) && !empty($active_world->id) ? (int)$active_world->id : 1;
$inscriber_entry_id = isset($entry) && !empty($entry->id) ? (int)$entry->id : 0;
?>

<!-- Hidden File Picker for Toolbar Button -->
<input type="file" id="editor-plate-file-input" accept="image/png,image/jpeg,image/webp,image/svg+xml,image/gif" class="hidden" onchange="handlePlateFileInput(this)">

<script>
(function() {
  const worldId = <?php echo $inscriber_world_id; ?>;
  const entryId = <?php echo $inscriber_entry_id; ?>;
  const uploadUrl = '<?php echo base_url("media/upload"); ?>';

  function getMarkdownEditor() {
    return document.getElementById('content_markdown');
  }

  function showPlateStatus(msg) {
    const statusBox = document.getElementById('editor-plate-status');
    const statusText = document.getElementById('editor-plate-status-text');
    if (statusBox && statusText) {
      statusText.textContent = msg || 'INSCRIBING ILLUMINATION INTO MEDIA VAULT...';
      statusBox.classList.remove('hidden');
    }
  }

  function hidePlateStatus() {
    const statusBox = document.getElementById('editor-plate-status');
    if (statusBox) {
      statusBox.classList.add('hidden');
    }
  }

  /**
   * Core Uploader: uploads File / Blob to Media.php and inserts Markdown plate tag
   */
  window.inscribePlateFile = function(file, customCaption) {
    if (!file) return;

    // Validate image MIME type
    if (!file.type || !file.type.startsWith('image/')) {
      if (typeof showArchivalToast === 'function') {
        showArchivalToast('Invalid file format. Only image plates are permitted.', false);
      } else {
        alert('Invalid file format. Only image plates are permitted.');
      }
      return;
    }

    const editor = getMarkdownEditor();
    if (!editor) return;

    // Generate unique temp token
    const tempId = 'INSCRIBING_' + Math.random().toString(36).substring(2, 9).toUpperCase();
    const rawStem = file.name ? file.name.replace(/\.[^/.]+$/, '').replace(/[-_]+/g, ' ') : 'Manuscript Illumination';
    const cleanStem = customCaption || rawStem.replace(/\b\w/g, l => l.toUpperCase());
    const placeholder = '\n\n![✦ Inscribing plate... ' + cleanStem + '](' + tempId + ')\n\n';

    // Insert placeholder at cursor or end
    const start = editor.selectionStart !== undefined ? editor.selectionStart : editor.value.length;
    const end = editor.selectionEnd !== undefined ? editor.selectionEnd : editor.value.length;
    const text = editor.value;
    editor.value = text.substring(0, start) + placeholder + text.substring(end);
    editor.selectionStart = editor.selectionEnd = start + placeholder.length;
    editor.focus();

    showPlateStatus('INSCRIBING [' + cleanStem.toUpperCase() + '] INTO MEDIA VAULT...');

    const formData = new FormData();
    formData.append('file', file);
    formData.append('world_id', worldId);
    if (entryId > 0) {
      formData.append('entry_id', entryId);
    }
    formData.append('caption', cleanStem);

    fetch(uploadUrl, {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      hidePlateStatus();
      if (data.success) {
        const finalCaption = data.caption || cleanStem;
        const finalTag = '\n\n![' + finalCaption + '](' + data.file_path + ')\n\n';

        if (editor.value.indexOf(tempId) !== -1) {
          editor.value = editor.value.replace(placeholder.trim(), '![' + finalCaption + '](' + data.file_path + ')');
        } else {
          editor.value += finalTag;
        }

        if (typeof showArchivalToast === 'function') {
          showArchivalToast('✦ Plate inscribed: ' + finalCaption);
        }
      } else {
        // Rollback placeholder
        editor.value = editor.value.replace(placeholder, '');
        if (typeof showArchivalToast === 'function') {
          showArchivalToast(data.message || 'Plate inscription failed.', false);
        } else {
          alert(data.message || 'Plate inscription failed.');
        }
      }
    })
    .catch(err => {
      hidePlateStatus();
      editor.value = editor.value.replace(placeholder, '');
      console.error(err);
      if (typeof showArchivalToast === 'function') {
        showArchivalToast('Network failure while inscribing plate.', false);
      } else {
        alert('Network failure while inscribing plate.');
      }
    });
  };

  /**
   * Toolbar Button Trigger
   */
  window.triggerPlateUpload = function() {
    const fileInput = document.getElementById('editor-plate-file-input');
    if (fileInput) {
      fileInput.value = '';
      fileInput.click();
    }
  };

  window.handlePlateFileInput = function(input) {
    if (input.files && input.files.length > 0) {
      window.inscribePlateFile(input.files[0]);
    }
  };

  /**
   * Setup Listeners: Clipboard Paste & Drag and Drop
   */
  document.addEventListener('DOMContentLoaded', function() {
    const editor = getMarkdownEditor();
    const writeContainer = document.getElementById('editor-write-container');
    if (!editor) return;

    // 1. CLIPBOARD PASTE LISTENER (Ctrl + V)
    editor.addEventListener('paste', function(e) {
      if (!e.clipboardData || !e.clipboardData.items) return;

      const items = e.clipboardData.items;
      for (let i = 0; i < items.length; i++) {
        if (items[i].type.indexOf('image') !== -1) {
          e.preventDefault();
          const file = items[i].getAsFile();
          if (file) {
            window.inscribePlateFile(file, 'Clipboard Study ' + new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }));
          }
          break;
        }
      }
    });

    // 2. DRAG AND DROP LISTENER
    const dropTargets = [editor, writeContainer].filter(Boolean);
    let dragCounter = 0;

    dropTargets.forEach(target => {
      target.addEventListener('dragenter', function(e) {
        e.preventDefault();
        dragCounter++;
        editor.classList.add('border-gold', 'bg-paper-deep/70', 'ring-2', 'ring-gold/40');
        showPlateStatus('✦ DROP ILLUMINATION FILE TO INSCRIBE AS CODEX PLATE');
      });

      target.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'copy';
      });

      target.addEventListener('dragleave', function(e) {
        e.preventDefault();
        dragCounter--;
        if (dragCounter <= 0) {
          dragCounter = 0;
          editor.classList.remove('border-gold', 'bg-paper-deep/70', 'ring-2', 'ring-gold/40');
          hidePlateStatus();
        }
      });

      target.addEventListener('drop', function(e) {
        e.preventDefault();
        dragCounter = 0;
        editor.classList.remove('border-gold', 'bg-paper-deep/70', 'ring-2', 'ring-gold/40');
        hidePlateStatus();

        if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length > 0) {
          const files = e.dataTransfer.files;
          for (let i = 0; i < files.length; i++) {
            if (files[i].type.startsWith('image/')) {
              window.inscribePlateFile(files[i]);
              break; // Inscribe first valid image
            }
          }
        }
      });
    });

  });
})();
</script>
