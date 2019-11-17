<?php include 'init.php' ?>

<?php include 'head.php' ?>

<?php protect_page() ?>

<!-- CONTENT -->

<h3>Seedlings:</h3>

<!-- display success message if redirected here after form submit: -->
<?php
    if (isset($_GET['success']) && empty($_GET['success'])) {
        echo "<blockquote class='success'><h3>New seedling created successfully!</h3></blockquote>";
    }
?>

<!-- feed seedling handling: -->
<?php 
    if (isset($_GET['feed'])) {
        feed_seedling($_GET['feed']);
    }
?>

<!-- display success message if redirected after feeding -->
<?php
    if (isset($_GET['fedsuccess']) && empty($_GET['fedsuccess'])) {
        echo "<blockquote class='success'><h3>Seedling fed successfully!</h3>
        <p>Your food -1</p></blockquote>";
    }
?>




<!-- get and display user's seeds -->
<section class="seedlings-wrap">
<?php 
    $seeds = array();
    $owner_id = user_id_from_username($user_data['username']);

    $sql = "SELECT * FROM `seedlings` WHERE `owner_id` = $owner_id AND `released` = 0";

    global $conn;
    $result = mysqli_query($conn, $sql);
    

if (mysqli_num_rows($result) > 0) {
    $i = 0;
    while($row = mysqli_fetch_assoc($result)) {
        $seeds[$i] = array(
            "seedling_id" => $row['seedling_id'],
            "name" => $row['name'],
            "type_id" => $row['type_id'],
            "adopt_date" => $row['adopt_date'],
            "img_url" => $row['img_url'],
            "last_fed" => $row['last_fed']
            );
        $i++;
    }
    foreach($seeds as $seed) {
        display_seed($seed);
    }
} else {
    echo "0 seeds :(";
}
    
?>
</section>









<?php
    
if (empty($_POST) === false) {
    // check name is filled, it's the only required field right now:
    if (empty($_POST['name']) ) {
        $errors[] = "Must give seedling a name.";
    } else if (empty($errors) && empty($_POST['name']) === false) {
        // if there are no errors and name has a value,
        // create seedling!
        $name = sanitize($_POST['name']);
        $img_url = sanitize($_POST['img_url']);
        $data = array(
            'name' => $name,
            'type_id' => $_POST['type_id'],
            'date' => date('Y-m-d'),
            'owner_id' => user_id_from_username($user_data['username']),
            'img_url' => $_POST['img_url']
        );
        $data_str = '\'' . implode('\', \'', $data) . '\'';
        
        $sql = "INSERT INTO `seedlings` (name, type_id, adopt_date, owner_id, img_url) VALUES ($data_str)";
        
        global $conn;
        if (mysqli_query($conn, $sql)) {
            header('Location: seeds.php?success');
            exit();
        } else {
            echo "<blockquote class='error'><h3>Seedling could not be created, ran into a MySQL error:</h3>
            <p>" . mysqli_error($conn) . "</p></blockquote>";
        }
        
    }
}    


// error handling.
    if (empty($errors) === false) {
        display_errors($errors, "create seedling");
    }
    
    
    
?>

<!-- create seedling -->
<h3>Create seedling:</h3>
<form action="" method="post">
    <ul>
        <li>Seedling picture:<br>
            <img id="seedImg" height="200px" width="200px" src="
                    <?php
                        $seed_img = gen_seed_img();
                        echo $seed_img;
                    ?>
                      ">
            
                      <input type="button" value="Get new image" onclick="getNewSeedImg()">

            <input type="hidden" id="img_url" name="img_url">
        </li>
        <li>Seedling name:<br>
            <input type="text" name="name"></li>
        <li>Type:<br>
            <!-- get types from `seed_types`...DRY. -->
            <select name="type_id">
                <?php 
                global $conn;
                $sql = "SELECT `type_id`, `type` FROM `seed_types`";
                $types = mysqli_query($conn, $sql);

                if (mysqli_num_rows($types) > 0) {
                    while($row = mysqli_fetch_assoc($types)) {
                        echo "<option value='" . $row['type_id'] . "'>" . $row['type'] . "</option>";
                    }
                } else {
                    echo "<option value='error'>MySQL ERROR. Please let me know</option>";
                }
                ?>
            </select>
        </li>
        <li>
            <button>Go</button></li>

    </ul>
</form>


<script>
    // set hidden field value to seedImg src so it can get passed on if they don't click Get New Image
    document.getElementById("img_url").value = document.getElementById("seedImg").src;

    // AJAX for get new image
    function getNewSeedImg() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("seedImg").src = this.responseText;
                document.getElementById("img_url").value = this.responseText;
            }
        };
        xmlhttp.open("GET", "seed_functions.php?func=gen_seed_img", true);
        xmlhttp.send();
    }
</script>

<?php include 'footer.php' ?>