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
                        if ($reserved[$d][$h] == 1) { ?>
                            <td style="background-color: #A7A7A9;"></td>
                        <?php } else if ($reserved[$d][$h] == 2) { ?>
                            <td onmouseover=style.backgroundColor='#64403E' ; onmouseout=style.backgroundColor='#5d737e' ; style="background-color: #5d737e;" data-bs-toggle="modal" data-bs-target="#deleteActivityModal" data-bs-url="actions/delete_activity.php?hour=<?= $h ?>&day=<?= $date->format('Y-m-d') ?>&type=<?= $type ?>&week=<?= $weekGET ?>&year=<?= $yearGET ?>"></td>
                        <?php } else if ($reserved[$d][$h] == 3) { ?>
                            <td onmouseover=style.backgroundColor='#838E83' ; onmouseout=style.backgroundColor='#EDB88B' ; style="background-color: #EDB88B;" data-bs-toggle="modal" data-bs-target="#validationModal" data-bs-url="actions/add_activity.php?hour=<?= $h ?>&day=<?= $date->format('Y-m-d') ?>&type=<?= $type ?>&week=<?= $weekGET ?>&year=<?= $yearGET ?>"></td>
                        <?php } else { ?>
                            <td onmouseover=style.backgroundColor='#838E83' ; onmouseout=style.backgroundColor='' ; data-bs-toggle="modal" data-bs-target="#validationModal" data-bs-url="actions/add_activity.php?hour=<?= $h ?>&day=<?= $date->format('Y-m-d') ?>&type=<?= $type ?>&week=<?= $weekGET ?>&year=<?= $yearGET ?>"></td>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </tr>
        <?php } ?>

    </table>
    <!-- Modal add activity -->
    <div class="modal fade" id="validationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Validation de la réservation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="message-text" class="col-form-label">Êtes-vous sûr de réserver cette activité ?</label>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <a type="button" id="send" class="btn btn-primary text-muted" style="background-color: #B8CCCF;border-color:#B8CCCF;">Valider</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal delete activity -->
    <div class="modal fade" id="deleteActivityModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Suppression de la réservation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="message-text" class="col-form-label">Êtes-vous sûr de supprimer cette activité ?</label>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <a type="button" id="send" class="btn btn-primary text-muted" style="background-color: #B8CCCF;border-color:#B8CCCF;">Valider</a>
                </div>
            </div>
        </div>
    </div>
    <?php include 'utils/footer.php'; ?>
</body>

</html>
<script>
    var validationModal = document.getElementById('validationModal')
    validationModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        var recipient = button.getAttribute('data-bs-url')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        var a = validationModal.querySelector('.modal-footer a')

        a.href = recipient
    });
    var deleteActivityModal = document.getElementById('deleteActivityModal')
    deleteActivityModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        var recipient = button.getAttribute('data-bs-url')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        var a = deleteActivityModal.querySelector('.modal-footer a')

        a.href = recipient
    });
</script>