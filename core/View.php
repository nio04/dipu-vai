<?php

namespace Core;

class View {
  public function render($view, $data = []) {
    extract($data);
    include "../app/views/$view.php";
  }
}
