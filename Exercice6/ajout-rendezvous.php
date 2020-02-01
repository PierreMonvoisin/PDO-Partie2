<?php
// Connection à la base de données
require_once 'connection.php';
$database = connectionToDatabase();
////////////////////////// EXERCICE 5 //////////////////////////
// Déclaration de la requête SQL pour afficher les noms et prénoms des clients
$query = 'SELECT `id`, `firstname`, `lastname` FROM `patients` ORDER BY `lastname` ASC';
// Envoie de la requête vers la base de données
$patientsListQuery = $database->query($query);
// Importe les fonctions de nettoyage et validation des valeurs
include 'input-cleaning-rendezvous.php';
$submitMessage = 'ERROR';
$appointmentRaw = 'ERROR';
$appointmentSanitized = 'ERROR';
$appointmentValidated = 'ERROR';
$formValidity = false;
// Collection des données dans un tableau associatif (FETCH_ASSOC)
$patientsList = $patientsListQuery->fetchAll(PDO::FETCH_ASSOC);
if (isset($_GET['submit']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
  empty($_GET['patient']) ? $patientId = null : $patientId = $_GET['patient'];
  empty($_GET['year']) ||  empty($_GET['month']) || empty($_GET['day'])? $date = null : $date = $_GET['year'] . '-' . $_GET['month'] . '-' . $_GET['day'];
  empty($_GET['year']) ||  empty($_GET['month']) || empty($_GET['day'])? $dateFrench = null :
   $dateFrench = $_GET['day'] . '-' . $_GET['month'] . '-' . $_GET['year'];
  empty($_GET['hour']) ? $hour = null : $hour = $_GET['hour'];
  $appointmentRaw = [$patientId, $date, $hour];
  // Envoie le tableau des valeurs pour le nettoyer
  if (! in_array(null, $appointmentRaw, true)) {
    $appointmentSanitized = sanitizeString($appointmentRaw);
  } else {
    $submitMessage = 'Un des champs est érroné ...';
  }
  // Envoie le tableau des valeurs pour le valider
  if ($submitMessage === 'ERROR' && ! in_array(null, $appointmentSanitized, true)) {
    $appointmentValidated = validateString($appointmentSanitized);
  } else {
    $submitMessage = 'Un des champs est érroné ...';
  }
  // Si toutes les valeurs sont bonnes, valide l'envoi
  if ($submitMessage === 'ERROR' && ! in_array(null, $appointmentValidated, true)) {
    $submitMessage = 'Un des champs est érroné ...';
  } else {
    $formValidity = true;
  }
  if ($formValidity) {
    // Concatène la date et les heures
    $dateHourString = $appointmentValidated[1] . ' ' . $appointmentValidated[2];
    // Déclare la date au format optimal pour SQL
    $dateHour = date('Y-m-d H:i', strtotime($dateHourString));
    // Réorganisation du tableau pour une meilleure utilisation
    $stmtParam = ['dateHour' => $dateHour, 'idPatients' => $appointmentValidated[0]];
    try {
      // Déclaration de la requête SQL avec paramètres
      $stmt = $database->prepare('INSERT INTO `appointments` (`dateHour`,`idPatients`) VALUES (?, ?)');
      // Execute la requête avec les variables en paramètres
      $stmt->execute([$stmtParam['dateHour'], $stmtParam['idPatients']]);
      // Réinitialise la requête
      $stmt = null;
      $submitMessage = 'Rendez vous bien enregistré !';
    } catch (PDOException $e) {
      echo $$query . '/' . $e->getMessage();
    }
  }
}
////////////////////////// EXERCICE 6 //////////////////////////
// Déclaration de la requête SQL pour afficher la date, l'heure et le patient du rendez vous
$query = 'SELECT `dateHour`, `idPatients` FROM `appointments`';
// Envoie de la requête vers la base de données
$appointmentsListQuery = $database->query($query);
// Collection des données dans un tableau associatif (FETCH_ASSOC)
$appointmentsList = $appointmentsListQuery->fetchAll(PDO::FETCH_ASSOC);
?>
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
      <?php if ($formValidity) { ?>
          <!--   Ajoute un message à la validation du formulaire-->
          <h3 class="text-center text-white"><?= $submitMessage ?></h3>
      <?php } ?>
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
                  foreach (range(1, 31) as $day) {
                    $day < 10 ? $day = '0' . $day : $day; ?>
                      <option value="<?= $day ?>"><?= $day ?></option>
                  <?php } ?>
                </select>
            </div>
            <div class="form-group row d-flex">
                <label for="month" class="mr-auto my-auto font-weight-bold text-white">Choisissez le mois :</label>
                <select name="month" id="month" class="form-control w-50 ml-auto my-3">
                    <option disabled selected>-- Mois --</option>
                    <option value="01">Janvier</option>
                    <option value="02">Février</option>
                    <option value="03">Mars</option>
                    <option value="04">Avril</option>
                    <option value="05">Mai</option>
                    <option value="06">Juin</option>
                    <option value="07">Juillet</option>
                    <option value="08">Août</option>
                    <option value="09">Septembre</option>
                    <option value="10">Octobre</option>
                    <option value="11">Novembre</option>
                    <option value="12">Décembre</option>
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
                  foreach (range(8, 19) as $hours) {
                    $hours < 10 ? $hours = '0' . $hours : $hours; ?>
                      <option value="<?= $hours ?>:00"><?= $hours ?>:00</option>
                      <option value="<?= $hours ?>:30"><?= $hours ?>:30</option>
                  <?php } ?>
                </select>
            </div>
            <button name="submit" type="submit" id="submitButton" class="btn btn-dark btn-block">Valider</button>
        </form>
    </div>
</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
