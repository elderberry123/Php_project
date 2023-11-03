
<?php
session_start();
include "config.php";

if (isset($_COOKIE["user_email"])) {
    echo $_COOKIE["user_email"];
} elseif (isset($_SESSION["user_email"])) {
    echo $_SESSION["user_email"];
}


?>


<?php if (isset($_COOKIE["user_email"])):?>

    <h1>Home </h1>
    <a href="logout.php"> logout </a>
<?php elseif(isset($_SESSION["user_email"])): ?>
    <h1>Home </h1>
    <a href="logout.php"> logout </a>
    <?php endif ?>
