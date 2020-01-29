<?php
$cleanedInputs = array();
function sanitizeString($key, $value){
  if ($key == 'Email'){
    $sanitizedEmail = filter_var($value, FILTER_SANITIZE_EMAIL);
    array_push($cleanedInputs, $sanitizedEmail);
  } else {
    ${'sanitized'.ucfirst($key)} = filter_var($value, FILTER_SANITIZE_STRING);
    array_push($cleanedInputs, ${'sanitized'.ucfirst($key)});
  }
}
