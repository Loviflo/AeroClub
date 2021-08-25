<?php
ini_set('display_errors', 1);
require('utils/database.php');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <?php include 'utils/head.php'; ?>
    <title>Espace Membre</title>
</head>
<body class="d-flex flex-column h-100">
<body>
<div class="wrapper">
    <?php include 'utils/header.php'; ?>
    <?php
    $bdd = getDatabaseConnection();
    $id = $_SESSION['user']['id'];
    $member = $bdd->query("SELECT * From members WHERE id = '$id' LIMIT 1")->fetch();
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
                <li class="list-group-item">
                    Mail : <?= $member['mail'] ?>
                    <form action="actions/changeMail.php" method="post">
                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-3">
                                    <input type="email" class="form-control" id="email" placeholder="Nouvel email..." name="email" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-3">
                                    <button type="submit" class="btn btn-primary">Valider</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </li>
                <li class="list-group-item">Votre niveau : <?= $member['level'] ?></li>
            </ul>
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