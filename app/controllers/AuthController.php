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
      $username = $this->sanitizeInput($_POST['username']);
      $password = $this->sanitizeInput($_POST['password']);
      $additionlToken = $this->sanitizeInput($_POST['additional_token']);

      $isAdmin = $additionlToken === "1234" ? true : false;

      if ($isAdmin) {
        $_SESSION['settings']['admin'] = true;
      } else {
        $_SESSION['settings']['admin'] = false;
      }

      $empty = $this->checkEmpty([$username, $password]);

      if ($empty === true) {
        $authModel = new Auth();
        $user = $authModel->login($username, $password);
      } else {
        $this->view->render('login', ['error' => 'email or password can not be empty']);
        exit;
      }

      if ($user && $empty && $isAdmin) {
        $_SESSION['user'] = $user;
        $_SESSION['settings']['admin'] = true;
        // Redirect to home or dashboard
        header('Location: /dashboard');
        exit;
      } else if (!$user) {
        $this->view->render('login', ['error' => 'Invalid username or password.']);
        exit;
      } else if ($user && $empty && !$isAdmin) {
        $_SESSION['user'] = $user;
        $_SESSION['settings']['admin'] = false;
        // redirect the non admin to [not dashboard] page
        header("Location: /viewallposts");
      } else {
        // Render login page
        $this->view->render('login');
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
    unset($_SESSION['settings']['admin']);
    header('Location:/');
  }
}
