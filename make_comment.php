<?php 
    date_default_timezone_set("Asia/Karachi");
    session_start();
    include 'connection.php';
    $videoID = $_POST["videoID"];
    $date = date('Y-m-d H:i:s');
    
    function getVideoTime($videoUploadDate){
        $currentTime = new DateTime('now', new DateTimeZone($_SESSION["user_timezone"]));
        $uploadedDateVideo = new DateTime($videoUploadDate, new DateTimeZone($_SESSION["user_timezone"]));
        $UploadDiff = $uploadedDateVideo->diff($currentTime);
    
        if ($UploadDiff->y > 0) {
            $UploadDate = $UploadDiff->y . ' years ago';
        } elseif ($UploadDiff->m > 0) {
            $UploadDate = $UploadDiff->m . ' months ago';
        } elseif ($UploadDiff->d > 0) {
            $UploadDate = $UploadDiff->d . ' days ago';
        } elseif ($UploadDiff->h > 0) {
            $UploadDate = $UploadDiff->h . ' hours ago';
        } elseif ($UploadDiff->i > 0) {
            $UploadDate = $UploadDiff->i . ' minutes ago';
        } else {
            $UploadDate = $UploadDiff->s . ' seconds ago';
        }
        return $UploadDate;
    }
    

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["comment"])){
            
            $comment = $_POST["comment"];
            $userID = $_SESSION["userID"];
            if($comment != ""){
                $commentSql = "insert into comments (videoID, userID, comment) values (?, ?, ?)";
                $commentStmt = $conn->prepare($commentSql);
                $commentStmt->bind_param("iis",$videoID, $_SESSION["userID"], $comment);
                if($commentStmt->execute()){
                    $commentHTML = 
                    '<div class="comments">
                        <img style="border-radius:50%" src="pfp/'.$_SESSION["pfp"].'" width="30px">
                        <div class="comments-data">
                            <div class="comment-name-date">
                                <p class="comment-name">'.$_SESSION["username"].'</p>
                                <p class="comment-date">'.getVideoTime($date).'</p>
                            </div>
                            <p class="comment-text">'.$comment.'</p>
                            <div class="feedback">
                                <button class="comment-feedback"><i class="fa fa-thumbs-up"></i></button>
                                <button class="comment-feedback"><i class="fa fa-thumbs-down fa-flip-horizontal"></i></button>
                                <button class="comment-feedback"><p>Reply</p></button>
                            </div>
                        </div>
                    </div>';

                    echo $commentHTML
                    ;
                }else{
                    echo 'Query didnt work';
                }
            }else{
                echo 'Empty Comment!';
            }
            
            echo "<script>window. close();</script>";
        }
    }
?>