<?php
    $serverName = "localhost";
    $userName = "root";
    $password = "123";
    $dbName = "youtube";
    
    $conn = mysqli_connect($serverName, $userName, $password, $dbName);

    if(mysqli_connect_errno()){
        echo 'Connection Failed :(';
        echo $conn->connect_error;
    } else{
        // echo 'Connection Successful!<br>';
    }
?>