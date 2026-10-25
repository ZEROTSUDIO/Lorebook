<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * LOREKEEPER // GLOBAL CODEX ILLUMINATION LIGHTBOX & ARCHIVAL TOAST
 * Zerotsudios Neobrutalist Grimoire Engine
 */
?>
<!-- FULL-RESOLUTION ILLUMINATION LIGHTBOX MODAL -->
<div id="portrait-lightbox-modal" class="fixed inset-0 bg-black/85 backdrop-blur-sm z-50 hidden flex flex-col items-center justify-center p-4" onclick="closeLightbox(event)">
  <div class="relative max-w-4xl max-h-[90vh] bg-paper-ink border-2 border-gold shadow-ink p-2 flex flex-col w-full sm:w-auto" onclick="event.stopPropagation()">
    
    <!-- Lightbox Mechanical Titlebar -->
    <div class="flex items-center justify-between border-b border-paper-line bg-paper-panel px-3 py-1.5 mb-2 font-mono text-xs">
      <div class="flex items-center gap-2 text-gold">
        <span class="w-2 h-2 bg-gold rotate-45"></span>
        <span id="lightbox-title" class="font-bold tracking-wider uppercase">ARCHIVAL ILLUMINATION</span>
      </div>
      <button type="button" onclick="closeLightbox()" class="text-ash hover:text-gold text-xs font-mono uppercase font-bold px-2 py-0.5 border border-paper-line bg-paper-base transition">
        ✕ CLOSE [ESC]
      </button>
    </div>

    <!-- Full Image Container with Antique Gold Corner Accents -->
    <div class="overflow-auto flex items-center justify-center max-h-[80vh] p-2 bg-paper-deep relative">
      <img id="lightbox-img" src="" alt="Enlarged Illumination Plate" class="max-w-full max-h-[76vh] object-contain border border-paper-line/50 shadow-ink-sm">
    </div>

  </div>
</div>

<script>
// Global Lightbox Handlers
function openLightbox(src, title) {
  if (!src) return;
  const modal = document.getElementById('portrait-lightbox-modal');
  const img = document.getElementById('lightbox-img');
  const titleEl = document.getElementById('lightbox-title');
  if (img) img.src = src;
  if (titleEl) {
    titleEl.textContent = title ? ('ILLUMINATION // ' + title.toUpperCase()) : 'ARCHIVAL ILLUMINATION';
  }
  if (modal) {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }
}

function closeLightbox(e) {
  const modal = document.getElementById('portrait-lightbox-modal');
  if (modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
}

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeLightbox();
  }
});

// Global Archival Toast System
function showArchivalToast(msg, isSuccess = true) {
  const existing = document.getElementById('codex-archival-toast');
  if (existing) existing.remove();

  const toast = document.createElement('div');
  toast.id = 'codex-archival-toast';
  toast.className = 'fixed bottom-5 right-5 z-50 bg-paper-ink border-2 ' + 
                    (isSuccess ? 'border-gold text-gold' : 'border-crimson text-crimson') + 
                    ' shadow-ink p-3 font-mono text-xs flex items-center gap-2 animate-bounce-subtle';
  toast.innerHTML = '<span class="w-2 h-2 ' + (isSuccess ? 'bg-gold' : 'bg-crimson') + ' rotate-45"></span><span>' + msg + '</span>';
  document.body.appendChild(toast);
  setTimeout(() => {
    if (toast) toast.remove();
  }, 4000);
}
</script>
