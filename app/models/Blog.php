<?php

namespace App\Models;

use Core\Model;
use PDO;

class Blog {
  private $db;

  public function __construct() {
    $this->db = new Model();
  }

  function searchBlog($blogTitle) {
    $data = [
      "title" => "%" . $blogTitle . "%",
    ];

    return $this->db->query("SELECT * FROM blogs WHERE title LIKE :title", $data, 'all');
  }

  function sortBy($inputSort) {
    if ($inputSort === "asc") {
      return $this->db->sort_asc();
    } else {
      return $this->db->sort_desc();
    }
  }

  public function getAllBlogs() {
    return $this->db->query("SELECT * from blogs", [], 'all');
  }

  public function getTheBlog($id) {
    $data = [
      'id' => $id
    ];
    return $this->db->query('SELECT * FROM blogs WHERE id = :id', $data, 'single');
  }

  public function fetchAuthorName($id) {
    $data = [
      'id' => $id
    ];

    return $this->db->query("SELECT username, id FROM users WHERE id = :id", $data, "single");
  }

  function registerLike($blog_id, $user_id) {
    $data = [
      'user_id' => $user_id,
      'blog_id' => $blog_id
    ];

    return $this->db->likeBlogPost($data);
  }

  function checkLiked($blog_id, $user_id) {
    $data = [
      'blog_id' => $blog_id,
      'user_id' => $user_id
    ];

    return $this->db->query("SELECT id FROM likes WHERE user_id = :user_id AND blog_id = :blog_id", $data, "single");
  }

  function getLikeCountForTheBlog($id) {
    $data = [
      'id' => $id
    ];

    return $this->db->query('SELECT like_count from blogs WHERE id = :id', $data, 'single');
  }

  public function likeCountIncreament($id, $count) {
    $data = ['id' => $id, 'like_count' => (int) $count];
    return $this->db->query("UPDATE blogs SET like_count = :like_count WHERE id = :id", $data);
  }

  public function loadCommentForBlog($id) {
    $data = [
      'blog_id' => $id,
    ];

    return $this->db->query("SELECT * FROM comments WHERE blog_id = :blog_id", $data, "all");
  }

  public function createCommnentForBlog($id, $comment) {

    $data = [
      'user_id' => $_SESSION['user']['id'],
      "blog_id" => $id,
      "comment" => $comment
    ];

    return $this->db->query("INSERT INTO comments (user_id, blog_id, comment) VALUES (:user_id, :blog_id, :comment)", $data);
  }

  function deleteTheBlog($id) {
    $data = [
      'id' => $id
    ];
    return $this->db->query('DELETE FROM blogs WHERE id = :id', $data);
  }

  function update($data) {

    $data = [
      'id' => (int) $_POST['id'],
      'title' => $_POST['title'],
      "description" => $_POST["description"],
      "tags" => $_POST["tags"],
    ];

    echo ("<pre>");
    var_dump($data);
    echo ("</pre>");

    $this->db->query("UPDATE blogs SET title = :title, description = :description, tags = :tags WHERE id = :id", $data);
  }

  // function findCategory($id) {

  //   $data = [
  //     'searchValue' => $id[0]
  //   ];

  //   return $this->db->query("SELECT * FROM blogs WHERE FIND_IN_SET(:searchValue, category) > 0", $data, "all");
  // }
}
