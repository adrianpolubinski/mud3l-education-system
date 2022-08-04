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

	$typ_uczenia=$_GET['type'];
	$lid=$_GET['lid'];

	$id = $_SESSION['id'];

	$_SESSION['type_of_learn']=$typ_uczenia;
	$polaczenie->query("UPDATE users SET type_of_learn=$typ_uczenia where id=$id");
        $polaczenie->close();


	if($typ_uczenia==1){
	$link = 'Location: lesson.php?lid='.$lid.'&tol=1';
           header($link);
	}
	if($typ_uczenia==2){
	$link = 'Location: lesson.php?lid='.$lid.'&tol=2';
           header($link);
	}
	if($typ_uczenia==3){
	$link = 'Location: lesson.php?lid='.$lid.'&tol=3';
           header($link);
	}
    }
} catch (Exception $e) {

    echo $e;
}

?>