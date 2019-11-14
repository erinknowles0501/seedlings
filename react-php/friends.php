<?php include 'init.php' ?>

<?php include 'head.php' ?>

<!-- CONTENT -->



<h1>Friends:</h1>

<?php 
    if (isset($_GET['success']) && empty($_GET['success'])) {
        echo "<blockquote class='success'><h3>Friend request sent successfully!</h3><p>You'll get a notification when they accept it.</p></blockquote";
    }
    
    
    
    if (isset($_POST['askee'])) {
    $asker_id = $session_user_id;
    $askee_id = user_id_from_username($_POST['askee']);

    global $conn;

    //if not already friends or asked:
    $sql = "SELECT * FROM `friends` WHERE (`asker_id` = $asker_id AND `askee_id` = $askee_id) OR (`asker_id` = $askee_id AND `askee_id` = $asker_id)";
    
    if (mysqli_num_rows(mysqli_query($conn, $sql)) != 0 ) {
        $errors[] = "You already have a relationship with that user.";
    } else {
        $sql = "INSERT INTO `friends` (`asker_id`, `askee_id`) VALUES ($asker_id, $askee_id)";

        $check = mysqli_query($conn, $sql);

        if ($check == false) {
            $errors[] = "Failed: Something MySQL related.";
        } else {
            header('Location: friends.php?success');
            exit();
        }
    }

if (empty($errors) == false) {
    print_r($errors);
}
        
}


?>




<?php include 'footer.php'; ?>