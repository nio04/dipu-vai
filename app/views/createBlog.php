<?php loadPartials("header") ?>
<?php loadPartials("navDashboard") ?>

<!-- Sidebar and Main Container -->
<div class="flex w-full">
  <?php loadPartials("asideDashboard") ?>
  <main id="mainContent" class="w-4/5 p-6 transition-margin duration-300 ml-auto">
    <?php loadPartials("createBlog", ['categories' => $categories]) ?>
  </main>
</div>

<?php loadPartials("footer") ?>
