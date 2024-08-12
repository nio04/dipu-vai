<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Auth;
use App\Traits\ValidationTrait;

class AuthController extends Controller {
  use ValidationTrait;

  public function index() {
    $this->view->render('login');
  }

  public function login() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Handle login form submission
      $username = $_POST['username'];
      $password = $_POST['password'];

      $authModel = new Auth();
      $user = $authModel->login($username, $password);

      if ($user) {
        $_SESSION['user'] = $user;
        // Redirect to home or dashboard
        header('Location: /dashboard');
        exit;
      } else {
        $this->view->render('login', ['error' => 'Invalid username or password.']);
      }
    } else {
      // Render login page
      $this->view->render('login');
    }
  }

  public function register() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Handle registration form submission
      $username = $_POST['username'];
      $email = $_POST['email'];
      $password = $_POST['password'];

      // Validate user input
      if (!$this->validateRequiredFields($_POST, ['username', 'email', 'password'])) {
        $this->view->render('register', ['error' => 'All fields are required.']);
        return;
      }

      if (!$this->validateUsername($username)) {
        $this->view->render('register', ['error' => 'Invalid username.']);
        return;
      }

      if (!$this->validateEmail($email)) {
        $this->view->render('register', ['error' => 'Invalid email format.']);
        return;
      }

      // if (!$this->validatePassword($password)) {
      //   $this->view->render('register', ['error' => 'Password must be at least 8 characters long and include a number and special character.']);
      //   return;
      // }

      $authModel = new Auth();

      if ($authModel->isEmailInUse($email)) {
        $this->view->render('register', [
          'error' => 'Email already in use. Please choose a different email.'
        ]);
      } else {
        $success = $authModel->register($username, $email, $password);

        if ($success) {
          header('Location: /login');
          exit;
        } else {
          $this->view->render('register', ['error' => 'Registration failed.']);
        }
      }
    } else {
      // Render registration page
      $this->view->render('register');
    }
  }

  function logout() {
    unset($_SESSION['user']);
    header('Location:/');
  }
}
