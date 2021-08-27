<?php
ini_set('display_errors', 1);
require_once('utils/database.php');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <?php include 'utils/head.php'; ?>
    <title>Espace Membre - Vos activités</title>
</head>

<body class="d-flex flex-column h-100">

    <div class="wrapper">
        <?php include 'utils/header.php'; ?>
        <?php
        $totalPrice = 0;
        $totalActivity = 0;
        $bdd = getDatabaseConnection();
        $idMember = $_SESSION['user']['id'];
        $showOldActivites = isset($_GET['oldActivities']) ? null : " AND start > NOW()";
        $sort = isset($_GET['oldActivities']) ? 'DESC' : 'ASC';
        $sql = 'SELECT activities.type as type, start, DATE_FORMAT(start, "%Hh%i %d/%m/%Y") as startFormat, DATE_FORMAT(end, "%Hh%i %d/%m/%Y") as end, activities.cost as cost, schedule.id_trainer as id_trainer FROM schedule INNER JOIN activities ON schedule.id_activity = activities.id WHERE id_member = ' . $idMember . $showOldActivites . ' ORDER BY start '. $sort .'';
        $req = $bdd->prepare($sql);
        $req->execute();
        $activities = $req->fetchAll();
        ?>
        <div class="container">
            <h1 style="text-align: center;">Espace Membre</h1>
            <h2 style="text-align: center;">Mes activités</h2>
            <a href="/AeroClub/member_space.php" class="btn btn-primary" style="background-color: #B8CCCF; border-color:#B8CCCF;">&lt;</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Formateur</th>
                        <th>Début</th>
                        <th>Fin</th>
                        <th>Tarif</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0;
                    foreach ($activities as $key => $activity) { ?>
                        <tr <?php if (date('Y-m-d H:i', strtotime(str_replace(array('/', 'h'), array('-', ':'), $activity['startFormat']))) < date('Y-m-d H:i') && $i < 1) {
                                echo 'style="border-top: 5px solid black"';
                                $i++;
                            } ?>>
                            <td scope="row"><?= $activity['type'] ?></td>
                            <td><?php
                                if ($activity['id_trainer'] !== NULL){
                                    $sql2 = 'SELECT firstname, lastname FROM trainers WHERE id = ?';
                                    $req2 = $bdd->prepare($sql2);
                                    $req2->execute([$activity['id_trainer']]);
                                    $trainer = $req2->fetch();
                                    echo $trainer['firstname'] . ' ' . $trainer['lastname'];
                                }else{
                                    echo 'Activité solo';
                                }
                                 ?></td>
                            <td><?= $activity['startFormat'] ?></td>
                            <td><?= $activity['end'] ?></td>
                            <td><?= $activity['cost'] ?> €</td>
                            <?php
                            $totalPrice += $activity['cost'];
                            $totalActivity++;
                            ?>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td><?= $totalActivity ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?= $totalPrice ?> €</td>
                    </tr>
                </tfoot>
            </table>
            <?php if (!isset($_GET['oldActivities'])) { ?>
                <a class="btn btn-primary text-center text-muted" style="background-color:#B8CCCF; border-color: #B8CCCF;" href="/AeroClub/memberActivities.php?oldActivities=yes" role="button">Voir mes anciennes activités</a>
            <?php } else { ?>
                <a class="btn btn-primary text-center text-muted" style="background-color:#B8CCCF; border-color: #B8CCCF;" href="/AeroClub/memberActivities.php" role="button">Cacher mes anciennes activités</a>
            <?php } ?>
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