<?php 
    // session_start();
    include_once 'header.php';
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
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="Images/favicon.ico">
    <title>YouTube</title>
</head>

<body>
    <script src="script.js"></script>
    <?php 
        include_once 'sidebar.php';
    ?>

    <main id="frontpage">
        <div class="tags">
            <button>All</button>
            <button>Music</button>
            <button>Gaming</button>
            <button>Computer Programming</button>
            <button>Computers</button>
            <button>Mixes</button>
            <button>Podcasts</button>
            <button>Live</button>
            <button>Computers</button>
            <button>Mixes</button>
            <button>Podcasts</button>
            <button>Live</button>
            <button>Mixes</button>
            <button>Podcasts</button>
            <button>Live</button>
        </div>

        <div class="video-grid">
        <?php
            $videoQuery = "Select video.video_ID, video.video_title, video.video_views, video.video_upload_date, video.video_thumbnail, users.username, users.pfp
            from video INNER JOIN users ON video.uploaderID = users.userID ORDER BY RAND()";
            $result = $conn->query($videoQuery);
            if($result->num_rows > 0){
                while($video = $result->fetch_assoc()){
                    $videoID = $video["video_ID"];
                    $videoTitle = $video["video_title"];
                    $views = $video["video_views"];
                    $uploadDate = $video["video_upload_date"];
                    $thumbnail = $video["video_thumbnail"];
                    $uploaderName = $video["username"];
                    $uploaderPFP = $video["pfp"];
                    echo '
                    <a href="video.php?videoID='.$videoID.'">
                        <div class="video">
                            <img class="thumbnail" src="'.$thumbnail.'" width="100%"><br>
                            <div class="video-info">
                                <img class="frontpage-user" src="pfp/'.$uploaderPFP.'" width="30">
                                <div class="video-text">
                                    <p class="video-title">'.$videoTitle.'</p>
                                    <p class="video-uploader">'.$uploaderName.'</p>
                                    <p class="video-stats">'.$views.' views . '.getVideoTime($uploadDate).'</p>
                                </div>
                            </div>
                        </div>
                    </a>';
                }
            }
        ?>
        </div>
    </main>
</body>

</html>