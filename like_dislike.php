<?php
    include 'connection.php';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $videoID = $_POST["videoID"];
        if(isset($_POST["likes"])){
            $likeButton = $_POST["likes"];
            echo 'Like Button: '.$likeButton;
            if($likeButton === 'increment'){
                $likeSql = "Update video SET video_likes = video_likes + 1 WHERE video_ID = ?";
                $likeStmt = $conn->prepare($likeSql);
                $likeStmt->bind_param("i", $videoID);
                $likeStmt->execute();
                echo "<script>window. close();</script>";
            }
            if($likeButton === 'decrement'){
                $likeSql = "Update video SET video_likes = video_likes - 1 WHERE video_ID = ?";
                $likeStmt = $conn->prepare($likeSql);
                $likeStmt->bind_param("i", $videoID);
                $likeStmt->execute();
                echo "<script>window. close();</script>";
            }
            
        }
        if(isset($_POST["dislikes"])){
            $dislikeButton = $_POST["dislikes"];
            echo 'Dislike Button: '.$dislikeButton;
            if($dislikeButton === 'increment'){
                $likeSql = "Update video SET video_dislikes = video_dislikes + 1 WHERE video_ID = ?";
                $likeStmt = $conn->prepare($likeSql);
                $likeStmt->bind_param("i", $videoID);
                $likeStmt->execute();
                echo "<script>window. close();</script>";
            }
            if($dislikeButton === 'decrement'){
                $likeSql = "Update video SET video_dislikes = video_dislikes - 1 WHERE video_ID = ?";
                $likeStmt = $conn->prepare($likeSql);
                $likeStmt->bind_param("i", $videoID);
                $likeStmt->execute();
                echo "<script>window. close();</script>";
            }
            echo "<script>window. close();</script>";
        }
    }
?>