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
<br><br>

<?php 

$sqlget = "SELECT type, location, name, shiny FROM babies";
$result = $conn->query($sqlget);

if ( $result->num_rows > 0 ) {
	while ($row = $result->fetch_assoc()) {
		echo $row["type"] . ", " .
			 $row["location"] . ", " .
			 $row["name"] . ", " .
			 $row["shiny"] . "<br>";
	}
} else {
	echo "no results :(";
}



?>