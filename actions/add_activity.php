<?php
session_start();
require_once('../utils/database.php');
ini_set("display_errors", 1);

$hour = $_GET['hour'];
$day = $_GET['day'];
$user = $_SESSION['user']['mail'];
$type = $_GET['type'];
$db = getDatabaseConnection();
$idMember = $db->query("SELECT id From members WHERE mail = '$user' LIMIT 1")->fetch();
$idMember = $idMember["id"];

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
    case 'BREVET':
        $plane = 1;
        $price = 323.2;
        break;
    case 'OTHER':
        $plane = 2;
        $price = 390;
        break;
    case 'ULM':
        $plane = rand(3,4);
        $price = 390;
        break;
}

$q = 'INSERT INTO activities (type,start,end,cost,id_member,id_trainer,id_plane) VALUES (?, ?, ?, ?, ?, ?, ?)';
$db = getDatabaseConnection();
$req = $db->prepare($q);
$req->execute([$type, $dateStart, $dateEnd, $price, $idMember, 1, $plane]);

header('location: ../CalendarWeek.php?type=' . $type . '');
