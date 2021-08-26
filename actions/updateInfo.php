<?php
ini_set('display_errors', 1);
require('../utils/database.php');

$db = getDatabaseConnection();

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <?php include '../utils/head.php'; ?>
    <title>Espace Membre</title>
</head>

<body class="d-flex flex-column h-100">

<body class="d-flex flex-column h-100">

<div class="wrapper">
    <?php include '../utils/header.php'; ?>
    <?php
    $id = $_SESSION['user']['id'];
    $member = $db->query("SELECT * From members WHERE id = '$id' LIMIT 1")->fetch();
    ?>
    <div class="container">
        <h1 style="text-align: center;">Espace Membre</h1>
        <h2 style="text-align: center;">Modifier mes informations</h2>
        <form class="card" action="updateInfoProcess.php" method="post">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <img style="width: 20%" src="../Images/Profil%20Icon.png" alt="Card image cap">
                    </div>
                    <div class="col">
                        <h4 class="card-title">Nom complet</h4>
                        <p class="card-text"><?= $member['firstname'] . ' ' . $member['lastname'] ?></p>
                    </div>
                    <div class="col">
                            <div class="form-group mb-3">
                                <input onkeyup="success()" type="text" class="form-control" id="textsend" placeholder="Nouveau prénom..." name="firstname">
                                <input onkeyup="success()" type="text" class="form-control" id="textsend2" placeholder="Nouveau nom..." name="lastname">
                            </div>
                    </div>
                </div>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Mail : <?= $member['mail'] ?>
                    <!-- div class="form-group mb-3">
                        <input onkeyup="success()" type="email" class="form-control" id="textsend3" placeholder="Nouveau mail..." name="mail">
                    </div -->
                </li>
                <li class="list-group-item">Votre niveau : <?= $member['level'] ?></li>
                <li class="list-group-item">Mot de passe
                    <div class="form-group mb-3">
                        <input onkeyup="success()" type="password" class="form-control" id="password" placeholder="Nouveau mot de passe..." name="password">
                        <input onkeyup="success()" type="password" class="form-control" id="pswdConfirm" placeholder="Retapez votre mot de passe..." name="passwordConf">
                    </div>
                </li>
                <li class="list-group-item"><button id="button" type="submit" class="btn btn-primary" disabled>Valider</button></li>
            </ul>
        </form>
        </div>
    </div>
</div>
<?php include("../utils/footer.php"); ?>
</body>
<script>
    function deletehref(link) {
        let href = link.href;
        let idDeleteURL = document.getElementById('deleteURL');
        idDeleteURL.href = href;
    }
    function success() {
        if(document.getElementById("textsend").value!=="" || document.getElementById("textsend2").value!==""/* ||document.getElementById("textsend3").value!==""*/) {
            document.getElementById('button').disabled = false;
        } else {
            document.getElementById('button').disabled = true;
        }
        if(document.getElementById("password").value!=="") {
            document.getElementById('pswdConfirm').required = true;
            document.getElementById('button').disabled = false;
        }else{
            document.getElementById('pswdConfirm').required = false;
        }
    }
</script>

</html>



