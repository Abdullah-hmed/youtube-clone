<?php
    include("connection.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["video_file"])) {
        $video_title = $_POST["video_title"];
        $video_description = $_POST["video_description"];
        $video_file = $_FILES["video_file"];
        echo '<pre>';
        print_r($video_file); //print all attributes
        
        $newFileName = uniqid('', true).'.mp4';
        $video_directory = "uploaded_videos/".$newFileName;
        
        if($video_file["size"] == 0){ //does file exist
            echo 'File does not exist!';
            $conn->close();
            header('refresh: 3;index.html');
            exit;
        }


        if($video_file["type"] == 'video/mp4'){ //check if video is uploaded.
            echo 'valid file format';
        } else{
            echo 'invalid file format';
            $conn->close();
            header('refresh: 3;index.html');
            exit;
        }

        $sqlQuery = "Insert into video(video_title, video_description, video_directory) values(?, ?, ?)";

        $stmt = $conn->prepare($sqlQuery);
        $stmt->bind_param("sss",$video_title, $video_description, $video_directory);

        if ($stmt->execute()) {
            move_uploaded_file($video_file["tmp_name"], $video_directory);
            echo '<p style="color: green;">Data Added Successfully!</p>';
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo '<p style="color: red;">Error uploading video.</p>';
    }
    $conn->close();
    header('refresh: 3;index.php');
?>