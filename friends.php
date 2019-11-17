<?php include 'init.php' ?>

<?php include 'head.php' ?>

<!-- CONTENT -->



<h1>Friends:</h1>

<?php 
    // if success in sending friend request
    if (isset($_GET['success']) && empty($_GET['success'])) {
        echo "<blockquote class='success'><h3>Friend request sent successfully!</h3><p>You'll get a notification when they accept it.</p></blockquote>";
    }

    // if success in accepting friend request
    if (isset($_GET['acceptsuccess']) && empty($_GET['success'])) {
        echo "<blockquote class='success'><h3>Friend request successfully accepted!</h3></blockquote>";
    }

    // send friend request
    if (isset($_POST['askee_id'])) {
    $asker_id = $session_user_id;
    $askee_id = $_POST['askee_id'];

    global $conn;

    //if not already friends or asked:
    $sql = "SELECT * FROM `friends` WHERE (`asker_id` = $asker_id AND `askee_id` = $askee_id) OR (`asker_id` = $askee_id AND `askee_id` = $asker_id)";
        
    $query = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($query) != 0 ) {
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

    
    // display friend-adding error
    if (empty($errors) == false) {
        display_errors($errors, "add friend");
    }   
}

// deal with accepting friend request
if (isset($_POST['accepted'])) {
    global $conn;
    $asker_id = $_POST['asker_id'];
    $sql = "UPDATE `friends` SET `accepted` = true WHERE `asker_id` = $asker_id AND `askee_id` = $session_user_id";
    mysqli_query($conn, $sql);
}

// display pending friend requests:
// pending_friend_requests() returns array of mysqli_fetch_assoc rows.
if (pending_friend_requests() != false ) {
    echo "<h3>Pending friend requests:</h3>";
    foreach (pending_friend_requests() as $request) {
        ?>

        <div class="friend-request-wrap">
            <!-- display profile image -->
            <div class="profile-pic-wrap request">
                <?php
                $other_data = user_data($request['asker_id'], 'profile_pic');
                if (empty($other_data['profile_pic']) == false ) {
                ?>
                    <div class="profile-pic" style="background-image: url(<?php echo $profile_pic_path . $other_data['profile_pic']; ?>);"> </div>
                <?php
                }
                ?>

            </div>
            <div class="friend-request-info-wrap">
                From: <b><a href="/<?php echo $user_lookup_path . username_from_user_id($request['asker_id']); ?>"><?php echo username_from_user_id($request['asker_id']); ?></a></b><br>
                On: <b><?php echo $request['date']; ?></b><br>
                <form action="friends.php?acceptsuccess" method="post">
                    <input type="hidden" name="accepted" value="true">
                    <input type="hidden" name="asker_id" value="<?php echo $request['asker_id']; ?>">
                    <button>Accept!</button>
                </form>
            </div>
        </div>

        <?php
    }
}

//display friends:
if (has_friends() != false ) {
    echo "<h3>Your friends:</h3>";
    echo "<div class='friends-wrap'>";
    foreach (has_friends() as $friend_entry) {
        // either asker_id or askee_id is $session_user_id. Get whatever the other one is.
        $the_friend_id = "something's gone wrong";
        if ($friend_entry['asker_id'] == $session_user_id) {
            $the_friend_id = $friend_entry['askee_id'];
        }
        else {
            $the_friend_id = $friend_entry['asker_id'];
        }
        
        $the_friend_data = user_data($the_friend_id, 'username', 'profile_pic');
    ?>

        <a href="<?php echo $the_friend_data['username']; ?>">
            <div class="profile-pic-wrap request">

                <div class="profile-pic" style="background-image: url('<?php echo $profile_pic_path . $the_friend_data['profile_pic'];?>')">
                    <span><?php echo $the_friend_data['username']; ?></span>
                </div>
            </div>
        </a>

    
    <?php
    }
    echo "</div>";
}



?>




<?php include 'footer.php'; ?>