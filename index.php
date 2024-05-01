<?php 
    // session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="Images/youtube.png">
    <title>YouTube</title>
</head>

<body>
    <script src="script.js"></script>
    <?php 
        include_once 'header.php';
    ?>
    <sidebar>
        <div class="sidebar">
            <button class="sidebar-max"><i class="fa fa-home"></i> Home</button>
            <button class="sidebar-max"><i class="fa fa-youtube-play" aria-hidden="true"></i> Shorts</button>
            <button class="sidebar-max"><i class="fa fa-clipboard" aria-hidden="true"></i> Subscriptions</button>
            <button class="sidebar-max"><b>You</b> <i class="fa fa-angle-right" aria-hidden="true"></i></button>
            <button class="sidebar-max"><i class="fa fa-user-o" aria-hidden="true"></i> Your Channel</button>
            <button class="sidebar-max"><i class="fa fa-history" aria-hidden="true"></i> History</button>
            <button class="sidebar-max"><i class="fa fa-play" aria-hidden="true"></i> Your Videos</button>
            <button class="sidebar-max"><i class="fa fa-clock-o" aria-hidden="true"></i> Watch Later</button>
            <button class="sidebar-max" onclick="showMore()"><i class="fa fa-angle-down" aria-hidden="true"></i> Show More</button>
            <button class="sidebar-min" style="margin-top: 10px;"><i class="fa fa-home" aria-hidden="true"></i><p>Home</p></button>
            <button class="sidebar-min"><i class="fa fa-youtube-play" aria-hidden="true"></i><p>You</p></button>


            <div id="show-more">
                <button><i class="fa fa-thumbs-up" aria-hidden="true"></i> Liked Videos</button>
            </div>
            <?php
                // echo '<pre>'; 
                // print_r($_SESSION);
            ?>
        </div>
    </sidebar>

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

        <a href="video.php">
            <div class="video-grid">
                <div class="video">
                    <img class="thumbnail" src="thumbnails/wallpaper.webp" width="240" height="135"><br>
                    <div class="video-info">
                        <img class="user" src="Images/user.png" width="30">
                        <div class="video-text">
                            <p class="video-title">Scenic Mountains</p>
                            <p class="video-uploader">Abdullah</p>
                            <p class="video-stats">100K views . 5 hours ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a href="video.php">
            <div class="video-grid">
                <div class="video">
                    <img class="thumbnail" src="thumbnails/Sonic_Adventure.png" width="240" height="135"><br>
                    <div class="video-info">
                        <img class="user" src="Images/user.png" width="30">
                        <div class="video-text">
                            <p class="video-title">Sonic Adventures</p>
                            <p class="video-uploader">Abdullah</p>
                            <p class="video-stats">100K views . 5 hours ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a href="video.php">
            <div class="video-grid">
                <div class="video">
                    <img class="thumbnail" src="thumbnails/c++.jpg" width="240" height="135"><br>
                    <div class="video-info">
                        <img class="user" src="Images/user.png" width="30">
                        <div class="video-text">
                            <p class="video-title">C++ Tutorial</p>
                            <p class="video-uploader">Abdullah</p>
                            <p class="video-stats">100K views . 5 hours ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a href="video.php">
            <div class="video-grid">
                <div class="video">
                    <img class="thumbnail" src="thumbnails/java.png" width="240" height="135"><br>
                    <div class="video-info">
                        <img class="user" src="Images/user.png" width="30">
                        <div class="video-text">
                            <p class="video-title">Java Tutorial</p>
                            <p class="video-uploader">Abdullah</p>
                            <p class="video-stats">100K views . 5 hours ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a href="video.php">
            <div class="video-grid">
                <div class="video">
                    <img class="thumbnail" src="thumbnails/react.png" width="240" height="135"><br>
                    <div class="video-info">
                        <img class="user" src="Images/user.png" width="30">
                        <div class="video-text">
                            <p class="video-title">Frontend Dev</p>
                            <p class="video-uploader">Abdullah</p>
                            <p class="video-stats">100K views . 5 hours ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a href="video.php">
            <div class="video-grid">
                <div class="video">
                    <img class="thumbnail" src="thumbnails/csgo.png" width="240" height="135"><br>
                    <div class="video-info">
                        <img class="user" src="Images/user.png" width="30">
                        <div class="video-text">
                            <p class="video-title">Top 5 Best Games!</p>
                            <p class="video-uploader">Abdullah</p>
                            <p class="video-stats">100K views . 5 hours ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a href="video.php">
            <div class="video-grid">
                <div class="video">
                    <img class="thumbnail" src="thumbnails/minecraft.png" width="240" height="135"><br>
                    <div class="video-info">
                        <img class="user" src="Images/user.png" width="30">
                        <div class="video-text">
                            <p class="video-title">Minecraft Lets Play!</p>
                            <p class="video-uploader">Abdullah</p>
                            <p class="video-stats">100K views . 5 hours ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </main>
</body>

</html>