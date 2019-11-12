<?php

function type_from_type_id($type_id) {
    $sql = "SELECT `type` FROM `seed_types` WHERE `type_id` = $type_id";
    global $conn;
    $type = mysqli_query($conn, $sql);
    return mysqli_fetch_array($type)['type'];
}

function display_seed($seed) {
        $type = type_from_type_id($seed['type_id']);
        echo "<section class='display-seed'>";
        echo "<b>Name: </b>" . $seed['name'] . "<br>" . 
             "<b>Type: </b>" . $type . "<br>" . 
             "<b>Adoption date: </b>" . $seed['adopt_date'];
        echo "</section>";
}

?>