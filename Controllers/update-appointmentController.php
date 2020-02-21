<?php
session_start();
require_once '../Models/Patient.php';
require_once '../Models/Appointments.php';
$currentDatehour = '';
$errors = [];
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
        $_SESSION['idPatient'] = $idPatient;
        array_push($test, true);
    }   
    if(count($test) != 2){
      header('Location: http://www.pdo-correctionpartie2.com/Controllers/liste-appointmentController.php'); 
      exit();
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $currentDatehour = filter_input(INPUT_POST, 'oldDatehour',FILTER_SANITIZE_STRING);
    if(empty($currentDatehour) || !preg_match($regexdateHour, $currentDatehour)){
        array_push($errors, true);
    }
    $datehour = filter_input(INPUT_POST, 'datehour',FILTER_SANITIZE_STRING);
    if(empty($datehour) || !preg_match($regexdateHour, $datehour)){
        array_push($errors, 'La date n\'est pas valide !');
    }
    $idPatient = (int) $_SESSION['idPatient'];
    if(empty($idPatient)){
        array_push($errors, true);
    } 
    if(count($errors) == 0){
      $dateHour = preg_replace($regexdateHour, '$3-$2-$1 $4', $_POST['datehour']);
      $currentDatehour = preg_replace($regexdateHour, '$3-$2-$1 $4', $_POST['oldDatehour']);
      $appointment = new Appointments();
      $appointment->dateHour = $dateHour;
      $appointment->idPatient = $idPatient;
      if ($appointment->update($currentDatehour)){
        $success = true;
      }
    }
}
$idPatient = $_GET['idPatient'] ?? ($_SESSION['idPatient']);
$patient = new Patient();
$patient->id = $idPatient;
$patient->getOneById();
require_once '../Views/update-appointment.php';
