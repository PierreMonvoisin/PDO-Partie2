<?php
require_once 'includes/header.php';
?>
    <div class="row">
        <div class="card col-sm-10 bg-light">
            <div class="card-header font-weight-bold bg-info">
                <h2>Etes vous sûr de vouloir supprimer le rendez vous de .. à ..</h2>
                <form action="#" method="post">
                    <input type="submit" class="btn btn-danger" name="deleteConfirm" value="supprimer">
                    <input type="submit" class="btn btn-info" name="deleteCancel" value="annuler">
                </form>
            </div>
        </div>
    </div>

<?php
require_once 'includes/footer.php';
?>