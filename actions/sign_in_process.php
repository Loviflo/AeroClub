<?php
require_once('../utils/database.php');
ini_set("display_errors",1);
$db = getDatabaseConnection();
if (isset($_POST['firstname']) &&
    isset($_POST['lastname']) &&
    isset($_POST['birthDate']) &&
    isset($_POST['password']) &&
    isset($_POST['FFAPrice']) &&
    isset($_POST['conf_password']) &&
    isset($_POST['level']) &&
    $_POST['password'] === $_POST['conf_password'] &&
    isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
    ){

    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $birthDate = $_POST['birthDate'];
    $email = htmlspecialchars($_POST['email']);
    $level = $_POST['level'];
    $password = $_POST['password'];
    $FFAPrice = $_POST['FFAPrice'];
    $q = 'INSERT INTO members (firstname,lastname,birthDate,level,mail,additionalCost,password) VALUES (?, ?, ?, ?, ?, ?, ?)';
    $req = $db->prepare($q);
    $req->execute([$firstname,$lastname,$birthDate,$level,$email,$FFAPrice,hash("sha512",$password)]);

    header("location:../index.php");
    exit;
}else{
    header("location:../sign_in.php?msg=Error");
    exit;
}
