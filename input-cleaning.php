<?php
// Fonction de nettoyage des valeurs
function sanitizeString($key, $value) {
  // Si la clé est celle de l'email, nettoyage spécifique pour l'email, sinon, nettoyage pour les chaînes de charactères
  return $key === 'Email' ? filter_var($value, FILTER_SANITIZE_EMAIL) : filter_var($value, FILTER_SANITIZE_STRING);
}
// Fonction de validation du tableau des valeurs
function validateString($array) {
  // Déclaration des Reg Ex
  // \x{00C0}-\x{00FF} = \u00C0-\u00FF = Toutes les lettres accentuées (ASCII 192 à 255)
  $regExName = '/^[a-zA-Z \x{00C0}-\x{00FF}"\'\-]{1,25}$/u';
  // \d = [0-9]
  $regExDate = '/^((?:19|20)\d{2})-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/';
  $regExPhoneNumber = '/^(\+?\d{2,5})?0[67]((\.)?\d{2}){4}$/';
  // Valide l'email avec le filtre PHP
  $array['Email'] = filter_var($array['Email'], FILTER_VALIDATE_EMAIL);
  // Valide les autres valeurs avec les REg EX
  preg_match($regExName, $array['firstname']) ?: $array['firstname'] = null;
  preg_match($regExName, $array['lastname']) ?: $array['lastname'] = null;
  preg_match($regExDate, $array['birthdate']) ?: $array['birthdate'] = null;
  preg_match($regExPhoneNumber, $array['phoneNumber']) ?: $array['phoneNumber'] = null;
  // Retourne le tableau des valeurs validées ou non
  return $array;
}