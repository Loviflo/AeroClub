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

<body class="d-flex flex-column h-100"> 
    <?php include 'utils/header.php'; ?>
    <?php

    require_once('utils/database.php');

    $bdd = getDatabaseConnection();
    $id = $_SESSION['user']['id'];
    $soloHours = $bdd->query("SELECT soloHours From members WHERE id = '$id' LIMIT 1")->fetch();
    $trainingHours = $bdd->query("SELECT trainingHours From members WHERE id = '$id' LIMIT 1")->fetch();
    $level = $bdd->query("SELECT level From members WHERE id = '$id' LIMIT 1")->fetch();

    if ($level['level'] === "Aucun Brevet"){
        $toStringLevel = "Brevet de Base";
    }elseif ($level['level'] === "Brevet de Base"){
        $toStringLevel = "License Pilote D'avion léger";
    }elseif ($level['level'] === "License Pilote D'avion léger"){
        $toStringLevel = "Brevet de Pilote Privé";
    }
    $q = "SELECT soloRequired From activities WHERE name = ? LIMIT 1";
    $req = $bdd->prepare($q);
    $req->execute([$toStringLevel]);
    $soloRequired = $req->fetch();

    $q2 = "SELECT trainingRequired From activities WHERE name = ? LIMIT 1";
    $req2 = $bdd->prepare($q2);
    $req2->execute([$toStringLevel]);
    $trainingRequired = $req2->fetch();

    if (($soloRequired['soloRequired'] - $soloHours['soloHours']) <= 0 && ($trainingRequired['trainingRequired'] - $trainingHours['trainingHours']) <= 0){
        echo "<script>alert(\"Félicitations ! Vous avez obtenu le prochain niveau de brevet! Rendez-vous dans 'Votre compte' pour consulter votre nouveau niveau \")</script>";
        $q2 = 'UPDATE members SET soloHours = 0, trainingHours = 0, level = ? WHERE id = ?';
        $req2 = $bdd->prepare($q2);
        $req2->execute([$toStringLevel, $_SESSION['user']['id']]);
    }


    require 'src/Calendar/Week.php';
    require 'src/Calendar/Activities.php';
    $type = isset($_GET['type']) ? $_GET['type'] :null;
    $activities = new Calendar\Activities();
    $hours = new Calendar\Activities();
    $week = new Calendar\Week($_GET["year"] ?? null, $_GET["week"] ?? null);
    $start = $week->getFirstDay();
    $end = (clone $start)->modify('+ 6 days');
    $activities = $activities->getActivitiesBetweenByDay($start, $end, $type);
    $weekGET = $week->week;
    $yearGET = $week->year;
    $getWeek = isset($_GET['week']) ? $_GET['week'] : $week->week;
    $getYear = isset($_GET['year']) ? $_GET['year'] : $week->year;
    $reserved = $hours->getActivitiesByHour($start, $end, $type, $getYear, $getWeek);
    ?>

    <div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
        <?php 
        switch ($type) {
            case 2:
                echo '<h1>Formation</h1>';
                break;
            case 3:
                echo '<h1>ULM</h1>';
                break;
            case 4:
                echo '<h1>Saut en parachute</h1>';
                break;
            case 9:
                echo '<h1>Baptême de l\'air</h1>';
                break;
            
            default:
                echo '<h1>Toutes les activités</h1>';
                break;
        }
        ?>
        <h2><?= $week->toString(); ?></h2>
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
                        // $reserved[$d][$h] == 1 Plus de place
                        // $reserved[$d][$h] == 2 Réserver par l'utilisateur donc possibilité de supprimer
                        // $reserved[$d][$h] == 3 Pour l'ULM quand il n'y a plus qu'un place
                        // else Quand il y a de la place
                        if ($reserved[$d][$h] == 1) { ?>
                            <td style="background-color: #A7A7A9;" rel="tooltip" data-bs-placement="top" title="Il n'est malheureusement pas possible de réserver pour cet horaire."></td>
                        <?php } else if ($reserved[$d][$h] == 2) { ?>
                            <td class="cursor-pointer" onmouseover=style.backgroundColor='#64403E' ; onmouseout=style.backgroundColor='#5d737e' ; style="background-color: #5d737e;" rel="tooltip" data-placement="top" title="Annuler votre activité." data-bs-toggle="modal" data-bs-target="#deleteActivityModal" data-bs-url="actions/delete_activity.php?hour=<?= $h ?>&day=<?= $date->format('Y-m-d') ?>&type=<?= $type ?>&week=<?= $weekGET ?>&year=<?= $yearGET ?>"></td>
                        <?php } else if ($reserved[$d][$h] == 3) { ?>
                            <td class="cursor-pointer" onmouseover=style.backgroundColor='#838E83' ; onmouseout=style.backgroundColor='#EDB88B' ; style="background-color: #EDB88B;" rel="tooltip" data-bs-placement="top" title="Il ne reste plus qu'une seule place." data-bs-toggle="modal" data-bs-target="#validationModal" data-bs-url="actions/add_activity.php?hour=<?= $h ?>&day=<?= $date->format('Y-m-d') ?>&type=<?= $type ?>&week=<?= $weekGET ?>&year=<?= $yearGET ?>"></td>
                        <?php } else { ?>
                            <td class="cursor-pointer" onmouseover=style.backgroundColor='#838E83' ; onmouseout=style.backgroundColor='' ; rel="tooltip" data-bs-placement="top" title="Ajouter une activité." data-bs-toggle="modal" data-bs-target="#validationModal" data-bs-url="actions/add_activity.php?hour=<?= $h ?>&day=<?= $date->format('Y-m-d') ?>&type=<?= $type ?>&week=<?= $weekGET ?>&year=<?= $yearGET ?>"></td>
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
                    <?php if($type == 2) { ?>
                        <a type="button" id="solo" class="btn btn-primary text-muted" style="background-color: #B8CCCF;border-color:#B8CCCF;">Seul</a>
                        <a type="button" id="trainer" class="btn btn-primary text-muted" style="background-color: #B8CCCF;border-color:#B8CCCF;">Avec le moniteur</a>
                        <?php } else { ?>
                    <a type="button" id="send" class="btn btn-primary text-muted" style="background-color: #B8CCCF;border-color:#B8CCCF;">Valider</a>
                    <?php } ?>
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
        <?php if($type == 2) { ?>
            solo = recipient + '&mode=solo';
            trainer = recipient + '&mode=trainer';
            var soloButton = validationModal.querySelector('.modal-footer #solo');
            soloButton.href = solo
            var trainerButton = validationModal.querySelector('.modal-footer #trainer');
            trainerButton.href = trainer
        <?php } else { ?>
            var a = validationModal.querySelector('.modal-footer #send');
            a.href = recipient
        <?php } ?>
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
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[rel="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
</script>