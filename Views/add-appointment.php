<?php
require_once 'includes/header.php';
?>
<div class="container">
    <?php if (isset($success)): ?>
        <div class="alert alert-success alert-dismissable" role="alert">
            <p>Le rendez-vous a été créé avec succès !</p>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="card col-sm-7 offset-2 bg-light">
            <div class="card-header font-weight-bold bg-info">
                <h1>Ajout de rendez vous</h1>
            </div>
            <form method="post" action="#">
                <p> Veuillez remplir les champs </p>
                <div class="identity">
                    <label for=""> Rechercher un patient: </label>
                    <input type="text" id="searchPatient" autocomplete="off"/>
                    <input type="hidden" id="idPatient" name="idPatient"/>
                    <div id="suggestBox">
                        <ul class="list-group">
                       
                        </ul>
                    </div>
                </div>
                <div class="appointment">
                    <label for="periodpicker"> Date et heure du rendez-vous: </label>
                    <input id="periodpicker" name="dateHour" type="text" />
                </div>
                <div class="button col-10 offset-2 mb-3 mt-3">
                    <input class=" btn btn-warning " name="create-appointment" type="submit" value="Ajouter un rendez-vous">
                    <a class="btn btn-success" href="liste-rdvController.php">Liste des rendez-vous</a>
                    <a class="btn btn-dark" href="index.php">Accueil</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../assets/js/jquery.js"></script>
<script src="../assets/js/jquery.datetimepicker.full.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js"></script>
<script src="../assets/js/ajax.js"></script>
<script>
    var min_date = new Date();
    jQuery.datetimepicker.setLocale('fr');
    jQuery('#periodpicker').datetimepicker({
        format: 'd.m.Y H:i',
        minDate: min_date,
        inline: false,
        lang: 'fr'
    });
   
</script>






<?php
require_once 'includes/footer.php';
?>

