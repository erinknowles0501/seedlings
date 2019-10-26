<!DOCTYPE html>
<html>
<head>
<title>Babies ~</title>
<meta charset="utf-8">

<script
			  src="https://code.jquery.com/jquery-3.4.1.min.js"
			  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
			  crossorigin="anonymous"></script>


<script type="text/javascript" src="test.js"></script>

</head>

<body>




<div>
<h1>Found new baby!!</h1>
<p><b>Location:</b> Rogue's Roost</p>
<p><b>Type:</b> Annoying</p>
<hr>
<h3>What shall we call it?</h3>

<form action="index.php" method="post">
<input id="nameField" name="nameField" type="text">
<input id="submit" type="submit" value="go!">
</form>

</div>


<?php include 'test.php'; ?>

</body>
</html>