<?php
session_start();
if ((!isset($_SESSION['id']))) {
    header("Location: index.php");
    exit();
} else {
    $lesson_list = [];
    $tests_list = [];
    $members_list = [];
    require_once "connection.php";
    try {
        $polaczenie = new mysqli($host, $db_login, $db_pass, $db_name);
        if ($polaczenie->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            $id = $_SESSION['id'];
            $course_id = $_GET['cid'];
            $_SESSION['cid'] = $course_id;
            $author_id = 0;

            $wynik = $polaczenie->query("SELECT * FROM lessons WHERE course_id='$course_id'");
            if (!$wynik) throw new Exception($polaczenie->error);
            if ($wynik->num_rows > 0) {
                $wynik1 = $polaczenie->query("SELECT name, author_id FROM courses WHERE id = $course_id");
                if (!$wynik1) throw new Exception($polaczenie->error);
                $r1 = $wynik1->fetch_assoc();
                $author_id = $r1['author_id'];

                $lesson_iter = 0;
                //echo 'COURSE: '.$course_id.' ID: '.$id;
                // sprawdzenie czy członek kursu ma już dostęp do tej lekcji
                $wynik0 = $polaczenie->query("SELECT accept FROM lesson_member WHERE course_id='$course_id' AND member_id='$id'");
                if (!$wynik0) throw new Exception($polaczenie->error);
                $r0 = $wynik0->fetch_assoc();
                $ilosc_lekcji = $r0['accept'];
                $wynik0->close();
               // ---------------------------------------------------------
                while ($r = $wynik->fetch_assoc()) {
                    $lesson_iter += 1;
                    $lid = $r['id']; // lesson id
                    $tol = $_SESSION['type_of_learn']; // typ nauczania
                    if ($author_id == $id) $temp = '<a href="lesson.php?lid=' . $lid . '&tol=' . $tol . '" class="button">Zarządzaj lekcją</a>';
                    elseif ($lesson_iter > $ilosc_lekcji) $temp = 'Przejdź test w lekcji '.$ilosc_lekcji.' by zobaczyć lekcje.';
                    else $temp = '<a href="lesson.php?lid=' . $lid . '&tol=' . $tol . '" class="button">Przejdź do lekcji</a>';
                    

                    $lesson = '  <div class="lesson">
                                <h2 class="lesson-title">' . $r['subject'] . '</h2>
                                <p class="lesson-desc">' . $r['description'] . '</p>
                                ' . $temp . '
                                <p class="lesson-course">' . $r1['name'] . '</p>
                            </div>';
                    array_push($lesson_list, $lesson);

                }
                $wynik1->close();
            } else {
                $brak = '<h1>Brak lekcji w tym kursie</h1>';
            }
            $wynik->close();


            //wyswietlenie testow
            if ($_SESSION['account_type'] == 1 || $id == $author_id) {
                $wynik = $polaczenie->query("SELECT * FROM testy WHERE id_kursu='$course_id'");
                if ($wynik->num_rows > 0) {
                    $temp =    '<h2 class="accept">Testy dostępne w kursie</h2>
                        <table class="users-to-accept">
                            <tr>
                                <th>Lp.</th>
                                <th>Nazwa</th>
                                <th>Opis</th>
                                <th>Akcja</th>
                            </tr>';
                    array_push($tests_list, $temp);
                    $iter = 0;
                    while ($r = $wynik->fetch_assoc()) {
                        $iter += 1;
                        if ($_SESSION['account_type'] < 3 || $id == $author_id) {

                            $temp =    '<tr>
                                <td>' . $iter . '</td>
                                <td>' . $r['nazwa'] . '</td>
                                <td>' . $r['opis'] . '</td>
                                <td><a href="test.php?tid=' .  $r['id'] . '&cid=' . $course_id . '" class="button">Zarządzaj testem</a> / 
                                <a href="delete_from_tests.php?tid=' . $r['id'] . '&cid=' . $course_id . '" class="button">Usuń</a></td>
                                
                            </tr>';
                        } else {
                            $temp =    '<tr>
                                    <td>' . $iter . '</td>
                                    <td>' . $r['nazwa'] . '</td>
					<td>' . $r['opis'] . '</td>
                                    <td><a href="test.php?tid=' .  $r['id'] . '&cid=' . $course_id . '" class="button">Rozwiąż test</a></td>
                                </tr>';
                        }
                        array_push($tests_list, $temp);
                    }
                }
                $temp = '</table>';
                array_push($tests_list, $temp);
                $wynik->close();
            }



            //użytkownicy w kursie
            if ($_SESSION['account_type'] == 1 || $id == $author_id) {
                $wynik = $polaczenie->query("SELECT member_id, date FROM course_members WHERE course_id='$course_id' AND accepted=1");
                if (!$wynik) throw new Exception($polaczenie->error);
                if ($wynik->num_rows > 0) {
                    $temp =    '<h2 class="accept">Użytkownicy w kursie</h2>
                            <table class="users-to-accept">
                                <tr>
                                    <th>Lp.</th>
                                    <th>Imię i nazwisko</th>
                                    <th>Data dołączenia</th>
                                    <th>Akcja</th>
                                </tr>';
                    array_push($members_list, $temp);
                    $iter = 0;
                    while ($r = $wynik->fetch_assoc()) {
                        $mem_id = $r['member_id'];
                        $wynik1 = $polaczenie->query("SELECT name, surname FROM persons JOIN users ON users.person_id=persons.id WHERE users.id='$mem_id'");
                        if (!$wynik1) throw new Exception($polaczenie->error);
                        $r1 = $wynik1->fetch_assoc();
                        $iter += 1;
                        $temp =    '<tr>
                                    <td>' . $iter . '</td>
                                    <td>' . $r1['name'] . ' ' . $r1['surname'] . '</td>
                                    <td>' . $r['date'] . '</td>
                                    <td><a href="delete_from_course.php?uid=' . $mem_id . '&cid=' . $course_id . '" class="button">Usuń</a></td>
                                </tr>';
                        array_push($members_list, $temp);
                    }
                }
                $temp = '</table>';
                array_push($members_list, $temp);
                $wynik->close();
            }
            //użytkownicy w kursie koniec 
        }
        $polaczenie->close();
    } catch (Exception $e) {
        echo $e;
    }
}
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
        .learn-type-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 50px 0;
        }

        .lesson {
            max-width: 1024px;
            border: 1px solid #111;
            padding: 0 10px;
            margin: 5px 20px 10px 20px;
        }

        .lesson .lesson-course {
            float: right;
            padding-right: 10px;
        }

        .lesson a.button {
            float: left;
            background-color: grey;
            border-radius: 5px;
            padding: 2px 3px;
            text-decoration: none;
            color: initial;
        }

        .lesson a.button:hover {
            background-color: greenyellow;
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
            <li><a href="profile.php"><?php echo $_SESSION['login']; ?> (pokaż profil)</a></li>
            <li><a href="logout.php">Wyloguj</a></li>
        </ul>
    </nav>

    <header>

    </header>

    <section class="learn-type-form">
        <?php
        foreach ($lesson_list as $lesson) {
            echo $lesson;
        }

        foreach ($tests_list as $tests) {
            echo $tests;
        }


        if (isset($brak)) echo $brak;
        foreach ($members_list as $member) {
            echo $member;
        }

        if ($_SESSION['account_type'] == 1 || $id == $author_id) {
            ob_start();
            include 'add_lesson_form.php';
            $result = ob_get_clean();
            echo $result;
        }


        if ($_SESSION['account_type'] == 1 || $id == $author_id) {
            ob_start();
            include 'add_test_form.php';
            $result = ob_get_clean();
            echo $result;
        }
        ?>


    </section>

    <footer class="royalFooter"> &copy; MUD3L</footer>
    <script src="scripts/jquery-3.2.1.min.js"></script>
    <script src="scripts/menu.js"></script>

</body>

</html>