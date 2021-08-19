<?php

require_once '../utils/database.php';
ini_set("display_errors",1);

$db = getDatabaseConnection();

// $db = new PDO('mysql:host=localhost;dbname=quickbaluchon','root','root',
// array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
echo 'Hello';
$q = 'SELECT id, mail, password FROM trainers WHERE mail = ? AND password = ?';
$req = $db->prepare($q);
$req->execute([$_POST['email'],hash('sha512',$_POST['password'])]);
$results = $req->fetchAll();
if (count($results) == 0) {
	header('location: ../log_in_trainers.php?ifail=Identifiants incorrects');
} else {
	$mail = $_POST['email'];

    session_start();
    $_SESSION['user'] = array('id' => $results[0]['id'],'mail' => $mail,'rank' => 'trainer');

    header('location: ../index.php');
    exit();	
}

?>
