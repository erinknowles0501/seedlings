<?php include 'init.php' ?>
<?php logged_in_redirect(); ?>
<?php include 'head.php' ?>

<!-- include check for making sure fields length isn't MORE than what mysql is expecting, and make sure username doesn't include spaces or special characters -->

<!-- structure, for debugging:
if POST is not empty:
    if required fields are empty:
        error,
        break
    if there are no errors:
        if user already exists: error
        if email already exists: error
        if username contains spaces: error
        if email is not an email: error
        if password is not 6+ chars: error
        if passwords do not match: error
    if POST is not empty AND there are no errors:
        register user,
        header redirect,
        exit
if errors is not empty,
    display errors



-->

<?php
    if (empty($_POST) === false) {
        $required_fields = array('username', 'password', 'password_again', 'email');
        
        foreach($_POST as $key=>$value) {
            if (empty($value) && in_array($key, $required_fields)) {
                $errors[] = 'One or more required fields are empty.';
                break 1;
            }
        }
        
        if (empty($errors)) {
            if (user_exists($_POST['username'])) {
                $errors[] = 'The username \'' . htmlentities($_POST['username']) . '\' is already taken.';
            }
            
            if (email_exists($_POST['email'])) {
                $errors[] = 'That email is already in use.';
            }
            
            if (preg_match("/\\s/", $_POST['username'])) {
                $errors[] = 'Usernames cannot contain spaces.';
            }
            
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
                $errors[] = 'Email address is not valid (xxx@yyy.zzz)';
            }
            
            if (strlen($_POST['password']) < 6) {
                $errors[] = 'Password not long enough, must be at least 6 characters.';
            }
            
            if ($_POST['password'] !== $_POST['password_again']) {
                $errors[] = 'Passwords must match - this is to prevent accidentally registering with a password with a typo.';
            }
            
            
        }

    // if there's data and no errors, register user:
    if ( empty($_POST) === false && empty($errors) === true ) {
        $register_data = array(
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'email' => $_POST['email']
        );
        register_user($register_data);
        header('Location: index.php?registersuccess');
        exit();
    }
}


?>


<h1>Register</h1>

<?php 
    if (empty($errors) === false) {
        echo "<blockquote class='error'><h3>Could not register: encountered the following error/s:</h3>";
        foreach($errors as $error) {
            echo "<li>" . $error . "</li>";
        }
        echo "</blockquote>";
    }
?>

<form action="" method="POST">

    <ul>
        <li>
            Username: <br>
            <input type="text" name="username">
        </li>

        <li>
            Password <i>(at least 6 characters)</i>: <br>
            <input type="password" name="password">
        </li>

        <li>
            Password again:<br>
            <input type="password" name="password_again">
        </li>

        <li>
            Email:<br>
            <input type="email" name="email">
        </li>

        <li>
            <button>Register</button>
        </li>
    </ul>

</form>



<?php include 'footer.php' ?>