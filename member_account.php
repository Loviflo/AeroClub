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
<div class="wrapper">
    <?php include 'utils/header.php'; ?>
    <?php
    $bdd = getDatabaseConnection();
    $mail = $_SESSION['user']['mail'];
    $member = $bdd->query("SELECT * From members WHERE mail = '$mail' LIMIT 1")->fetch();
    ?>
    <div class="container">
        <h1 style="text-align: center;">Espace Membre</h1>
        <h2 style="text-align: center;">Mon compte</h2>
<div class="card">
    <img class="card-img-top" src="" alt="Card image cap">
    <div class="card-body">
        <h4 class="card-title">Mon compte</h4>
        <p class="card-text"><?= $member['firstname'] . ' ' . $member['lastname'] ?></p>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">Mail : <?= $member['mail'] ?></li>
        <li class="list-group-item">Votre niveau : <?= $member['level'] ?></li>
    </ul>
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