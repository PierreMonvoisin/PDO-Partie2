<?php
require_once 'connection.php';
$database = connectionToDatabase();

include 'input-cleaning.php';
$submitMessage = "Vous êtes bien enregistré";
if (isset($_GET['submit'])){
  foreach ($_GET as $key => $value){
    if ( $value == '' || $value == null ) {
      $submitMessage = 'Un des champs est incomplet';
    } else {
      $sanitizedInputs = sanitizeString($key, $value);
    }
  }
}
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <!-- ³ = alt + 0179 -->
  <title>PDO-Partie1-Exercice1</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/header.css">
  <link rel="stylesheet" href="assets/css/ajout-patient.css">
</head>
<body class="container-fluid p-0 bg-secondary">
  <?php include 'header.php' ?>
  <div class="jumbotron pt-4 my-5 mx-auto w-50">
    <h2 class="text-center">Formulaire d'inscription</h2>
    <form action="ajout-patient.php" method="get" autocomplete="on">
      <div class="form-group row my-4">
        <label for="firstname" class="col-sm-3 col-form-label text-center">Prénom :</label>
        <div class="col-sm-9">
          <input name="firstname" type="text" class="form-control" id="firstname" placeholder="John">
        </div>
      </div>
      <div class="form-group row my-4">
        <label for="lastname" class="col-sm-3 col-form-label text-center">Nom de famille :</label>
        <div class="col-sm-9">
          <input name="lastname" type="text" class="form-control" id="lastname" placeholder="Doe">
        </div>
      </div>
      <div class="form-group row my-4">
        <label for="birthdate" class="col-sm-3 col-form-label text-center">Date de naissance :</label>
        <div class="col-sm-9">
          <input name="birthdate" type="date" class="form-control" id="birthdate">
        </div>
      </div>
      <div class="form-group row my-4">
        <label for="phoneNumber" class="col-sm-3 col-form-label text-center">Téléphone portable :</label>
        <div class="col-sm-9">
          <input name="phoneNumber" type="text" class="form-control" id="phoneNumber" placeholder="06.11.22.33.44">
        </div>
      </div>
      <div class="form-group row my-4">
        <label for="Email" class="col-sm-3 col-form-label text-center">Email :</label>
        <div class="col-sm-9">
          <input name="Email" type="mail" class="form-control" id="Email" placeholder="john.doe@gmail.com">
        </div>
      </div>
      <div class="form-group row my-4">
        <div class="col-sm-9 offset-sm-3">
          <button name="submit" type="submit" class="btn btn-primary" value="on">S'inscrire</button>
        </div>
      </div>
    </form>
  </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
