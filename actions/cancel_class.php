<?php
ini_set('display_errors', 1);
session_start();
require_once(dirname(__DIR__) . "/utils/database.php");
$bdd = getDatabaseConnection();
$q = "DELETE FROM TO_DO WHERE TO_DO = '" . $_GET['TO_DO'] . "'";
$req = $bdd->prepare($q);
$req->execute();
header('location: /AeroClub/member_space.php')
?>
