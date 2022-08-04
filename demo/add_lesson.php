<?php
session_start();
$cid = $_SESSION['cid'];
if ((!isset($_SESSION['id'])) | (!isset($_POST['title']))) {
    header("Location: index.php");
    exit();
} else {
    require_once "connection.php";
    try {
        $polaczenie = new mysqli($host, $db_login, $db_pass, $db_name);
        if ($polaczenie->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            $title = $_POST['title'];
            $desc = $_POST['desc'];
            if ($polaczenie->query("INSERT INTO lessons(course_id, subject, description) VALUES('$cid', '$title', '$desc')")) {

                $link = "Location: lessons.php?cid=$cid";
                header($link);
            }
        }
        $polaczenie->close();
    } catch (Exception $e) {
        echo $e;
    }
}
