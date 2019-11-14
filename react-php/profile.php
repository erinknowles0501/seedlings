<?php include 'init.php'; ?>

<?php include 'head.php'; ?>

<?php protect_page() ?>

<!-- CONTENT -->



<?php
if (isset($_GET['username']) && empty($_GET['username']) === false) {
    $username = $_GET['username'];
    
    if (user_exists($username) === true) {
        $user_id = user_id_from_username($username);
        $profile_data = user_data($user_id, 'username');
        ?>

    <h1><?php echo $profile_data['username']; ?>'s Profile:</h1>

    <div class="profile-pic-wrap">
        <?php
        if (empty($user_data['profile_pic']) == false ) {
        ?>
            <div class="profile-pic" style="background-image: url(<?php echo $profile_pic_path . $user_data['profile_pic']; ?>);"> </div>
        <?php
        }
        ?>

    </div>

<?php
    // add friend button
        
    ?>
    <form action="" method="POST">
        <button>Send friend request</button>  
    </form>
        
        
    } else {
        echo "<blockquote class='error'><h3>Error: User does not exist.</h3></blockquote>";
    }
} else {
    header('Location: index.php');
    exit();
}
?>






<?php include 'footer.php'; ?>
