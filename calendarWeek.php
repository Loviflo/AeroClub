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
    // require 'src/Calendar/week.php';
    require 'src/Calendar/Activities.php';
    $type = $_GET['type'];
    $activities = new Calendar\Activities();
    $hours = new Calendar\Activities();
    $week = new Calendar\Week($_GET["year"] ?? null, $_GET["week"] ?? null);
    $start = $week->getFirstDay();
    $end = (clone $start)->modify('+ 6 days');
    $activities = $activities->getActivitiesBetweenByDay($start, $end, $type);
    $hours = $hours->getActivitiesByHour($start, $end, $type);
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
        // var_dump($hours);
        $length = count($hours);
        $hourIter = [];
        $dayIter = [];
        $x = 1;
        for ($i = 0; $i < 6; $i++) : ?>
            <tr>
                <td class="calendar__hours">
                    <?php if ($i === 0) : ?>
                        <h3 style="text-align: center;">Heures</h3>
                    <?php endif; ?>
                    <?php if ($i > 0) : ?>
                        <h4 style="text-align: center;"><?= 2 * $i + 8 ?>h</h4>
                        <h4 style="text-align: center;"><?= 2 * $i + 10 ?>h</h4>
                    <?php endif; ?>
                </td>
                <?php foreach ($week->days as $k => $day) :
                    $date = (clone $start)->modify("+" . $k . " days");
                    $activitiesForDay = $activities[$date->format('Y-m-d')] ?? [];
                ?>
                    <td <?php foreach ($hours as $hour) {
                            if ($i == $hour[1][0] && $k == $hour[0][0]) {
                                echo 'style="background-color: grey;"';
                                $hourIter[$x] = $hour[1][0];
                                $dayIter[$x] = $hour[0][0];
                                $x++;
                            } else /*if (count($hourIter) == $length) {
                                for ($l = 1; $l < $length; $l++) { */
                                if ($hour[1][0] !== $i && $hour[0][0] !== $k && $i !== 0) { ?> onmouseover=style.backgroundColor='blue' ; onmouseout=style.backgroundColor='' ; onclick=window.location.href="actions/add_activity.php?hour=<?= $i ?>&day=<?= $date->format('Y-m-d') ?>&type=<?= $type ?>" <?php }
                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                //}
                                                                                                                                                                                                                                                                                                //}



                                                                                                                                                                                                                                                                                                            ?>>
                        <?php if ($i === 0) : ?>
                            <div class="calendar__weekday"><?= $day; ?></div>
                            <div class="calendar__day"><?= $date->format('d/m'); ?></div>
                        <?php endif; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endfor;
        // echo count($hourIter);
        ?>

    </table>
    <?php include 'utils/footer.php'; ?>
</body>

</html>