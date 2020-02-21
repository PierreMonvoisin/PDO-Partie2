<?php
require_once '../Models/Patient.php';
require_once '../Models/Appointments.php';
$patient = new Patient('pierre', 'monvoisin', '1998-08-19', '06.33.66.55.11', 'monvoisin.pierre@gmail.com');
$appointment = new Appointments('2020-05-12 18:00', 5);
if (isset($_GET['idPatient'])) {
  if (!filter_input(INPUT_GET, 'idPatient', FILTER_VALIDATE_INT) || $_GET['idPatient'] <= 0) {
    header('Location: liste-patientController.php');
    exit();
  }
//  $patient->id = (int) $_GET['idPatient'];
//  $appointment->idPatient = $patient->id;
  try {
    $patient->db->beginTransaction();
    $patient->create();
    $appointment->create();
  } catch (Exception $e){
    var_dump($patient);
    echo $e->getMessage();
    $appointment->db->rollBack();
  }
}