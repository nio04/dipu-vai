<?php

namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller {
  public function index() {
    // header("location:/viewallposts");

    if ($_SESSION['settings']['admin'] === true) {
      header('Location:/dashboard');
    } else {
      header('location:/viewallposts');
      $this->view->render('home', ['message' => 'Welcome to the Home Page!']);
    }
  }
}
