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


    require 'src/Calendar/Week.php';
    require 'src/Calendar/Activities.php';
    $type = $_GET['type'];
    $activities = new Calendar\Activities();
    $hours = new Calendar\Activities();
    $week = new Calendar\Week($_GET["year"] ?? null, $_GET["week"] ?? null);
    $start = $week->getFirstDay();
    $end = (clone $start)->modify('+ 6 days');
    $activities = $activities->getActivitiesBetweenByDay($start, $end, $type);
    $reserved = $hours->getActivitiesByHour($start, $end, $type);
    $weekGET = $week->week;
    $yearGET = $week->year;
    ?>

    <div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
        <h1><?= $week->toString(); ?></h1>
        <div>
            <a href="?week=<?= $week->previousWeek()->week; ?>&year=<?= $week->previousWeek()->year; ?>&type=<?= $type ?>" class="btn btn-primary">&lt;</a>
            <a href="?week=<?= $week->nextWeek()->week; ?>&year=<?= $week->nextWeek()->year; ?>&type=<?= $type ?>" class="btn btn-primary">&gt;</a>
        </div>
    </div>

    <table class="table calendar__table">

        <?php
        for ($h = 0; $h < 6; $h++) { ?>
            <tr>
                <td class="calendar__hours">
                    <!-- First column -->
                    <?php if ($h === 0) : ?>
                        <h3 style="text-align: center;">Heures</h3>
                    <?php endif; ?>
                    <?php if ($h > 0) : ?>
                        <h4 style="text-align: center;"><?= 2 * $h + 8 ?>h</h4>
                        <h4 style="text-align: center;"><?= 2 * $h + 10 ?>h</h4>
                    <?php endif; ?>
                </td>
                <?php for ($d = 1; $d < 8; $d++) {
                    $date = (clone $start)->modify("+" . $d - 1 . " days");
                    if ($h == 0) { ?>
                        <td>
                            <div class="calendar__weekday"><?= $week->days[$d - 1] ?></div>
                            <div class="calendar__day"><?= $date->format('d/m'); ?></div>
                        </td>
                        <?php } else {
                        if ($reserved[$d][$h]) { ?>
                            <td style="background-color: grey;"></td>
                        <?php } else { ?>
                            <td onmouseover=style.backgroundColor='blue' ; onmouseout=style.backgroundColor='' ; onclick=window.location.href="actions/add_activity.php?hour=<?= $h ?>&day=<?= $date->format('Y-m-d') ?>&type=<?= $type ?>&week=<?= $weekGET ?>&year=<?= $yearGET ?>"></td>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </tr>
        <?php } ?>

    </table>
    <?php include 'utils/footer.php'; ?>
</body>

</html>