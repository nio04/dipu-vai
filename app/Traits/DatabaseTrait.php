<?php

namespace App\Traits;

use PDO;
use PDOException;
use Exception;
use App\Traits\DbConnectTrait;

trait DatabaseTrait {
  use DbConnectTrait;

  /**
   * Execute an SQL query with optional parameters.
   *
   * @param string $sql The SQL statement to be executed.
   * @param array $params Optional associative array of parameters to bind to the SQL placeholders.
   * @return mixed The result of the query execution:
   *               - An array of rows for SELECT queries.
   *               - The ID of the last inserted row for INSERT queries.
   *               - The number of affected rows for UPDATE or DELETE queries.
   *               - True for other successful queries.
   * @throws Exception if there is an error during query execution.
   */
  public function query(string $sql, array $params = []) {
    try {
      $stmt = $this->getDb()->prepare($sql);

      foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
      }

      $stmt->execute();

      $queryType = strtolower(explode(' ', trim($sql))[0]);

      if ($queryType === 'select') {
        return $stmt->fetchAll(PDO::FETCH_OBJ);
      } elseif ($queryType === 'insert') {
        return $this->getDb()->lastInsertId();
      } elseif ($queryType === 'update' || $queryType === 'delete') {
        return $stmt->rowCount();
      } else {
        return true;
      }
    } catch (PDOException $e) {
      throw new Exception("Database query error: " . $e->getMessage());
    }
  }

  function sort_asc() {
    return $this->getDb()->prepare("SELECT * FROM blogs ORDER BY title ASC");
  }

  function sort_desc() {
    return $this->getDb()->prepare("SELECT * FROM blogs ORDER BY title DESC");
  }

  // register blog_id, user_id to the table: likes.
  // for later checking if the current user liked the current blog post
  function likeBlogPost($data) {

    $stmt = $this->getDb()->prepare("INSERT INTO likes (user_id, blog_id) VALUES (:user_id, :blog_id)
                           ON DUPLICATE KEY UPDATE created_at = CURRENT_TIMESTAMP");

    foreach ($data as $placeholder => $value) {
      $stmt->bindValue(':' . $placeholder, $value);
    }

    return $stmt->execute() ? true : false;
  }
}
