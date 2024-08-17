<?php
session_start();
include 'connection.php'; // Include your database connection

$channelID = $_POST['channelID'];
$userID = $_POST['userID'];
$action = $_POST['action'];

if ($action == 'increment') {
    // Add subscription logic
    $sql = "INSERT INTO subscriptions (subscriberID, channelID) VALUES ('$userID', '$channelID')";
    $result = $conn->query($sql);
    $newAction = 'decrement';
    $buttonText = 'Subscribed';
    $buttonColor = '#cfcfcf';
    $textColor = 'black';
} else {
    // Remove subscription logic
    $sql = "DELETE FROM subscriptions WHERE subscriberID = '$userID' AND channelID = '$channelID'";
    $result = $conn->query($sql);
    $newAction = 'increment';
    $buttonText = 'Subscribe';
    $buttonColor = '#cfcfcf';
    $textColor = 'black';
}

// Return the updated button HTML
echo "
    <form id=\"subscription-form\" method=\"post\" hx-post=\"subscribe.php\" hx-swap=\"outerHTML\">
        <div class=\"subscription\">
            <input type=\"hidden\" name=\"channelID\" value=\"$channelID\">
            <input type=\"hidden\" name=\"videoID\" value=\"{$_POST['videoID']}\">
            <input type=\"hidden\" name=\"userID\" value=\"$userID\">
            <input type=\"hidden\" name=\"action\" id=\"subscribe-action\" value=\"$newAction\">
            <button type=\"submit\" id=\"subscribe\">
                $buttonText
            </button>
        </div>
    </form>";
?>

