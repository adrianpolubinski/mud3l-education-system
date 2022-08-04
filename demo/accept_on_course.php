<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_GET['cid'])) {
	header("Location: index.php");
	exit();
}
require_once "connection.php";
try {
	$polaczenie = new mysqli($host, $db_login, $db_pass, $db_name);
	if ($polaczenie->connect_errno != 0) {
		throw new Exception(mysqli_connect_errno());
	} else {
		$uid = $_GET['uid'];
		$cid = $_GET['cid'];
		if($polaczenie->query("UPDATE course_members SET accepted=1 WHERE course_id='$cid' AND member_id='$uid'")) {
			header("Location: profile.php");
		}
		$polaczenie->close();
	}
} catch(Exception $e) {
	echo $e;
}