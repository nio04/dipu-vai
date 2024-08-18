<?php

namespace App\Controllers;

use App\Models\User;
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
      } else if ($user && !$isAdmin) {
        $_SESSION['user'] = $user;
        $_SESSION['settings']['admin'] = false;
        // redirect to view all posts
        return header("location: /viewallposts");
      } else {
        $this->view->render("login", ['errors' => ['invalid username or password']]);
      }
    }
  }

  function registerLoadView() {
    $this->view->render('register');
  }

  public function registerSubmit() {
    // Handle registration form submission
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // sanitize
    list($username, $email, $password) = $this->sanitize([$username, $email, $password]);

    // check if empty
    $requiredFields = ['username', 'email', 'password'];
    $empty = $this->isEmpty(['username' => $username, 'email' => $email, 'password' => $password], $requiredFields);

    if (is_array($empty) && isset($empty[0])) {
      // header('location:/register/load');
      return $this->view->render("register", ['errors' => $empty]);
    }

    // validate register data
    $validateResults = $this->validateField(['username' => ['data' => $username, 'validateMethod' => 'stringValidate', 'rules' => ['min_length' => 4, 'max_length' => 30]], 'email' => ['data' => $email, 'validateMethod' => 'emailValidate'], 'password' => ['data' => $password, 'validateMethod' => 'passwordValidate', 'rules' => ['min_length' => 4, 'max_length' => 30]]]);

    if (is_array($validateResults) && isset($validateResults[0])) {
      // invalid data
      return $this->view->render('register', ['errors' => $validateResults]);
    } else {
      // no invalid data
      $authModel = new Auth();
      $checkIfAlreadyInUse = $authModel->isEmailAndUsernameInUse($email, $username);

      if ($checkIfAlreadyInUse) {
        $this->view->render("register", ["errors" => ['email or username already in use']]);
      } else {
        $userModel = new Auth();
        $userModel = $userModel->register($username, $email, $password);

        // get user object
        $userData = new User();
        $userData = $userData->getUser($userModel);

        $_SESSION['user'] = [
          'id' => $userData->id,
          'email' => $userData->email,
          'username' => $userData->username
        ];

        header('location: /viewallposts');
      }
    }
  }
  function logout() {
    unset($_SESSION['user']);
    unset($_SESSION['settings']['admin']);
    header('Location: /');
  }
}
