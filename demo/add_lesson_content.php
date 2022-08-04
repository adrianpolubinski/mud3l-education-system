<?php
session_start();
if ((!isset($_SESSION['id'])) || (!isset($_POST['type']))) {
    header("Location: index.php");
    exit();
} else {
    $type = $_POST['type'];
    $context = $_POST['context'];
    $link = $_POST['link'];
    $lid = $_POST['lid'];
$tol=$_SESSION['type_of_learn'];
    require_once "connection.php";
    try {
        $polaczenie = new mysqli($host, $db_login, $db_pass, $db_name);
        if ($polaczenie->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            if ($polaczenie->query("INSERT INTO $type (lesson_id, context, link) VALUES ($lid,'$context','$link')")) {
                header("Location: lesson.php?lid=$lid&tol=$tol");
            }
            if ($type == "sluchowiec") { // dodanie pliku mp3
                $target_dir = "audio/";
                // $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $target_file = $target_dir . $link;
                echo '<br>NAZWA: ' . $target_file . '<br>';
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Check if file already exists
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 10000000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if ($imageFileType != "mp3") {
                    echo "To nie mp3!";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                    // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }
        }
    } catch (Exception $e) {
        echo $e;
    }
}
