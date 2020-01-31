<?php
require_once 'connection.php';
$database = connectionToDatabase();
$patientLastName = '';
if (! empty($_GET['patient'])) {
  $patientLastName = $_GET['patient'];
}
$query = 'SELECT `firstname`, `lastname`, `birthdate`, `phone`, `mail` FROM `patients` WHERE `lastname` = "'.$patientLastName.'"';
$patientInfoQuery = $database->query($query);
$patientInfo = $patientInfoQuery->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <!-- ³ = alt + 0179 -->
  <title>PDO-Partie2</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/header.css">
  <link rel="stylesheet" href="assets/css/profil-patient.css">
</head>
<body class="container-fluid p-0 bg-secondary">
<?php include 'header.php' ?>
<div class="jumbotron pt-4 my-5 bg-success mx-auto">
  <table class="table text-center table-striped table-bordered table-hover">
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
    <?php foreach ($patientInfo as $patient) {?>
      <tr id="<?= $patient['lastname'] ?>">
        <td><?= $patient['lastname'] ?></td>
        <td><?= $patient['firstname'] ?></td>
        <td><?= $patient['birthdate'] ?></td>
        <td><?= $patient['phone'] ?></td>
        <td><?= $patient['mail'] ?></td>
        <td><a class="text-white">Modifier</a></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
