<?php include 'init.php' ?>

<?php include 'head.php' ?>
        
if ( user_exists('admin') ) {
    echo 'exists';
}

if (empty($_POST) === false) {
$username = $_POST['username'];
$password = $_POST['password'];


    if (empty($username) === true || empty($password) === true ) {
        $errors[] = 'You need to enter a username and password';
    } else if ( user_exists($username) === false) {
        $errors[] = 'User does not exist, check for typos?';
    }
}

}




<?php include 'footer.php' ?>