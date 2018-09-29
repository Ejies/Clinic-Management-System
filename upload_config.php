<?php

$servername = "ponsmedicaldiagnostics.com";
$username = "jjnvmgwo_wp250@localhost";
$password = "2#Hgh8vt4MY4W+";
$dbname = "jjnvmgwo_wp250";

// Create connection
$conn2 = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn2->connect_error) {
    die("Connection failed: " . $conn2->connect_error);
}

?>