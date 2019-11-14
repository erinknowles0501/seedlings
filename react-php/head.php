<!DOCTYPE html>
<html>

<head>
    <title>Seedlings v1</title>
    <meta charset="utf-8">


    <link rel="stylesheet" href="water.css-master/dist/light.standalone.min.css">


    <link rel="stylesheet" type="text/css" href="heck.css">

</head>

<body>

    <header>
        <?php 
            // if have pending requests!
            
            if (logged_in() === true && pending_friend_requests() != false ) {
                echo "<p class='notice'>Pending friend request/s! Check out your <a href='friends.php'>Friends</a> page to accept.</p>";
            }
            
        ?>
        <h1>Seedlings</h1>
        <p>testing it!</p>



    </header>

    <?php include 'nav.php' ?>


    <main>
        <!-- CONTENT STARTS HERE -->