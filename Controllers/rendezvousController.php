<?php
require_once '../Models/Appointments.php';
include '../form-validation.php';
if (empty($_GET['id']) || !filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) {
  header ('location: liste-rdvController.php');
  exit();
}
$rdv = new Appointments();
$rdv->id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$rdv->getOneById()){
    echo 'Ce rendez-vous n\'existe pas';
    $sleep = 5;
  header('Refresh:'. $sleep .';http://www.pdo-correctionpartie2.com/Controllers/liste-rdvController.php');
}



require_once '../Views/rdv-patient.php';


