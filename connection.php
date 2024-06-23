<?php
    $serverName = "db";
    $userName = "db";
    $password = "db";
    $dbName = "db";
    
    $conn = mysqli_connect($serverName, $userName, $password, $dbName);

    if(mysqli_connect_errno()){
        echo 'Connection Failed :(';
        echo mysqli_connect_error(); // Use mysqli_connect_error() to get the specific connection error
        echo $conn->connect_error;
    } else{
        // echo 'Connection Successful!<br>';
    }
?>