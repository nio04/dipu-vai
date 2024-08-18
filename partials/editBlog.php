<!-- Container to center the form -->
<div class="mx-auto w-full max-w-lg mt-14">
  <!-- Button to go back to view all blogs -->
  <div class="mb-4">
    <a href="/blogs" class="text-blue-600 hover:underline">← Go back to view all blogs</a>
  </div>

  <div>
    <h2 class="text-left text-3xl mt-10 mb-2 font-bold">Edit the blog</h2>
  </div>

  <!-- Form -->
  <form action="/blogs/update" method="POST" class="bg-white p-6 rounded-lg shadow-lg space-y-8">
    <input type="hidden" name="id" value="<?= $blog->id ?>">
    <div class="mb-4">
      <label for="title" class="block text-gray-400">Title:</label>
      <input type="text" id="title" name="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="<?= $blog->title ?>">
    </div>
    <div class="mb-4">
      <label for="description" class="block text-gray-400">Description:</label>
      <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"><?= $blog->description ?></textarea>
    </div>
    <div class="mb-4">
      <label for="tags" class="block text-gray-400">Tags:</label>
      <input type="text" id="tags" name="tags" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="<?= $blog->tags ?>">
    </div>
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">Edit</button>
  </form>
</div>
