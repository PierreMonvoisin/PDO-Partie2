<?php

require_once '../Models/Patient.php';
if (empty($_GET['idPatient']) || !filter_input(INPUT_GET, 'idPatient', FILTER_VALIDATE_INT)) {
    header('location: liste-patients.php');
    exit();
}
//Accès à la page update via un get
$idPatient = filter_input(INPUT_GET, 'idPatient', FILTER_SANITIZE_NUMBER_INT);
require_once '../form-validation.php';
$idPatient = filter_input(INPUT_GET, 'idPatient', FILTER_SANITIZE_NUMBER_INT);
if (isset($_POST['idPatient'])) {
    if (!filter_input(INPUT_POST, 'idPatient', FILTER_VALIDATE_INT) || $_POST['idPatient'] <= 0) {
        $errors['idPatient'] = 'Ce patient n\'existe pas';
    }
}
//On crée un nouveau patient
$patient = new Patient();
$patient->id = $idPatient;
//On vérifie si le formulaire de mise à jour a été posté (POST)
if ($isSubmitted && count($errors) == 0) {
    $patient->firstname = $firstname;
    $patient->lastname = $lastname;
    $patient->birthdate = $birthdate;
    $patient->phone = $phone;
    $patient->mail = $mail;
    if (!$patient->update()) {
        require_once '../Views/errors/503.php';
        exit();
    }
    $success = true;
    $sleep = 4;
    header('Refresh:' . $sleep . ';http://www.pdo-correctionpartie2.com/Controllers/profil-patientController.php?idPatient='. $patient->id);
}
if (!$patient->getOneById()) {
    echo 'Ce patient n\'existe pas';
    $sleep = 4;
    header('Refresh:' . $sleep . ';http://www.pdo-correctionpartie2.com/Controllers/list-patientsController.php');
}
require_once '../Views/update-patient.php';
