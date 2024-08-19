<?php

namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller {
  public function index() {
    // header("location:/viewallblogs");

    if ($_SESSION['settings']['admin'] === true) {
      header('Location:/dashboard');
    } else {
      header('location:/viewallblogs');
    }
  }
}
