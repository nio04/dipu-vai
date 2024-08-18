<?php loadPartials("header") ?>
<?php loadPartials("navDashboard") ?>


<!-- Sidebar and Main Container -->
<div class="flex w-full h-screen">
  <?php loadPartials("asideDashboard") ?>

  <!-- view & manage category -->
  <main id="mainContent" class="w-4/5 p-6 transition-margin duration-300 ml-auto">
    <!-- load all categories -->
    <?php loadPartials("categoriesDashboard", ['categories' => $categories]) ?>

    <!-- load  -->
  </main>
</div>

<?php loadPartials("footer") ?>
