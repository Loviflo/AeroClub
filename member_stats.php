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
    <div class="wrapper">
        <?php include 'utils/header.php'; ?>
        <?php
        $bdd = getDatabaseConnection();
        $mail = $_SESSION['user']['mail'];
        $soloHours = $bdd->query("SELECT soloHours From members WHERE mail = '$mail' LIMIT 1")->fetch();
        $trainingHours = $bdd->query("SELECT trainingHours From members WHERE mail = '$mail' LIMIT 1")->fetch();

        ?>
        <div class="container">
            <h1 style="text-align: center;">Espace Membre</h1>
            <h2 style="text-align: center;">Mes statistiques</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Heures en solo</th>
                        <th>Heures en entraînement</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $soloHours['soloHours']; ?></td>
                        <td><?= $trainingHours['trainingHours']; ?></td>
                    </tr>
                </tbody>
            </table>
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