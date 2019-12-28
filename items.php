<?php include 'init.php' ?>
<?php protect_page(); ?>

<?php include 'head.php' ?>

<h1>My items</h1>




<section class="items">    
<?php
    
global $conn;
$sql = "SELECT * FROM `items` WHERE `owner_id` = $session_user_id";

if (mysqli_num_rows(mysqli_query($conn, $sql)) != 0) {

    display_inventory($session_user_id);

} else {
    echo "No items.";
}
    
    
?>
</section>



<?php include 'footer.php'; ?>
