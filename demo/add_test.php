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
        $name = $_POST['nazwa'];
        $desc = $_POST['opis'];
        $cid= $_POST['cid'];
	$lid = $_POST['lid'];

	echo $lid;
	echo $cid;

if ($result = $polaczenie->query("select * from testy where id_lekcji=$lid;")) {
    $row_cnt = $result->num_rows;
	echo $row_cnt;
}


	if($row_cnt == 0){
        if ($polaczenie->query("INSERT INTO testy(nazwa, opis, id_kursu, id_lekcji) VALUES('$name', '$desc', '$cid', 		'$lid')")) {
            $link = "Location: lessons.php?cid=$cid";
            header($link);
        }
}
else{
//miejsce na blad
$link = "Location: lessons.php?cid=$cid";
echo $test;
            //header($link);
}
        $polaczenie->close();
    }
} catch (Exception $e) {
    echo $e;
}
