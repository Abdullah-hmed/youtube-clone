<?php 
    session_start();
    session_unset();
    header("refresh: 1; index.php");
?>