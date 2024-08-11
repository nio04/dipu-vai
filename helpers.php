<?php

function loadView($view, $data = []) {
  extract($data);
  require_once __DIR__ . "/app/views/" . $view . ".php";
}


function timestamp() {
  return date('Y-m-d H:i:s');
}
