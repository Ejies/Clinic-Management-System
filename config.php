<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cyber_lab";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>