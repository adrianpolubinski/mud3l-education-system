<?php
session_start();
if ((!isset($_SESSION['id']))) {
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
        $lid = $_GET['lid']; // id lekcji
        if (!isset($_GET['tol'])) $tol = $_SESSION['type_of_learn'];
        else $tol = $_GET['tol']; // typ nauki ucznia
        $cid = $_SESSION['cid']; // id kursu
        $back_link = "lessons.php?cid=$cid";

        $wynik = $polaczenie->query("SELECT * FROM lessons WHERE id='$lid'");
        if (!$wynik) throw new Exception($polaczenie->error);
        if ($wynik->num_rows > 0) {
            $r = $wynik->fetch_assoc();
            $cid = $r['course_id'];
            $h1 = $r['subject'];
            $desc = $r['description'];
            $content = "";
            switch ($tol) {
                case 1:
                    $temp = "sluchowiec";
                    $h1 = $h1 . " (Słuchowiec)";
                    $add = "słuchowca:";
                    break;
                case 2:
                    $temp = "wzrokowiec";
                    $h1 = $h1 . " (Wzrokowiec)";
                    $add = "wzrokowca:";
                    break;
                case 3:
                    $temp =  "dzialaniowiec";
                    $h1 = $h1 . " (Działaniowiec)";
                    $add = "działaniowca: ";
                    break;
            }

            $licznik = 0;
            $content = [];
            $context = [];
            $aid = [];

            $wynik1 = $polaczenie->query("SELECT * FROM $temp WHERE lesson_id=$lid");
            if (!$wynik1) throw new Exception($polaczenie->error);
            while ($r1 = $wynik1->fetch_assoc()) {
                //if ($r1 = $wynik1->fetch_assoc()) {
                $context[$licznik] = $r1['context'];
                $aid[$licznik] = $r1['id'];
                $link = $r1['link'];
                ob_start();
                switch ($tol) {
                    case 1:
                        include 'audio_template.php';
                        $content[$licznik] = ob_get_clean();
                        break;
                    case 2:
                        include 'video_template.php';
                        $content[$licznik] = ob_get_clean();
                        break;
                    case 3:
                        include 'action_template.php';
                        $content[$licznik] = ob_get_clean();
                        break;
                }
                $licznik++;
            }
        }
        $wynik1->close();
        $wynik->close();
        // link do testu
        $linktest = "#";
        $wynik = $polaczenie->query("SELECT * FROM testy WHERE id_kursu=$cid AND id_lekcji=$lid");
        if (!$wynik) throw new Exception($polaczenie->error);
        if ($r = $wynik->fetch_assoc()) {
            $tid = $r['id'];
            $linktest = "test.php?tid=$tid&cid=$cid&lid=$lid";
        }
        $wynik->close();

        // jeśli admin lub autor kursu
        $id = $_SESSION['id'];
        $author_id = -1;
        $wynik = $polaczenie->query("SELECT author_id FROM courses WHERE id=$cid");
        if (!$wynik) throw new Exception($polaczenie->error);
        if ($r = $wynik->fetch_assoc()) {
            $author_id = $r['author_id'];
        }
        $wynik->close();
        if ($_SESSION['account_type'] == 1 || $id == $author_id) {
            $tempA = '"lesson.php?lid=' . $lid . '&tol=1"';
            $tempB = '"lesson.php?lid=' . $lid . '&tol=2"';
            $tempC = '"lesson.php?lid=' . $lid . '&tol=3"';
            $navigation_types = "<a href=$tempA>Zmień na słuchowiec</a><a href=$tempB>Zmień na wzrokowiec</a><a href=$tempC>Zmień na działaniowiec</a>";
        }
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
    <style>
        section.lesson {
            max-width: 960px;
            margin: 100px auto 0 auto;
        }

        .description-of-lesson h1 {
            text-align: center;
            font-size: 32px;
        }

        .description-of-lesson p {
            font-size: 16px;
            margin-top: 20px;
            text-align: justify;
        }

        .context-of-lesson {
            margin-top: 50px;
        }

        .context-of-lesson p {
            font-size: 16px;
        }

        .context-of-lesson p:first-child {
            font-weight: 600;
        }

        .to-test {
            margin-top: 30px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            font-size: 16px;
        }
    </style>
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
    <section class="lesson">
        <div class="description-of-lesson">
            <!-- Temat lekcji -->
            <h1><?php echo $h1; ?></h1>
            <!-- Opis -->
            <p><?php echo $desc; ?></p>
        </div>
        <div class="context-of-lesson">
            <p>Zapoznaj się z treścią lekcji by następnie zdać test:</p>
            <p><?php if (!$context) echo "Chwilowo brak treści w lekcji." ?></p>
            <?php for ($i = 0; $i < $licznik; $i++) {  ?>
                <p><?php echo $context[$i]; ?></p>
                <p><?php echo $content[$i]; ?></p>
            <?php } ?>
        </div>
        <div class="to-test">
            <a href="<?php echo $back_link; ?>">Powrót</a>
            <?php if (isset($navigation_types)) echo $navigation_types; ?>
            <a href="<?php echo $linktest; ?>"><?php if ($linktest != "#") echo "Przejdź do testu";
                                                else echo "Brak testu dla tej lekcji!"; ?></a>
        </div>
        <?php

        $wynik1 = $polaczenie->query("SELECT max(id) from sluchowiec;");
        while ($row = $wynik1->fetch_assoc()) {
            $wolny_index = $row['max(id)'];
        }
        $wolny_index++;




        if ($_SESSION['account_type'] == 1 || $id == $author_id) {
            ob_start();
            if ($tol == 1) {

                $filename = $wolny_index . ".mp3";
                include 'addfile.php';
            } else {
                include 'add_lesson_content_form.php';
            }

            $result = ob_get_clean();
            echo $result;
        }
        ?>
    </section>

    <footer class="royalFooter"> &copy; MUD3L</footer>

</body>

</html>