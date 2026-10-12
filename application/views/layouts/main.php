<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Master Grimoire Layout
 * Reusable layout wrapper porting the exact design system from mockup-zerostudios.html
 */

// 1. Head (meta, fonts, Tailwind CDN, grimoire textures)
$this->load->view('partials/head', $data ?? get_defined_vars());

// 2. Top Mechanical Telemetry Bar
$this->load->view('partials/topbar', $data ?? get_defined_vars());
?>

<!-- MAIN WRAPPER CONTAINER -->
<div class="max-w-7xl mx-auto p-4 sm:p-8 lg:p-10 flex flex-col gap-8 flex-1 w-full">
  <?php 
  // 3. Header Heraldry & Navigation Tabs
  $this->load->view('partials/header', $data ?? get_defined_vars()); 
  ?>

  <!-- 4. DYNAMIC VIEW CONTENT SLOT -->
  <main class="w-full">
    <?php 
    if (isset($content_view)) {
        $this->load->view($content_view, $data ?? get_defined_vars());
    } elseif (isset($content)) {
        echo $content;
    }
    ?>
  </main>
</div>

<?php
// 5. Archival Footer & Scripts
$this->load->view('partials/footer', $data ?? get_defined_vars());
?>
