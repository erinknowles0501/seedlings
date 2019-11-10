<?php include 'init.php' ?>
<?php logged_in_redirect() ?>

<?php include 'head.php' ?>

<?php

if (empty($_POST) === false) {
$username = $_POST['username'];
$password = $_POST['password'];


if (empty($username) === true || empty($password) === true ) {
        $errors[] = 'You need to enter a username and password';
    } else if ( user_exists($username) === false) {
        $errors[] = 'Entered user does not exist, check for typos?';
    } else if (user_active($username) === false) {
        $errors[] = 'You have not activated your account';
    } else {
    
        $login = login($username, $password);
        if ($login === false) {
           $errors[] = 'That user/password combo is incorrect';
        } else {
            $_SESSION['user_id'] = $login;
            header('Location: index.php');
            exit();
        }
    }
    
} else {
    header('Location: index.php');
}

if (empty($errors) === false) {
    echo "<h3>We tried to log you in but encountered the following error/s:</h3>";
    foreach($errors as $error) {
        echo "<li>" . $error . "</li>";
    }
}

?>




<?php include 'footer.php' ?>