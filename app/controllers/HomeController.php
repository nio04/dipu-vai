<?php

namespace App\Controllers;

use App\Traits\SessionTrait;
use Core\Controller;

class HomeController extends Controller {
  use SessionTrait;
  public function index() {
    // header("location:/viewallblogs");

    // if ($_SESSION['settings']['admin'] === true) {
    if ($this->getSession(['settings', 'admin']) === true) {
      header('Location:/dashboard');
    } else {
      header('location:/viewallblogs');
    }
  }
}
