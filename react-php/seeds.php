<?php include 'init.php' ?>

<?php include 'head.php' ?>

<?php protect_page() ?>

<!-- CONTENT -->

<h3>Seedlings:</h3>



<!-- get and display user's seeds -->
<?php 
    $seeds = array();
    $owner_id = user_id_from_username($user_data['username']);

    $sql = "SELECT * FROM `seedlings` WHERE `owner_id` = $owner_id";

    global $conn;
    $result = mysqli_query($conn, $sql);
    

if (mysqli_num_rows($result) > 0) {
    $i = 0;
    while($row = mysqli_fetch_assoc($result)) {
        $seeds[$i] = array(
            "seedling_id" => $row['seedling_id'],
            "name" => $row['name'],
            "type_id" => $row['type_id'],
            "adopt_date" => $row['adopt_date']
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









    <?php
    
if (empty($_POST) === false) {
    // check name is filled, it's the only required field right now:
    if (empty($_POST['name']) ) {
        $errors[] = "Must give seedling a name.";
    } else if (empty($errors) && empty($_POST['name']) === false) {
        // if there are no errors and name has a value,
        // create seedling!
        $name = sanitize($_POST['name']);
        $data = array(
            'name' => $name,
            'type_id' => $_POST['type_id'],
            'date' => date('Y-m-d'),
            'owner_id' => user_id_from_username($user_data['username'])
        );
        $data_str = '\'' . implode('\', \'', $data) . '\'';
        
        $sql = "INSERT INTO `seedlings` (name, type_id, adopt_date, owner_id) VALUES ($data_str)";
        
        global $conn;
        if (mysqli_query($conn, $sql)) {
            echo "<blockquote class='success'><h3>New seedling created successfully!</h3><p>You might have to refresh to see it appear in your seedlings list.</p></blockquote>";
            exit();
        } else {
            echo "<blockquote class='error'><h3>Seedling could not be created, ran into a MySQL error:</h3>
            <p>" . mysqli_error($conn) . "</p></blockquote>";
        }
        
    }
}    


// error handling.
    if (empty($errors) === false) {
        echo "<blockquote class='error'><h3>Could not create seedling: encountered the following errors:</h3>";
        foreach($errors as $error) {
            echo "<li>" . $error . "</li>";
        }
        echo "</blockquote>";
    }
    
    
    
?>

    <!-- create seedling -->
    <h3>Create seedling:</h3>
    <form action="" method="post">
        <ul>
            <li>Seedling name:<br>
                <input type="text" name="name"></li>
            <li>Type:<br>
                <select name="type_id">
                    <option value="1">Ranch</option>
                    <option value="2">Sea</option>
                    <option value="3">Swamp</option>
                </select>
            </li>
            <li><button>Go</button></li>

        </ul>
    </form>

    <?php include 'footer.php' ?>