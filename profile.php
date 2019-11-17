<?php include 'init.php'; ?>

<?php include 'head.php'; ?>

<?php protect_page() ?>

<!-- CONTENT -->



<?php
if (isset($_GET['username']) && empty($_GET['username']) === false) {
    $profile_username = $_GET['username'];
    
    if (user_exists($profile_username) === true) {
        $profile_user_id = user_id_from_username($profile_username);
        $profile_data = user_data($profile_user_id, 'username', 'profile_pic', 'about_me');
        ?>

    <h1><?php echo $profile_data['username']; ?>'s Profile:</h1>

    <div class="user-lookup-wrap">
        
        <div class="profile-pic-wrap">
            <?php
                if (empty($profile_data['profile_pic']) == false ) {
            ?>
                    <div class="profile-pic" style="background-image: url(<?php echo $profile_pic_path . $profile_data['profile_pic']; ?>);"> </div>
            <?php
                }
            ?>

        </div>
    
        <div class="user-info-wrap">

        <!-- about me: -->
        <div>
            <?php
                if (empty($profile_data['about_me']) == false ) {
                    echo $profile_data['about_me'];
                }
            ?>
        </div>



        <?php
        
        // add friend button if not already friends.
        $sql = "SELECT * FROM `friends` WHERE `askee_id` = $profile_user_id AND `asker_id` = $session_user_id OR `asker_id` = $profile_user_id AND `askee_id` = $session_user_id";
        
        $result = mysqli_query($conn, $sql);
        
        if ((mysqli_num_rows($result) == 0) && ($session_user_id !== $profile_user_id)) {
        ?>
        
            <form action='friends.php' method='POST'>
            <input type='hidden' name='askee_id' value='<?php echo $profile_user_id; ?>'>
            <button>Send friend request</button>  
        </form>
            
        <?php
        } else if (mysqli_num_rows($result) !== 0 ) {
            echo "Already / soon to be friends with this user :)";
        } else if ($session_user_id === $profile_user_id) {
        }


        } else {
            echo "<blockquote class='error'><h3>Error: User does not exist.</h3></blockquote>";
        }
    } else {
        header('Location: index.php');
        exit();
    }
    ?>
    </div>
    
</div>






<?php include 'footer.php'; ?>
