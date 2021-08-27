<?php
ini_set('display_errors', 1);
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('../lib/PHPMailer/src/PHPMailer.php');
require_once('../lib/PHPMailer/src/Exception.php');
require_once(dirname(__DIR__) . "/utils/database.php");
$bdd = getDatabaseConnection();

$q = "SELECT id_member FROM schedule WHERE id_trainer = " . $_GET['id_trainer'] . " AND start = '". $_GET['start'] ."'";
$req = $bdd->prepare($q);
$req->execute();
$results = $req->fetchAll();

foreach ($results as $key => $members){
    $q2 = "SELECT mail FROM members WHERE id = ?";
    $req2 = $bdd->prepare($q2);
    $req2->execute([$members['id_member']]);
    $results2 = $req2->fetchAll();

    if ($_GET['mode'] !== NULL){
        if ($_GET['mode'] == 'solo'){
            $q3 = "UPDATE members SET soloHours = soloHours - 2 WHERE id = ?";
            $req3 = $bdd->prepare($q3);
            $req3->execute([$members['id_member']]);
        }else {
            $q4 = "UPDATE members SET trainingHours = trainingHours - 2 WHERE id = ?";
            $req4 = $bdd->prepare($q4);
            $req4->execute([$members['id_member']]);
        }
    }

    foreach ($results2 as $key => $mails){
        $email = new PHPMailer();
        $email->SetFrom('Aeroclub@aeroclub.com');
        $email->Subject   = "Annulation d'activité";
        $email->Body      =
            "Nous sommes au regret de vous informer qu'un formateur a dù annuler une activité à laquelle vous étiez inscrits. Pour plus d'informations rendez-vous sur votre espace afin de consulter vos activités.";
        $email->AddAddress($mails['mail']);
        $email->Send();
    }
}

$q3 = "DELETE FROM schedule WHERE id_trainer = ? AND start = ?";
$req3 = $bdd->prepare($q3);
$req3->execute([$_GET['id_trainer'], $_GET['start']]);


header('location: /AeroClub/trainer_space.php')
?>
