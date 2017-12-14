<?php

$servername = "db4free.net:3307";
$username = "oscarnovillo";
$password = "c557ef";
$database = "clasesdaw";


$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

