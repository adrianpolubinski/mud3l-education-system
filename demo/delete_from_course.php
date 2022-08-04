<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_GET['uid'])) {
	header("Location: index.php");
	exit();
}
require_once "connection.php";
try {
	$polaczenie = new mysqli($host, $db_login, $db_pass, $db_name);
	if ($polaczenie->connect_errno != 0) {
		throw new Exception(mysqli_connect_errno());
	} else {
		$cid = $_GET['cid'];
        $uid = $_GET['uid'];
        if($polaczenie->query("DELETE FROM course_members WHERE course_id='$cid' AND member_id='$uid';")) {
            $link = "Location: lessons.php?cid=$cid";
			header($link);
        }

		$polaczenie->close();
	}
} catch(Exception $e) {
	echo $e;
}