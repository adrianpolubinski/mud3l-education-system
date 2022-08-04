<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_POST['name'])) {
    header("Location: index.php");
    exit();
}
require_once "connection.php";
try {
    $polaczenie = new mysqli($host, $db_login, $db_pass, $db_name);
    if ($polaczenie->connect_errno != 0) {
        throw new Exception(mysqli_connect_errno());
    } else {
        $name = $_POST['name'];
        $desc = $_POST['opis'];
        $cat_id = $_GET['cid'];
        $auth_id = $_SESSION['id'];
        $link = 'Location: courses.php?cid='.$cat_id;

        if ($polaczenie->query("INSERT INTO courses(name, author_id, category_id, description, accepted) VALUES('$name', '$auth_id', '$cat_id', '$desc', 0)")) {

            header($link);
        } else {
            $_SESSION['blad'] = 'Błąd w nazwie kursu.';
            header($link);
        }
        $polaczenie->close();
    }
} catch (Exception $e) {
    echo $e;
}
