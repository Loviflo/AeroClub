<?php
session_start();
require_once('../utils/database.php');
ini_set("display_errors", 1);

$hour = $_GET['hour'];
$day = $_GET['day'];
$idMember = $_SESSION['user']['id'];
$type = $_GET['type'];
$week = $_GET['week'];
$year = $_GET['year'];

// Switch pour chaque heure
switch ($hour) {
    // Pour formater la date pour la suppression dans la base de données
    case 1:
        $date = $day . ' 10:00'; // Ajout de l'heure à la date
        $dateStart = new DateTime($date); // Conversion en DateTime pour les méthodes PHP
        $dateStart = $dateStart->format('Y-m-d H:i:s'); // Formatage pour la suppression dans la base de données
        break;
    case 2:
        $date = $day . ' 12:00';
        $dateStart = new DateTime($date);
        $dateStart = $dateStart->format('Y-m-d H:i:s');
        break;
    case 3:
        $date = $day . ' 14:00';
        $dateStart = new DateTime($date);
        $dateStart = $dateStart->format('Y-m-d H:i:s');
        break;
    case 4:
        $date = $day . ' 16:00';
        $dateStart = new DateTime($date);
        $dateStart = $dateStart->format('Y-m-d H:i:s');
        break;
    case 5:
        $date = $day . ' 18:00';
        $dateStart = new DateTime($date);
        $dateStart = $dateStart->format('Y-m-d H:i:s');
        break;
}

$db = getDatabaseConnection();
// On récupère le mode de l'activité. C'est-à-dire en solo ou avec le formateur
$result = $db->query("SELECT mode From schedule WHERE start = '". $dateStart ."' AND id_member = ". $idMember ." AND id_activity = ". $type)->fetch();

// On enlève le nombre d'heures de formation en fonction du mode
if (isset($result['mode'])) {
    if ($result['mode'] == 'trainer') {
        $sql = 'UPDATE members SET trainingHours = trainingHours-2 WHERE id = "' . $idMember . '"';
    } else if($result['mode'] == 'solo') {
        $sql = 'UPDATE members SET soloHours = soloHours-2 WHERE id = "' . $idMember . '"';
    }
    $req = $db->prepare($sql);
    $req->execute();
}

// On supprime l'activité
$sql = 'DELETE FROM schedule WHERE start = ? AND id_member = ? AND id_activity = ?';
$req = $db->prepare($sql);
$req->execute([$dateStart, $idMember, $type]);

header('location: ../CalendarWeek.php?type=' . $type . '&week=' . $week . '&year=' . $year . '');
