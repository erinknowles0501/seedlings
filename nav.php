<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
    </ul>

        <!-- logged-in only pages! -->
        <?php 
        if (logged_in() === true) {
            include 'nav_protected_pages.php';
        }
        ?>

        <!-- admin-only pages! -->
        <?php
        global $user_data;
        if ( $user_data['user_type'] == 1 ) {
            include 'nav_admin_protected_pages.php';  
        }
        ?>

</nav>
