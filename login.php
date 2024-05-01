<?php 
    session_start();
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
        $userData = mysqli_fetch_assoc($result);
        if (!$userData) {
            echo "No rows attained. User doesn't exist!" . var_dump($result);
            header("refresh: 3;login.html"); // Redirect to login.html after 3 seconds
            exit();
        }

        //compare username
        if($userData["username"] == $username){
            echo '<p style="color: green;">Username Exists!</p>';
            
        } else{
            echo '<p style="color: red;">Username doesn\'t exist or is Invalid!</p>';
            header("refresh: 3;login.html");
            exit;
        }

        // verify password
        if(password_verify($password, $userData["password"])){
            echo '<p style="color: green;">Password is valid!</p>';
            $_SESSION["pfp"] = $userData["pfp"];
            $_SESSION["username"] = $userData["username"];
            $_SESSION["loginStatus"] = true;
        } else{
            echo '<p style="color: red;">Password isn\'t correct!</p>';
            header("refresh: 3;login.html");
            $_SESSION["username"] = "Guest";
            $_SESSION["pfp"] = "pfp/user.png";
            $_SESSION["loginStatus"] = false;
            exit;
        }
    } else{
        die('<p style="color: red;">An Error Occurred!</p>');
    }
    $stmt->close();
    $conn->close();
    header("refresh: 3;index.php");
?>