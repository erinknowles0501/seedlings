<?php include 'init.php' ?>
<?php protect_page(); ?>

<?php include 'head.php' ?>

<!-- CONTENT -->



<h1>The corner shop</h1>

<div>
<?php
    
// manage purchase:    
if (isset($_POST['item_type']) && !empty($_POST['item_type'])) {
    global $conn;
    $item_type = $_POST['item_type'];
    var_dump($_POST['item_type']);
    echo $item_type;
    $item_info = get_item_info_from_id($item_type);
    $sql = "INSERT INTO `items` (`type_id`, `owner_id`) VALUES ($item_type, $session_user_id)";
    
    $result = mysqli_query($conn, $sql);
    if ($result) {
        change_food(-1 * $item_info['price']);
        header('Location: shop.php?success');
        exit();
    }
} else {
    echo "FECK OFF";
}
    
?>
</div>


<section class="items">
<?php
    // random number of random item is created every hour and you get the chance to grab one. 
    // or: it just displays all the items and if you click one you can trade food for it.
    
    
    display_shop_items();
?>
</section>



<?php include 'footer.php'; ?>
