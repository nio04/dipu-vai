<?php

namespace App\Models;

use Core\Model;
use PDO;

class Blog {
  private $db;

  public function __construct() {
    $this->db = new Model();
  }

  public function getAllBlogs() {
    return $this->db->query("SELECT * from blogs", [], 'all');
  }
}
