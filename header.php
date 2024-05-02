<?php
    session_start();
    if(isset($_SESSION["username"])){
        $username = $_SESSION["username"];
        $pfp = $_SESSION["pfp"];
        $_SESSION["loginStatus"] = true;
    } else {
        $username = "Guest";
        $pfp = "user.png";
        $_SESSION["loginStatus"] = false;
    }
    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"/>
    <link rel="icon" type="image/x-icon" href="Images/youtube.png">
    <title>Header</title>
</head>
<body>
<header>
        <div class="left-elements">
            <button onclick="hideSidebar()" class="menu"><img src="Images/menu.png" alt="Menu Button" height="20"></button>
            <div class="yt-logo">
                <a href="index.php" class="logo"><img class="youtube-text" src="Images/yt_logo.png" alt="Menu Button" height="25"></a>
                <p id="country">PK</p>
            </div>
        </div>
        <div class="searchbar">
            <input id="searchfield" placeholder="Search" size="30">
            <a href="video.html"><img src="Images/search.png" alt="Search Button" height="20"></a>
        </div>
        <nav>
            
            <?php 
                if($_SESSION["loginStatus"]){
                    echo '<a href="upload_video.html"><img src="Images/upload.png" alt="Menu Button" height="20"></a>';
                }
            ?>
            
            <a class="omittable-button" href="#"><img src="Images/notification.png" alt="Menu Button" height="20"></a>
            <a id="user-info-button" href="#"><img src=<?php echo 'pfp/'.$pfp ?> alt="Menu Button" onclick="onUserInfoClick()" height="20" width="20"></a>
            <div class="dropdown">
                <div class="user-menu-button">
                    <div class="user-pfp">
                        <img id="menu-pfp" src= <?php echo 'pfp/'.$pfp;?> alt="User Image" width="30px">
                    </div>
                    <div class="user-name">
                        <p><?php echo $username ?> <br><?php echo '@'.$username ?></p>
                        <!-- <a href="#">View your channel</a> -->
                    </div>
                </div>
                <!-- <button class="google-account">
                    <p style="font-weight: bolder;">G</p>
                    Google Account
                </button>
                <button class="switch-account">
                    <i class="fa fa-youtube-play"></i>
                    <p>Switch account</p>
                </button> -->
                <?php 
                
                    if($_SESSION["loginStatus"]){
                        echo '<a href="logout.php" class="dropdown-buttons">
                                <i class="fa fa-youtube-play"></i>
                                <p>Log out</p>
                             </a>';
                    }else{
                        echo '<a href="login.html" class="dropdown-buttons">
                                <i class="fa fa-youtube-play"></i>
                                <p>Log in</p>
                             </a>';
                        echo '<a href="signup.html" class="dropdown-buttons">
                                <i class="fa fa-youtube-play"></i>
                                <p>Sign up</p>
                             </a>';
                    }
                ?>
            </div>
        </nav>
    </header>
</body>
</html>
