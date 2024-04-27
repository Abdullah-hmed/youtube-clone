<?php
    include("connection.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["video_file"])) {
        $video_title = $_POST["video_title"];
        $video_description = $_POST["video_description"];
        $video_file = $_FILES["video_file"];
        echo '<pre>';
        print_r($video_file); //print all attributes
        $file = file_get_contents($video_file['tmp_name']);
        if($video_file["size"] == 0){ //does file exist
            echo 'File does not exist!';
        }

        if($video_file["size"] > 1853177){
            echo '<p style="color: red;">File is too large!</p>';
        }

        if($video_file["type"] == 'video/mp4'){ //check if video is uploaded.
            echo 'valid file format';
        } else{
            echo 'invalid file format';
        }

        $sqlQuery = "Insert into video(video_title, video_description, video_file) values(?, ?, ?)";

        $stmt = $conn->prepare($sqlQuery);
        $stmt->bind_param("sss",$video_title, $video_description, $file);

        if ($stmt->execute()) {
            echo '<p style="color: green;">Data Added Successfully!</p>';
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo '<p style="color: red;">Error uploading video.</p>';
    }
    $conn->close();
    header('refresh: 3;index.html');
?>