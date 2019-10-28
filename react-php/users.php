<?php 
function logged_in() {
    if (isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}


function user_exists($username) {
    global $conn;
    $username = sanitize($username);
    $query = mysqli_query($conn, "SELECT COUNT(`id`) as cnt FROM `users` WHERE `username` = '$username'");
    $row = mysqli_fetch_object($query);
    return ($row->cnt[0] == 1) ? true : false;
}

function user_active($username) {
    global $conn;
    $username = sanitize($username);
    $query = mysqli_query($conn, "SELECT COUNT(`id`) as cnt FROM `users` WHERE `username` = '$username' AND `active` = 1");
    $row = mysqli_fetch_object($query);
    return ($row->cnt[0] == 1) ? true : false;
}

function user_id_from_username($username) {
    global $conn;
    $username = sanitize($username);
    $query = mysqli_query($conn, "SELECT `id` FROM `users` WHERE `username` = '$username'");
    return mysqli_fetch_array($query)['id'];
}

function login($username, $password) {
    global $conn;
    $user_id = user_id_from_username($username);
    
    $username = sanitize($username);
    $password = md5($password);
    
    $query = mysqli_query($conn, "SELECT COUNT(`id`) FROM `users` WHERE `username` = '$username' AND `password` = '$password'");
    $data = mysqli_fetch_array($query);
    
    return ($data[0] == 1) ? $user_id : false;
}

?>