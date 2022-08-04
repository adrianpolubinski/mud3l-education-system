<?php
session_start();
// sprawdzenie czy zalogowany jak nie to na zalogowany.php 
if (!isset($_SESSION['zalogowany'])) {
    header("Location: logowanie.php");
    exit();
} else {
    $login = $_SESSION['login'];
    $email = $_SESSION['email'];
    $id_person = $_SESSION['person_id'];
    $create_date = $_SESSION['create_date'];
    $name = $_SESSION['name'];
    $surname = $_SESSION['surname'];
    $phone_number = $_SESSION['phone_number'];
    $account_type = $_SESSION['account_type'];
    $type_of_learn = $_SESSION['type_of_learn'];
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
</head>

<body>
    <nav class="menu">
        <a href="index.php"><img src="img/logo.png"></a>
        <button><i class="fas fa-bars"></i></button>
        <ul>
            <li><a href="../index.html">(Wyjście z DEMO)</a></li>
            <li><a href="index.php"><i class="fas fa-home"></i><span> Strona Główna</span></a></li>
            <li><a href="course_categories.php">Kategorie Kursów</a></li>
            <li class="active"><a href="profile.php"><?php echo $login; ?> (pokaż profil)</a></li>
            <li><a href="logout.php">Wyloguj</a></li>
        </ul>
    </nav>


    <aside class="userInfo">
        <ul>
            <li><span>Imie:</span> <?php echo $name; ?></li>
            <li><span>Nazwisko:</span> <?php echo $surname; ?></li>
            <li><span>Email:</span> <?php echo $email; ?></li>
            <li><span>Numer Telefonu:</span> <?php echo $phone_number; ?></li>
            <li><span>Data dołączenia:</span> <?php echo $create_date; ?></li>
            <li><span>Typ nauki:</span>
                <?php
                if (!$type_of_learn) {
                    echo "<a href='form.php'>Ustaw</a>";
                } else {
                    switch ($type_of_learn) {
                        case 1:
                            echo "Słuchowiec";
                            break;
                        case 2:
                            echo "Wzrokowiec";
                            break;
                        case 3:
                            echo "Działaniowiec";
                            break;
                    }
                }
                ?></li>

            <li><span>Typ konta:</span> <?php
                                        switch ($account_type) {
                                            case 1:
                                                echo "Administrator";
                                                break;
                                            case 2:
                                                echo "Nauczyciel";
                                                break;
                                            case 3:
                                                echo "Uczeń";
                                                break;
                                            case 4:
                                                echo "Nauczyciel";
                                                break;
                                        } ?>
            </li>
        </ul>
    </aside>


    <main class="box" style="min-height: calc(90vh - 60px  - 6px );">
        <section class="learn-type-form">
            <?php
            require_once "connection.php";
            try {
                $polaczenie = new mysqli($host, $db_login, $db_pass, $db_name);
                if ($polaczenie->connect_errno != 0) {
                    throw new Exception(mysqli_connect_errno());
                } else {
                    ob_start();
                    include 'your_courses.php';
                    $result = ob_get_clean();
                    echo $result;

                    if ($account_type == 4) {
                        echo '<span>Twoje konto nauczyciela oczekuje na akceptację przez Administratora.</span>';
                    }

                    if ($account_type < 3) {
                        // lista osób zapisujących się na kurs wyświetlająca się dla nauczyciela i administratora
                        include 'on_course_list.php';
                        $result = ob_get_clean();
                        echo $result;
                    }

                    if ($account_type == 1) {

                        // tabelka z akceptacją nowego stworzonego kursu
                        include 'accept_course.php';
                        $result = ob_get_clean();
                        echo $result;
                        // tabelka z akceptacją konta nauczyciela
                        include 'accept_teacher.php';
                        $result = ob_get_clean();
                        echo $result;
                        // formularz dodanie użytkownika
                        include 'add_form.php';
                        $result = ob_get_clean();
                        echo $result;
                    }
                }
                $polaczenie->close();
            } catch (Exception $e) {
                echo $e;
            }
            ?>

        </section>
    </main>

    <footer class="greenFooter"> &copy; MUD3L</footer>
    <script src="scripts/jquery-3.2.1.min.js"></script>
    <script src="scripts/menu.js"></script>

</body>

</html>