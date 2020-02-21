<?php
require_once '../Models/Patient.php';
$patient = new Patient();
$patientsList = $patient->getAll();
require_once '../Views/liste-patients.php';

