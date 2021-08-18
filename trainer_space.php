<?php
$month = date('m');
$days = date('t');
$year = date('Y');
$start_month = $year . '-' . $month . '-' . "01";
$end_month = $year . '-' . $month . '-' . $days;
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <?php include 'utils/head.php'; ?>
        <title>Espace Formateur</title>
    </head>
    <body>
        <?php include 'utils/header.php'; ?>
        <div class="container">
            <h1 style="text-align: center;">Espace formateur</h1>
            <div class="row">
                <div class="col">
                    <h2 style="text-align: center;">Mes heures de cours : </h2>
                </div>
                <div class="col">
                    <h2 style="text-align: center;">Mes disponibilités : </h2>
                </div>
            </div>
            <div class="row">
                <a class='btn btn-primary' href="<?php echo 'actions/exportBill.php?start_month=' . $start_month . '&end_month='. $end_month?>">Exporter la facture des activités des membres</a>
            </div>
        </div>
        <?php include("utils/footer.php"); ?>
    </body>
</html>