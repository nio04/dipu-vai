<?php loadPartials("header") ?>
<?php loadPartials("navDashboard") ?>

<?php $errors = $errors ?? [] ?>
<?php $category = $category ?? [] ?>
<!-- Sidebar and Main Container -->
<div class="flex w-full">
  <?php loadPartials("asideDashboard") ?>
  <main id="mainContent" class="w-4/5 p-6 transition-margin duration-300 ml-auto">
    <?php loadPartials("editCategory", ["errors" => $errors, 'category' => $category]) ?>
  </main>
</div>

<?php loadPartials("footer") ?>
