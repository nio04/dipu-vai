<?php

namespace App\Traits;

use App\Models\Blog;

trait BlogTraits {
  public $blog;
  public $getAllTheBlogs;

  public function __construct() {
    $this->blog = new Blog();
  }

  function appendAuthorToBlog($allBlogs) {
    // Prepare all blog IDs to get the author name
    $allBlogsId = [];

    foreach ($allBlogs as $value) {
      // Directly add the user_id to the array
      $allBlogsId[] = $value->user_id;
    }

    // get author name method
    $authorNames = $this->getBlogAuthorName($allBlogsId);

    // Loop through allBlogs and match user_id with authorNames
    foreach ($allBlogs as $blog) {
      foreach ($authorNames as $author) {
        if ($blog->user_id === $author->id) {
          // Add the matched author object to the current blog object
          $blog->author = $author;
          break; // Exit inner loop once match is found
        }
      }
    }

    return $allBlogs;
  }
  public function getBlogAuthorName($blog) {
    $authorNames = [];

    foreach ($blog as $value) {
      $authorNames[] = $this->blog->fetchAuthorName($value);
    }

    return $authorNames;
  }

  function getAllTheBlogs() {
    return $this->getAllTheBlogs = $this->blog->getAllBlogs();
  }
}
