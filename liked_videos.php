<?php 
    include 'connection.php';
    include 'header.php';
    include_once 'sidebar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="Images/favicon.ico">
    <title>Liked Videos</title>
</head>
<body>
    <script src="script.js"></script>
    <?php
        function getVideoTime($videoUploadDate){
            date_default_timezone_set("Asia/Karachi");
            $currentTime = new DateTime('now');
            $currentTime->format('%y %m %d %h %i %s');
            $uploadedDateVideo = new DateTime($videoUploadDate);
            $UploadDiff = $uploadedDateVideo->diff($currentTime);
    
    
            if(!$UploadDiff->format('%y') == 0){
                $UploadDate = $UploadDiff->format('%y years ago');
            } elseif(!$UploadDiff->format('%m') == 0){
                $UploadDate = $UploadDiff->format('%m months ago');
            } elseif(!$UploadDiff->format('%d') == 0){
                $UploadDate = $UploadDiff->format('%d days ago');
            } elseif(!$UploadDiff->format('%h') == 0){
                $UploadDate = $UploadDiff->format('%h hours ago');
            } elseif(!$UploadDiff->format('%i') == 0){
                $UploadDate = $UploadDiff->format('%i minutes ago');
            } else {
                $UploadDate = $UploadDiff->format('%s seconds ago');
            }
            return $UploadDate;
        }
        
        if(!isset($_SESSION["userID"])){
            echo '<h1>Not Logged In! Redirecting</h1>';
            // header('refresh: 0.5s;index.php');
            echo '<script>window.location.replace("index.php")</script>';
        }
        $likedVideoQuery = "select video.video_ID, video.video_title, video.video_description, video.video_thumbnail, users.username, users.pfp, video.video_views, video.video_upload_date from video INNER JOIN users ON video.uploaderID = users.userID INNER JOIN likes ON video.video_ID = likes.videoID where likes.userID = ?;";
        $likedVideoStmt = $conn->prepare($likedVideoQuery);
        $likedVideoStmt->bind_param("i", $_SESSION["userID"]);
        
        $likedVideoStmt->execute();

        $likedVideoStmt->bind_result($likedVideoID, $likedVideoTitle, $likedVideoDescription, $thumbnail, $likedVideoUser, $likedVideoUserPFP , $likedVideoViews, $likedVideoDate);
        
    ?>
    
    <div class="liked-videos-container">
        <h1>Liked Videos</h1>
        <?php 
            while($likedVideoStmt->fetch()){
                echo '
                    <a class="video" href="video.php?videoID='.$likedVideoID.'">
                        <div class="result-video">
                        <img src="'.$thumbnail.'" alt="thumbnail" width="400px" height="100%">
                            <div class="results-video-data">
                                <p class="results-video-title">'.$likedVideoTitle.'</p>
                                <p class="video-stats">'.$likedVideoViews.'  views . '.getVideoTime($likedVideoDate).'</p>
                                <div class="user"><img src="pfp/'.$likedVideoUserPFP.'" width="30"><p>'.$likedVideoUser.'</p></div>
                                <p class="likedVideo-description">'.$likedVideoDescription.'</p>
                            </div>
                        </div>
                    </a>
                ';
            }
        ?>
    </div>
</body>
</html>