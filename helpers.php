<?php

function basePath($path) {
  return __DIR__ . '/public/' . $path;
}

function loadImagePath($path) {
  return "/uploads/blogs/" . $path;
}

function loadView($view, $data = []) {
  extract($data);
  require_once __DIR__ . "/app/views/" . $view . ".php";
}

function timestamp() {
  return date('Y-m-d H:i:s');
}


// simple date formatter (Auguest 12, 2024)
function simpleFormatDate($dateInput) {
  // Create a DateTime object from the provided datetime string
  $date = new DateTime($dateInput);

  // Format the date as "Month Day, Year"
  return $date->format('F j, Y');
}

// additional date formatter (Auguest 12, 2024. [HOUR : MINUTE (AM|PM)])
function additionalDateFormatter($dateInput) {
  // Create a DateTime object from the provided datetime string
  $date = new DateTime($dateInput);

  // Format the date and time as "Month Day, Year hour:minute AM/PM"
  return $date->format('F j, Y g:i a');
}
