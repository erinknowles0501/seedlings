<?php include 'init.php' ?>
<?php protect_page(); ?>

<?php include 'head.php' ?>

<!-- CONTENT -->



<h1>Change about me:</h1>

<?php 

if (isset($_GET['success']) && empty($_GET['success'])) {
    echo "<blockquote class='success'><h3>'About me' successfully changed!</h3></blockquote>";
} 

if (isset($_POST['about_me'])) {
    // sanitization. Not really any validation needed.
    // OOP except you need to escape quotes and stuff
    $about_me = sanitize($_POST['about_me']);
    
    // submit
    if (empty($errors) == true) {
        global $conn;
        $sql = "UPDATE `users` SET `about_me` = '$about_me' WHERE `user_id` = $session_user_id";
        mysqli_query($conn, $sql);
        header('Location: change_about_me.php?success');
    }
    
}

if (empty($errors) === false) {
    display_errors($errors, "change 'about me'");
}

?>

<form action="" method="POST">
    <ul>        
        <li>
            About me: <i>(Markdown not currently supported, just plaintext for now!)</i><br>
            <textarea name="about_me"></textarea>
        </li>
        
        <li>
            <button>Change</button>
        </li>
        
    </ul>
    
</form>




<?php include 'footer.php'; ?>