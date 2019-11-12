<?php include 'init.php' ?>
<?php protect_page(); ?>

<?php include 'head.php' ?>

<?php
if (empty($_POST) === false) {
    $required_fields = array('currentpassword', 'newpassword', 'newpassword_again');

    foreach($_POST as $key=>$value) {
        if (empty($value) && in_array($key, $required_fields)) {
            $errors[] = 'One or more required fields are empty.';
            break 1;
        }
    }
    
    if (md5($_POST['currentpassword']) !== $user_data['password']) {
        $errors[] = 'Current password was entered incorrectly.';
    } else if (md5($_POST['currentpassword']) === $user_data['password']) {
        if (empty($errors)) {
            if ($_POST['newpassword'] !== $_POST['newpassword_again']) {
                $errors[] = 'Passwords must match - this is to prevent accidentally registering with a password with a typo.';
            } else if (strlen($_POST['newpassword']) < 6) {
                $errors[] = 'Password not long enough, must be at least 6 characters.';
            } else if (empty($errors === true && empty($_POST) === false)) {
                change_password($session_user_id, $_POST['newpassword']);
                header('Location: change_password.php?success');
                exit();
            }

        }
    }
}
    
    
    
    
?>



<!-- CONTENT -->



<h1>Change password</h1>

<?php 

if (isset($_GET['success']) && empty($_GET['success'])) {
    echo "<blockquote class='success'><h3>Password successfully changed!</h3></blockquote>";
} 

if (empty($errors) === false) {
        echo "<blockquote class='error'><h3>Could not change password: encountered the following error/s:</h3>";
        foreach($errors as $error) {
            echo "<li>" . $error . "</li>";
        }
        echo "</blockquote>";
    }

?>

<form action="" method="POST">
    <ul>
        <li>
            Current password:<br>
            <input type="password" name="currentpassword">
        </li>
        
        <li>
            New password <i>(At least 6 characters)</i>:<br>
            <input type="password" name="newpassword">
        </li>
        
        <li>
            New password (confirm):<br>
            <input type="password" name="newpassword_again">
        </li>
        
        <li>
            <button>Change</button>
        </li>
        
    </ul>
    
</form>




<?php include 'footer.php'; ?>