<?php
require_once 'includes/header.php';
?>
 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 alert alert-secondary">
            <h1>Rendez-vous du patient</h1>
            <form method="post" action="#" novalidate>
               <div name="bloc1">
                   <fieldset>
                       <legend>Ses coordonnées</legend>
                       <div class="form-group">
                           <label for="lastname">Nom : </label>
                           <input type="text" class="form-control" name="lastname" id="lastname" placeholder="KIROUL" value="<?= $rdv->lastname ?>">
                           <span class="text-danger"><?= ($errors['lastname']) ?? '' ?></span>
                       </div>
                       <div class="form-group">
                           <label for="firstname">Prénom : </label>
                           <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Pierre" value="<?= $rdv->firstname ?>">
                           <span class="text-danger"><?= ($errors['firstname']) ?? '' ?></span>
                       </div>
                       <div class="form-group">
                           <label for="birthdate">Date de naissance : </label>
                           <input type="date" class="form-control" name="birthdate" id="birthdate" min="1900-01-01" max="2020-01-01" value="<?= $rdv->birthdate ?>">
                           <span class="text-danger"><?= ($errors['birthdate']) ?? '' ?></span>
                       </div>
                       <div class="form-group">
                           <label for="phone">Téléphone : </label>
                           <input type="tel" class="form-control" name="phone" id="phone" placeholder="06.22.95.01.02" value="<?= $rdv->phone ?>">
                           <span class="text-danger"><?= ($errors['phone']) ?? '' ?></span>
                       </div>
                       <div class="form-group">
                           <label for="mail">Email : </label>
                           <input type="email" class="form-control" name="mail" id="mail" placeholder="pierre.kiroul@lamanu.fr" value="<?= $rdv->mail ?>">
                           <span class="text-danger"><?= ($errors['mail']) ?? '' ?></span>
                       </div>
                       <div class="form-group">
                           <label for="dateRdv">Date du rendez-vous : </label>
                           <input type="date" class="form-control" name="dateRdv" id="dateRdv" min="1900-01-01" max="2020-01-01" value="<?= substr($rdv->dateHour,0,10) ?>">
                           <span class="text-danger"><?= ($errors['dateRdv']) ?? '' ?></span>
                       </div>
                       <div class="form-group">
                           <label for="hourRdv">Heure du rendez-vous : </label>
                           <input type="text" class="form-control" name="hourRdv" id="hourRdv" min="09:00" max="19:00" placeholder="00:00" value="<?= substr($rdv->dateHour,11,5) ?>">
                           <span class="text-danger"><?= ($errors['hourRdv']) ?? '' ?></span>
                       </div>
                       <input class=" btn btn-warning " name="modify-appointment" type="submit" value="Modifier un rendez-vous">
                       <input type="reset"  name="reset" value="Effacez" />
                   </fieldset>
               </div>
           </form>
        </div>
    </div>
</div>
<?php
require_once 'includes/footer.php';
