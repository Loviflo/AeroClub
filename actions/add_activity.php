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
$mode = isset($_GET['mode']) ? $_GET['mode'] :null;

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
/* 

*/
switch ($type) {
    case 2:
        $plane = 1;
        break;
    case 4:
        $plane = 2;
        break;
    case 3:
        $plane = rand(3, 4);
        break;
    case 9:
        $plane = 2;
        break;
}

$db = getDatabaseConnection();
if ($mode != 'solo') {
    $result = $db->query("SELECT trainers.id FROM trainers WHERE NOT EXISTS (SELECT * FROM schedule WHERE start = '". $dateStart ."' AND id_trainer = trainers.id) ORDER BY RAND() LIMIT 1")->fetch();
}
$idTrainer = isset($result['id']) ? $result['id'] : null;

$q = 'INSERT INTO schedule (id_activity,start,end,id_member,id_trainer,id_plane,mode) VALUES (?, ?, ?, ?, ?, ?, ?)';
$req = $db->prepare($q);
$req->execute([$type, $dateStart, $dateEnd, $idMember, $idTrainer, $plane, $mode]);

if ($type == 2) {
if ($mode == 'trainer') {
    $sql = 'UPDATE members SET trainingHours = trainingHours+2 WHERE id = "' . $idMember . '"';
} else if($mode == 'solo') {
    $sql = 'UPDATE members SET soloHours = soloHours+2 WHERE id = "' . $idMember . '"';
}
$req = $db->prepare($sql);
$req->execute();
}


header('location: ../CalendarWeek.php?type=' . $type . '&week=' . $week . '&year=' . $year . '');
