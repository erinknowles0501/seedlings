<?php 
function user_exists($username) {
    $username = sanitize($username);
    $query = mysqli_query("SELECT COUNT(`id`) FROM `users` WHERE `username` = '$username'");
    return (mysqli_result($query, 0) == 1) ? true : false;
}

?>