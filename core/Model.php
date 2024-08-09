<?php

namespace Core;

use PDO;

class Model {
  protected $db;

  public function __construct() {
    $this->db = new PDO('mysql:host=localhost;dbname=dipu_vai', 'nishat', '1234');
  }
}
