<?php include 'init.php' ?>

<?php include 'head.php' ?>

<!-- CONTENT -->

<!-- can't do this until upload / feel like configuring sendmail. this is the email activation part.
https://www.youtube.com/watch?v=erFZWX9aGUc&list=PLE134D877783367C7&index=25
-->


<?php 


if (isset($_GET['alreadyloggedin']) && empty($_GET['alreadyloggedin'])) {
    echo "<blockquote class='warning'><h3>You have to log out before accessing that page.</h3>
    </blockquote>";
}

if (isset($_GET['registersuccess']) && empty($_GET['registersuccess'])) {
    echo "<blockquote class='success'><h3>User registered!</h3><p>Check your email for the activation link. Once you have activated your account, please log in.</p></blockquote>";
}


if (logged_in() === true) {
    include 'loggedIn.php';
} else {
    include 'loginForm.php';
}




?>









<?php include 'footer.php' ?>