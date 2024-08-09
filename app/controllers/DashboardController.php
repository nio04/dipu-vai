<?php

namespace App\Controllers;

use Core\Controller;

class DashboardController extends Controller {
  public function index() {

    // Check if user is logged in
    if (!isset($_SESSION['user'])) {
      header('Location: /login');
      exit;
    }

    // Render the dashboard view
    $this->view->render('dashboard');
  }
}
