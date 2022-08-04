<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
require_once "connection.php";
try {
    $polaczenie = new mysqli($host, $db_login, $db_pass, $db_name);
    if ($polaczenie->connect_errno != 0) {
        throw new Exception(mysqli_connect_errno());
    } else {
        $tresc = $_POST['tresc'];
        $odpowiedz1 = $_POST['odpowiedz1'];
        $odpowiedz2 = $_POST['odpowiedz2'];
        $odpowiedz3 = $_POST['odpowiedz3'];
        $odpowiedz4 = $_POST['odpowiedz4'];
        $prawidlowa = $_POST['prawidlowa'];
        $cid= $_POST['cid'];
        $tid= $_POST['tid'];
        if ($polaczenie->query("INSERT INTO Pytania(id_testu,tresc, odpowiedz1, odpowiedz2, odpowiedz3, odpowiedz4, prawidlowa) VALUES($tid, '$tresc', '$odpowiedz1', '$odpowiedz2',
         '$odpowiedz3', '$odpowiedz4' , '$prawidlowa' )")) {
            $link = 'Location: test.php?cid='.$cid.'&tid='.$tid;
            header($link);
        }
        $polaczenie->close();
    }
} catch (Exception $e) {
    echo $e;
}
