<?php
require_once 'includes/header.php';
?>
<div class="container">
        <div class="justify-content-center row">
            <div class="col-6 border border-primary rounded p-5">
                <div class="justify-content-center row">            
                    <span class="display-1 col-2"><i class="fa fa-user" aria-hidden="true"></i></span>
                    <h2 class="text-center my-5 col-6">Profil Patient</h2>
                </div>
                <form method="post" novalidate>
                    <div class="form-group row">
                        <label for="lastname" class="col-sm-4 col-form-label col-form-label-lg font-weight-bold">Nom</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-lg" name="lastname" id="lastname" value="<?= $patient->lastname ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="firstname" class="col-sm-4 col-form-label col-form-label-lg font-weight-bold">Prénom</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-lg" name="firstname" id="firstname" value="<?= $patient->firstname ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="birthdate" class="col-sm-4 col-form-label col-form-label-lg font-weight-bold">Date de naissance</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control form-control-lg" name="birthdate" id="birthdate" value="<?= $patient->birthdate ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-sm-4 col-form-label col-form-label-lg font-weight-bold">Téléphone</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-lg" name="phone" id="phone" value="<?= $patient->phone ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="mail" class="col-sm-4 col-form-label col-form-label-lg font-weight-bold">Email</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-lg" name="mail" id="mail" value="<?= $patient->mail ?>" required>
                        </div>
                    </div>
                    <div>
                        <ul class="list-group text-center">
                            <li class="list-group-item"><span class="font-weight-bold"></span><?= ($appointment->dateHour) ?? 'Pas de rendez-vous' ?></li>
                        </ul>
                    </div>
                    <button type="submit" class="btn btn-outline-primary float-right mt-4">Envoyer les modifications</button>
                </form>
            </div>
            <div class="col-md-6">
                <?php
                if(count($appointmentsList)==0){ ?>
                <p>Aucun rendez-vous disponible !</p>
                <?php } 
                else { ?>
                    <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Date et heure du rendez-vous</th>
                        </tr>
                   </thead>
                   <tbody>
                <?php
                    foreach($appointmentsList as $appointment_info):  
                ?>
                       <tr>
                           <td><?= $appointment_info->dateHour ?></td>
                       </tr>
                     
                    <?php endforeach; ?>
                   </tbody>
                </table> 
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
require_once 'includes/footer.php';