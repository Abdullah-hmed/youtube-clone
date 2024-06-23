<?php 
    include 'connection.php';
    include 'header.php';
    include 'sidebar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="Images/favicon.ico" type="image/x-icon">
    <title>Subscriptions</title>
</head>
<body>
    
    <script defer src="script.js"></script>
    <?php 
    $subsSql = "SELECT users.userID ,users.username, users.pfp 
        FROM users INNER JOIN subscriptions ON users.userID = subscriptions.channelID where subscriptions.subscriberID = ?;";
    $subsStmt = $conn->prepare($subsSql);
    $subsStmt->bind_param("i", $_SESSION['userID']);
    $subsStmt->execute();
    $subsStmt->bind_result($subscribedChannelID, $subscribedChannelName, $subscribedChannelPFP);
    ?>
    <div class="subs-main" id="frontpage">
        <h1>Subscriptions</h1>
        <?php
            while($subsStmt->fetch()){
               echo"<a href='channel.php?channelID=$subscribedChannelID'> 
                        <div class='subscribed-card'>
                            <img class='sub-img' src='pfp/$subscribedChannelPFP' alt='Channel Profile Picture'>
                            <div class='subs-data'>
                                <h3>$subscribedChannelName</h3>
                            </div>
                        </div>
                    </a>";
            }
        ?>
    </div>

</body>
</html>