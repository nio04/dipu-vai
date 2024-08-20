<?php loadPartials("header") ?>
<?php loadPartials("navDashboard", ["showCreatePostBtn" => $showCreatePostBtn, 'showUserName' => $showUserName]) ?>

<!-- Sidebar and Main Container -->
<div class="flex w-full h-screen">
  <?php loadPartials("asideDashboard") ?>
  <main id="mainContent" class="w-4/5 p-6 transition-margin duration-300 ml-auto">
    <?php loadPartials("mainDashboard", ['blogs' => $blogs]) ?>
  </main>
</div>

<?php loadPartials("footer") ?>
