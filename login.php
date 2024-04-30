<?php 

    include "connection.php";
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST["username"];
        $password = $_POST["password"];
    }

    //check if username exists
    $sqlUserExists = 'select * from users where username=? LIMIT 1';
    $stmt = $conn->prepare($sqlUserExists);
    $stmt->bind_param("s", $username);
    
    
    if($stmt->execute()){
        //fetch data
        $result = $stmt->get_result() or die("Result didnt make it through!");
        $userData = mysqli_fetch_assoc($result) or die("No rows Attained, User Doesn't Exist!".var_dump($result));
        //compare username
        if($userData["username"] == $username){
            echo '<p style="color: green;">Username Exists!</p>';
        } else{
            die('<p style="color: red;">Username doesn\'t exist or is Invalid!</p>');    
        }

        // verify password
        if(password_verify($password, $userData["password"])){
            echo '<p style="color: green;">Password is valid!</p>';
        } else{
            die('<p style="color: red;">Password isn\'t correct!</p>');
        }
    } else{
        die('<p style="color: red;">An Error Occurred!</p>');
    }
    $stmt->close();
    $conn->close();
    header("refresh: 3;index.html");
?>