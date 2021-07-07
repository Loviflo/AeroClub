<?php
require_once('../utils/database.php');
ini_set("display_errors",1);

$db = getDatabaseConnection();

if (isset($_POST['firstname']) &&
    isset($_POST['lastname']) &&
    isset($_POST['password']) &&
    isset($_POST['conf_password']) &&
    $_POST['password'] === $_POST['conf_password'] &&
    isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
    ){

    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $q = 'INSERT INTO membres (firstname,lastname,mail,password) VALUES (?, ?, ?, ?)';
    $req = $db->prepare($q);
    $req->execute([$firstname,$lastname,$email,hash("sha512",$password)]);

    header("location:../index.php");
    exit;
}else{
    header("location:../sign_in.php?msg=Error");
    exit;
}
