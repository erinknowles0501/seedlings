<?php

function display_message($message, $direction) {
    if ($direction == "in") {
        $info = "From: " . username_from_user_id($message['sender_id']);
    } else if ($direction == "out") {
        $info = "To: " . username_from_user_id($message['sendee_id']);
    }
    ?>
    <section class="message">
        <h4><?= $message['subject']; ?> <p><?php echo $info, ", ", $message['date']; ?></p></h4>
        <p><?= $message['body']; ?></p>
    </section>
    <?php
}


?>