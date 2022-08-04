<?php
session_start();
if (!isset($_POST['quest2'])) {
    header("Location: form.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moodle UwB</title>
    <style>
        .learn-type-form {
            display: flex;
            align-items: center;
            margin: 50px 0;
            width: 100%;
            flex-direction: column;
        }
    </style>
</head>

<body>

    <nav class="menu">

    </nav>

    <header>

    </header>

    <section class="learn-type-form">
        <?php
        $typ = 0;
        $wzrok = 0;
        $sluch = 0;
        $dzial = 0;
        $wynik = false;
        $link = "'form.php'";

        foreach ($_POST as $key => $value) {
            // echo "Field ".$key." is ".$value."<br>";
            if ($value == 'wzrokowiec') $wzrok++;
            if ($value == 'sluchowiec') $sluch++;
            if ($value == 'dzialaniowiec') $dzial++;
        }

        // echo '<br>dzial '.$dzial.'  sluch '.$sluch.'  wzrok '.$wzrok;
        if ($dzial > $_wzrok and $dzial > $sluch) {
            $wynik = "działaniowiec";
            $typ = 3;
        }
        if ($sluch > $wzrok and $sluch > $dzial) {
            $wynik = "słuchowiec";
            $typ = 1;
        }
        if ($wzrok > $sluch and $wzrok > $dzial) {
            $wynik = "wzrokowiec";
            $typ = 2;
        }

        if ($wynik) {
            require_once "connection.php";
            try {
                $polaczenie = new mysqli($host, $db_login, $db_pass, $db_name);
                if ($polaczenie->connect_errno != 0) {
                    throw new Exception(mysqli_connect_errno());
                }
                $id = $_SESSION['id'];
                if ($polaczenie->query("UPDATE users SET type_of_learn=$typ WHERE id='$id'")) {
                    $_SESSION['type_of_learn'] = $typ;
                    echo '<br>Twój typ nauki to ' . $wynik . '.';
                    $link = "'index.php'";
                    echo '<button onclick="window.location.href=' . $link . '">Powrót</button>';
                } else {
                    throw new Exception($polaczenie->error);
                }
                $polaczenie->close();
            } catch (Exception $e) {
                echo $e;
            }
        } else {
            echo 'Twoje odpowiedzi nie wyznaczyły jednoznacznie twojego typu nauki, spróbuj podejść do testu raz jeszcze.';
            echo '<button onclick="window.location.href=' . $link . '">Powrót</button>';
        }
        ?>
    </section>

    <footer> &copy; Moodle UwB</footer>

</body>

</html>