<?php

namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller {
  public function index() {
    header("location:/viewallposts");

    // if (isset($_SESSION['user'])) {
    //   header('Location:/blogs');
    // } else {
    //   $this->view->render('home', ['message' => 'Welcome to the Home Page!']);
    // }
  }
}
