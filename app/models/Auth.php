<?php

namespace App\Models;

use App\Traits\DatabaseTrait;

class Auth {
  use DatabaseTrait;

  public function __construct() {
    $this->connect();
  }

  public function login($username, $password) {

    $data = [
      "username" => $username,
    ];
    $user = $this->query("SELECT * FROM users WHERE username = :username", $data);

    // Check if user exists and verify password
    if ($user && password_verify($password, $user[0]->password)) {
      // Return user data if password matches
      return $user;
    } else {
      // Return false if password does not match or user does not exist
      return false;
    }
  }

  public function register($username, $email, $password) {
    $data = [
      'username' => $username,
      'email' => $email,
      'password' => password_hash($password, PASSWORD_BCRYPT),
    ];

    // Prepare and execute the SQL query
    return $this->query("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)", $data);
  }

  public function isEmailAndUsernameInUse($email, $username) {
    $data = [
      "email" => $email,
      'username' => $username
    ];
    return $this->query("SELECT email, username FROM users WHERE email = :email OR username = :username", $data);
  }
}
