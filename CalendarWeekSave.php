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

<body class="d-flex flex-column h-100">    <?php include 'utils/header.php'; ?>
    <?php

    require_once('utils/database.php');


    require 'src/Calendar/Week.php';
    // require 'src/Calendar/week.php';
    require 'src/Calendar/Activities.php';
    $activities = new Calendar\Activities();
    $hours = new Calendar\Activities();
    $week = new Calendar\Week($_GET["year"] ?? null, $_GET["week"] ?? null);
    $start = $week->getFirstDay();
    $end = (clone $start)->modify('+ 6 days');
    $activities = $activities->getActivitiesBetweenByDay($start, $end);
    $hours = $hours->getActivitiesByHour($start,$end);
    ?>

    <div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
        <h1><?= $week->toString(); ?></h1>
        <div>
            <a href="?week=<?= $week->previousWeek()->week; ?>&year=<?= $week->previousWeek()->year; ?>" class="btn btn-primary">&lt;</a>
            <a href="?week=<?= $week->nextWeek()->week; ?>&year=<?= $week->nextWeek()->year; ?>" class="btn btn-primary">&gt;</a>
        </div>
    </div>

    <table class="table calendar__table">
        <?php
        /*$bdd = getDatabaseConnection();
    $q = 'SELECT TO_DO, TO_DO FROM TO_DO';
    $req = $bdd->prepare($q);
    $req->execute();
    $results = $req->fetchAll();*/
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
                    <td  
                    <?php foreach ($activitiesForDay as $activity) : ?>
                            <?php for ($j = 1; $j < 6; $j++) : ?>
                                <?php if ((new DateTime($activity['start']))->format('H') == 2 * $j + 8 && $i == $j) {
                                     ?>style="background-color: grey;"
                                <?php } else if((new DateTime($activity['start']))->format('H') == 2 * $j + 8 && $i !== $j && $i !== 0) { ?> onmouseover="style.backgroundColor = 'blue';" onmouseout="style.backgroundColor = ''" onclick="console.log('hello')"
                            <?php } endfor; ?>
                        <?php endforeach; ?> 
                        <?php for ($j = 1; $j < 6; $j++) : ?>
                            <?php if($i !== $j && $i !== 0) { ?> onmouseover="style.backgroundColor = 'blue';" onmouseout="style.backgroundColor = ''" onclick="console.log('hello')"
                        <?php } endfor; ?> >
                        <?php if ($i === 0) : ?>
                            <div class="calendar__weekday"><?= $day; ?></div>
                            <div class="calendar__day"><?= $date->format('d/m'); ?></div>
                        <?php endif; ?>
                        <?/*php foreach ($results as $key => $user) {
                        if ($user["TO_DO"] == null){*/ ?>
                        <!-- <a href='actions/new_reservation.php'><button type='button' class='btn btn-primary'>Réservez</button></a> -->
                        <? //}else{
                        ?>
                        <!-- <button type='button' class='btn btn-danger'>Créneau indisponible</button></a> -->
                        <? //}
                        //}
                        ?>

                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endfor; ?>

    </table>
    <?php include 'utils/footer.php'; ?>
</body>

</html>