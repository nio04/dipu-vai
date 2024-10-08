<?php

namespace App\Models;

use App\Traits\DatabaseTrait;
use App\Traits\SessionTrait;

class Blog {
  use DatabaseTrait;
  use SessionTrait;

  public function __construct() {
    $this->connect(); // Initialize connection
  }

  private $db;

  function searchBlog($blogTitle) {
    $data = [
      'title' => "%$blogTitle%" // Correct wildcard placement
    ];

    // SQL query with corrected syntax
    return $this->query(
      'SELECT blogs.*, users.username 
        FROM blogs 
        INNER JOIN users ON blogs.user_id = users.id 
        WHERE blogs.title LIKE :title',
      $data
    );
  }


  function sortBy($inputSort) {
    if ($inputSort === "asc") {
      return $this->query('SELECT blogs.*, users.username FROM `blogs` INNER JOIN users ON blogs.user_id = users.id ORDER BY blogs.title ASC');
    } else {
      return $this->query('SELECT blogs.*, users.username FROM `blogs` INNER JOIN users ON blogs.user_id = users.id ORDER BY blogs.title DESC');
    }
  }

  public function getAllBlogs() {
    return $this->joinQuery([
      'tables' => ['blogs', 'users'],
      'joinConditions' => ['blogs.user_id = users.id'],
      'selectColumns' => ['blogs.*', 'users.username', 'users.email']
    ]);
  }

  public function getTheBlog($id) {
    $data = [
      'id' => $id
    ];
    return $this->query('SELECT * FROM blogs WHERE id = :id', $data);
  }

  public function fetchAuthorName($id) {
    $data = [
      'id' => $id
    ];

    return $this->query("SELECT username, id FROM users WHERE id = :id", $data);
  }

  function registerLike($blog_id, $user_id) {
    $data = [
      'user_id' => $user_id,
      'blog_id' => $blog_id
    ];

    echo ("<pre>");
    var_dump($data);
    echo ("</pre>");


    // ///////////
    // CHECK
    ///////////
    return $this->likeBlogPost($data);
  }

  function checkLiked($blog_id, $user_id) {
    $data = [
      'blog_id' => $blog_id,
      'user_id' => $user_id
    ];

    return $this->query("SELECT id FROM likes WHERE user_id = :user_id AND blog_id = :blog_id", $data);
  }

  function getLikeCountForTheBlog($id) {
    $data = [
      'id' => (int) $id
    ];

    return $this->query('SELECT like_count from blogs WHERE id = :id', $data);
  }

  public function likeCountIncreament($id, $count) {
    $data = ['id' =>  (int) $id, 'like_count' => (int) $count];
    return $this->query("UPDATE blogs SET like_count = :like_count WHERE id = :id", $data);
  }

  public function loadCommentForBlog($id) {
    $data = [
      'blog_id' => $id,
    ];

    return $this->query("SELECT * FROM comments WHERE blog_id = :blog_id", $data);
  }

  public function createCommnentForBlog($id, $comment) {

    $data = [
      'user_id' => $this->getSession(['user', 'id']),
      "blog_id" => (int) $id,
      "comment" => $comment
    ];

    return $this->query("INSERT INTO comments (user_id, blog_id, comment) VALUES (:user_id, :blog_id, :comment)", $data);
  }

  function insertBlogData($data) {
    return $this->query("INSERT INTO blogs (user_id, title, description, tags, created_at, category, image) VALUES (:user_id, :title, :description, :tags, :created_at, :category, :image)", $data);
  }

  function deleteTheBlog($id) {
    $data = [
      'id' => $id
    ];
    return $this->query('DELETE FROM blogs WHERE id = :id', $data);
  }

  function update($id, $title, $description, $tags) {

    $data = [
      'id' =>  (int) $id,
      'title' => $title,
      "description" => $description,
      "tags" => $tags,
    ];

    $this->query("UPDATE blogs SET title = :title, description = :description, tags = :tags WHERE id = :id", $data);
  }

  function handleFileUpload($file, $targetDir, $allowedTypes = ['jpg', 'jpeg', 'png', 'gif']) {
    // Sanitize file name
    $fileName = basename($file['name']);

    // Define the target file path
    $targetFile = $targetDir . $fileName;

    // Check file type extension
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Validate file type
    if (in_array($fileType, $allowedTypes)) {
      // Move file to the target directory
      if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        // File upload successful
        return [
          'success' => true,
          'file_path' => $targetFile
        ];
      } else {
        // File upload failed
        return [
          'success' => false,
          'error' => 'Failed to move uploaded file.'
        ];
      }
    } else {
      // Invalid file type
      return [
        'success' => false,
        'error' => 'Invalid file type. Allowed types are: ' . implode(', ', $allowedTypes)
      ];
    }
  }
}
