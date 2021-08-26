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
        $id = $_SESSION['user']['id'];
        $soloHours = $bdd->query("SELECT soloHours From members WHERE id = '$id' LIMIT 1")->fetch();
        $trainingHours = $bdd->query("SELECT trainingHours From members WHERE id = '$id' LIMIT 1")->fetch();
        $level = $bdd->query("SELECT level From members WHERE id = '$id' LIMIT 1")->fetch();

        if ($level['level'] === "Aucun Brevet"){
            $toStringLevel = "Brevet de Base";
        }elseif ($level['level'] === "Brevet de Base"){
            $toStringLevel = "License Pilote D'avion léger";
        }elseif ($level['level'] === "License Pilote D'avion léger"){
            $toStringLevel = "Brevet de Pilote Privé";
        }

        $q = "SELECT soloRequired From activities WHERE name = ? LIMIT 1";
        $req = $bdd->prepare($q);
        $req->execute([$toStringLevel]);
        $soloRequired = $req->fetch();

        $q2 = "SELECT trainingRequired From activities WHERE name = ? LIMIT 1";
        $req2 = $bdd->prepare($q2);
        $req2->execute([$toStringLevel]);
        $trainingRequired = $req2->fetch();
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
                        <td><?= ($soloRequired['soloRequired'] - $soloHours['soloHours']) <= 0? 0: $soloRequired['soloRequired'] - $soloHours['soloHours']; ?></td>
                        <td><?= ($trainingRequired['trainingRequired'] - $trainingHours['trainingHours']) <= 0? 0: $trainingRequired['trainingRequired'] - $trainingHours['trainingHours']; ?></td>
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