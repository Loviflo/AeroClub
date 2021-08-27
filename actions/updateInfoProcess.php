<?php

require_once '../utils/database.php';
ini_set("display_errors", 1);
session_start();

$db = getDatabaseConnection();

if (isset($_POST['firstname'])){
    $firstname = htmlspecialchars($_POST['firstname']);
    $q = 'UPDATE members SET firstname = ? WHERE id = ?';
    $req = $db->prepare($q);
    $req->execute([$firstname, $_SESSION['user']['id']]);
}

if (isset($_POST['lastname'])){
    $lastname = htmlspecialchars($_POST['lastname']);
    $q = 'UPDATE members SET lastname = ? WHERE id = ?';
    $req = $db->prepare($q);
    $req->execute([$lastname, $_SESSION['user']['id']]);
}

/*if (isset($_POST['mail']) && FILTER_VALIDATE_EMAIL($_POST['mail'])){
    $email = htmlspecialchars($_POST['mail']);
    $q = 'UPDATE members SET mail WHERE id = ?';
    $req = $db->prepare($q);
    $req->execute([$email, $_SESSION['user']['id']]);
}*/

if (isset($_POST['license'])){
    $license = $_POST['lastname'];
    $q = 'UPDATE members SET additionalCost = ? WHERE id = ?';
    $req = $db->prepare($q);
    $req->execute([$license, $_SESSION['user']['id']]);
}

if (isset($_POST['password']) && isset($_POST['passwordConf'])){
    if ($_POST['password'] === $_POST['passwordConf']){
        $password = hash('sha512', $_POST['password']);
        $q = 'UPDATE members SET password = ? WHERE id = ?';
        $req = $db->prepare($q);
        $req->execute([$password, $_SESSION['user']['id']]);
    }else{
        header('location: ../member_account.php?ifail=Les mots de passe ne correspondent pas');
    }
}



header('location: ../member_account.php');
exit();
