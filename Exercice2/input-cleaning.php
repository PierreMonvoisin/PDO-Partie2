<?php
function sanitizeString($key, $value) {
  return $key === 'Email' ? filter_var($value, FILTER_SANITIZE_EMAIL) : filter_var($value, FILTER_SANITIZE_STRING);
}
function validateString($array) {
  $regExName = '/^[a-zA-Z \x{00C0}-\x{00FF}"\'\-]{1,25}$/u';
  $regExDate = '/^((?:19|20)\d{2})-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/';
  $regExPhoneNumber = '/^(\+?\d{2,5})?0[67]((\.)?\d{2}){4}$/';

  $array['Email'] = filter_var($array['Email'], FILTER_VALIDATE_EMAIL);
  preg_match($regExName, $array['firstname']) ?: $array['firstname'] = null;
  preg_match($regExName, $array['lastname']) ?: $array['lastname'] = null;
  preg_match($regExDate, $array['birthdate']) ?: $array['birthdate'] = null;
  preg_match($regExPhoneNumber, $array['phoneNumber']) ?: $array['phoneNumber'] = null;
  return $array;
}