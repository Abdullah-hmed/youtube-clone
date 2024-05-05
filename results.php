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
    <link rel="icon" type="image/x-icon" href="Images/favicon.ico">
    <title>Search Results</title>
</head>
<body>
    <?php
        include 'header.php';
        include_once 'sidebar.php';
        $searchText = $_GET["searchField"];
        $searchParam = "%$searchText%";
        // $searchText = "test";
        // if(!isset($searchText)){
        //     $searchText = 'test';
        // }
        $searchQuery = "select video.video_ID, video.video_title, video.video_description, video.video_thumbnail, users.username, users.pfp, video.video_views, video.video_upload_date
        from video left join users on video.uploaderID = users.userID
        where MATCH(video_title, video_description) against(? IN NATURAL LANGUAGE MODE) OR video.video_title LIKE ? OR video.video_description LIKE ?;";
        $searchStmt = $conn->prepare($searchQuery);
        $searchStmt->bind_param("sss",$searchText, $searchParam, $searchParam);
        
        $searchStmt->execute();

        $searchStmt->bind_result($searchID, $searchTitle, $searchDescription, $thumbnail, $searchUser, $searchUserPFP , $searchViews, $searchDate);
    ?>
    <div class="search-result-container">
        <?php 
            while($searchStmt->fetch()){
                echo '
                    <a class="video" href="video.php?videoID='.$searchID.'">
                        <div class="result-video">
                        <img src="'.$thumbnail.'" alt="thumbnail" width="400px" height="100%">
                            <div class="results-video-data">
                                <p class="results-video-title">'.$searchTitle.'</p>
                                <p class="video-stats">'.$searchViews.'  views . '.getVideoTime($searchDate).'</p>
                                <div class="user"><img src="pfp/'.$searchUserPFP.'" width="30"><p>'.$searchUser.'</p></div>
                                <p class="search-description">'.$searchDescription.'</p>
                            </div>
                        </div>
                    </a>
                ';
            }
        ?>
    </div>
</body>
</html>