<?php include 'init.php' ?>

<?php include 'head.php' ?>
        

<h1>Register</h1>

<form action="" method="POST">
    
    <ul>
        <li>
            Username: <br>
            <input type="text" name="username">
        </li>
        
        <li>
            Password: <br>
            <input type="password" name="password">
        </li>
        
        <li>
            Password again:<br>
            <input type="password" name="password_again">
        </li>
        
        <li>
            Email:<br>
            <input type="email" name="email">
        </li>
        
        <li>
            <button>Submit</button>
        </li>
    </ul>
    
</form>



<?php include 'footer.php' ?>