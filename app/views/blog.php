<?php

$tags = $blog[0]->tags;
$tags = explode(",", $tags);

if (isset($_SESSION['settings']['admin']) && $_SESSION['settings']['admin'] === true) {
  $goBackTo = '/blogs';
} else {
  $goBackTo = '/';
}

?>


<?php loadPartials('header') ?>

<div class="max-w-2xl mx-auto w-8/12 my-10 p-6 bg-white rounded-lg shadow-lg">
  <!-- Back to all blogs button -->
  <div class="mb-6">
    <a href="<?php echo $goBackTo ?>" class="text-blue-600 hover:underline">← Back to all blogs</a>
  </div>

  <!-- cover image -->
  <?php $cover_image = $blog[0]->image; ?>
  <?php if (strlen($cover_image) > 0): ?>
    <div class="relative h-80 my-12">
      <img class="absolute top-0 left-0 w-full h-full object-cover rounded-md" src="<?= loadImagePath("cover_images/") . $blog[0]->image ?>" alt="<?= $blog[0]->title ?>">
    </div>
  <?php else: ?>
    <div class="relative h-80 my-12">
      <img class="absolute top-0 left-0 w-full h-full object-cover rounded-md" src="<?= loadImagePath("cover_images/cover.jpg") ?>" alt="<?= $blog[0]->title ?>">
    </div>
  <?php endif ?>


  <!-- Blog Title -->
  <h1 class="text-3xl font-bold text-gray-800 mb-4"><?= $blog[0]->title ?></h1>

  <!-- Meta Information -->
  <p class="text-gray-500 text-sm mb-2">Created at: <span class="text-gray-500"><?= additionalDateFormatter($blog[0]->created_at)  ?></span> </p>
  <p class="text-gray-500 text-sm mb-2 -mt-2">Author name: <span class="text-gray-500"><?= $blog[0]->username ?></span> </p>

  <!-- Blog Description -->
  <div class="text-gray-700 leading-relaxed my-6">
    <?= $blog[0]->description ?>
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
      <a href="<?php echo $isLiked ? 'javascript:void(0);' : '/blogs/like/' . $blog[0]->id; ?>"
        class="inline-block px-4 py-2 text-sm font-medium text-white rounded-lg transition-colors duration-300 
   <?php echo $isLiked ? 'bg-green-500 cursor-not-allowed' : 'bg-gray-400 hover:bg-gray-500'; ?>"
        <?php echo $isLiked ? 'aria-disabled="true" tabindex="-1"' : ''; ?>>
        <?php echo $isLiked ? 'Liked' : 'Like'; ?>
      </a>

      <!-- make the link disable so when $isliked is true otherwise do not disable it -->
      <!-- Like Count -->
      <span class="text-lg font-semibold text-gray-700">
        <?php echo $blog[0]->like_count; ?> Like<?php echo $blog[0]->like_count == 1 ? '' : 's'; ?>
      </span>
    </div>

  <?php else: ?>
    <!-- Message for Non-Logged-In Users -->
    <p class="text-gray-700 text-xl font-semibold mt-16 mb-16">Please <a href="/login" class="text-blue-500 hover:underline">log in</a> to like the blog.</p>
  <?php endif; ?>


  <!-- check if user is logged in to render comment container or log message -->

  <?php if (isset($_SESSION['user'])): ?>
    <!-- Comment Container -->
    <form action="/blogs/createComment/<?php echo $blog[0]->id ?>" method="POST" class="mt-16 mb-16 p-4 bg-white rounded-lg shadow-lg flex flex-col">
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

<?php loadPartials("footer") ?>
