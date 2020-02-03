<?php
// Fonction de nettoyage des valeurs
function sanitizeString($array) {
  $array[0] = filter_var($array[0], FILTER_SANITIZE_NUMBER_INT);
  $array[1] = filter_var($array[1], FILTER_SANITIZE_STRING);
  $array[2] = filter_var($array[2], FILTER_SANITIZE_STRING);
  return $array;
}
function validateString($array) {
  // Déclaration des Reg Ex
  // \d = [0-9]
  $regExDate = '/^((?:19|20)\d{2})-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/';
  $regExHour = '/^((0[8-9]{1}|1\d{1})){1}\:((3|0)0){1}$/';
  $array[0] = filter_var($array[0], FILTER_VALIDATE_INT);
  // Valide les autres valeurs avec les REg EX
  preg_match($regExDate, $array[1]) ?: $array[1] = null;
  preg_match($regExHour, $array[2]) ?: $array[2] = null;
  return $array;
}