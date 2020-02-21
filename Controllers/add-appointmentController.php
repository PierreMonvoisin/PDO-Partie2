<?php

require_once '../Models/Patient.php';
require_once '../Models/Appointments.php';
$errors = [];
$regexdateHour = '/^(\d{2})\.(\d{2})\.(\d{4})\s(\d{2}:\d{2})$/';
//on recupére les données via axios
$data = json_decode(file_get_contents('php://input', true));
//on verifie que cela n'est pas nul
if (!empty($data)) {
    if (isset($data->search)) {
        $patient = new Patient();
        $search = filter_var($data->search, FILTER_SANITIZE_STRING);
        $patientsList = $patient->findPatient($search);
//on retourne la liste des patients correspondant sous format json
        exit(json_encode($patientsList, JSON_UNESCAPED_UNICODE));
    }
}

if(isset($_POST['create-appointment'])){
   if(!empty($_POST['dateHour']) && preg_match($regexdateHour, $_POST['dateHour'])){
        $dateHour = preg_replace($regexdateHour, '$3-$2-$1 $4', $_POST['dateHour']);
    } else{
        $errors['dateHour'] = 'Veuillez renseigner une date de rendez-vous valide';
    } 
    if(!empty($_POST['idPatient']) && filter_input(INPUT_POST, 'idPatient', FILTER_VALIDATE_INT)){
        $idPatient = (int) $_POST['idPatient'];
    }
    else{
        $errors['patient'] = 'Veuillez choisir un patient de la liste';
    } 
    if (count($errors) == 0) {
        $appointment = new Appointments($dateHour, $idPatient);
        if($appointment->create()){
            $success = true;
        }
    }
}

require_once '../Views/add-appointment.php';
