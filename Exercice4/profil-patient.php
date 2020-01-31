<?php
// Connection à la base de données
require_once 'connection.php';
$database = connectionToDatabase();
// Récupération du nom du patient avec la méthode GET
$patientLastName = '';
if (!empty($_GET['patient'])) {
  $patientLastName = $_GET['patient'];
}
// Déclaration de la requête SQL associée au nom du patient
$query = 'SELECT `firstname`, `lastname`, DATE_FORMAT(`birthDate`,\'%d-%m-%Y\') `birthdate`, `phone`, `mail` FROM `patients` WHERE `lastname` = "' . $patientLastName . '"';
// Envoie de la requête vers la base de données
$patientInfoQuery = $database->query($query);
// Collection des données dans un tableau associatif (FETCH_ASSOC)
$patientInfo = $patientInfoQuery->fetchAll(PDO::FETCH_ASSOC);
// Importe les fonctions de nettoyage et validation des valeurs
include 'input-cleaning.php';
$submitMessage = 'Vos modifications sont bien enregistrées !';
$validatedInputs = 'ERROR';
$formValidity = false;
$queryStatus = false;
if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
  foreach ($_POST as $key => $value) {
    if ($value === '' || $value === null) {
      // Change le message si une valeur est vide
      $submitMessage = 'Un des champs est érroné ...';
    } else {
      // Nettoie toutes les valeurs
      $sanitizedInputs[$key] = sanitizeString($key, $value);
      // Envoie le tableau des valeurs pour le valider
      if (count($sanitizedInputs) === 5) {
        $validatedInputs = validateString($sanitizedInputs);
      } else {
        $submitMessage = 'Un des champs est érroné ...';
      }
    }
  }
  // Si toutes les valeurs sont bonnes, valide l'envoi
  if (in_array(null, $validatedInputs, true)) {
    $submitMessage = 'Un des champs est érroné ...';
  } else {
    $formValidity = true;
  }
  if ($formValidity === true) {
    // Change le nom de la variable pour une meilleure compréhension
    $stmtParam = $validatedInputs;
    try {
      // Déclaration de la requête SQL avec paramètres
      $stmt = $database->prepare('UPDATE `patients` SET `firstname` = ?, `lastname` = ?, `birthdate` = ?, `phone` = ?, `mail` = ? WHERE `lastname` = \'' . $patientLastName . '\'');
      // Execute la requête avec les variables en paramètres
      $stmt->execute([$stmtParam['firstname'], $stmtParam['lastname'], $stmtParam['birthdate'], $stmtParam['phoneNumber'], $stmtParam['Email']]);
      // Réinitialise la requête
      $stmt = null;
      $submitMessage = 'Vos modifications sont bien enregistrées !';
      $queryStatus = true;
    } catch (PDOException $e) {
      echo $$query . '/' . $e->getMessage();
    }
  }
  // Recharge les informations du client après modification
  if ($queryStatus) {
    $query = 'SELECT `firstname`, `lastname`, DATE_FORMAT(`birthDate`,\'%d-%m-%Y\') `birthdate`, `phone`, `mail` FROM `patients` WHERE `lastname` = "' . $patientLastName . '"';
    $patientInfoQuery = $database->query($query);
    $patientInfo = $patientInfoQuery->fetchAll(PDO::FETCH_ASSOC);
  }
}
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <title>PDO-Partie2</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/profil-patient.css">
</head>
<body class="container-fluid p-0 bg-secondary">
<?php include 'header.php' ?>
<div class="jumbotron pt-4 my-5 bg-success mx-auto">
  <?php if ($queryStatus === true) { ?>
      <!--Ajoute un message à l'envoi du formulaire-->
      <h2 class="text-center my-2"><?= $submitMessage ?></h2>
  <?php } ?>
    <table class="table mt-3 text-center table-striped table-bordered table-hover">
        <thead>
        <tr class="text-white">
            <th>Nom de famille</th>
            <th>Prénom</th>
            <th>Date de naissance</th>
            <th>Téléphone portable</th>
            <th>Adresse mail</th>
            <th>Modification</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($patientInfo as $patient) { ?>
            <!--Affichage de toutes les données du patient-->
            <tr id="<?= $patient['lastname'] ?>">
                <td><?= $patient['lastname'] ?></td>
                <td><?= $patient['firstname'] ?></td>
                <td><?= $patient['birthdate'] ?></td>
                <td><?= $patient['phone'] ?></td>
                <td><?= $patient['mail'] ?></td>
                <!--Ajoute un lien pour modifier les données du patient-->
                <td><a href="profil-patient.php?patient=<?= $patientLastName ?>&modify=on"
                       class="text-white">Modifier</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<!--Au clique du bouton, afficher le jumbotron avec le formulaire pour modifier les données-->
<?php if (!empty($_GET['modify']) && $_GET['modify'] === 'on') { ?>
    <div class="jumbotron pt-4 my-5 bg-primary mx-auto">
        <form action="profil-patient.php?patient=<?= $patientLastName ?>" method="post">
            <table class="table text-center table-striped table-bordered table-hover">
                <thead>
                <tr class="text-white">
                    <th>Nom de famille</th>
                    <th>Prénom</th>
                    <th>Date de naissance</th>
                    <th>Téléphone portable</th>
                    <th>Adresse mail</th>
                    <th>Validation</th>
                </tr>
                </thead>
                <tbody>
                <tr id="modification">
                    <td>
                        <label class="sr-only" for="lastname">Nom de famille</label>
                        <input name="lastname" type="text" class="form-control" id="lastname"
                               placeholder="<?= $patient['lastname'] ?>">
                    </td>
                    <td>
                        <label class="sr-only" for="firstname">Prénom</label>
                        <input name="firstname" type="text" class="form-control" id="firstname"
                               placeholder="<?= $patient['firstname'] ?>">
                    </td>
                    <td>
                        <label class="sr-only" for="birthdate">Date de naissance</label>
                        <input name="birthdate" type="date" class="form-control" id="birthdate">
                    </td>
                    <td>
                        <label class="sr-only" for="phoneNumber">Numéro de téléphone</label>
                        <input name="phoneNumber" type="text" class="form-control" id="phoneNumber"
                               placeholder="<?= $patient['phone'] ?>">
                    </td>
                    <td>
                        <label class="sr-only" for="Email"></label>
                        <input name="Email" type="email" class="form-control" id="Email"
                               placeholder="<?= $patient['mail'] ?>">
                    </td>
                    <td>
                        <button name="submit" type="submit" class="btn btn-danger">Confirmer</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
<?php } ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>