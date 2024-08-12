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
