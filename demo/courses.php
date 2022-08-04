<?php
session_start();
if ((!isset($_SESSION['id']))) {
    header("Location: index.php");
    exit();
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

        .course {
            max-width: 1024px;
            border: 1px solid #111;
            padding: 0 10px;
            margin: 5px 20px 10px 20px;
        }

        .course .course-author {
            float: right;
            padding-right: 10px;
        }

        .course a.button {
            float: left;
            background-color: grey;
            border-radius: 5px;
            padding: 2px 3px;
            text-decoration: none;
            color: initial;
        }

        .course a.button:hover {
            background-color: greenyellow;
        }

        .course .waiting {
            font-weight: 500;
            text-decoration: underline;
            float: left;
        }

        form #desc {
            resize: both;
            overflow: auto;
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

    <section class="learn-type-form">


        <?php
        require_once "connection.php";
        $id = $_SESSION['id'];
        $category_id = $_GET['cid'];
        try {
            $polaczenie = new mysqli($host, $db_login, $db_pass, $db_name);
            if ($polaczenie->connect_errno != 0) {
                throw new Exception(mysqli_connect_errno());
            } else {
                $wynik = $polaczenie->query("SELECT * FROM courses WHERE category_id='$category_id' and accepted=1");
                if (!$wynik) throw new Exception($polaczenie->error);
                if ($wynik->num_rows == 0) {
                    echo '<h1>Brak kursów w tej kategorii</h1>';
                } else {
                    $wynik0 = $polaczenie->query("SELECT name FROM categories WHERE id='$category_id'");
                    if (!$wynik0) throw new Exception($polaczenie->error);
                    $r0 = $wynik0->fetch_assoc();
                    echo '<h1>' . $r0['name'] . '</h1>';
                }
                while ($r = $wynik->fetch_assoc()) {
                    $id_author = $r['author_id'];
                    $id_course = $r['id'];
                    // pobranie imienia i nazwiska autora kursu
                    $wynik1 = $polaczenie->query("SELECT name, surname FROM persons JOIN users ON persons.id = users.person_id WHERE users.id = '$id_author'");
                    $r1 = $wynik1->fetch_assoc();
                    if ($id_author == $id) {
                        $temp = '<a href="lessons.php?cid=' . $id_course . '" class="button">Zarządzaj kursem</a>';
                    } else {
                        //sprawdzenie czy użytkownik zapisany i wyświetlenie statusu akceptacji
                        $wynik2 = $polaczenie->query("SELECT id, accepted FROM course_members WHERE course_id='$id_course' and member_id='$id'");
                        if (!$wynik2) throw new Exception($polaczenie->error);
                        if ($wynik2->num_rows > 0) {
                            $r2 = $wynik2->fetch_assoc();
                            if ($r2['accepted'] == 0) $temp = '<p class="waiting">Zapis na kurs oczekuje na akceptacje.</p>';
                            else $temp = '<a href="lessons.php?cid=' . $id_course . '" class="button">Przejdź do lekcji w kursie</a>';
                        } else {
                            $temp = '<a href="enroll.php?cid=' . $id_course . '" class="button">Zapisz się na kurs</a>';
                            if ($_SESSION['type_of_learn'] == NULL) {
                                $temp = "<a href='form.php'>Przejdź do formularza i pozwól byśmy rozpoznali twój system nauki.</a>";
                            }
                        }
                        $wynik2->close();
                    }


                    echo '  <div class="course">
                                <h2 class="course-title">' . $r['name'] . '</h2>
                                <p class="course-desc">' . $r['description'] . '</p>
                                ' . $temp . '
                                <p class="course-author">Autor: ' . $r1['name'] . ' ' . $r1['surname'] . '</p>
                            </div>';

                    $wynik1->close();

                }
                $wynik->close();
                if ($_SESSION['account_type'] < 3) {
                    echo '<h2>Dodaj kurs</h2>';
                    echo    '<form class="dodajKurs" action="add_course.php?cid=' . $category_id . '" method="post">
                                <label for="name">Nazwa kursu: </label>
                                <input type="text" name="name" placeholder="Wprowadź nazwę..." pattern="[\p{L}\s+]+" required><br>
                                <label for="opis">Opis: </label>
                                <textarea id="desc" type="text" name="opis" placeholder="Wpisz opis kursu..." pattern="[\p{L}\s+\.+\,+]+" required></textarea><br>
                                <input class="dodaj" type="submit" value="Dodaj">';
                    if (isset($_SESSION['blad']))
                        echo '<div class="blad">' . $_SESSION['blad'] . '</div>';
                    unset($_SESSION['blad']);
                    echo    '</form>';
                }
            }
            $polaczenie->close();
        } catch (Exception $e) {
            echo $e;
        }
        ?>
    </section>

    <footer class="royalFooter"> &copy; MUD3L</footer>
    <script src="scripts/jquery-3.2.1.min.js"></script>
    <script src="scripts/menu.js"></script>

</body>

</html>