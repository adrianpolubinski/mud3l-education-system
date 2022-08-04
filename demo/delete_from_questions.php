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
		$qid = $_GET['qid'];
        if($polaczenie->query("DELETE FROM Pytania WHERE id='$qid';")) {
            $link = "Location: test.php?cid=$cid&tid=$tid";
			header($link);
        }

		$polaczenie->close();
	}
} catch(Exception $e) {
	echo $e;
}