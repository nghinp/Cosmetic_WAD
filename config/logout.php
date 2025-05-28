<?php
 session_start();
 // Destroy the session regardless of whether specific variables exist
 session_destroy();
 // Make sure to exit after redirect to prevent further script execution
 header("Location:../homePage.php");
 exit();
?>