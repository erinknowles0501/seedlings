<?php 

function register_user($register_data) {
    global $conn;
    
    array_walk($register_data, 'array_sanitize');
    $register_data['password'] = md5($register_data['password']);
    
    $fields = '`' . implode('`, `', array_keys($register_data)) . '`';
    $data = '\'' . implode('\', \'', $register_data) . '\'';
    
    $sql = "INSERT INTO `users` ($fields) VALUES ($data)";
    
    mysqli_query($conn, $sql);
    
    if ($conn->query($sql) === true) {
        echo "<blockquote class='success'>User created successfully! You may now <a href='index.php'>log in</a>.</blockquote>";
    }
    
}

function user_data($user_id) {
    global $conn;
    $data = array();
    $user_id = (int)$user_id;
    
    $func_num_args = func_num_args();
    $func_get_args = func_get_args();
    
    if ($func_num_args > 1) {
        unset($func_get_args[0]);
        
        $fields = '`' . implode('`, `', $func_get_args) . '`';
        
        $result = mysqli_query($conn, "SELECT $fields FROM `users` WHERE `user_id` = $user_id");
        $data = mysqli_fetch_assoc($result);
        
        return $data;
    }

}


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
    $query = mysqli_query($conn, "SELECT COUNT(`user_id`) as cnt FROM `users` WHERE `username` = '$username'");
    $row = mysqli_fetch_object($query);
    return ($row->cnt[0] == 1) ? true : false;
}

function email_exists($email) {
    global $conn;
    $email = sanitize($email);
    $query = mysqli_query($conn, "SELECT COUNT(`user_id`) as cnt FROM `users` WHERE `email` = '$email'");
    $row = mysqli_fetch_object($query);
    return ($row->cnt[0] == 1) ? true : false;
}

function user_active($username) {
    global $conn;
    $username = sanitize($username);
    $query = mysqli_query($conn, "SELECT COUNT(`user_id`) as cnt FROM `users` WHERE `username` = '$username' AND `active` = 1");
    $row = mysqli_fetch_object($query);
    return ($row->cnt[0] == 1) ? true : false;
}

function user_id_from_username($username) {
    global $conn;
    $username = sanitize($username);
    $query = mysqli_query($conn, "SELECT `user_id` FROM `users` WHERE `username` = '$username'");
    return mysqli_fetch_array($query)['user_id'];
}

function login($username, $password) {
    global $conn;
    $user_id = user_id_from_username($username);
    
    $username = sanitize($username);
    $password = md5($password);
    
    $query = mysqli_query($conn, "SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username' AND `password` = '$password'");
    $data = mysqli_fetch_array($query);
    
    return ($data[0] == 1) ? $user_id : false;
}

function change_password($user_id, $password) {
    global $conn;
    
    $user_id = (int)$user_id;
    $password = md5($password);
    
    mysqli_query($conn, "UPDATE `users` SET `password` = '$password' WHERE `user_id` = $user_id");
}

?>