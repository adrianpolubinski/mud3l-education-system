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
        if ($polaczenie->query("INSERT INTO categories(name) VALUES('$name')")) {

            header("Location: course_categories.php");
        } else {
            $_SESSION['blad'] = 'Błąd w nazwie nowej kategorii.';
            header("Location: course_categories.php");
        }
        $polaczenie->close();
    }
} catch (Exception $e) {
    echo $e;
}
