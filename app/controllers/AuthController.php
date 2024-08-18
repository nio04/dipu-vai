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
    // Render login page
    $this->view->render('login');
  }

  function submit() {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $additionlToken = $_POST['additional_token'];

    // sanitize
    list($username, $password, $additionlToken) = $this->sanitize([$username, $password, $additionlToken]);

    // check if admin
    $isAdmin = $additionlToken === "1234" ? true : false;

    if ($isAdmin) {
      $_SESSION['settings']['admin'] = true;
    } else {
      $_SESSION['settings']['admin'] = false;
    }

    // check if empty
    $requiredFields = ['username', 'password'];
    $empty = $this->isEmpty(['username' => $username, 'password' => $password], $requiredFields);

    if (is_array($empty) && isset($empty[0])) {
      return $this->view->render("login", ['errors' => $empty]);
    }

    // validate login data
    $validateResults = $this->validateField(['username' => ['data' => $username, 'validateMethod' => 'stringValidate', 'rules' => ['min_length' => 4, 'max_length' => 30]], 'password' => ['data' => $password, 'validateMethod' => 'passwordValidate']]);


    if (is_array($validateResults) && isset($validateResults[0])) {
      return $this->view->render('login', ['errors' => $validateResults]);
    } else {
      // Proceed with validated data
      $authModel = new Auth();
      $user = $authModel->login($username, $password);

      if ($user && $isAdmin) {
        // redirect to dashboard
        $_SESSION['user'] = $user;
        $_SESSION['settings']['admin'] = true;
        header('location: /dashboard');
      } else {
        // redirect to view all posts
        return header("location: /viewallposts");
      }
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
