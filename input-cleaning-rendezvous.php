<?php
// Fonction de nettoyage des valeurs
function sanitizeString($array) {
  $array[0] = filter_var($array[0], FILTER_SANITIZE_STRING);
  $array[1] = filter_var($array[1], FILTER_SANITIZE_STRING);
  return $array;
}
function validateString($array) {
  // Déclaration des Reg Ex
  // \d = [0-9]
  $regExDate = '/^((?:19|20)\d{2})-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/';
  $regExHour = '/^((0[8-9]{1}|1\d{1})){1}\:((3|0)0){1}$/';
  // Valide les autres valeurs avec les Reg Ex
  preg_match($regExDate, $array[0]) ?: $array[0] = null;
  preg_match($regExHour, $array[1]) ?: $array[1] = null;
  return $array;
}
