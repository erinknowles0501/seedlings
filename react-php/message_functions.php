<?php

function display_message($message) {
    ?>
    <section class="message">
        <h4><?= $message['subject']; ?> <p>From: <?= username_from_user_id($message['sender_id']); ?>, <?= $message['date']; ?></p></h4>
        <p><?= $message['body']; ?></p>
    </section>
    <?php
}


?>