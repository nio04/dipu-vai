<?php

namespace App\Models;

use App\Traits\DatabaseTrait;

class Category {
  use DatabaseTrait;

  public function __construct() {
    $this->connect();
  }
  function getCategoryTitles() {
    return $this->query("SELECT * FROM category", [],);
  }

  function checkExistCategory($title) {
    $data = [
      "title" => $title,
    ];
    return $this->query("SELECT title FROM category WHERE title = :title", $data);
  }

  function getCategoryDetail($id) {
    $data = [
      'id' => (int) $id
    ];

    return $this->query("SELECT * FROM category where id = :id", $data);
  }

  function insertCategory($title) {
    $data = [
      "title" => $title,
    ];
    return $this->query("INSERT INTO category (title) VALUES (:title)", $data);
  }

  function edit($id, $title) {
    $data = [
      'title' => $title,
      'id' => (int) $id
    ];

    return $this->query("UPDATE category SET title = :title WHERE id = :id", $data);
  }


  function deleteCategory($id) {
    $data = [
      "id" => $id
    ];
    return $this->query("DELETE FROM category WHERE id = :id", $data);
  }

  function updateCategory($id, $title) {
    $data = [
      "title" => $title,
      'id' => (int) $id
    ];

    return $this->query("UPDATE category SET title = :title WHERE id = :id", $data);
  }
}
