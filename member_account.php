<?php
ini_set('display_errors', 1);
require('utils/database.php');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <?php include 'utils/head.php'; ?>
    <title>Espace Membre - Compte</title>
</head>

<body class="d-flex flex-column h-100">

    <body class="d-flex flex-column h-100">

        <div class="wrapper">
            <?php include 'utils/header.php'; ?>
            <?php
            $bdd = getDatabaseConnection();
            $id = $_SESSION['user']['id'];
            $member = $bdd->query("SELECT * From members WHERE id = '$id' LIMIT 1")->fetch();
            ?>
            <div class="container">
                <?php echo isset($_GET['ifail'])?$_GET['ifail']:null; ?>
                <h1 style="text-align: center;">Espace Membre</h1>
                <h2 style="text-align: center;">Mon compte</h2>
                <a href="/AeroClub/member_space.php" class="btn btn-primary mb-2" style="background-color: #B8CCCF; border-color:#B8CCCF;">&lt;</a>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <img style="width: 10%" src="Images/Profil%20Icon.png" alt="Card image cap">
                            </div>
                            <div class="col">
                                <h4 class="card-title">Nom complet</h4>
                                <p class="card-text"><?= $member['firstname'] . ' ' . $member['lastname'] ?></p>
                            </div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Mail : <?= $member['mail'] ?></li>
                        <li class="list-group-item">Votre niveau : <?= $member['level'] ?></li>
                        <li class="list-group-item">Votre license :
                            <?php if ($member['additionalCost'] == 74){
                                echo 'License simple (' . $member['additionalCost'] . ' EUR)';
                            }else{
                                echo 'License + revue (' . $member['additionalCost'] . ' EUR)';
                            }
                            ?></li>
                    </ul>
                </div>
            </div>
        </div>
        <div style="text-align: center">
            <a class="btn btn-primary mt-2 buttonColor" href="actions/updateInfo.php">Modifier mes informations</a>
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