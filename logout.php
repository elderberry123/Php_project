<?php 


session_start();
include "config.php";

    if (isset($_COOKIE["user_email"])) {
        setcookie($_COOKIE["user_email"], "", time() - 3600);
        header("location:login.php");
      } elseif (isset($_SESSION["user_email"])) {
        unset($_SESSION["user_email"]);
        echo session_destroy() ? "Successfully Logged Out" :
        exit;
        header("location:login.php");
      }
      
      
      ?>