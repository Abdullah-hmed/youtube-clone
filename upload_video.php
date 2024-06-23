<?php
    session_start();

    include("connection.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["video_file"])) {
        $video_title = $_POST["video_title"];
        $video_description = $_POST["video_description"];
        $video_file = $_FILES["video_file"];
        $video_tmp_directory = $_FILES["video_file"]["tmp_name"];
        echo '<pre>';
        print_r($video_file); //print all attributes
        
        $videoName = uniqid('', true);

        $newFileName = $videoName.'.mp4';
        $video_directory = "uploaded_videos/".$newFileName;

        $thumbnailName = $videoName.'.jpg';
        $thumbnail_directory = "thumbnails/".$thumbnailName;
        echo $thumbnail_directory.'<br>';
        
        if($video_file["size"] == 0){ //does file exist
            echo 'File does not exist!';
            $conn->close();
            header('refresh: 3;index.php');
            exit;
        }


        if($video_file["type"] == 'video/mp4'){ //check if video is uploaded.
            echo 'valid file format';
        } else{
            echo 'invalid file format';
            $conn->close();
            header('refresh: 3;index.php');
            exit;
        }

        $error_messages = array(
            UPLOAD_ERR_OK         => 'There is no error, the file uploaded with success',
            UPLOAD_ERR_INI_SIZE   => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            UPLOAD_ERR_FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            UPLOAD_ERR_PARTIAL    => 'The uploaded file was only partially uploaded',
            UPLOAD_ERR_NO_FILE    => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload',
        );

        if($video_file["error"] > 0){
            echo '<br>'.$error_messages[$video_file["error"]].'<br>';
        }

        // Command to generate thumbnail using FFmpeg
        $ffmpegCMD = "C:/ffmpeg/bin/ffmpeg -i $video_tmp_directory -ss 00:00:02 -vf scale=1280:720 -vframes 1 $thumbnail_directory";
        // Exsecute FFmpeg command
        exec($ffmpegCMD, $output, $returnCode);
        if ($returnCode === 0) {
            echo "<br>Thumbnail generated successfully.";
            $sqlQuery = "Insert into video(video_title, video_description, video_directory, video_thumbnail, uploaderID) values(?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bind_param("ssssi",$video_title, $video_description, $video_directory, $thumbnail_directory, $_SESSION["userID"]);
        } else {
            echo "<br>Error generating thumbnail.";
            $sqlQuery = "Insert into video(video_title, video_description, video_directory, uploaderID) values(?, ?, ?, ?)";
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bind_param("sssi",$video_title, $video_description, $video_directory, $_SESSION["userID"]);
        }

        

        



        
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