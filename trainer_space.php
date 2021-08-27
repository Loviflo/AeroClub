<?php
$month = date('m');
$days = date('t');
$year = date('Y');
$start_month = $year . '-' . $month . '-' . "01";
$end_month = $year . '-' . $month . '-' . $days;

$now = new dateTime("now", new dateTimezone('Europe/Paris'));

ini_set('display_errors', 1);
require_once('utils/database.php');
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <?php include 'utils/head.php'; ?>
        <title>Espace Formateur</title>
    </head>
    <body class="d-flex flex-column h-100">        
        <?php include 'utils/header.php'; ?>
        <div class="container">
            <h1 style="text-align: center;">Espace formateur</h1>
            <div class="row">
                <div class="col">
                    <?php
                        $bdd = getDatabaseConnection();
                        $q = 'SELECT DISTINCT(start) as start, end, id_activity, id_trainer, mode FROM schedule WHERE id_trainer = ? AND start > ? ORDER BY schedule.start ASC';
                        $req = $bdd->prepare($q);
                        $req->execute([$_SESSION['user']['id'], $now->format('Y-m-d H:i:s')]);
                        $results = $req->fetchAll();
                    ?>
                    <h2 style="text-align: center;">Mes heures de cours : </h2>
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
                            <?php foreach ($results as $key => $activity) {
                                    $q2 = 'SELECT * FROM activity WHERE id = ?';
                                    $req2 = $bdd->prepare($q2);
                                    switch ($activity['id_activity']) {
                                        case 2:
                                            $type = 'Formation';
                                            break;
                                        case 3:
                                            $type = 'ULM';
                                            break;
                                        case 4:
                                            $type = 'Saut en parachute';
                                            break;
                                        case 9:
                                            $type = 'Baptême de l\'air';
                                            break;
                                    }
                                ?>
                            <tbody>
                            <tr>
                                <td><?= $activity['start']; ?></td>
                                <td><?= $activity['end']; ?> </td>
                                <td><?= $type; ?> </td>
                                <td><a onClick="javascript: return confirm('Veuillez comfirmer la suppression');" href="actions/cancel_class.php?id_trainer=<?php echo $activity['id_trainer'] . '&start=' . $activity['start'] . '&mode=' . $activity['mode']?>" class="btn btn-danger" style="margin: 10px"><i class="fas fa-trash" style="text-align: center"></i></a></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </ul>
                </div>
            </div>
            <div class="col" style="text-align: center">
                <a onClick="javascript: return confirm('Attention cette action doit seulement être effectuer à la fin du mois');" class='btn btn-primary buttonColor' href="<?php echo 'actions/exportBill.php?start_month=' . $start_month . '&end_month='. $end_month?>">Exporter la facture des activités des membres</a>
                <a class='btn btn-primary buttonColor' href="actions/manageMembers.php">Gérer les membres</a>
            </div>
        </div>
        <?php include("utils/footer.php"); ?>
    </body>
</html>