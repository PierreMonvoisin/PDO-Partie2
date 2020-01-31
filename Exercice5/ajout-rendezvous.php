<?php
// Connection à la base de données
require_once 'connection.php';
$database = connectionToDatabase(); ?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <title>PDO-Partie2</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/header.css">
</head>
<body class="container-fluid bg-secondary p-0">
<?php include 'header.php' ?>
<div class="jumbotron pt-4 my-5 mx-auto bg-primary w-50 shadow">
</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
