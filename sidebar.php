<?php 
    function disableIfNotLoggedIn(){
        if(!isset($_SESSION["userID"])){ 
            echo 'disabled';
        };
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Sidebar</title>
</head>
<body>
    <sidebar>
            <div class="sidebar">
                <div class="sidebar-max">
                    <button><i class="fa fa-home"></i> Home</button>
                    <button><i class="fa fa-youtube-play" aria-hidden="true"></i> Shorts</button>
                    <button><i class="fa fa-clipboard" aria-hidden="true"></i> Subscriptions</button>
                    <button <?php disableIfNotLoggedIn() ?> ><b>You</b> <i class="fa fa-angle-right" aria-hidden="true"></i></button>
                    <button <?php disableIfNotLoggedIn() ?> ><i class="fa fa-user-o" aria-hidden="true"></i> Your Channel</button>
                    <button <?php disableIfNotLoggedIn() ?> ><i class="fa fa-history" aria-hidden="true"></i> History</button>
                    <button <?php disableIfNotLoggedIn() ?> ><i class="fa fa-play" aria-hidden="true"></i> Your Videos</button>
                    <button <?php disableIfNotLoggedIn() ?> ><i class="fa fa-clock-o" aria-hidden="true"></i> Watch Later</button>
                    <button <?php disableIfNotLoggedIn() ?> onclick="showMore()"><i class="fa fa-angle-down" aria-hidden="true"></i> Show More</button>
                </div>
                <div class="sidebar-min hide">
                    <button style="margin-top: 10px;"><i class="fa fa-home" aria-hidden="true"></i><p>Home</p></button>
                    <button><i class="fa fa-youtube-play" aria-hidden="true"></i><p>You</p></button>
                </div>
                


                <div id="show-more">
                    <a href="liked_videos.php"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Liked Videos</a>
                </div>
            </div>
    </sidebar>
</body>
</html>
