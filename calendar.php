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
    require 'src/Calendar/Month.php';
    require 'src/Calendar/Activities.php';
    $activities = new Calendar\Activities();
    $month = new Calendar\Month($_GET["month"] ?? null, $_GET["year"] ?? null);
    $start = $month->getFirstDay();
    $start = $start->format('N') === '1' ? $start : $month->getFirstDay()->modify('last monday');
    $weeks = $month->getWeeks();
    $end = (clone $start)->modify('+' . (6 + 7 * ($weeks - 1)) . ' days');
    $activities = $activities->getActivitiesBetweenByDay($start, $end);
    ?>

    <div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
        <h1><?= $month->toString(); ?></h1>
        <div>
            <a href="?month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-primary">&lt;</a>
            <a href="?month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-primary">&gt;</a>
        </div>
    </div>


    <table class="table calendar__table calendar__table--<?= $weeks; ?>weeks">
        <?php
        /*$bdd = getDatabaseConnection();
    $q = 'SELECT TO_DO, TO_DO FROM TO_DO';
    $req = $bdd->prepare($q);
    $req->execute();
    $results = $req->fetchAll();*/
        for ($i = 0; $i < $weeks; $i++) : ?>
            <tr>
                <?php foreach ($month->days as $k => $day) :
                    $date = (clone $start)->modify("+" . $k + $i * 7 . " days");
                    $activitiesForDay = $activities[$date->format('Y-m-d')] ?? [];
                ?>
                    <td class="<?= $month->withinMonth($date) ? '' : 'calendar__othermonth'; ?>">
                        <?php if ($i === 0) : ?>
                            <div class="calendar__weekday"><?= $day; ?></div>
                        <?php endif; ?>
                        <div class="calendar__day"><?= $date->format('d'); ?></div>
                        <?php foreach ($activitiesForDay as $activity) : ?>
                            <div class="calendar__activity">
                                <?= (new DateTime($activity['start']))->format('H\hi') ?> - <?= (new DateTime($activity['end']))->format('H\hi') ?> : <a href="activity.php?id=<?= $activity['id'] ?>"><?= $activity['type'] ?></a>
                            </div>
                        <?php endforeach; ?>
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