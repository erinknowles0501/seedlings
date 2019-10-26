<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "seedlings-test";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
	die("connection failed: " . $conn->connect_error);
}

$name = $_POST["nameField"];

$sql = "INSERT INTO babies (type,location,name,shiny)
VALUES (2, 'rogues roost', '" . $name . "', false)";

if ($conn->query($sql) === TRUE) {
	echo "Record success, " . $name . " has been added";
} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}

?>