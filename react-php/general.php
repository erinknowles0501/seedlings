<?php

// could consolidate into one protect_page with an arg for type of protection. eg when calling, protect_page(loggedin) or protect_page(admin).

function protect_page() {
    if (logged_in() === false) {
        header('Location: index.php');
        exit();
    }
}

function protect_page_admin() {
    global $user_data;
    if ($user_data['user_type'] != 1) {
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
    return htmlspecialchars(strip_tags(mysqli_real_escape_string($conn, $data)));
}

function array_sanitize(&$item) {
    global $conn;
    $item = htmlspecialchars(strip_tags(mysqli_real_escape_string($conn, $item)));
}


function display_errors($errors, $action) {
    echo "<blockquote class='error'><h3>Could not ".$action.": encountered the following error/s:</h3>";
    foreach($errors as $error) {
        echo "<li>" . $error . "</li>";
    }
    echo "</blockquote>";
}

?>
