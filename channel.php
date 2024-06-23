<?php 
    include 'header.php';
    include 'connection.php';
    include 'sidebar.php';
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
    <link rel="shortcut icon" href="Images/favicon.ico" type="image/x-icon">
    <title>Channel</title>
</head>
<body>
    <script defer src="script.js"></script>
    <?php 
        $channelID = $_GET["channelID"];
        echo $channelID;
        
        $channelNameSql = "SELECT username, pfp FROM users WHERE userID = ?;";
        $channelNameStmt = $conn->prepare($channelNameSql);
        $channelNameStmt->bind_param("i", $channelID);
        $channelNameStmt->execute();
        $channelNameStmt->bind_result($channelName, $channelPFP);
        $channelNameStmt->fetch();
        $channelNameStmt->close();

        function subscriberCount($conn, $channelID){
            $countSql = "SELECT COUNT(*) as subscribers from subscriptions where channelID = ?;";
            $countStmt = $conn->prepare($countSql);
            $countStmt->bind_param("i", $channelID);
            if($countStmt->execute()){
                $result = $countStmt->get_result() or die();
                $count = mysqli_fetch_assoc($result);
                return $count['subscribers'];
            }
        }
    ?>
    <div class="channel-main" id="frontpage">
        <div class="channel-hero-page">
            <img src="pfp/<?php echo $channelPFP ?>" alt="Channel Picture" width="150px">
            <div class="channel-data">
                <h1><?php echo $channelName ?></h1>
                <h3>@<?php echo $channelName ?></h3>
                <h4><?php echo subscriberCount($conn, $channelID) ?> Subscribers</h4>
                <button id="subscribe" style="margin: 0;" >Subscribe</button>
            </div>
        </div>
        <br>
        <hr>
        <h2>Videos</h2>
        <div class="video-grid">
        <?php
            $videoQuery = "Select video_ID, video_title, video_views, video_upload_date, video_thumbnail
            from video WHERE uploaderID = ?";
            $videoStmt = $conn->prepare($videoQuery);
            $videoStmt->bind_param("i", $channelID);
            $videoStmt->execute();
            $result = $videoStmt->get_result();
            if($result->num_rows > 0){
                while($video = $result->fetch_assoc()){
                    $videoID = $video["video_ID"];
                    $videoTitle = $video["video_title"];
                    $views = $video["video_views"];
                    $uploadDate = $video["video_upload_date"];
                    $thumbnail = $video["video_thumbnail"];
                    echo '
                    <a href="video.php?videoID='.$videoID.'">
                        <div class="video" >
                            <img class="thumbnail"  src="'.$thumbnail.'" width="100%"><br>
                            <div class="video-info">
                                <div class="video-text">
                                    <p class="video-title">'.$videoTitle.'</p>
                                    <p class="video-stats">'.$views.' views . '.getVideoTime($uploadDate).'</p>
                                </div>
                            </div>
                        </div>
                    </a>';
                }
            }
        ?>
        </div>
    </div>

</body>
</html>