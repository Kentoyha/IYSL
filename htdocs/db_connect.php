<?php
$host = "127.0.0.1";
$user = ("mariadb");
$pass = ("mariadb");
$db = ("mariadb");

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    
}

?>