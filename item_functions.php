<?php


// okay you're getting donked up because of the different, variable terminology for items and etc. Go through the database and here and make it more obvious.
/*
Item Category - Food, Books, etc
Item Kind - candy apple, "hello from the grave", etc
The Items - candy apple #1 belonging to user #35, etc
and then you have item_category_id, item_category_name. Item_kind_id, Item_kind_name. Item_kind_desc. Holy dang.

*/

function display_shop_items() {
    global $conn;
    global $session_user_id;
    global $item_image_path;
    
    $sql = "SELECT * FROM `item_types`";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $items = array();
        while ($row = mysqli_Fetch_assoc($result)) {
            array_push($items, $row);
        }
    }
    
    foreach($items as $item) {
        $item_info = get_item_type_info_from_id($item['id']);
        echo "<div class='item'><img src='"; 
        echo $item_image_path . "/" . get_category_from_category_id($item_info['category']) . "/" . $item_info['image'];
        echo "'><p><b>";
        echo $item['name'];
        echo ":</b> ";
        echo "<i>";
        echo $item_info['description'];
        echo "</i>";
        
            echo "<form action='' method='POST'>";
            ?>
            <input type="hidden" name="item_type" value="<?= $item['id'] ?>">
            <?php
            echo "</p><p>Price: ";
            echo $item_info['price'];
            echo " food";
            echo "<button>Buy</button>";
            echo "</form>";
        
        
        echo "</p></div>";
    }
}


function display_inventory($user_id) {
    global $session_user_id;
    global $conn;
    
    $sql = "SELECT * FROM `items` WHERE `owner_id` = $user_id";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $items = array();
        while ($row = mysqli_Fetch_assoc($result)) {
            array_push($items, $row);
        }
    }

    global $item_image_path;
    
    // the problem is with get_item_type_info_from_id - you're pulling in the list of item TYPES for the shop - needs to be indv. items for user inventory. 
    // actualy the problem might be in the array above - the row above contains a list of item types if its the shop, and a row of item instances if its a user. This function needs to be broken up.
    
    foreach($items as $item) {
        $item_info = get_item_instance_info_from_id($item['id']);
        echo "<div class='item'><img src='"; 
        echo $item_image_path . "/" . get_category_from_category_id($item_info['category']) . "/" . $item_info['image'];
        echo "'><p><b>";
        echo item_id_to_name($item['id']);
        echo ":</b> ";
        echo "<i>";
        echo $item_info['description'];
        echo "</i>";
        
        echo "</p></div>";
    }
}

function get_item_type_info_from_id($item_type_id) {
    global $conn;
    $sql = "SELECT * FROM `item_types` WHERE `id` = $item_type_id";
    return mysqli_fetch_assoc(mysqli_query($conn, $sql));
}

function get_item_instance_info_From_id($item_inst_id) {
    global $conn;
    $sql = "SELECT * FROM `items` WHERE `id` = $item_inst_id";
    return mysqli_fetch_assoc(mysqli_query($conn, $sql));
}

function get_category_from_category_id($id) {
    global $conn;
    $sql = "SELECT `name` FROM `item_categories` WHERE `id` = $id";
    $query = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($query)['name'];
}

function get_category_name_from_item_type_id($id) {
    global $conn;
    // item types gives category id, item_categories gives category name..
}

function item_id_to_name($id) {
    global $conn;
    $sql = "SELECT `name` FROM `item_types` WHERE `id` = $id";
    $query = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($query)['name'];
}

?>