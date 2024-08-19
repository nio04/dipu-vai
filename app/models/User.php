<?php

namespace App\Models;

use App\Traits\DatabaseTrait;

use PDO;

class User {
  use DatabaseTrait;

  public function __construct() {
    $this->connect();
  }

  public function getUserByEmail($email) {
    $data = ['emai' => $email];
    return $this->query("SELECT * FROM users WHERE email = :email", $data);
  }

  public function createUser($username, $email, $password) {
    $data = [
      "username" => $username,
      "email" => $email,
      "password" =>
      password_hash($password, PASSWORD_DEFAULT)
    ];

    return $this->query("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)", $data);
  }

  public function getUser($id) {
    $data = ['id' => (int) $id];

    return $this->query("SELECT * FROM users WHERE id = :id", $data,);
  }
}
