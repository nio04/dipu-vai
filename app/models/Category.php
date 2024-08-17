<?php

namespace App\Models;

use COre\Model;

class Category {
  private $db;

  public function __construct() {
    $this->db = new Model();
  }

  function getCategoryTitles() {
    return $this->db->query("SELECT * FROM category", [], "all");
  }

  function checkExistCategory($title) {
    $data = [
      "title" => $title,
    ];
    return $this->db->query("SELECT * FROM category WHERE title = :title", $data, 'single');
  }

  function getCategoryDetail($id) {
    $data = [
      'id' => (int) $id
    ];

    return $this->db->query("SELECT * FROM category where id = :id", $data, 'single');
  }

  function insertCategory($title) {
    $data = [
      "title" => $title,
    ];
    return $this->db->query("INSERT INTO category (title) VALUES (:title)", $data);
  }

  function edit($id, $title) {
    $data = [
      'title' => $title,
      'id' => (int) $id
    ];

    return $this->db->query("UPDATE category SET title = :title WHERE id = :id", $data);
  }


  function deleteCategory($id) {
    $data = [
      "id" => $id
    ];
    return $this->db->query("DELETE FROM category WHERE id = :id", $data);
  }
}
