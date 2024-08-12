<?php

$tags = $post->tags;
$tags = explode(",", $tags);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog Post</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

  <div class="max-w-2xl mx-auto my-10 p-6 bg-white rounded-lg shadow-lg">

    <!-- Back to all blogs button -->
    <div class="mb-6">
      <a href="/blogs" class="text-blue-600 hover:underline">← Back to all blogs</a>
    </div>

    <!-- Blog Title -->
    <h1 class="text-3xl font-bold text-gray-800 mb-4"><?= $post->title ?></h1>

    <!-- Meta Information -->
    <p class="text-gray-600 text-sm mb-2">Created at: <span class="text-gray-800"><?= $post->created_at ?></span></p>

    <p class="text-gray-600 text-sm mb-2">Like Count: <span class="text-gray-800"><?= $post->like_count ?></span></p>

    <!-- Blog Description -->
    <div class="text-gray-700 leading-relaxed my-6">
      <?= $post->description ?>
    </div>

    <!-- Tags -->
    <div class="mb-6">
      <?php foreach ($tags as $tag): ?>
        <span class="inline-block bg-blue-200 text-blue-800 text-xs font-semibold rounded-full px-2 py-1 mr-2"><?= $tag ?></span>
      <?php endforeach; ?>
    </div>
  </div>

</body>

</html>
