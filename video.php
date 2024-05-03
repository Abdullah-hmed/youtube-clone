<?php 
    include 'connection.php';
    $videoID = $_GET["videoID"];

    //Query to increment views of video
    $viewQuery = "update video set video_views = video_views + 1 where video_ID = ?";
    $viewStmt = $conn->prepare($viewQuery);
    $viewStmt->bind_param("i",$videoID);
    $viewStmt->execute();

    //geting the video dat
    $videoQuery = "select video_title, video_description, video_likes, video_dislikes, video_upload_date, video_views, video_directory from video where video_ID=? LIMIT 1;";
    $videoStmt = $conn->prepare($videoQuery);
    $videoStmt->bind_param("i",$videoID);

    $videoStmt->execute();

    $videoStmt->bind_result($videoTitle, $videoDescription, $videoLikes, $videoDislikes, $videoUploadDate, $videoViews, $videoDirectory);

    $videoStmt->fetch();

    $videoStmt->close();
    

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
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="Images/youtube.png">
    <title>Video Page</title>
</head>
<body>
    <script src="script.js"></script>
    <?php
        include_once 'header.php';
    ?>

    <sidebar id="video-sidebar">
        <div>
            <button><i class="fa fa-home"></i> Home</button>
            <button><i class="fa fa-youtube-play" aria-hidden="true"></i> Shorts</button>
            <button><i class="fa fa-clipboard" aria-hidden="true"></i> Subscriptions</button>
            <button><b>You</b> <i class="fa fa-angle-right" aria-hidden="true"></i></button>
            <button><i class="fa fa-user-o" aria-hidden="true"></i> Your Channel</button>
            <button><i class="fa fa-history" aria-hidden="true"></i> History</button>
            <button><i class="fa fa-play" aria-hidden="true"></i> Your Videos</button>
            <button><i class="fa fa-clock-o" aria-hidden="true"></i> Watch Later</button>
            <button onclick="showMore()"><i class="fa fa-angle-down" aria-hidden="true"></i> Show More</button>

            <div id="show-more">
                <button><i class="fa fa-thumbs-up" aria-hidden="true"></i> Liked Videos</button>
            </div>
        </div>
        
    </sidebar>

    <main class="video-page-container">
        <div class="video-and-comments">
        <video class="youtube-video" src=<?php echo $videoDirectory ?> controls autoplay></video>
            <p id="video-page-title"><?php echo $videoTitle ?></p>
            <div class="user-and-video-info">
                <div class="user-subs">
                    <div class="user-info">
                        <img src="./Images/user.png" alt="user" width="40px">
                        <div class="acc-info">
                            <p id="acc-name">Abdullah</p>
                            <p id="acc-subs">2.86M subscribers</p>
                        </div>
                    </div>
                    <div class="subscription">
                        <button id="subscribe">Subscribe</button>
                    </div>
                </div>
                <div class="feedback-buttons">
                    <button id="like-button"><i class="fa fa-thumbs-up"></i> <?php echo $videoLikes ?></button>
                    <button id="dislike-button"><i class="fa fa-thumbs-down fa-flip-horizontal"></i></button>
                    <button class="omittable-button"><i class="fa fa-share"></i> Share</button>
                    <button class="omittable-button"><i class="fa fa-download"></i> Download</button>
                    <button class="omittable-button"><i class="fa fa-scissors"></i> Clip</button>
                    <button class="omittable-button"><i class="fa fa-ellipsis-h"></i></button>
                </div>
            </div>
            <div class="description">
                <div class="description-data">
                    <p id="description-date"><?php echo $videoViews.' views . '.getVideoTime($videoUploadDate) ?></p>
                    <!-- <p id="description-tags">#programming #compsci #learntocode</p> -->
                </div>
                <p id="description-text"> <?php echo $videoDescription ?> </p>

                <!-- <p id="read-more">... more</p> -->
            </div>
            <div class="comments-section">
                <div class="comment-title">
                    <p id="Comments-title">911 Comments</p>
                    <button id="sort-by"><i class="fa fa-sort"></i> Sort By</button>
                </div>
                <div class="comment-area">
                    <img src="/youtube-clone/Images/user.png" width="40px">
                    <div class="comment-write">
                        <input type="text" name="comment-writer" id="comment-writer" onkeypress="handleCommentWriter(event)" placeholder="Add a comment...">
                        <div class="comment-submit">
                            <button>😊</button>
                            <div class="comment-cancel">
                                <button>Cancel</button>
                                <button id="submit-button" onclick="makeComment()">Comment</button>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="comments-container">
                    <div class="comments">
                        <img src="/youtube-clone/Images/user.png" width="30px">
                        <div class="comments-data">
                            <div class="comment-name-date">
                                <p class="comment-name">Abdullah</p>
                                <p class="comment-date">1 year ago</p>
                            </div>
                            <p class="comment-text">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Expedita, aspernatur repellendus cupiditate deleniti itaque rerum natus, porro atque similique eum dignissimos? Commodi adipisci voluptas at atque quis exercitationem dolorem nihil!</p>
                            <div class="feedback">
                                <button class="comment-feedback"><i class="fa fa-thumbs-up"></i></button>
                                <button class="comment-feedback"><i class="fa fa-thumbs-down fa-flip-horizontal"></i></button>
                                <button class="comment-feedback"><p>Reply</p></button>
                            </div>
                        </div>
                    </div>
                    <div class="comments">
                    <img src="/youtube-clone/Images/user.png" width="30px">
                    <div class="comments-data">
                        <div class="comment-name-date">
                            <p class="comment-name">Abdullah</p>
                            <p class="comment-date">1 year ago</p>
                        </div>
                        <p class="comment-text">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Expedita, aspernatur repellendus cupiditate deleniti itaque rerum natus, porro atque similique eum dignissimos? Commodi adipisci voluptas at atque quis exercitationem dolorem nihil!</p>
                        <div class="feedback">
                            <button class="comment-feedback"><i class="fa fa-thumbs-up"></i></button>
                            <button class="comment-feedback"><i class="fa fa-thumbs-down fa-flip-horizontal"></i></button>
                            <button class="comment-feedback"><p>Reply</p></button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <aside>
            <div class="tag-container">
                <div class="tags">
                    <button>All</button>
                    <button>Gaming</button>
                    <button>Computers</button>
                    <button>Mixes</button>
                    <button>Podcasts</button>
                </div>
            </div>
            <div class="suggested-container">
                <?php 
                    $suggestedQuery = "Select video_ID, video_title, uploader, video_views, video_upload_date from video WHERE video_ID != ?;";
                    $suggestedStmt = $conn->prepare($suggestedQuery);
                    $suggestedStmt->bind_param("i",$videoID);
                    $suggestedStmt->execute();
                    $suggestedStmt->bind_result($suggestedID, $suggestedTitle, $suggestedUploader, $suggestedViews, $suggestedDate);
                    
                    while($suggestedStmt->fetch()){
                        echo '
                            <a class="video" href="video.php?videoID='.$suggestedID.'">
                                <div class="suggested-video">
                                <img src="thumbnails/react.png" alt="thumbnail" width="240" height="135">
                                    <div class="suggested-video-data">
                                        <p class="video-title">'.$suggestedTitle.'</p>
                                        <p class="user">'.$suggestedUploader.'</p>
                                        <p class="video-stats">'.$suggestedViews.' . '.getVideoTime($suggestedDate).'</p>
                                    </div>
                                </div>
                            </a>
                        ';
                    }
                ?>
            </div>
        <aside>
    </main>
</body>
</html>