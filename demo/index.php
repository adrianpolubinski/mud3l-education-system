<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mud3l</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
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
            <li class="active"><a href="index.php"><i class="fas fa-home"></i><span> Strona Główna</span></a></li>
            <li><a href="course_categories.php">Kategorie Kursów</a></li>
            <li><a href="profile.php"><?php  echo $login; ?> (pokaż profil)</a></li>
            <li><a href="logout.php">Wyloguj</a></li>
        </ul>
    </nav>

    <section class="powitanie">
        <div>
            <h1>Witaj na platformie MUD3L!</h1>
            <p>Jesteśmy dumni, że kożystasz z naszej platformy. Pozostaje nam tylko życzyć sukcesów i wytrwałości w nauce!</p>
            <h2>Życzy zespół MUDE3L!</h2>
        </div>
    </section>

    <footer> &copy; MUD3L</footer>
    <script src="scripts/jquery-3.2.1.min.js"></script>
    <script src="scripts/menu.js"></script>

</body>

</html>