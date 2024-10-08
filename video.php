<?php 
    include_once 'header.php';
    include 'connection.php';
    $videoID = $_GET["videoID"];

    //Query to increment views of video
    $viewQuery = "update video set video_views = video_views + 1 where video_ID = ?";
    $viewStmt = $conn->prepare($viewQuery);
    $viewStmt->bind_param("i",$videoID);
    $viewStmt->execute();

    //geting the video data
    $videoQuery = "select video.uploaderID, video.video_title, video.video_description, video.video_likes, video.video_dislikes, video.video_upload_date, video.video_views, video.video_directory, users.username, users.pfp
    from video INNER JOIN users ON video.uploaderID = users.userID where video_ID=? LIMIT 1;";
    $videoStmt = $conn->prepare($videoQuery);
    $videoStmt->bind_param("i",$videoID);

    $videoStmt->execute();

    $videoStmt->bind_result($uploaderID, $videoTitle, $videoDescription, $videoLikes, $videoDislikes, $videoUploadDate, $videoViews, $videoDirectory, $videoChannelName, $videoChannelPFP);

    $videoStmt->fetch();

    $videoStmt->close();
    
    function videoLiked($conn, $videoID){
        $likeCheckSql = "SELECT 1 FROM likes WHERE userID=? AND videoID=? LIMIT 1;";
        $likeCheckStmt = $conn->prepare($likeCheckSql);
        $likeCheckStmt->bind_param("ii", $_SESSION["userID"], $videoID);
        if($likeCheckStmt->execute()){
            $result = $likeCheckStmt->get_result() or die ();
            $likeCheck = mysqli_fetch_assoc($result);
            if ($likeCheck){
                return true;
            }else{
                return false;
            }
        }
    }

    function videoDisliked($conn, $videoID){
        $dislikeCheckSql = "SELECT 1 FROM dislikes WHERE userID=? AND videoID=? LIMIT 1;";
        $dislikeCheckStmt = $conn->prepare($dislikeCheckSql);
        $dislikeCheckStmt->bind_param("ii", $_SESSION["userID"], $videoID);
        if($dislikeCheckStmt->execute()){
            $result = $dislikeCheckStmt->get_result() or die ();
            $dislikeCheck = mysqli_fetch_assoc($result);
            if ($dislikeCheck){
                return true;
            }else{
                return false;
            }
        }
    }

    function subscribedOrNot($conn, $channelID, $subscriberID){
        $subscribeCheckSql = "SELECT 1 FROM subscriptions WHERE channelID=? AND subscriberID=? LIMIT 1;";
        $subscribeCheckStmt = $conn->prepare($subscribeCheckSql);
        $subscribeCheckStmt->bind_param("ii", $channelID, $subscriberID);
        if($subscribeCheckStmt->execute()){
            $result = $subscribeCheckStmt->get_result() or die ();
            $subscribeCheck = mysqli_fetch_assoc($result);
            if ($subscribeCheck){
                return true;
            }else{
                return false;
            }
        }
    }

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

    function getVideoTime($videoUploadDateUTC) {
        // Convert UTC time to user's local time
        $user_timezone = isset($_SESSION['user_timezone']) ? $_SESSION['user_timezone'] : 'UTC';
        $uploadedDateVideo = new DateTime($videoUploadDateUTC, new DateTimeZone('UTC'));
        $uploadedDateVideo->setTimezone(new DateTimeZone($user_timezone));
        
        // Get the current time in the user's timezone
        $currentTime = new DateTime('now', new DateTimeZone($user_timezone));
        
        // Calculate the difference between the uploaded date and the current time
        $UploadDiff = $uploadedDateVideo->diff($currentTime);
        
        // Determine the time difference in a human-readable format
        if ($UploadDiff->y != 0) {
            $UploadDate = $UploadDiff->format('%y years ago');
        } elseif ($UploadDiff->m != 0) {
            $UploadDate = $UploadDiff->format('%m months ago');
        } elseif ($UploadDiff->d != 0) {
            $UploadDate = $UploadDiff->format('%d days ago');
        } elseif ($UploadDiff->h != 0) {
            $UploadDate = $UploadDiff->format('%h hours ago');
        } elseif ($UploadDiff->i != 0) {
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
    <script src="https://unpkg.com/htmx.org@2.0.2" integrity="sha384-Y7hw+L/jvKeWIRRkqWYfPcvVxHzVzn5REgzbawhxAuQGwX1XWe70vji+VSeHOThJ" crossorigin="anonymous"></script>
    <title>Video Page</title>
</head>
<body>
    <script defer src="script.js"></script>
    <?php
        include_once 'sidebar.php';
    ?>

    <main class="video-page-container">
        <div class="video-and-comments">
            <video class="youtube-video" src=<?php echo $videoDirectory ?> controls autoplay></video>
                <p id="video-page-title"><?php echo $videoTitle ?></p>
                    <div class="user-and-video-info">
                        <div class="user-subs">
                            <a href="channel.php?channelID=<?php echo $uploaderID ?>">
                                <div class="user-info">
                                    <img src="pfp/<?php echo $videoChannelPFP ?>" alt="user" width="40px">
                                    <div class="acc-info">
                                        <p id="acc-name"><?php echo $videoChannelName ?></p>
                                        <p id="acc-subs"><?php echo subscriberCount($conn, $uploaderID) ?> subscribers</p>
                                    </div>
                                </div>
                            </a>
                            <form id="subscription-form" method="post" hx-post="subscribe.php" hx-swap="outerHTML">
                                <div class="subscription">
                                    <input type="hidden" name="channelID" value="<?php echo $uploaderID; ?>">
                                    <input type="hidden" name="videoID" value="<?php echo $videoID; ?>">
                                    <input type="hidden" name="userID" value="<?php echo $_SESSION['userID'] ?? ''; ?>">
                                    <input type="hidden" name="action" id="subscribe-action" value="<?php echo subscribedOrNot($conn, $uploaderID, $_SESSION['userID']) ? 'decrement' : 'increment'; ?>">
                                    <button type="submit" id="subscribe">
                                        <?php echo subscribedOrNot($conn, $uploaderID, $_SESSION['userID']) ? 'Subscribed' : 'Subscribe'; ?>
                                    </button>
                                </div>
                            </form>


                        </div>
                    <div class="feedback-buttons">
                        <button id="like-button" 
                                <?php 
                                    if(!isset($_SESSION["userID"]) or videoDisliked($conn, $videoID)){
                                        echo 'disabled';
                                    }; 
                                ?>
                            onclick="likeVideo()">
                            <i id="like-icon" 
                                class="
                                    <?php
                                        if(videoLiked($conn, $videoID)){
                                            echo 'fa fa-thumbs-up';
                                        } else {
                                            echo 'fa fa-thumbs-o-up';
                                        }
                                ?>">
                            </i> 
                            <?php echo $videoLikes ?>
                        </button>

                        <button id="dislike-button" 
                            <?php 
                                if(!isset($_SESSION["userID"]) or videoLiked($conn, $videoID)){
                                    
                                    echo 'disabled';
                                };
                            ?>
                            onclick="dislikeVideo()">
                            <i id="dislike-icon" 
                                class="
                                <?php 
                                    if(videoDisliked($conn, $videoID)){
                                        echo 'fa fa-thumbs-down ';
                                    } else {
                                        echo 'fa fa-thumbs-o-down ';
                                    }
                                ?>
                                    fa-flip-horizontal">

                            </i>
                        </button>
                        <button class="omittable-button"><i class="fa fa-share"></i> Share</button>
                        <button class="omittable-button"><i class="fa fa-download"></i> Download</button>
                        <button class="omittable-button"><i class="fa fa-scissors"></i> Clip</button>
                        <button class="omittable-button"><i class="fa fa-ellipsis-h"></i></button>
                    </div>
                </div>
                <div class="description">
                    <div class="description-data">
                        <p id="description-date"><?php echo $videoViews.' views . '.getVideoTime($videoUploadDate) ?></p>
                    </div>
                    <p id="description-text"> <?php echo $videoDescription ?> </p>

                </div>
                <div class="comments-section">
                    <div class="comment-title">
                        <p id="Comments-title">Comments</p>
                        <button id="sort-by"><i class="fa fa-sort"></i> Sort By</button>
                    </div>
                    <div class="comment-area">
                    <div class="user-info">
                        <img src="
                        <?php 
                            if($_SESSION["loginStatus"] == True){
                                echo 'pfp/'.$pfp;
                            } else {
                                echo 'Images/user.png';
                            }
                        ?>
                        " width="40px">
                    </div>
                    <div class="comment-write">
                        <input type="hidden" id="videoID" name="videoID" value="<?php echo $videoID; ?>">
                        <input type="text" name="comment" id="comment-writer" required placeholder="Add a comment...">
                        <div class="comment-submit">
                            <button>😊</button>
                            <div class="comment-cancel">
                                <button>Cancel</button>
                                <button id="submit-button" <?php disableIfNotLoggedIn(); ?>
                                        hx-post="/make_comment.php"
                                        hx-target=".comments-container"
                                        hx-swap="afterbegin"
                                        hx-include="[name=videoID], [name=comment]">
                                    Comment
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
                    
                <br>
                <div class="comments-container">
                    <?php 

                        $commentSql = "select comments.comment, users.username, users.pfp, comments.time 
                        from comments INNER JOIN users 
                        ON comments.userID = users.userID where videoID = ".$_GET["videoID"]." ORDER BY comments.time DESC";
                        $result = $conn->query($commentSql);
                        if($result->num_rows > 0){
                            while($comment = $result->fetch_assoc()){
                                echo'<div class="comments">
                                    <img class="comment-pfp" src="pfp/'.$comment["pfp"].'" width="30px">
                                    <div class="comments-data">
                                        <div class="comment-name-date">
                                            <p class="comment-name">'.$comment["username"].'</p>
                                            <p class="comment-date">'.getVideoTime($comment["time"]).'</p>
                                        </div>
                                        <p class="comment-text">'.$comment["comment"].'</p>
                                        <div class="feedback">
                                            <button class="comment-feedback"><i class="fa fa-thumbs-up"></i></button>
                                            <button class="comment-feedback"><i class="fa fa-thumbs-down fa-flip-horizontal"></i></button>
                                            <button class="comment-feedback"><p>Reply</p></button>
                                        </div>
                                    </div>
                                </div>';
                            }
                        }                    
                    ?>
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
                    $suggestedQuery = "Select video.video_ID, video.video_title, video.video_thumbnail, users.username, video.video_views, video.video_upload_date 
                    from video INNER JOIN users ON video.uploaderID = users.UserID WHERE video_ID != ?;";
                    $suggestedStmt = $conn->prepare($suggestedQuery);
                    $suggestedStmt->bind_param("i",$videoID);
                    $suggestedStmt->execute();
                    $suggestedStmt->bind_result($suggestedID, $suggestedTitle, $suggestedThumbnail, $suggestedUploader, $suggestedViews, $suggestedDate);
                    
                    while($suggestedStmt->fetch()){
                        echo '
                            <a class="video" href="video.php?videoID='.$suggestedID.'">
                                <div class="suggested-video">
                                <img src="'.$suggestedThumbnail.'" alt="thumbnail" width="240" height="135">
                                    <div class="suggested-video-data">
                                        <p class="video-title">'.$suggestedTitle.'</p>
                                        <p class="user">'.$suggestedUploader.'</p>
                                        <p class="video-stats">'.$suggestedViews.' views . '.getVideoTime($suggestedDate).'</p>
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