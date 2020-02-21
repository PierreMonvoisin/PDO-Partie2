<?php
define('USER', 'pierremonvoisin');
define('PASS', 'monvoisin');
define('HOST', 'localhost');
define('DB', 'hospitalE2N');
function connectDb() {
  try {
    $database = new PDO('mysql:dbname=' .DB. ';host=' .HOST. ';charset=utf8', USER, PASS);
    return $database;
  } catch (Exception $ex) {
    die('La connexion à la base de données a échoué, veuillez contacter l\'administrateur du site !'.'<br>'.'Connection to database failed, please contact website\'s administrator !');
  }
}
?>
