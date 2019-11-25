<?php

function display_items($id) {
    global $session_user_id;
    global $conn;
    $sql = "SELECT * FROM `items` WHERE `owner_id` = $id";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $items = array();
        while ($row = mysqli_Fetch_assoc($result)) {
            array_push($items, $row);
        }
    }

    global $item_image_path;
    
    foreach($items as $item) {
        $item_info = get_item_info_from_id($item['id']);
        echo "<div class='item'><img src='"; 
        echo $item_image_path . "/" . get_category_from_category_id($item_info['category']) . "/" . $item_info['image'];
        echo "'><p><b>";
        echo item_id_to_name($item['type_id']);
        echo "</b>: ";
        echo "<i>";
        echo $item_info['description'];
        echo "</i></p></div>";
    }
}

function get_item_info_from_id($id) {
    global $conn;
    $sql = "SELECT * FROM `item_types` WHERE `id` = $id";
    return mysqli_fetch_assoc(mysqli_query($conn, $sql));
}

function get_category_from_category_id($id) {
    global $conn;
    $sql = "SELECT `name` FROM `item_categories` WHERE `id` = $id";
    $query = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($query)['name'];
}

function item_id_to_name($id) {
    global $conn;
    $sql = "SELECT `name` FROM `item_types` WHERE `id` = $id";
    $query = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($query)['name'];
}

?>