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

// Switch pour chaque heure
switch ($hour) {
    // Pour formater la date pour l'insérer dans la base de données
    case 1:
        $date = $day . ' 10:00'; // Ajout de l'heure à la date
        $dateStart = new DateTime($date);  // Conversion en DateTime pour les méthodes PHP
        $dateEnd = (clone $dateStart)->add(new DateInterval('PT2H'))->format('Y-m-d H:i:s'); // Ajout de deux heures pour l'heure de fin puis formatage pour l'insertion dans la base de données
        $dateStart = $dateStart->format('Y-m-d H:i:s'); // Formatage pour l'insertion dans la base de données
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

// Switch sur le type pour attribuer un avion en fonction de l'activité
switch ($type) {
    case 2:
        $plane = 1; // Avion de formation
        break;
    case 4:
        $plane = 2; // Avion de voyage
        break;
    case 3:
        $plane = rand(3, 4); // Choix d'un ULM aléatoire
        break;
    case 9:
        $plane = 2; // Avion de voyage
        break;
}

$db = getDatabaseConnection();
// Récupère les formateurs libres si l'activité nécessite un formateur
if ($mode != 'solo') {
    $result = $db->query("SELECT trainers.id FROM trainers WHERE NOT EXISTS (SELECT * FROM schedule WHERE start = '". $dateStart ."' AND id_trainer = trainers.id) ORDER BY RAND() LIMIT 1")->fetch();
}
$idTrainer = isset($result['id']) ? $result['id'] : null;

// Si l'activité est un baptême de l'air récupère le formateur
if ($type == 9) {
    $sql = "SELECT count(*) as count, max(id_trainer) as trainer FROM `schedule` WHERE start = '". $dateStart . "' and id_activity = 9";
    $trainer = $db->query($sql)->fetch();
    if ($trainer['count'] > 0) {
        $idTrainer = $trainer['trainer'];
    }
}

// Insertion dans la base de données
$q = 'INSERT INTO schedule (id_activity,start,end,id_member,id_trainer,id_plane,mode) VALUES (?, ?, ?, ?, ?, ?, ?)';
$req = $db->prepare($q);
$req->execute([$type, $dateStart, $dateEnd, $idMember, $idTrainer, $plane, $mode]);

// Si l'activité est une formation
if ($type == 2) {
// Si la formation nécessite un formateur, ajout de 2 heures avec le formateur
if ($mode == 'trainer') {
    $sql = 'UPDATE members SET trainingHours = trainingHours+2 WHERE id = "' . $idMember . '"';
// Si la formation ne nécessite pas de formateur, ajout de 2 heures en solo
} else if($mode == 'solo') {
    $sql = 'UPDATE members SET soloHours = soloHours+2 WHERE id = "' . $idMember . '"';
}
$req = $db->prepare($sql);
$req->execute();
}


header('location: ../CalendarWeek.php?type=' . $type . '&week=' . $week . '&year=' . $year . '');
