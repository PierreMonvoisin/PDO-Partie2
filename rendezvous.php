<?php
// Connection à la base de données
require_once 'connection.php';
$database = connectionToDatabase();
$patientLastName = '';
if (!empty($_GET['patient'])) {
  $patientLastName = $_GET['patient'];
}
// Déclaration de la requête SQL pour afficher les noms et prénoms des clients et les rendez vous associers
$query = 'SELECT `appointments`.`id` `idRDV`, `appointments`.`dateHour` `dateRDV`,
`patients`.`firstname` `patientFirstname`, `patients`.`lastname` `patientLastname`, `patients`.`birthdate` `patientBirthdate`,`patients`.`mail` `patientMail`, `patients`.`phone` `patientPhone`
FROM `appointments` INNER JOIN `patients`
ON `appointments`.`idPatients` = `patients`.`id`
WHERE `patients`.`lastname` = "'.$patientLastName.'"';
// Envoie de la requête vers la base de données
$rdvInfoListQuery = $database->query($query);
// Collection des données dans un tableau associatif (FETCH_ASSOC)
$rdvInfoList = $rdvInfoListQuery->fetchAll(PDO::FETCH_ASSOC);

/////////////// Récupération des informations du formulaire ///////////////
// Importe les fonctions de nettoyage et validation des valeurs
include 'input-cleaning-rendezvous.php';
$message = 'ERROR';
$formValidity = false;
if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST'){
  empty($_POST['rdvDate']) ? $rdvDateRaw = null : $rdvDateRaw = $_POST['rdvDate'];
  empty($_POST['hour']) ? $hourRaw = null : $hourRaw = $_POST['hour'];
  $modificationRaw = [$rdvDateRaw, $hourRaw];
  if (! in_array(null, $modificationRaw, true)) {
    $modificationSanitized = sanitizeString($modificationRaw);
  } else {
    $message = 'Un des champs est érroné ...';
  }
  // Envoie le tableau des valeurs pour le valider
  if ($message === 'ERROR' && ! in_array(null, $modificationSanitized, true)) {
    $modificationValidated = validateString($modificationSanitized);
  } else {
    $message = 'Un des champs est érroné ...';
  }
  // Si toutes les valeurs sont bonnes, valide l'envoi
  if ($message === 'ERROR' && in_array(null, $modificationValidated, true)) {
    $message = 'Un des champs est érroné ...';
  } else {
    $formValidity = true;
  }
  if ($formValidity === true) {
    // Concatène la date et les heures
    $dateHourString = $modificationValidated[0] . ' ' . $modificationValidated[1];
    // Déclare la date au format optimal pour SQL
    $dateHour = date('Y-m-d H:i', strtotime($dateHourString));
    // Réorganisation du tableau pour une meilleure utilisation
    $stmtParam = ['dateHour' => $dateHour];
    try {
      // Déclaration de la requête SQL avec paramètres
      $stmt = $database->prepare('UPDATE `appointments` SET `dateHour` = ? WHERE `id` ='.$idRDV);
      // Execute la requête avec les variables en paramètres
      $stmt->execute([$stmtParam['dateHour']]);
      // Réinitialise la requête
      $stmt = null;
      $submitMessage = 'Rendez vous bien enregistré !';
    } catch (PDOException $e) {
      echo $$query . '/' . $e->getMessage();
    }
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
<?php include 'header.php'; ?>
<div class="jumbotron pt-4 my-5 bg-success mx-auto shadow">
  <?php if (isset($_POST['submit'])) { ?>
    <h2><?= $message ?></h2>
  <?php } ?>
    <table class="table mt-3 text-center table-striped table-bordered table-hover">
        <thead>
        <tr class="text-white">
          <th>Nom et prénom du patient</th>
          <th>Date de naissance</th>
          <th>Mail</th>
          <th>Téléphone</th>
          <th>Date du RDV</th>
          <th>Heure du RDV</th>
          <th>Modification</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rdvInfoList as $info) {
          $idRDV = $info['idRDV'];
          $dateObject = new DateTime($info['dateRDV']);
          $birthdateObject = new DateTime($info['patientBirthdate']);
          $info['dateRDV'] = $dateObject->format('d/m/Y H:i');
          $info['patientBirthdate'] = $birthdateObject->format('d / m / Y');
          $dateHourSeparation = explode(' ', $info['dateRDV']);
          $day = $dateHourSeparation[0];
          $hour = $dateHourSeparation[1]; ?>
            <tr id="<?= $info['patientLastname']. ' ' .$info['patientFirstname'] ?>">
              <td><?= $info['patientFirstname']. ' ' .$info['patientLastname'] ?></td>
              <td><?= $info['patientBirthdate'] ?></td>
              <td><?= $info['patientMail'] ?></td>
              <td><?= $info['patientPhone'] ?></td>
              <td><?= $day ?></td>
              <td><?= $hour ?></td>
              <td><a class="text-white" href="rendezvous.php?patient=<?= $info['patientLastname'] ?>&modify=on">Modifier</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<!--Au clique du bouton, afficher le jumbotron avec le formulaire pour modifier les données-->
<?php if (!empty($_GET['modify']) && $_GET['modify'] === 'on') { ?>
    <div class="jumbotron pt-4 my-5 bg-success mx-auto shadow">
        <form action="rendezvous.php?patient=<?= $patientLastName ?>" method="post">
            <table class="table text-center table-striped table-bordered table-hover">
                <thead>
                <tr class="text-white">
                  <th>Nom et prénom du patient</th>
                  <th>Date de naissance</th>
                  <th>Mail</th>
                  <th>Téléphone</th>
                  <th>Date</th>
                  <th>Heure</th>
                  <th>Validation</th>
                </tr>
                </thead>
                <tbody>
                <tr id="modification">
                    <td>
                        <label class="sr-only" for="name">Prénom et nom du patient</label>
                        <input name="name" type="text" class="form-control" id="name"
                               value="<?= $info['patientFirstname']. ' ' .$info['patientLastname'] ?>" disabled>
                    </td>
                    <td>
                        <label class="sr-only" for="birthdate">Date de naissance</label>
                        <input name="birthdate" type="date" class="form-control" value="<?= $dateObject->format('Y-m-d') ?>" id="birthdate" disabled>
                    </td>
                    <td>
                        <label class="sr-only" for="mail">Email</label>
                        <input name="mail" type="text" class="form-control" id="mail"
                               value="<?= $info['patientMail'] ?>">
                    </td>
                    <td>
                        <label class="sr-only" for="phone">Téléphone portable</label>
                        <input name="phone" type="email" class="form-control" id="phone"
                               placeholder="<?= $info['patientPhone'] ?>">
                    </td>
                    <td>
                        <label class="sr-only" for="rdvDate">Date du rendez-vous</label>
                        <input name="rdvDate" type="date" class="form-control" value="<?= $birthdateObject->format('Y-m-d') ?>" id="rdvDate">
                    </td>
                    <td>
                      <label for="hour" class="sr-only">Heure du rendez-vous</label>
                      <select name="hour" id="hour" class="form-control">
                        <option disabled selected>-- Heure --</option>
                        <?php // Créer une liste de tous les crénaux horraire
                        foreach (range(8, 19) as $hours) {
                          $hour == $hours.':00' ? $message00 = 'selected': $message00 = '';
                          $hour == $hours.':30' ? $message30 = 'selected': $message30 = '';
                          $hours < 10 ? $hours = '0' . $hours : $hours; ?>
                          <option value="<?= $hours ?>:00" <?= $message00 ?>><?= $hours ?>:00</option>
                          <option value="<?= $hours ?>:30" <?= $message30 ?>><?= $hours ?>:30</option>
                        <?php } ?>
                      </select>
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
