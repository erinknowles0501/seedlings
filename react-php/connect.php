<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "seedlings";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn->connect_error) {
	die("connection failed: " . $conn->connect_error);
}

?>