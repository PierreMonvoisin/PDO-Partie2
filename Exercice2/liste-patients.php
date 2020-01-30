<?php
require_once 'connection.php';
$database = connectionToDatabase();
$query = 'SELECT `firstname`, `lastname` FROM `patients` ORDER BY `lastname` ASC';
$patientsListQuery = $database->query($query);
$patientsList = $patientsListQuery->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="assets/css/liste-patients.css">
</head>
<body class="container-fluid p-0 bg-secondary">
<?php include 'header.php' ?>
<div class="jumbotron bg-info pt-4 my-5 mx-auto w-50 text-white">
    <h2 class="text-center">Liste des patients</h2>
    <table class="table text-center table-striped table-bordered table-hover">
        <thead>
        <tr class="text-white">
            <th>Nom de famille</th>
            <th>Prénom</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($patientsList as $patient) {?>
        <tr id="<?= $patient['lastname'] ?>">
            <td><?= $patient['lastname'] ?></td>
            <td><?= $patient['firstname'] ?></td>
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
