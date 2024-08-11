<?php

namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller {
  public function index() {
    if (isset($_SESSION['user'])) {
      header('Location:/blogs');
    } else {
      $this->view->render('home', ['message' => 'Welcome to the Home Page!']);
    }
  }
}
