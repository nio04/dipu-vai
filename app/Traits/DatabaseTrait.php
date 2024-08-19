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
  /**
   * Perform a join operation between multiple tables.
   *
   * @param array $params Associative array of parameters:
   *   - 'tables' (array): List of tables to join, with the first table as the primary table.
   *   - 'joinConditions' (array): Conditions defining how to join the tables (e.g., 'blogs.user_id = users.id').
   *   - 'selectColumns' (array|string): Columns to select (default: '*').
   *   - 'whereConditions' (array): Optional. Conditions for the WHERE clause (default: []).
   *   - 'orderBy' (string): Optional. ORDER BY clause (default: '').
   *   - 'limit' (string): Optional. LIMIT clause (default: '').
   *
   * @return array Result set as an associative array.
   */
  public function joinQuery($params) {
    // Set default values for optional parameters
    $tables = $params['tables'] ?? [];
    $joinConditions = $params['joinConditions'] ?? [];
    $selectColumns = $params['selectColumns'] ?? '*';
    $whereConditions = $params['whereConditions'] ?? [];
    $orderBy = $params['orderBy'] ?? '';
    $limit = $params['limit'] ?? '';

    // Validate required parameters
    if (empty($tables) || empty($joinConditions)) {
      throw new \InvalidArgumentException('Tables and joinConditions are required parameters.');
    }

    // Build the SELECT clause
    $columns = is_array($selectColumns) ? implode(', ', $selectColumns) : $selectColumns;

    // Start building the SQL query
    $sql = "SELECT $columns FROM " . array_shift($tables);

    // Add join conditions
    foreach ($tables as $index => $table) {
      $sql .= " INNER JOIN $table ON " . $joinConditions[$index];
    }

    // Add WHERE conditions if provided
    if (!empty($whereConditions)) {
      $sql .= " WHERE " . implode(' AND ', $whereConditions);
    }

    // Add ORDER BY clause if provided
    if (!empty($orderBy)) {
      $sql .= " ORDER BY $orderBy";
    }

    // Add LIMIT clause if provided
    if (!empty($limit)) {
      $sql .= " LIMIT $limit";
    }

    // Prepare and execute the SQL statement
    $stmt = $this->getDb()->prepare($sql);
    $stmt->execute();

    // Return the results as an associative array
    return $stmt->fetchAll(PDO::FETCH_OBJ);
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
