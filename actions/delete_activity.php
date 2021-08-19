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

switch ($hour) {
    case 1:
        $date = $day . ' 10:00';
        $dateStart = new DateTime($date);
        $dateStart = $dateStart->format('Y-m-d H:i:s');
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
$sql = 'DELETE FROM activities WHERE start = ? AND id_member = ? AND type = ?';
$req = $db->prepare($sql);
$req->execute([$dateStart, $idMember, $type]);

if ($type == 'BREVET') {
    $sql = 'UPDATE members SET trainingHours = trainingHours-2 WHERE id = "' . $idMember . '"';
} else {
    $sql = 'UPDATE members SET soloHours = soloHours-2 WHERE id = "' . $idMember . '"';
}
$req = $db->prepare($sql);
$req->execute();

header('location: ../CalendarWeek.php?type=' . $type . '&week=' . $week . '&year=' . $year . '');
