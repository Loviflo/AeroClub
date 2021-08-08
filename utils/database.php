<?php

function e404()
{
    require 'utils/404.php';
    exit();
}

function debug(...$vars)
{
    foreach ($vars as $var) {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}

function getDatabaseConnection(): PDO
{
    $dbname = "aeroclub";
    $port = 3306;
    $user = "root";
    $pwd = "root";
    return new PDO("mysql:host=localhost;dbname=$dbname;port=$port;charset=utf8", $user, $pwd, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
}
