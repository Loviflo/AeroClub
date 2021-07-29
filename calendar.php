<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'utils/head.php'; ?>
    <title>Réservation</title>
    <link rel="stylesheet" href="CSS/calendar.css">
    <?php
    ini_set("display_errors", 1);
    ?>
</head>

<body>
<?php include 'utils/header.php'; ?>
<?php
require_once('utils/database.php');
require 'src/Date/Month.php';
$month = new Month($_GET["month"] ?? null, $_GET["year"] ?? null);
$start = $month->getFirstDay()->modify('last monday');
?>

<div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
    <h1><?= $month->toString(); ?></h1>
    <div>
        <a href="?month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-primary">&lt;</a>
        <a href="?month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-primary">&gt;</a>
    </div>
</div>


<table class="table calendar__table calendar__table--<?= $month->getWeeks(); ?>weeks">
    <?php
    /*$bdd = getDatabaseConnection();
    $q = 'SELECT TO_DO, TO_DO FROM TO_DO';
    $req = $bdd->prepare($q);
    $req->execute();
    $results = $req->fetchAll();*/
    for ($i = 0; $i < $month->getWeeks(); $i++) :?>
        <tr>
            <?php foreach ($month->days as $k => $day) :
                $date = (clone $start)->modify("+" . $k + $i * 7 . " days");
                ?>
                <td class="<?= $month->withinMonth($date) ? '' : 'calendar__othermonth'; ?>">
                    <?php if ($i === 0) : ?><div class="calendar__weekday"><?= $day; ?></div><?php endif; ?>
                    <div class="calendar__day"><?= $date->format('d'); ?></div>
                    <?/*php foreach ($results as $key => $user) {
                        if ($user["TO_DO"] == null){*/?>
                           <a href='actions/new_reservation.php'><button type='button' class='btn btn-primary'>Réservez</button></a>
                        <?//}else{?>
                            <button type='button' class='btn btn-danger'>Créneau indisponible</button></a>
                        <?//}
                    //}?>

                </td>
            <?php endforeach; ?>
        </tr>
    <?php endfor; ?>

</table>
<?php include 'utils/footer.php'; ?>
</body>

</html>