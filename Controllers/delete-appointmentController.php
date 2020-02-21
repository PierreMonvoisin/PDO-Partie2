<?php
session_start();
require_once '../Models/Patient.php';
require_once '../Models/Appointments.php';
$regexdateHour = '/^(\d{2})\.(\d{2})\.(\d{4})\s(\d{2}:\d{2})$/';
if(isset($_GET['idPatient'], $_GET['datehour'])){
  $test = [];
  if(!empty($_GET['datehour']) && preg_match($regexdateHour, $_GET['datehour'])){
    $currentDatehour = filter_input(INPUT_GET, 'datehour',FILTER_SANITIZE_STRING);
    array_push($test, true);
  }
  if(!empty($_GET['idPatient']) && filter_input(INPUT_GET, 'idPatient', FILTER_VALIDATE_INT)){
    //$dateHour = preg_replace($regexdateHour, '$3-$2-$1 $4', $_GET['datehour']);
    $idPatient = (int) $_GET['idPatient'];
    array_push($test, true);
  }
  if(count($test) != 2){
    header('Location: http://www.pdo-correctionpartie2.com/Controllers/liste-appointmentController.php');
    exit();
  }
  $_SESSION['idPatient'] = $idPatient;
  $_SESSION['datehour'] = $currentDatehour;
  $_SESSION['deleteAppointment'] = false;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  if (isset($_POST['deleteConfirm'])){
    $appointment = new Appointments();
    $appointment->idPatient = $_SESSION['idPatient'];
    $patient = new Patient();
    $patient->id = $_SESSION['idPatient'];
    $patient->getOneById();
    $_SESSION['patient'] = $patient->firstname. ' ' .$patient->lastname;
    $appointment->dateHour = filter_var(preg_replace($regexdateHour, '$3-$2-$1 $4', $_SESSION['datehour']), FILTER_SANITIZE_STRING);
    if ($appointment->delete()){
      $_SESSION['deleteAppointment'] = true;
    }
  }
  header('Location: http://pdopartie2.exercice/pdo-partie2-correction/Controllers/liste-appointmentController.php');
  exit();
}
require '../Views/delete-appointment.php';