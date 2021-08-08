<?php require 'src/Calendar/Activities.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'utils/head.php'; ?>
    <title>Activité</title>
    <link rel="stylesheet" href="CSS/calendar.css">
    <?php
    ini_set("display_errors", 1);
    ?>
</head>

<body>
    <?php
    require_once('utils/database.php');
    include 'utils/header.php';
    $activities = new Calendar\Activities();
    if (!isset($_GET['id'])) {
        e404();
    }
    try {
        $activity = $activities->find($_GET['id']);
    } catch (\Exception $e) {
        e404();
    }
    ?>

    <h1><?= $activity['type'] ?></h1>

    <ul>
        <li>Date: <?= (new DateTime($activity['start']))->format('d/m/Y'); ?></li>
        <li>Heure de début: <?= (new DateTime($activity['start']))->format('H\hi'); ?></li>
        <li>Heure de fin: <?= (new DateTime($activity['end']))->format('H\hi'); ?></li>

    </ul>

    <?php include 'utils/footer.php'; ?>
</body>

</html>