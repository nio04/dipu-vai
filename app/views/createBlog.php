<?php loadPartials("header") ?>
<?php loadPartials("navDashboard") ?>

<?php $errors = $errors ?? [] ?>
<?php $title = $title ?? "" ?>
<?php $description = $description ?? '' ?>
<?php $tags = $tags ?? "" ?>

<!-- Sidebar and Main Container -->
<div class="flex w-full">
  <?php loadPartials("asideDashboard") ?>
  <main id="mainContent" class="w-4/5 p-6 transition-margin duration-300 ml-auto">
    <?php loadPartials("createBlog", ['errors' => $errors, 'categories' => $categories, 'title' => $title, 'description' => $description, 'tags' => $tags]) ?>
  </main>
</div>

<?php loadPartials("footer") ?>
