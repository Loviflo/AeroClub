<?php
require_once('../utils/database.php');
ini_set("display_errors",1);
session_start();

$db = getDatabaseConnection();

if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
) {
    $email = htmlspecialchars($_POST['email']);
    $q = 'UPDATE members SET mail = ? WHERE id = ?';
    $req = $db->prepare($q);
    $req->execute([$email, $_SESSION['user']['id']]);


    header("location: ../member_account.php");
}else{
    header("location: ../member_account.php?msg=Error");
}
exit;
