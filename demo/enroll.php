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
		$id = $_SESSION['id'];
		$cid = $_GET['cid'];
		$date = date("Y-m-d");
		if ($polaczenie->query("INSERT INTO course_members(course_id, member_id, date) VALUES('$cid','$id','$date')")) {
			if ($polaczenie->query("INSERT INTO lesson_member(member_id, course_id, accept) VALUES($id, $cid, 1)")) {
				$wynik = $polaczenie->query("SELECT category_id FROM courses WHERE id='$cid'");
				if (!$wynik) throw new Exception($polaczenie->error);
				$r = $wynik->fetch_assoc();
				$cat_id = $r['category_id'];
				$link = "Location: courses.php?cid=$cat_id";
				header($link);

				$wynik->close();
			}
		}

		$polaczenie->close();
	}
} catch (Exception $e) {
	echo $e;
}
