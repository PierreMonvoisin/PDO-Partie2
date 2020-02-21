<?php
require_once 'includes/header.php';
?>
 <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 alert alert-secondary">
            <h2>Liste des rendez-vous</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                    <th>0</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date de rendez-vous</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($rdvList) > 0) {
                    foreach ($rdvList AS $rdvId => $rdv){
                    ?>
                    <tr>
                        <td><?= $rdvId + 1 ?></td>
                        <td><a href="rendezvousController.php?id=<?= $rdv['id'] ?>"><?= $rdv['lastname'] ?></a></td>
                        <td><?= $rdv['firstname'] ?></td>
                        <td><?= $rdv['dateHour'] ?></td>
                    </tr>
                    <?php
                    }
                }
                    ?>
                </tbody>
            </table>
            <div class="btn  btn-warning col-sm-5"><a href="ajout-rendezvous.php" title="Ajouter un rendez-vous">Ajouter un rendez-vous</a></div>
        </div>
    </div>
 </div>
<?php
include 'includes/footer.php';
