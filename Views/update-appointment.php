
<?php
require_once 'includes/header.php';
?>
 
<div class="container">
    <?php if (isset($success)) { ?>
     <p class="alert alert-success text-center">Le rendez vous a bien été modifié !</p>
    <?php } ?>
    <div class="row justify-content-center">
        <div class="col-md-8 alert alert-secondary">
            <h1>Rendez-vous du patient</h1>
            <p><?= $patient->firstname.' '. $patient->lastname ?></p>
            <div class="row justify-content-center bg-info">
                <div class="col-md-8 p-5">
                    <form method="POST" action="../Controllers/update-appointmentController.php">
                         <div class="appointment form-group">
                            <label for="periodpicker"> Date et heure du rendez-vous: </label>
                            <input name="datehour" class="form-control" id="periodpicker" value="<?= $currentDatehour ?>" type="text" />
                        </div>
                        <input type="hidden" name="oldDatehour" value="<?= $currentDatehour ?>" />
                        <input type="submit" value="Modifier le rendez-vous" class="btn btn-primary" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../assets/js/jquery.js"></script>
<script src="../assets/js/jquery.datetimepicker.full.js"></script>
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
