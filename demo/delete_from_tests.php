<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_GET['tid'])) {
	header("Location: index.php");
	exit();
}
require_once "connection.php";
try {
	$polaczenie = new mysqli($host, $db_login, $db_pass, $db_name);
	if ($polaczenie->connect_errno != 0) {
		throw new Exception(mysqli_connect_errno());
	} else {
		$tid = $_GET['tid'];
        $cid = $_GET['cid'];
        if($polaczenie->query("DELETE FROM testy WHERE id='$tid';")) {
            $link = "Location: lessons.php?cid=$cid";
			header($link);
        }
        if($polaczenie->query("DELETE FROM Pytania WHERE id_testu='$tid';")) {
            $link = "Location: lessons.php?cid=$cid";
			header($link);
        }

		$polaczenie->close();
	}
} catch(Exception $e) {
	echo $e;
}