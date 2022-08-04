<?php
session_start();
if ((!isset($_SESSION['id'])) || !isset($_GET['lid'])) {
    header("Location: index.php");
    exit();
}

require_once "connection.php";
try {
    $polaczenie = new mysqli($host, $db_login, $db_pass, $db_name);
    if ($polaczenie->connect_errno != 0) {
        throw new Exception(mysqli_connect_errno());
    } else {
        $lid = $_GET['lid']; // id lekcji
        $tol = $_GET['tol']; // typ nauki ucznia

        $wynik = $polaczenie->query("SELECT * FROM lessons WHERE id='$lid'");
        if (!$wynik) throw new Exception($polaczenie->error);
        if($wynik->num_rows > 0) {
            $r = $wynik->fetch_assoc();
            $h1 = $r['subject'];
            $desc = $r['description'];
            switch ($tol) {
                case 1:
                    $temp = "sluchowiec";
                    break;
                case 2:
                    $temp = "wzrokowiec";
                    break;
                case 3:
                    $temp =  "dzialaniowiec";
                    break;
            }
            $wynik1 = $polaczenie->query("SELECT * FROM $temp WHERE lesson_id=$lid");
            if (!$wynik1) throw new Exception($polaczenie->error);
            if($wynik1->num_rows > 0) {
                $r1 = $wynik1->fetch_assoc();
                $context = $r1['context'];
                $link = $r1['link'];
            }
        }
        $wynik->close();
        $polaczenie->close();
    }

} catch (Exception $e) {
    echo $e;
}


$login = $_SESSION['login'];
?>

<!DOCTYPE html>

<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mud3l</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <nav class="menu">
        <a href="index.php"><img src="img/logo.png"></a>
        <button><i class="fas fa-bars"></i></button>
        <ul>
            <li><a href="../index.html">(Wyjście z DEMO)</a></li>
            <li><a href="index.php"><i class="fas fa-home"></i><span> Strona Główna</span></a></li>
            <li class="active"><a href="course_categories.php">Kategorie Kursów</a></li>
            <li><a href="profile.php"><?php echo $login; ?> (pokaż profil)</a></li>
            <li><a href="logout.php">Wyloguj</a></li>
        </ul>
    </nav>

    <header>

    </header>

    <section class="learn-type-form">
        <?php echo $h1.'<br>'.$context;
            echo '<a href="https://'.$link.'">link to jest</a>';
        ?>
    </section>

    <footer class="royalFooter"> &copy; MUD3L</footer>

</body>

</html>