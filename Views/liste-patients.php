<?php
require_once 'includes/header.php';
?>
<h2 class="text-center my-4">Liste des patients</h2>
<div class="justify-content-center row">
    <form method="post" action="#">
        <div class="form-group row ">
            <input type="text" class="form-control col-7" placeholder="Sélectionnez un Nom" name="search">
            <input type="submit" value="Recherche" class="btn btn-sm btn-outline-primary ml-2 col-4">
        </div> 
    </form>
</div>
<div class="row justify-content-center">
    <table class="table table-striped table-bordered col-8">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Profil</th>
                <th scope="col">Supprimer</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if (count($patientsList) > 0) {
                    foreach ($patientsList as $patientId => $patient):
                        ?>
                        <tr>
                            <td><?= $patientId + 1 ?></td>
                            <td><?= $patient['lastname'] ?></td>
                            <td><?= $patient['firstname'] ?></td>
                            <td><a href="../Controllers/profile-patientController.php?idPatient=<?= $patient['id'] ?>" class="btn btn-sm btn-primary" >Modifier</a></td>
                            <td><a href="../Controllers/delete-patientController.php?idPatient=<?= $patient['id'] ?>">Supprimer</a></td>
                        </tr>
                        <?php
                    endforeach;
                }
            ?>
        </tbody>
    </table>
</div>
<div class="justify-content-center d-flex">
    <a href="ajout-patient.php" class="btn btn-lg btn-primary">Ajouter des patients</a>
</div>
<?php
include 'includes/footer.php';