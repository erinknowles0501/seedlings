<?php
session_start();


require 'connect.php';
require 'general.php';
require 'users.php';
require 'seed_functions.php';

if (logged_in() === true) {
    $session_user_id = $_SESSION['user_id'];
    $user_data = user_data($session_user_id, 'user_id', 'username', 'password', 'register_date', 'last_active', 'user_type', 'profile_pic', 'about_me', 'food');
    
    set_last_active();
}
    
$errors = array();

// path relative to stylesheet. Leading / tends to break it.
$profile_pic_path = "images/profile/";

$user_lookup_path = "seedlings/react-php/";

?>
