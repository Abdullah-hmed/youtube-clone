<?php 

    include "connection.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $pfp = $_FILES["pfp"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $email = $_POST["email"];
    }
    $pfpName = $pfp['name'];
    $pfpExt = pathinfo($pfpName, PATHINFO_EXTENSION);
    $newPfpName = uniqid("", true).".".$pfpExt;
    $pfp_directory = "pfp/".$newPfpName;
    echo $username;
    echo '<br>',$password;
    echo '<br>',$email;
    echo '<br>',$pfp['tmp_name'];
    echo '<br>',$pfp_directory;
    //validate email
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo '<p style="color: red;">Invalid Email!</p>';
        $conn->close();
        // header('refresh: 3;signup.html');
        echo '<script>window.location.replace("signup.html")</script>';
    }

    // VALIDATE FOR IF USERNAME ALREADY EXISTS
    $UsernameInUseSql = "Select 1 from users WHERE username = ?";
    $UsernameInUseStmt = $conn->prepare($UsernameInUseSql);
    $UsernameInUseStmt->bind_param("s", $username);
    if($UsernameInUseStmt->execute()){
        $result = $UsernameInUseStmt->get_result() or die ();
        $UsernameInUse = mysqli_fetch_assoc($result);
        if (!$UsernameInUse){
            echo '<p style="color: green;">Username available!</p>';
        }else{
            echo '<p style="color: red;">Username Unavailable!</p>';
            $conn->close();
            // header('refresh: 3;signup.html');
            echo '<script>window.location.replace("signup.html")</script>';
            exit;
        }
    }

    //check for whitespace in username
    if(!preg_match('/^\S*$/', $username)){
        echo '<p style="color: red;">Remove Whitespace from username!</p>';
        $conn->close();
        echo '<script>window.location.replace("signup.html")</script>';
        // header('refresh: 3;signup.html');
    }
    
    //convert password into hash
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    echo '<br>',$password,'<br>',$hashedPassword;

    if($pfp['size'] == 0){
        echo '<br><p style="color: red;">No pfp uploaded!</p>';
        $sqlQuery = "insert into users(username, password, email) values (?, ?, ?)";
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bind_param("sss",$username, $hashedPassword, $email);
    } else {
        echo '<br>PFP Uploaded!';
        $sqlQuery = "insert into users(username, password, email, pfp) values (?, ?, ?, ?)";
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bind_param("ssss",$username, $hashedPassword, $email, $newPfpName);
    }
    if ($stmt->execute()) {
        move_uploaded_file($pfp["tmp_name"], $pfp_directory);
        echo '<p style="color: green;">Pfp Added Successfully!</p>';
    } else {
        echo "Error: " . $stmt->error;
    }
    echo '<script>window.location.replace("index.php")</script>';
    // header('refresh: 3;index.php');
?>
