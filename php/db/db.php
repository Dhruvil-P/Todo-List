<?php 

$host = "localhost:3310";
$user = "root";
$pass = "";
$db = "users";

try {
    $con = new PDO("mysql:host=$host;dbname=$db", 
                    $user, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
  echo "Connection failed : ". $e->getMessage();
}