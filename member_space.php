<?php
ini_set('display_errors', 1);
require_once('utils/database.php');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <?php include 'utils/head.php'; ?>
    <title>Espace Membre</title>
</head>
<?php include 'utils/header.php'; ?>
<div class="container">
    <h1 style="text-align: center;">Espace Membre</h1>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Votre compte</h5>
                    <a href="/AeroClub/member_account.php" class="btn btn-primary" style="background-color: #B8CCCF; border-color:#B8CCCF;">Voir</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <img src="/AeroClub/Images/calendar.png" class="card-img-top center" style="width:50%;" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Vos activités</h5>
                    <a href="/AeroClub/memberActivities.php" class="btn btn-primary" style="background-color: #B8CCCF; border-color:#B8CCCF;">Voir</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Vos statistiques</h5>
                    <a href="/AeroClub/member_stats.php" class="btn btn-primary" style="background-color: #B8CCCF; border-color:#B8CCCF;">Voir</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("utils/footer.php"); ?>
</body>
<script>
    function deletehref(link) {
        let href = link.href;
        let idDeleteURL = document.getElementById('deleteURL');
        idDeleteURL.href = href;
    }
</script>

</html>