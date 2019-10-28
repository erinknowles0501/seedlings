<?php include 'init.php' ?>

<?php include 'head.php' ?>

<!-- CONTENT -->


<?php 
    

if (logged_in() === true) {
echo 'logged in hellooo. <a href="logout.php">log out</a>';
} else {
    include 'loginForm.php';
}
?>









<?php include 'footer.php' ?>