<?php
ini_set('display_errors', 1);
require_once('../utils/database.php');

$now = new dateTime("now", new dateTimezone('Europe/Paris'));
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <?php include '../utils/head.php'; ?>
    <title>Profil membre</title>
</head>

<body class="d-flex flex-column h-100">

    <?php include '../utils/header.php';
    $bdd = getDatabaseConnection();
    $q = 'SELECT * FROM members WHERE id = ?';
    $req = $bdd->prepare($q);
    $req->execute([$_GET['id_member']]);
    $member = $req->fetch();
    ?>
    <div class="container">
        <h1 style="text-align: center;">Profil</h1>
        <h2 style="text-align: center;">Compte</h2>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <img style="width: 10%" src="../Images/Profil%20Icon.png" alt="Card image cap">
                    </div>
                    <div class="col">
                        <h4 class="card-title">Nom complet</h4>
                        <p class="card-text"><?= $member['firstname'] . ' ' . $member['lastname'] ?></p>
                    </div>
                </div>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Mail : <?= $member['mail'] ?></li>
                <li class="list-group-item">Niveau : <?= $member['level'] ?></li>
                <li class="list-group-item">Nombre d'heures de vol en solo vers le prochain brevet : <?= $member['soloHours'] ?></li>
                <li class="list-group-item">Nombre d'heures de vol acoompagné vers le prochain brevet : <?= $member['trainingHours'] ?></li>
            </ul>
        </div>
        <?php
        $q2 = 'SELECT * FROM schedule WHERE id_member = ? AND start > ? ORDER BY schedule.start ASC';
        $req2 = $bdd->prepare($q2);
        $req2->execute([$_GET['id_member'], $now->format('Y-m-d H:i:s')]);
        $results2 = $req2->fetchAll(); ?>
        <h2 style="text-align: center;">Activités du mois</h2>
        <ul>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Début</th>
                        <th scope="col">Fin</th>
                        <th scope="col">Type d'activité</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <?php foreach ($results2 as $key => $activities) {
                    $q3 = 'SELECT * FROM activities WHERE id = ?';
                    $req3 = $bdd->prepare($q3);
                    $req3->execute([$activities['id_activity']]);
                    $results3 = $req3->fetchAll();
                ?>
                    <tbody>
                        <tr>
                            <td><?= $activities['start']; ?></td>
                            <td><?= $activities['end']; ?> </td>
                            <td><?= $results3[0]['type']; ?> </td>
                            <td><a onClick="javascript: return confirm('Veuillez comfirmer l'annulation'');" href="actions/cancel_class_single.php?id_member=<?php echo $activities['id_member'] . '&start=' . $activities['start'] . '&end=' . $activities['end'] . '&mode=' . $activities['mode']?>" class="btn btn-danger" style="margin: 10px"><i class="fas fa-trash" style="text-align: center"></i></a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
            </table>
        </ul>
    </div>
    <?php include("../utils/footer.php"); ?>
</body>