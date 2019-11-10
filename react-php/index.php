<?php include 'init.php' ?>

<?php include 'head.php' ?>

<!-- CONTENT -->


<?php 


if (isset($_GET['alreadyloggedin']) && empty($_GET['alreadyloggedin'])) {
    echo "<blockquote class='warning'><h3>You have to log out before accessing that page.</h3>
    </blockquote>";
}


if (logged_in() === true) {
    include 'loggedIn.php';
} else {
    include 'loginForm.php';
}




?>









<?php include 'footer.php' ?>