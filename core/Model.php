<?php

namespace Core;

use PDO;

class Model {
  protected $db;

  public function __construct() {
    $this->db = new PDO('mysql:host=localhost;dbname=dipu_vai', 'nishat', '1234', [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]);
  }

  /**
   * execute any types of query 
   * @param string $sql sql statement
   * @param array $data pass data as associative array
   * @param string $fetch support (all, single, none) all- return all the data, single- return single data, none- return no data
   * @return mixed
   */
  public function query($sql, $data = [], $fetch = 'none') {
    $stmt = $this->db->prepare($sql);

    foreach ($data as $placeholder => $value) {
      $stmt->bindValue(':' . $placeholder, $value);
    }

    $stmt->execute();

    if ($fetch === "all") {
      return $stmt->fetchAll();
    } else if ($fetch === "single") {
      return $stmt->fetch();
    } else {
      return $stmt->rowCount();
    }
  }

  function likeBlogPost($data) {

    $stmt = $this->db->prepare("INSERT INTO likes (user_id, blog_id) VALUES (:user_id, :blog_id)
                           ON DUPLICATE KEY UPDATE created_at = CURRENT_TIMESTAMP");

    foreach ($data as $placeholder => $value) {
      $stmt->bindValue(':' . $placeholder, $value);
    }

    // $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    // $stmt->bindValue(':blog_id', $blogId, PDO::PARAM_INT);

    return $stmt->execute() ? true : false;
  }
}
