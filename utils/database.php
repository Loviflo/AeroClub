<?php
function getDatabaseConnection():PDO{
    $dbname = "aeroclub";
    $port = 3306;
    $user = "root";
    $pwd = "root";
    return new PDO("mysql:host=localhost;dbname=$dbname;port=$port;charset=utf8",$user,$pwd);
}
?>