<?php include 'init.php' ?>
<?php protect_page(); ?>

<?php include 'head.php' ?>

<!-- CONTENT -->

<?php
if (isset($_GET['success']) && empty($_GET['success'])) {
    echo "<blockquote class='success'><h3>Successfully changed profile picture!</h3></blockquote>";
}

?>

<h1>Change profile pic</h1>

    <div class="profile-pic-wrap" style="float: none;">
    <h4>Current profile pic:</h4>
        <?php
        if (empty($user_data['profile_pic']) == false ) {
        ?>

            <div class="profile-pic" style="background-image: url(<?php echo $profile_pic_path . $user_data['profile_pic']; ?>);"> </div>
        <?php
        } else {echo "None set!";}
        ?>

    </div>


<h4>Set new profile pic:</h4>
<?php 
if (isset($_FILES['profile_pic']) === true) {
    if (empty($_FILES['profile_pic']['name']) === true) {
        $errors[] = "No file selected.";
    } else {
        $allowed = array('jpg', 'jpeg', 'gif', 'png');
        
        $file_name = $_FILES['profile_pic']['name'];
        $file_extn = explode('.', $file_name);
        $file_extn = strtolower(end($file_extn));
        $file_temp = $_FILES['profile_pic']['tmp_name'];
        $file_size = $_FILES['profile_pic']['size'];
        // don't forget to limit file size later
        
        if (in_array($file_extn, $allowed)) {
            $new_file_name = substr(md5(time()), 0, 10) . "." . $file_extn;
            $new_file_path = "images/profile/" . $new_file_name;
            move_uploaded_file($file_temp, $new_file_path);
            
            global $conn;
            mysqli_query($conn, "UPDATE `users` SET `profile_pic` = '$new_file_name' WHERE `user_id` = $session_user_id");
            
            header('Location: change_profile_pic.php?success');
            exit();
        } else {
            $errors[] = "Disallowed file extension. Allowed file extensions: " . implode(", ", $allowed);
            
        }
        
    }
}

// write error output function already
if (empty($errors) === false) {
    echo "<blockquote class='error'><h3>Could not upload image: encountered the following error/s:</h3>";
    foreach($errors as $error) {
        echo "<li>" . $error . "</li>";
    }
    echo "</blockquote>";
}

?>
<form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="profile_pic"><br>
    <button>Go</button>
</form>




<?php include 'footer.php'; ?>
