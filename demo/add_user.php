<?php
session_start();
if ((!isset($_POST['login'])) || $_SESSION['account_type']!=1) {
    header("Location: zarejestruj.php");
    exit();
} else {

    $poprawne_dane = true;
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $login = $_POST['login'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];
    $haslo = $_POST['haslo'];
    $haslor = $_POST['haslor'];
    $typ = $_POST['account_type'];

    // E-mail ================================================================================
    # usunięcie wszystkich nielegalnych znaków z adresu e-mail
    $emailfiltr = filter_var($email, FILTER_SANITIZE_EMAIL);
    # sprwadzenie walidacji adresu e-mail
    if (!filter_var($emailfiltr, FILTER_VALIDATE_EMAIL) || ($email != $emailfiltr)) {
        $poprawne_dane = false;
        $_SESSION['blad'] = "Niepoprawny adres e-mail!";
    }

    // Hasło ================================================================================
    # sprawdzenie czy podane hasła są takie same
    if ($haslo != $haslor) {
        $poprawne_dane = false;
        $_SESSION['blad'] = "Hasła nie są identyczne!";
    }

    // Zapisz dane w sesji ================================================================================
    $_SESSION['imie'] = $imie;
    $_SESSION['nazwisko'] = $nazwisko;
    $_SESSION['login'] = $login;
    $_SESSION['email'] = $email;
    $_SESSION['telefon'] = $telefon;
    $_SESSION['haslo'] = $haslo;
    $_SESSION['haslor'] = $haslor;

    // Jeśli dane poprawne łącz z bazą 
    if ($poprawne_dane) {
        require_once("connection.php");
        $do_bazy = true;
        $haslohash = password_hash($haslo, PASSWORD_DEFAULT);
        try {
            $polaczenie = new mysqli($host, $db_login, $db_pass, $db_name);
            if ($polaczenie->connect_errno != 0) {
                throw new Exception(mysqli_connect_errno());
            } else {
                # czy login i mail istnieje
                $wynik = $polaczenie->query("SELECT id FROM users WHERE login='$login' OR email='$email'");
                if (!$wynik) throw new Exception($polaczenie->error);
                if (($wynik->num_rows) > 0) {
                    $do_bazy = false;
                    $_SESSION['blad'] = "Login lub adres e-mail jest już zajęty!";
                    header("Location: rejestracja.php");
                    exit();
                }
                # czy bezbłędnie przeszło ?
                if ($poprawne_dane && $do_bazy) {
                    if ($polaczenie->query("INSERT INTO persons (`name`, `surname`, `phone_number`) VALUES('$imie', '$nazwisko', '$telefon')")) {
                        $wynik1 = $polaczenie->query("SELECT * FROM persons ORDER BY id DESC LIMIT 1");
                        if (!$wynik1) throw new Exception($polaczenie->error);
                        $r = $wynik1->fetch_assoc();
                        $person_id = (int)$r['id'];
                        $data = date("Y-m-d");
                        if ($polaczenie->query("INSERT INTO users (`login`, `password`, `email`, `person_id`, `account_type`, `create_date`) VALUES ('$login','$haslohash','$email',$person_id,$typ,'$data')")) {
                            unset($_SESSION['imie']);
                            unset($_SESSION['nazwisko']);
                            unset($_SESSION['login']);
                            unset($_SESSION['email']);
                            unset($_SESSION['telefon']);
                            unset($_SESSION['haslo']);
                            unset($_SESSION['haslor']);
                            $_SESSION['blad'] = "Dodano nowego użytkownika!";
                            header("Location: index.php");
                        } else {
                            throw new Exception($polaczenie->error);
                        }
                    } else {
                        throw new Exception($polaczenie->error);
                    }
                }
                $wynik1->close();
                $wynik->close();
                $polaczenie->close();
            }
        } catch (Exception $e) {
            $_SESSION['blad'] = "Błąd serwera: " . $e;
            header("Location: index.php");
            exit();
        }
    } else {
        header("Location: index.php");
        exit();
    }
}
