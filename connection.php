<?php
function connectionToDatabase() {
  // Importe les constantes de connection
  require_once 'parameters.php';
  try {
    // Création du nouveau PDO associer à l'utilisateur et la base de donnée
    $database = new PDO('mysql:dbname=' .DB. ';host=' .HOST. ';charset=utf8', USER, PASSWORD);
    // Retourne la base de donnée
    return $database;
  } catch (Exception $ex) {
    // Si il y une erreur, coupe le script
    die('La connexion à la base de données a échoué !');
  }
}
