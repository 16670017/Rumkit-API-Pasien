<?php

$host         = "localhost";
$username     = "root";
$password     = "";
$dbname       = "rumkit_db";

$db = mysqli_connect($host, $username, $password, $dbname);

try {
    $dbconn = new PDO('mysql:host=localhost;dbname=rumkit_db', $username, $password);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>
