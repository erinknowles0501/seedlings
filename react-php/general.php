<?php

function protect_page() {
    if (logged_in() === false) {
        header('Location: index.php');
        exit();
    }
}

function logged_in_redirect() {
    if (logged_in() === true ) {
        header('Location: index.php?alreadyloggedin');
        exit();
    }
}

function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, $data);
}

function array_sanitize(&$item) {
    global $conn;
    $item = mysqli_real_escape_string($conn, $item);
}
?>