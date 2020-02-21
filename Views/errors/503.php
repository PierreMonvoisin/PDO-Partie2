<?php
//Constante magique pour donner le chemin absolu(voir doc php)
require_once  dirname(__FILE__).'/../includes/header.php';
?>
<h1>Une erreur est survenue lors de modification</h1>
<p>Veuillez contacter l'administeur du site</p>
<a href='../../Controllers/list-patientsController.php'>Retour à la liste des patients</a>

<?php
require_once dirname(__FILE__).'/../includes/footer.php';
?>
