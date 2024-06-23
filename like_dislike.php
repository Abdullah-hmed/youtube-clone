<?php
    session_start();
    include 'connection.php';
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $videoID = $_POST["videoID"];
        if(isset($_POST["likes"])){
            $likeButton = $_POST["likes"];
            echo 'Like Button: '.$likeButton;
            if($likeButton === 'increment'){
                $likeSql = "Update video SET video_likes = video_likes + 1 WHERE video_ID = ?;";
                $likeStmt = $conn->prepare($likeSql);
                $likeStmt->bind_param("i", $videoID);
                $likeStmt->execute();
                $likeStmt->close();

                $likedatabaseSql = "Insert into likes (videoID, userID) values (?, ?);";
                $likedatabaseStmt = $conn->prepare($likedatabaseSql);
                $likedatabaseStmt->bind_param("ii", $videoID, $_SESSION["userID"]);
                $likedatabaseStmt->execute();
                    header("location: video.php?videoID=$videoID");
                //echo "<script>window. close();</script>";
            }
            if($likeButton === 'decrement'){
                $likeSql = "Update video SET video_likes = video_likes - 1 WHERE video_ID = ?";
                $likeStmt = $conn->prepare($likeSql);
                $likeStmt->bind_param("i", $videoID);
                $likeStmt->execute();
                
                $unlikedatabaseSql = "delete from likes where userID= ? AND videoID = ?;";
                $unlikedatabaseStmt = $conn->prepare($unlikedatabaseSql);
                $unlikedatabaseStmt->bind_param("ii", $_SESSION["userID"], $videoID);
                $unlikedatabaseStmt->execute();
                
                header("location: video.php?videoID=$videoID");
                //echo "<script>window. close();</script>";
            }
            
        }
        if(isset($_POST["dislikes"])){
            $dislikeButton = $_POST["dislikes"];
            echo 'Dislike Button: '.$dislikeButton;
            if($dislikeButton === 'increment'){
                $dislikeSql = "Update video SET video_dislikes = video_dislikes + 1 WHERE video_ID = ?";
                $dislikeStmt = $conn->prepare($dislikeSql);
                $dislikeStmt->bind_param("i", $videoID);
                $dislikeStmt->execute();

                $dislikedatabaseSql = "Insert into dislikes (videoID, userID) values (?, ?);";
                $dislikedatabaseStmt = $conn->prepare($dislikedatabaseSql);
                $dislikedatabaseStmt->bind_param("ii", $videoID, $_SESSION["userID"]);
                $dislikedatabaseStmt->execute();
                header("location: video.php?videoID=$videoID");
                //echo "<script>window. close();</script>";
            }
            if($dislikeButton === 'decrement'){
                $dislikeSql = "Update video SET video_dislikes = video_dislikes - 1 WHERE video_ID = ?";
                $dislikeStmt = $conn->prepare($dislikeSql);
                $dislikeStmt->bind_param("i", $videoID);
                $dislikeStmt->execute();

                $undislikedatabaseSql = "delete from dislikes where userID= ? AND videoID = ?;";
                $undislikedatabaseStmt = $conn->prepare($undislikedatabaseSql);
                $undislikedatabaseStmt->bind_param("ii", $_SESSION["userID"], $videoID);
                $undislikedatabaseStmt->execute();
                header("location: video.php?videoID=$videoID");
                //echo "<script>window. close();</script>";
            }   header("location: video.php?videoID=$videoID");
            //echo "<script>window. close();</script>";
        }
    }
?>