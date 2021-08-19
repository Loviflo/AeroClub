<?php
session_start();
require_once('../utils/database.php');
ini_set("display_errors", 1);

$hour = $_GET['hour'];
$day = $_GET['day'];
$idMember = $_SESSION['user']['id'];
$type = $_GET['type'];
$db = getDatabaseConnection();
$week = $_GET['week'];
$year = $_GET['year'];

switch ($hour) {
    case 1:
        $date = $day . ' 10:00';
        $dateStart = new DateTime($date);
        $dateEnd = (clone $dateStart)->add(new DateInterval('PT2H'))->format('Y-m-d H:i:s');
        $dateStart = $dateStart->format('Y-m-d H:i:s');
        break;
    case 2:
        $date = $day . ' 12:00';
        $dateStart = new DateTime($date);
        $dateEnd = (clone $dateStart)->add(new DateInterval('PT2H'))->format('Y-m-d H:i:s');
        $dateStart = $dateStart->format('Y-m-d H:i:s');
        break;
    case 3:
        $date = $day . ' 14:00';
        $dateStart = new DateTime($date);
        $dateEnd = (clone $dateStart)->add(new DateInterval('PT2H'))->format('Y-m-d H:i:s');
        $dateStart = $dateStart->format('Y-m-d H:i:s');
        break;
    case 4:
        $date = $day . ' 16:00';
        $dateStart = new DateTime($date);
        $dateEnd = (clone $dateStart)->add(new DateInterval('PT2H'))->format('Y-m-d H:i:s');
        $dateStart = $dateStart->format('Y-m-d H:i:s');
        break;
    case 5:
        $date = $day . ' 18:00';
        $dateStart = new DateTime($date);
        $dateEnd = (clone $dateStart)->add(new DateInterval('PT2H'))->format('Y-m-d H:i:s');
        $dateStart = $dateStart->format('Y-m-d H:i:s');
        break;
}

switch ($type) {
    case 2:
        $plane = 1;
        $price = 323.2;
        break;
    case 4:
        $plane = 2;
        $price = 390;
        break;
    case 3:
        $plane = rand(3, 4);
        $price = 390;
        break;
}

$db = getDatabaseConnection();
$q = 'INSERT INTO schedule (id_activity,start,end,id_member,id_trainer,id_plane) VALUES (?, ?, ?, ?, ?, ?)';
$req = $db->prepare($q);
$req->execute([$type, $dateStart, $dateEnd, $idMember, 1, $plane]);

if ($type == 'BREVET') {
    $sql = 'UPDATE members SET trainingHours = trainingHours+2 WHERE id = "' . $idMember . '"';
} else {
    $sql = 'UPDATE members SET soloHours = soloHours+2 WHERE id = "' . $idMember . '"';
}
$req = $db->prepare($sql);
$req->execute();


header('location: ../CalendarWeek.php?type=' . $type . '&week=' . $week . '&year=' . $year . '');
