<?php

namespace App\Models;

use Core\Model;
use PDO;

class Blog {
  private $db;

  public function __construct() {
    $this->db = new Model();
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

  public function updateLike($data) {
    return $this->db->query("UPDATE blogs SET like_count = :like_count, user_id = :user_id WHERE id = :id", $data);
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
}
