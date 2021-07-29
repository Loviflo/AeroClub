<?php echo "This works";

require_once('../utils/database.php');
ini_set("display_errors",1);
 // BIG WIP
$db = getDatabaseConnection();

if (isset($_POST['name']) &&
    isset($_POST['password']) &&
    isset($_POST['conf_password']) &&
    $_POST['password'] === $_POST['conf_password'] &&
    isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
    isset($_POST['siret']) &&
    isset($_POST['motives'])){

    $name = htmlspecialchars($_POST['name']);
    $password = $_POST['password'];
    $email = htmlspecialchars($_POST['email']);
    $siret = htmlspecialchars($_POST['siret']);
    $motives = htmlspecialchars($_POST['motives']);
    $q = 'INSERT INTO client (company_name,cli_pwd,mail,siret_nb,motives) VALUES (?, ?, ?, ?, ?)';
    $req = $db->prepare($q);
    $req->execute([$name,hash("sha512",$password),$email,$siret,$motives]);

    header("location:../index.php");
    exit;
}else{
    header("location:../signIn_client.php?msg=Error");
    exit;
}