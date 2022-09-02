<?php

ob_start(); // Turning output buffering
session_start(); // saving var and values even after page closed off

date_default_timezone_set('asia/dhaka');

try {
    $con = new PDO("mysql:dbname=sadakalodb;host=localhost", "root", "");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch (PDOException $e) { 
    exit("Connection failed: " . $e->getMessage());
}
?>


