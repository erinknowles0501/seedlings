<?php include 'init.php' ?>
<?php protect_page(); ?>

<?php include 'head.php' ?>

<!-- CONTENT -->

<h2>Messages:</h2>


<?php
// display success if message sent:
if (isset($_GET['success']) && empty($_GET['success'])) {
    echo "<blockquote class='success'><h3>Message successfully sent!</h3></blockquote>";
}
    
    
// send message.
if (empty($_POST) === false) {
    $sendee_id = $_POST['sendee_id'];
    $subject = sanitize($_POST['subject']);
    $body = sanitize($_POST['body']);
    
    global $conn;
    $sql = "INSERT INTO `messages` (sender_id, sendee_id, subject, body) VALUES ($session_user_id, $sendee_id, '$subject', '$body')";
    
    if (mysqli_query($conn, $sql)) {
        header('Location: messages.php?success');
        exit();
    } else {
        echo "<blockquote class='error'><h3>Could not send message: SQL error.</h3></blockquote>";
    }
}

    
    
?>


<section class="messages-wrap">
    <section><h3>Inbox:</h3>
<?php
// display messages: inbox
global $conn;
$sql = "SELECT * FROM `messages` WHERE `sendee_id` = $session_user_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) != 0 ) {
    $i = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[$i] = array(
            "id" => $row['id'],
            "sender_id" => $row['sender_id'],
            "sendee_id" => $row['sendee_id'],
            "date" => $row['date'],
            "subject" => $row['subject'],
            "body" => $row['body'],
            "was_read" => $row['was_read']
        );
    $i++;
    }

    foreach ($messages as $message) {
        display_message($message, "in");
    }
} else {
    echo "No messages!";
}
?>
    </section>
    <section><h3>Outbox:</h3>
<?php
//display messages: outbox
$sql = "SELECT * FROM `messages` WHERE `sender_id` = $session_user_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) != 0) {
    $i=0;
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[$i] = array(
            "id" => $row['id'],
            "sender_id" => $row['sender_id'],
            "sendee_id" => $row['sendee_id'],
            "date" => $row['date'],
            "subject" => $row['subject'],
            "body" => $row['body'],
            "was_read" => $row['was_read']
        );
    $i++;
    }
    
    foreach ($messages as $message) {
        display_message($message, "out");
    }
}
    
?>
    </section>
</section>



<h3>Send message:</h3>
<!-- drop-down with friends -->
<form action="messages.php" method="POST">
    <ul>
        <li><b>To:</b><br>
            <?php 
            global $conn;
            $sql = "SELECT `asker_id`, `askee_id`, `accepted` FROM `friends` WHERE `accepted` = 1 AND (`askee_id` = $session_user_id OR `asker_id` = $session_user_id)";
            
            $friends = mysqli_query($conn, $sql);
            
            

            if (mysqli_num_rows($friends) > 0) {
                echo "<select name='sendee_id'>";
                
                // either asker_id or askee_id is $session_user_id. Get whatever the other one is.
                
                while($row = mysqli_fetch_assoc($friends)) {
                    $the_friend_id = null;
                    if ($row['asker_id'] == $session_user_id) {
                        $the_friend_id = $row['askee_id'];
                    } else {
                        $the_friend_id = $row['asker_id'];
                    }
                    echo "<option value='" . $the_friend_id . "'>" . username_from_user_id($the_friend_id) . "</option>";
                }
                echo "</select";
            } else {
                echo "No friends to send a message to :(";
            }
            ?>
        
        </li>
        <li><b>Subject:</b><br>
        <input type="text" name="subject" value="">
        </li>
        <li><b>Message:</b><br>
        <textarea name="body"></textarea>
        </li>
        <li><button>Send!</button></li>
    </ul>
    
</form>







<?php include 'footer.php'; ?>