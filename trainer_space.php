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
                        $q = 'SELECT * FROM schedule WHERE id_trainer = ? AND start > ? ORDER BY schedule.start ASC';
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
                            <?php foreach ($results as $key => $activities) {
                                    $q2 = 'SELECT * FROM activities WHERE id = ?';
                                    $req2 = $bdd->prepare($q2);
                                    $req2->execute([$activities['id_activity']]);
                                    $results2 = $req2->fetchAll();
                                ?>
                            <tbody>
                            <tr>
                                <td><?= $activities['start']; ?></td>
                                <td><?= $activities['end']; ?> </td>
                                <td><?= $results2[0]['type']; ?> </td>
                                <td><a onClick="javascript: return confirm('Veuillez comfirmer la suppression');" href="actions/cancel_class.php?id_trainer=<?php echo $activities['id_trainer'] . '&start=' . $activities['start'] . '&end=' . $activities['end'] . '&mode=' . $activities['end']?>" class="btn btn-danger" style="margin: 10px"><i class="fas fa-trash" style="text-align: center"></i></a></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </ul>
                </div>
                <div class="col">
                    <h2 style="text-align: center;">Mes congés : </h2>
                </div>
            </div>
            <div class="col" style="text-align: center">
                <a onClick="javascript: return confirm('Attention cette action doit seulement être effectuer à la fin du mois');" class='btn btn-primary' href="<?php echo 'actions/exportBill.php?start_month=' . $start_month . '&end_month='. $end_month?>">Exporter la facture des activités des membres</a>
                <a class='btn btn-primary' href="actions/manageMembers.php">Gérer les membres</a>
            </div>
        </div>
        <?php include("utils/footer.php"); ?>
    </body>
</html>