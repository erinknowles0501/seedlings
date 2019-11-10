<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        
        <!-- logged-in only pages! -->
        <?php 
        if (logged_in() === true) {
            include 'nav_protected_pages.php';
        }
        ?>

        
    </ul>
</nav>