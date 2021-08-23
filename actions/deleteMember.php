<?php
ini_set('display_errors', 1);
session_start();
require_once(dirname(__DIR__) . "/utils/database.php");
$bdd = getDatabaseConnection();

$q = "DELETE FROM members WHERE id = ?";
$req = $bdd->prepare($q);
$req->execute([$_GET['id_member']]);


header('location:manageMembers.php');
?>
