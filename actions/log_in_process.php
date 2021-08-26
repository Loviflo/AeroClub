<?php

require_once '../utils/database.php';
ini_set("display_errors", 1);

$db = getDatabaseConnection();

// $db = new PDO('mysql:host=localhost;dbname=quickbaluchon','root','root',
// array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$mail = $_POST['email'];
$q = 'SELECT mail, password, id FROM members WHERE mail = ? AND password = ?';
$req = $db->prepare($q);
$req->execute([$mail, hash('sha512', $_POST['password'])]);
$results = $req->fetchAll();
if (count($results) == 0) {
    header('location: ../log_in.php?ifail=Identifiants incorrects');
} else {
    session_start();
    $_SESSION['user'] = array('rank' => 'member', 'id' => $results[0]['id']);

    header('location: ../index.php');
    exit();
}
