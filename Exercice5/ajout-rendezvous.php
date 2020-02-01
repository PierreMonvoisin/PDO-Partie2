<?php
// Connection à la base de données
require_once 'connection.php';
$database = connectionToDatabase();
// Déclaration de la requête SQL pour afficher les noms et prénoms des clients
$query = 'SELECT `id`, `firstname`, `lastname` FROM `patients` ORDER BY `lastname` ASC';
// Envoie de la requête vers la base de données
$patientsListQuery = $database->query($query);
// Collection des données dans un tableau associatif (FETCH_ASSOC)
$patientsList = $patientsListQuery->fetchAll(PDO::FETCH_ASSOC); ?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <title>PDO-Partie2</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/ajout-rendezvous.css">
</head>
<body class="container-fluid bg-secondary p-0">
<?php include 'header.php' ?>
<div class="jumbotron pt-4 my-5 mx-auto bg-primary w-50 shadow">
    <div id="dateSelector">
        <h2 class="text-center text-white">Choississez la date du rendez vous</h2>
        <form class="form-group w-50 mx-auto" action="ajout-rendezvous.php" method="get">
            <div class="form-group row d-flex">
                <label for="patient" class="mr-auto my-auto font-weight-bold text-white">Choisissez le patient :</label>
                <select name="patient" id="patient" class="form-control w-50 ml-auto my-3">
                    <option disabled selected>-- Patient --</option>
                  <?php foreach ($patientsList as $patient) { ?>
                      <option value="<?= $patient['id'] ?>"><?= $patient['lastname'] . ' ' . $patient['firstname'] ?></option>
                  <?php } ?>
                </select>
            </div>
            <div class="form-group row d-flex">
                <label for="day" class="mr-auto my-auto font-weight-bold text-white">Choisissez le jour :</label>
                <select name="day" id="day" class="form-control w-50 ml-auto my-3">
                    <option disabled selected>-- Jour --</option>
                  <?php // Créer une liste de 1 à 31 pour le jour
                  foreach (range(1, 31) as $day) { ?>
                      <option value="<?= $day ?>"><?= $day ?></option>
                  <?php } ?>
                </select>
            </div>
            <div class="form-group row d-flex">
                <label for="month" class="mr-auto my-auto font-weight-bold text-white">Choisissez le mois :</label>
                <select name="month" id="month" class="form-control w-50 ml-auto my-3">
                    <option disabled selected>-- Mois --</option>
                    <option value="January">Janvier</option>
                    <option value="February">Février</option>
                    <option value="March">Mars</option>
                    <option value="April">Avril</option>
                    <option value="May">Mai</option>
                    <option value="June">Juin</option>
                    <option value="July">Juillet</option>
                    <option value="August">Août</option>
                    <option value="September">Septembre</option>
                    <option value="October">Octobre</option>
                    <option value="November">Novembre</option>
                    <option value="December">Décembre</option>
                </select>
            </div>
            <div class="form-group row d-flex">
                <label for="year" class="mr-auto my-auto font-weight-bold text-white">Choisissez l'année :</label>
                <select name="year" id="year" class="form-control w-50 ml-auto my-3">
                    <option disabled selected>-- Année --</option>
                  <?php // Créer une liste de cette année à 2025
                  foreach (range(2025, date('Y')) as $year) { ?>
                      <option value="<?= $year ?>"><?= $year ?></option>
                  <?php } ?>
                </select>
            </div>
            <div class="form-group row d-flex">
                <label for="hour" class="mr-auto my-auto font-weight-bold text-white">Choisissez l'heure :</label>
                <select name="hour" id="hour" class="form-control w-50 ml-auto my-3">
                    <option disabled selected>-- Heure --</option>
                  <?php // Créer une liste de tous les crénaux horraire
                  foreach (range(8, 19) as $hours) { ?>
                      <option value="<?= $hours ?>:00"><?= $hours ?>:00</option>
                      <option value="<?= $hours ?>:30"><?= $hours ?>:30</option>
                  <?php } ?>
                </select>
            </div>
            <button type="submit" id="submitButton" class="btn btn-dark btn-block">Valider</button>
        </form>
    </div>
</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
