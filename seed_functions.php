<?php

// AJAX HANDLING:
if(isset($_GET['func']) && !empty($_GET['func'])) {
    $call_function = $_GET['func'];
    switch($call_function) {
        case 'gen_seed_img' : gen_seed_img(); break;
    }
}



function type_from_type_id($type_id) {
    $sql = "SELECT `type` FROM `seed_types` WHERE `type_id` = $type_id";
    global $conn;
    $type = mysqli_query($conn, $sql);
    return mysqli_fetch_array($type)['type'];
}

function display_seed($seed) {
    $type = type_from_type_id($seed['type_id']);
    echo "<section class='display-seed'>";
    echo "<div class='seed-img' style='background-image: url(" . $seed['img_url'] . ");'></div><br>";
    echo "<b>Name: </b>" . $seed['name'] . "<br>" . 
         "<b>Type: </b>" . $type . "<br>" . 
         "<b>Adoption date: </b>" . $seed['adopt_date'] . "<br>";
    
    $hungry = 0;
    $one_week_ago = date('Y-m-d', strtotime('-3 days'));
    $last_fed = $seed['last_fed'];
    if ($last_fed < $one_week_ago ) {
        $hungry = 1;
    }
    $seedling_id = $seed['seedling_id'];
    
    if ($hungry == true) {
        echo "<p style='color: red;'><b>Hungry!!</b>";
        ?>
        <form action="seeds.php" method="GET">
            <input type="hidden" name="feed" value="<?php echo $seedling_id; ?>">
            <button>Feed this poor baby</button>
        </form>
        <?php
        echo "</p>";
    } else {
        echo "<p><b>Not hungry</b></p>";
    }
    echo "</section>";
}

function gen_seed_img() {
    echo "https://placekitten.com/".rand(200,600)."/".rand(200,600);
}

function feed_seedling($seedling_id) {
    $today = date('Y-m-d');
    
    global $conn;
    $sql = "UPDATE `seedlings` SET `last_fed` = '$today' WHERE `seedling_id` = $seedling_id";
    if (mysqli_query($conn, $sql)) {
        change_food(-1);
        header('Location: seeds.php?fedsuccess');
        exit();
    } else {
        echo "<blockquote class='error'><h3>Seedling could not be fed, ran into a MySQL error:</h3>
        <p>" . mysqli_error($conn) . "</p></blockquote>";
    }
}

function change_food($amount) {
    global $conn;
    global $user_data;
    global $session_user_id;
    $new_food = $user_data['food'] + $amount;
    
    $sql = "UPDATE `users` SET `food` = $new_food WHERE `user_id` = $session_user_id";
    mysqli_query($conn, $sql);
}



?>