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
    $showOldActivites = isset($_GET['oldActivities']) ? null : " AND start > NOW()";
    $sql = 'SELECT type, start, DATE_FORMAT(start, "%Hh%i %d/%m/%Y") as startFormat, DATE_FORMAT(end, "%Hh%i %d/%m/%Y") as end, cost FROM activities WHERE id_member = (SELECT members.id FROM members where mail = "' . $mail . '")' . $showOldActivites . ' ORDER BY start DESC';
    $req = $bdd->prepare($sql);
    $req->execute();
    $activities = $req->fetchAll();
    ?>
    <div class="container">
        <h1 style="text-align: center;">Espace Membre</h1>
        <h2 style="text-align: center;">Mes activités</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Type</th>
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
                        <td><?= $activity['startFormat'] ?></td>
                        <td><?= $activity['end'] ?></td>
                        <td><?= $activity['cost'] ?> €</td>
                    </tr>
                <?php } ?>
            </tbody>
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