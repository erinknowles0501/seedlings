<?php include 'init.php' ?>
<?php protect_page(); ?>

<?php include 'head.php' ?>

<!-- CONTENT -->

<h1>Inbox:</h1>


<?php
// send message.
if (empty($_POST) === false) {
    $sendee_id = 36; // just for testing, do the rest later
    $subject = sanitize($_POST['subject']);
    $body = sanitize($_POST['body']);
    
    global $conn;
    $sql = "INSERT INTO `messages` (sender_id, sendee_id, subject, body) VALUES ($session_user_id, $sendee_id, '$subject', '$body')";
    
    mysqli_query($conn, $sql);
}

    
    
?>

<?php
// display messages.
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
            display_message($message);
        }
    } else {
        echo "No messages!";
    }

    
?>



<h3>Send message:</h3>
<!-- drop-down with friends -->
<form action="messages.php" method="POST">
    <ul>
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