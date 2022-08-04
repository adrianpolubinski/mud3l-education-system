<?php

session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
require_once "connection.php";
try {
	$aid= $_GET['aid'];
$lid= $_GET['lid'];
$tol= $_GET['tol'];
    $polaczenie = new mysqli($host, $db_login, $db_pass, $db_name);
    if ($polaczenie->connect_errno != 0) {
        throw new Exception(mysqli_connect_errno());
    } else {

echo $aid;



        if ($polaczenie->query("delete from wzrokowiec where id=$aid")) {
            $link = 'Location: lesson.php?lid='.$lid.'&tol='.$tol;
            header($link);
        }


    }
} catch (Exception $e) {
    echo $e;
}

?>