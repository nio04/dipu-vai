<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <!-- Include TailwindCSS for styling -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <!-- Container to center the form -->
  <div class="w-full max-w-lg">
    <!-- Button to go back to view all blogs -->
    <div class="mb-4">
      <a href="/blogs" class="text-blue-600 hover:underline">← Go back to view all blogs</a>
    </div>

    <div>
      <h2 class="text-left text-3xl mt-10 mb-2 font-bold">Edit the blog</h2>
    </div>

    <!-- Form -->
    <form action="/blogs/update" method="POST" class="bg-white p-6 rounded-lg shadow-lg space-y-4">
      <input type="hidden" name="id" value="<?= $post->id ?>">
      <div class="mb-4">
        <label for="title" class="block text-gray-700">Title:</label>
        <input type="text" id="title" name="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="<?= $post->title ?>">
      </div>
      <div class="mb-4">
        <label for="description" class="block text-gray-700">Description:</label>
        <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"><?= $post->description ?></textarea>
      </div>
      <div class="mb-4">
        <label for="tags" class="block text-gray-700">Tags:</label>
        <input type="text" id="tags" name="tags" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="<?= $post->tags ?>">
      </div>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Edit</button>
    </form>
  </div>

</body>

</html>
