<?php

namespace App\Models;

use Core\Model;
use PDO;

class User extends Model {
  public $db;

  public function getUserByEmail($email) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function createUser($username, $email, $password) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    return $stmt->execute();
  }

  public function getUser($id) {
    $this->db = new Model();
    $data = ['id' => $id];

    return $this->db->query("SELECT username, id FROM users WHERE id = :id", $data, "single");

    echo ("<pre>");
    // var_dump($t);
    echo ("</pre>");
  }
}
