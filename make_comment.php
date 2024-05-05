<?php 
    session_start();
    include 'connection.php';
    $videoID = $_POST["videoID"];
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["comment"])){
            
            $comment = $_POST["comment"];
            $userID = $_SESSION["userID"];
            $commentSql = "insert into comments (videoID, userID, comment) values (?, ?, ?)";
            $commentStmt = $conn->prepare($commentSql);
            $commentStmt->bind_param("iis",$videoID, $_SESSION["userID"], $comment);
            // echo $videoID.','.$_SESSION['userID'].','.$comment;
            if($commentStmt->execute()){
                echo 'Query worked!';
            }else{
                echo 'Query didnt work';
            }
            echo "<script>window. close();</script>";
        }
    }
?>