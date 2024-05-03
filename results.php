<?php 
    include 'connection.php';

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
</head>
<body>
    <?php
        include 'header.php';
        include_once 'sidebar.php';
        $searchText = $_GET["searchField"];
        // $searchText = "test";
        // if(!isset($searchText)){
        //     $searchText = 'test';
        // }
        $searchQuery = "select video_ID, video_title, video_description, uploader, video_views, video_upload_date from video where MATCH(video_title, video_description) against(? IN NATURAL LANGUAGE MODE);";
        $searchStmt = $conn->prepare($searchQuery);
        $searchStmt->bind_param("s",$searchText);
        
        $searchStmt->execute();

        $searchStmt->bind_result($searchID, $searchTitle, $searchDescription ,$searchUploader, $searchViews, $searchDate);
    ?>
    <div class="search-result-container">
        <?php 
            while($searchStmt->fetch()){
                echo '
                    <a class="video" href="video.php?videoID='.$searchID.'">
                        <div class="suggested-video">
                        <img src="thumbnails/react.png" alt="thumbnail" width="400px" height="100%">
                            <div class="suggested-video-data">
                                <p class="video-title">'.$searchTitle.'</p>
                                <div class="user"><img src="Images/user.png" width="30"><p>'.$searchUploader.'</p></div>
                                <p class="search-description">'.$searchDescription.'</p>
                                <p class="video-stats">'.$searchViews.'  views . '.getVideoTime($searchDate).'</p>
                            </div>
                        </div>
                    </a>
                ';
            }
        ?>
    </div>
</body>
</html>