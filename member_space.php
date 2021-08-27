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
<body class="d-flex flex-column h-100">
<?php include 'utils/header.php'; ?>
<div class="container">
    <h1 style="text-align: center;">Espace Membre</h1>
    <div class="row">
        <div class="col-lg-4">
            <img src="Images/account.png" class="card-img-top mx-auto d-block" alt="Account Icon" style="width: 50%">
            <div class="text-center">
                <h5 class="card-title mt-3">Votre compte</h5>
                <a href="/AeroClub/member_account.php" class="btn btn-primary buttonColor mt-2">Voir</a>
            </div>
        </div>
        <div class="col-lg-4">
            <img src="/AeroClub/Images/calendar.png" class="card-img-top center mx-auto d-block" style="width:50%;" alt="...">
            <div class="text-center">
                <h5 class="card-title mt-3">Vos activités</h5>
                <a href="/AeroClub/memberActivities.php" class="btn btn-primary buttonColor mt-2">Voir</a>
            </div>
        </div>
        <div class="col-lg-4">
            <img src="Images/training.png" class="card-img-top mx-auto d-block" alt="Training Icon" style="width: 50%">
            <div class="text-center">
                <h5 class="card-title mt-3">Votre formation</h5>
                <a href="/AeroClub/member_stats.php" class="btn btn-primary buttonColor mt-2">Voir</a>
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