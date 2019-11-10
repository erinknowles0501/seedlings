<?php
session_start();


require 'connect.php';
require 'general.php';
require 'users.php';

if (logged_in() === true) {
    $session_user_id = $_SESSION['user_id'];
    $user_data = user_data($session_user_id, 'user_id', 'username', 'password');
}
    
$errors = array();

?>