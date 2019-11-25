<?php
session_start();


require 'connect.php';
require 'general.php';
require 'users.php';
require 'seed_functions.php';
require 'item_functions.php';
require 'message_functions.php';

if (logged_in() === true) {
    $session_user_id = $_SESSION['user_id'];
    $user_data = user_data($session_user_id, 'user_id', 'username', 'password', 'register_date', 'last_active', 'user_type', 'profile_pic', 'about_me', 'food');
    
    set_last_active();
}
    
$errors = array();


/////
// these paths should all be in their relevant _functions.php files.

// path relative to stylesheet. Leading / tends to break it.
$profile_pic_path = "images/profile/";

// path for item images.
// if you moved this to item_functions.php you'd be able to do like,
// $category = "food";
// $item_image_path = "seedlings/images/items/" . $category;
// and then change category whenever it was called....
$item_image_path = "images/items";

$user_lookup_path = "seedlings/";

?>
