<?php
ini_set('display_errors', 1);
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('../lib/PHPMailer/src/PHPMailer.php');
require_once('../lib/PHPMailer/src/Exception.php');
require_once(dirname(__DIR__) . "/utils/database.php");
$bdd = getDatabaseConnection();

$q = "SELECT mail FROM members WHERE id = ?";
$req = $bdd->prepare($q);
$req->execute([$_GET['id_member']]);
$results = $req->fetchAll();

foreach ($results as $key => $mails){
    $email = new PHPMailer();
    $email->SetFrom('Aeroclub@aeroclub.com');
    $email->Subject   = "Annulation d'activité";
    $email->Body      =
        "Nous sommes au regret de vous informer qu'un formateur a dù annuler une activité à laquelle vous étiez inscrits. Pour plus d'informations rendez-vous sur votre espace afin de consulter vos activités.";
    $email->AddAddress($mails['mail']);
    $email->Send();
}


$q3 = "DELETE FROM schedule WHERE id_member = ? AND start = ? AND end = ?";
$req3 = $bdd->prepare($q3);
$req3->execute([$_GET['id_member'], $_GET['start'], $_GET['end']]);


header('location: seeDetails.php')
?>
