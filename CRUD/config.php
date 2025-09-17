<?php

$server = "localhost";
$db = "test";
$user = "root";
$password = "";

try{
$pdo = new PDO("mysql: host=$server; dbname=$db", $user, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
// echo "<font color='green'>Connected to database</font>";

} catch(PDOException $e){
    echo "<font color='red'>Error in connection</font> " . $e->getMessage();
}
