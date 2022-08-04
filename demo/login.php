<?php
session_start();
if ((!isset($_POST['login'])) || (!isset($_POST['haslo']))) {
	header("Location: logowanie.php");
	exit();
}
require_once "connection.php";
try {
	$polaczenie = new mysqli($host, $db_login, $db_pass, $db_name);
	if ($polaczenie->connect_errno != 0) {
		throw new Exception(mysqli_connect_errno());
	} else {
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		if ($wynik = $polaczenie->query(sprintf(
			"SELECT * FROM users WHERE login='%s' ",
			mysqli_real_escape_string($polaczenie, $login)
		))) {
			if ($wynik->num_rows > 0) {
				$dane = $wynik->fetch_assoc();
				if (password_verify($haslo, $dane['password'])) {
					$_SESSION['zalogowany'] = true; 
					$_SESSION['id'] = $dane['id']; 
					$_SESSION['login'] = $dane['login'];
					$_SESSION['email'] = $dane['email'];
					$_SESSION['person_id'] = $dane['person_id'];
					$id_person = $dane['person_id'];
					$_SESSION['account_type'] = $dane['account_type']; 
                    $_SESSION['type_of_learn'] = $dane['type_of_learn'];
					$_SESSION['create_date'] = $dane['create_date'];
					$wynik1 = $polaczenie->query("SELECT * FROM persons WHERE id='$id_person'");
					if (!$wynik1) throw new Exception($polaczenie->error);
					if ($r = $wynik1->fetch_assoc()) {
						
						$_SESSION['name']=$r['name'];
						$_SESSION['surname']=$r['surname'];
						$_SESSION['phone_number'] = $r['phone_number'];
			
					}            
					$wynik1->close();

					unset($_SESSION['blad']);
					$wynik->close();
					header("Location: index.php");
				} else {
					$_SESSION['blad'] = 'Nieprawidłowy login lub hasło!';
					header("Location: logowanie.php");
				}
			} else {
				$_SESSION['blad'] = 'Nieprawidłowy login lub hasło!';
				header("Location: logowanie.php");
			}
		}
		$polaczenie->close();
	}
} catch(Exception $e) {
	echo $e;
}