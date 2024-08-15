<?php

$tags = $blog->tags;
$tags = explode(",", $tags);

if (isset($_SESSION['settings']['admin']) && $_SESSION['settings']['admin'] === true) {
  $goBackTo = '/blogs';
} else {
  $goBackTo = '/';
}

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
      <a href="<?php echo $goBackTo ?>" class="text-blue-600 hover:underline">← Back to all blogs</a>
    </div>

    <!-- cover image -->
    <div class="object-cover h-80 my-12 ">
      <img class="h-full w-full rounded-md" src="<?= loadImagePath("cover_images/") . $blog->image ?>" alt="<?= $blog->title ?>">
    </div>

    <!-- Blog Title -->
    <h1 class="text-3xl font-bold text-gray-800 mb-4"><?= $blog->title ?></h1>

    <!-- Meta Information -->
    <p class="text-gray-500 text-sm mb-2">Created at: <span class="text-gray-500"><?= additionalDateFormatter($blog->created_at)  ?></span> </p>
    <p class="text-gray-500 text-sm mb-2 -mt-2">Author name: <span class="text-gray-500"><?= $blog->author->username ?></span> </p>

    <!-- Blog Description -->
    <div class="text-gray-700 leading-relaxed my-6">
      <?= $blog->description ?>
    </div>

    <!-- Tags -->
    <div class="mb-6">
      <p class="inline text-gray-500">tags: </p>
      <?php foreach ($tags as $tag): ?>
        <span class="inline-block bg-blue-200 text-blue-800 text-xs font-semibold rounded-full px-2 py-1 mr-2"><?= $tag ?></span>
      <?php endforeach; ?>
    </div>

    <?php
    // $isLiked = $blog->user_id === $_SESSION['user']['id'] ? true : false;
    $isLiked = $already_liked;
    ?>

    <?php if (isset($_SESSION['user'])): ?>
      <!-- like container -->
      <div class="flex items-center space-x-2 mt-8">
        <a href="<?php echo $isLiked ? 'javascript:void(0);' : '/blogs/like/' . $blog->id; ?>"
          class="inline-block px-4 py-2 text-sm font-medium text-white rounded-lg transition-colors duration-300 
   <?php echo $isLiked ? 'bg-green-500 cursor-not-allowed' : 'bg-gray-400 hover:bg-gray-500'; ?>"
          <?php echo $isLiked ? 'aria-disabled="true" tabindex="-1"' : ''; ?>>
          <?php echo $isLiked ? 'Liked' : 'Like'; ?>
        </a>

        <!-- make the link disable so when $isliked is true otherwise do not disable it -->
        <!-- Like Count -->
        <span class="text-lg font-semibold text-gray-700">
          <?php echo $blog->like_count; ?> Like<?php echo $blog->like_count == 1 ? '' : 's'; ?>
        </span>
      </div>

    <?php else: ?>
      <!-- Message for Non-Logged-In Users -->
      <p class="text-gray-700 text-xl font-semibold mt-16 mb-16">Please <a href="/login" class="text-blue-500 hover:underline">log in</a> to like the blog.</p>
    <?php endif; ?>


    <!-- check if user is logged in to render comment container or log message -->

    <?php if (isset($_SESSION['user'])): ?>
      <!-- Comment Container -->
      <form action="/blogs/createComment/<?php echo $blog->id ?>" method="POST" class="mt-16 mb-16 p-4 bg-white rounded-lg shadow-lg flex flex-col">
        <!-- Write Comment Section -->
        <h4 class="text-xl font-semibold text-gray-800 mb-4">Write Comment</h4>

        <!-- Comment Textarea -->
        <textarea
          class="w-full p-3 text-gray-800 bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500"
          rows="5"
          placeholder="Add your comment..." name="comment"></textarea>

        <!-- Add Comment Button -->
        <button class="mt-4 px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-green-600">
          Add Comment
        </button>
      </form>
    <?php else: ?>
      <!-- Message for Non-Logged-In Users -->
      <p class="text-gray-700 text-xl font-semibold mt-16 mb-16">Please <a href="/login" class="text-blue-500 hover:underline">log in</a> to add a comment.</p>
    <?php endif; ?>


    <!-- Existing Comments Section -->
    <div class="mt-8 p-4 bg-white rounded-lg shadow-lg">
      <h4 class="text-xl font-semibold text-gray-800 mb-4">Comments</h4>

      <?php if (empty($comments)): ?>
        <!-- No Comments Found -->
        <p class="text-gray-600 italic">No comment was found for this blog post.</p>
      <?php else: ?>
        <!-- List of Comments -->
        <ul class="space-y-4">
          <?php foreach ($comments as $comment): ?>
            <li class="p-4 bg-gray-100 rounded-lg flex flex-col">
              <p class="text-gray-500 font-bold"><?php echo htmlspecialchars($comment['user']->username); ?></p>
              <p class="text-gray-800 font-semibold"><?php echo htmlspecialchars($comment['comment']->comment); ?></p>
              <p class="text-gray-700 mt-2 ml-auto"><?php echo htmlspecialchars($comment['comment']->created_at); ?></p>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>


  </div>


</body>

</html>
