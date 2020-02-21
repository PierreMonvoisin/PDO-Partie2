<?php
session_start();
require_once '../Models/Appointments.php';
$appointment = new Appointments();
$appointmentsList = $appointment->getAll();
require_once '../Views/liste-appointment.php';

