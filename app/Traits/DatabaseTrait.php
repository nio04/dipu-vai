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
   * **Usage:**
   * ```php
   * $sql = "SELECT * FROM users WHERE id = :id";
   * $params = ['id' => 1];
   * $result = $this->query($sql, $params);
   * // Output: Array of rows matching the query.
   * ```
   *
   * @param string $sql The SQL statement to be executed.
   * @param array $params Optional associative array of parameters to bind to the SQL placeholders.
   *                      Example: ['id' => 1, 'username' => 'john_doe']
   *                      - 'id' is the placeholder in the SQL query, and 1 is the value to bind.
   *                      - 'username' is another placeholder, and 'john_doe' is the value to bind.
   * @return mixed The result of the query execution:
   *               - An array of rows for SELECT queries.
   *               - The ID of the last inserted row for INSERT queries.
   *               - The number of affected rows for UPDATE or DELETE queries.
   *               - True for other successful queries.
   * @throws Exception if there is an error during query execution.
   *
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
   * **Usage:**
   * ```php
   * $params = [
   *     'tables' => ['users', 'posts'],
   *     'joinConditions' => ['users.id = posts.user_id'],
   *     'selectColumns' => ['users.username', 'posts.title'],
   *     'whereConditions' => ['posts.status = 1'],
   *     'orderBy' => 'posts.created_at DESC',
   *     'limit' => '10'
   * ];
   * $result = $this->joinQuery($params);
   * // Output: Array of joined rows matching the query.
   * ```
   *
   * @param array $params Associative array of parameters:
   *   - 'tables' (array): List of tables to join, with the first table as the primary table.
   *                       Example: ['users', 'posts']
   *   - 'joinConditions' (array): Conditions defining how to join the tables (e.g., 'users.id = posts.user_id').
   *                               Example: ['users.id = posts.user_id']
   *   - 'selectColumns' (array|string): Columns to select (default: '*').
   *                                     Example: ['users.username', 'posts.title']
   *   - 'whereConditions' (array): Optional. Conditions for the WHERE clause (default: []).
   *                                Example: ['posts.status = 1']
   *   - 'orderBy' (string): Optional. ORDER BY clause (default: '').
   *                         Example: 'posts.created_at DESC'
   *   - 'limit' (string): Optional. LIMIT clause (default: '').
   *                       Example: '10'
   *
   * @return array Result set as an associative array.
   *
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

  /**
   * Sort the 'blogs' table in ascending order by the title.
   *
   *
   * **Usage:**
   * ```php
   * $stmt = $this->sort_asc();
   * $stmt->execute();
   * $results = $stmt->fetchAll(PDO::FETCH_OBJ);
   * // Output: Array of blog posts sorted in ascending order by title.
   * ```
   */
  function sort_asc() {
    return $this->getDb()->prepare("SELECT * FROM blogs ORDER BY title ASC");
  }

  /**
   * Sort the 'blogs' table in descending order by the title.
   *
   *
   * **Usage:**
   * ```php
   * $stmt = $this->sort_desc();
   * $stmt->execute();
   * $results = $stmt->fetchAll(PDO::FETCH_OBJ);
   * // Output: Array of blog posts sorted in descending order by title.
   * ```
   */
  function sort_desc() {
    return $this->getDb()->prepare("SELECT * FROM blogs ORDER BY title DESC");
  }

  /**
   * Register a like for a blog post by a user.
   *
   * @param array $data Associative array containing:
   *   - 'user_id' (int): The ID of the user liking the post.
   *   - 'blog_id' (int): The ID of the blog post being liked.
   *
   * @return bool True on success, false on failure.
   *
   * **Usage:**
   * ```php
   * $data = ['user_id' => 1, 'blog_id' => 42];
   * $success = $this->likeBlogPost($data);
   * // Output: true if the like was successfully registered, false otherwise.
   * ```
   */
  function likeBlogPost($data) {
    $stmt = $this->getDb()->prepare("INSERT INTO likes (user_id, blog_id) VALUES (:user_id, :blog_id)
                           ON DUPLICATE KEY UPDATE created_at = CURRENT_TIMESTAMP");

    foreach ($data as $placeholder => $value) {
      $stmt->bindValue(':' . $placeholder, $value);
    }

    return $stmt->execute() ? true : false;
  }
}
