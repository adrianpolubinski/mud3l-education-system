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

<?php
session_start();
// sprawdzenie czy zalogowany jak nie to na zalogowany.php 
if (!isset($_SESSION['zalogowany'])) {
    header("Location: logowanie.php");
    exit();
} else {
    $login = $_SESSION['login'];
}
?>

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

    <section class="courseCategory">
        <div>
            <h1>WYBIERZ KATEGORIĘ KURSU</h1>
            <?php
            require_once "connection.php";
            try {
                $polaczenie = new mysqli($host, $db_login, $db_pass, $db_name);
                if ($polaczenie->connect_errno != 0) {
                    throw new Exception(mysqli_connect_errno());
                } else {
                    $wynik = $polaczenie->query("SELECT * FROM categories");
                    if (!$wynik) throw new Exception($polaczenie->error);
                    while ($r = $wynik->fetch_assoc()) {
                        $id_course = $r['id'];

                        echo '  <div class="category">
                                    <h2 class="category-title">' . $r['name'] . '</h2>
                                    <a href="courses.php?cid=' . $id_course . '" class="button">Przejdź do kursów w tej kategorii</a>
                                </div>';
                    }
                    $wynik->close();
                    
                    if ($_SESSION['type_account'] == 1) {
                        echo '<div class="addCategory"><h2>Dodaj kategorie</h2>';
                        echo    '<form action="add_category.php" method="post">
                                    <label for="name">Nazwa kategorii </label>
                                    <input type="text" name="name"  pattern="[\p{L}\s+]+" required>
                                    <input class="add" type="submit" value="Dodaj">';
                        if (isset($_SESSION['blad']))
                            echo '<div class="blad">' . $_SESSION['blad'] . '</div>';
                        unset($_SESSION['blad']);
                        echo    '</form></div>';
                    }
                }
                $polaczenie->close();
            } catch (Exception $e) {
                echo $e;
            }
            ?>
        </div>
    </section>

    <footer class="royalFooter"> &copy; MUD3L</footer>
    <script src="scripts/jquery-3.2.1.min.js"></script>
    <script src="scripts/menu.js"></script>

</body>

</html>