<?php
    include 'connection.php';
    $action = $_POST["action"];
    $channelID = $_POST["channelID"];
    $userID = $_POST["userID"];
    $videoID = $_POST["videoID"];

    // echo $channelID;
    // echo '<br>'.$userID;
    if($action == 'increment'){
        $subscribeSql = "INSERT INTO subscriptions (channelID, subscriberID) values (?, ?)";
        echo '<p style="color:green;">Channel Subscribed!</p>';
    }else {
        $subscribeSql = "DELETE FROM subscriptions WHERE channelID = ? AND subscriberID = ?";
        echo '<p style="color:red;">Channel Unsubscribed!</p>';
    }
    
    $subscribeStmt = $conn->prepare($subscribeSql);
    $subscribeStmt->bind_param("ii", $channelID, $userID);
    $subscribeStmt->execute();
    echo '<script>window.location.replace("video.php?videoID='.$videoID.'")</script>';
    // header("location: video.php?videoID=$videoID");
?>