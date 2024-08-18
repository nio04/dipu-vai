<?php

namespace App\Models;

use Core\Model;
use PDO;

class Auth extends Model {

  public function login($username, $password) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user exists and verify password
    if ($user && password_verify($password, $user['password'])) {
      // Return user data if password matches
      return $user;
    } else {
      // Return false if password does not match or user does not exist
      return false;
    }
  }

  public function register($username, $email, $password) {
    // Prepare and execute the SQL query
    $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $password = password_hash($password, PASSWORD_BCRYPT);
    $stmt->execute();
    return $this->db->lastInsertId();
  }

  public function isEmailAndUsernameInUse($email, $username) {
    $stmt = $this->db->prepare("SELECT email, username FROM users WHERE email = :email AND username = :username");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
  }
}
