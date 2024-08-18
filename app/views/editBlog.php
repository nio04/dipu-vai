<?php loadPartials("header") ?>

<?php $errors = $errors ?? [] ?>

<?php loadPartials("editBlog", ['errors' => $errors,  'id' => $id, 'title' => $title, 'description' => 'description', 'tags' => 'tags']) ?>

<?php loadPartials("footer") ?>
