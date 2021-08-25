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
        $level = $bdd->query("SELECT level From members WHERE mail = '$mail' LIMIT 1")->fetch();

        if ($level['level'] === "Aucun Brevet"){
            $toStringLevel = "Brevet de Base";
        }elseif ($level['level'] === "Brevet de Base"){
            $toStringLevel = "License Pilote D'avion léger";
        }elseif ($level['level'] === "License Pilote D'avion léger"){
            $toStringLevel = "Brevet de Pilote Privé";
        }
        $soloLeft = $bdd->query("SELECT soloRequired From activities WHERE name = '$toStringLevel' LIMIT 1")->fetch();
        $trainingLeft = $bdd->query("SELECT trainingRequired From activities WHERE name = '$toStringLevel' LIMIT 1")->fetch();
        ?>
        <div class="container">
            <h1 style="text-align: center;">Espace Membre</h1>
            <h2 style="text-align: center;">Mes statistiques</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Heures en solo</th>
                        <th>Heures en entraînement</th>
                        <th>Brevet en cours</th>
                        <th>Heures en solo restantes</th>
                        <th>Heures en entraînement restantes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $soloHours['soloHours']; ?></td>
                        <td><?= $trainingHours['trainingHours']; ?></td>
                        <td><?= $toStringLevel; ?></td>
                        <td><?= ($soloLeft['soloRequired'] - $soloHours['soloHours']) <= 0? 0: $soloLeft['soloRequired'] - $soloHours['soloHours']; ?></td>
                        <td><?= ($trainingLeft['trainingRequired'] - $trainingHours['trainingHours']) <= 0? 0: $trainingLeft['trainingRequired'] - $trainingHours['trainingHours']; ?></td>
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