<?php

session_start();

if (!isset($_SESSION['id'])) {

    header("Location: index.php");

    exit();
}

require_once "connection.php";

try {

    $polaczenie = new mysqli($host, $db_login, $db_pass, $db_name);

    if ($polaczenie->connect_errno != 0) {

        throw new Exception(mysqli_connect_errno());
    } else {

        $points = 0;
$id = $_SESSION['id'];
        $cid = $_POST['cid'];

        $tid = $_POST['tid'];
	$lid = $_POST['lid'];

        $count = $_POST['count'];
	$typ_uczenia=$_SESSION['type_of_learn'];


        $odpowiedzi = [];

        $poprawne = [];



        for ($i = 0; $i < $count; $i++) {

            $odpowiedzi[$i] = $_POST['pytanie' . ($i + 1) . ''];
        }



        $licznik = 0;

        $wynik = $polaczenie->query("SELECT prawidlowa FROM Pytania");

        if (!$wynik) throw new Exception($polaczenie->error);

        if ($wynik->num_rows > 0) {

            while ($r = $wynik->fetch_assoc()) {

                $poprawne[$licznik] = $r['prawidlowa'];

                $licznik++;
            }
        }

        for ($i = 0; $i < $count; $i++) {

            if ($odpowiedzi[$i] == $poprawne[$i]) {

                $points++;
            }
        }



        if (($count / 2) <=  $points) {

            $zdane = 1;
        } else {

            $zdane = 0;
        }
	$punkty= $points.'/'.$count;

        $polaczenie->query("INSERT INTO wyniki (id_testu, id_konta, wynik, zaliczenie, typ_uczenia) VALUES ($tid, $id, '$punkty', $zdane, $typ_uczenia);");

	$wynik = $polaczenie->query("SELECT * FROM wyniki where id_konta=$id and id_testu=$tid and zaliczenie=1");
        if ($wynik->num_rows == 1) {
		$polaczenie->query("UPDATE lesson_member SET accept=accept+1 where member_id=$id and course_id=$cid");
        }




        $polaczenie->close();
    }
} catch (Exception $e) {

    echo $e;
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

            <li class="active"><a href="course_categories.php">Kategorie Kursów</a></li>

            <li><a href="profile.php"><?php echo $_SESSION['login']; ?> (pokaż profil)</a></li>

            <li><a href="logout.php">Wyloguj</a></li>

        </ul>

    </nav>



    <section class="checkTest">

        <div>

            <p>Wynik Testu</p>

            <p>Ukończyłeś Test uzyskując: <span style="color:orange;"><?php echo $points . '/' . $count;  ?></span> punktów!</p>

            <?php

            if (($count / 2) <=  $points) {

            ?>

                <p>Co znaczy, że <span style="color:greenyellow;">Zdałeś</span> Test!!!</p>

                <p> GRATULACJE !!!</p>

            <?php

            } else { ?>

                <p>Co znaczy, że <span style="color:red;">nie zdałeś</span> Testu!!!</p>

                <a href="javascript:history.back()" style="color: orange; font-size:2rem;">Spróbuj jeszcze raz !!!</a>
	
		<p style="color: white; font-size:2rem; margin-top:10px;">Może chciałbyś zmienić tryb uczenia się na:</p>

                <a href="change_type.php?type=1&lid=<?php echo $lid; ?>" style="font-size:2rem; color:red;">słuchowca</a>
	

		<a href="change_type.php?type=2&lid=<?php echo $lid; ?>" style="font-size:2rem; color:yellow;">wzrokowca</a>

		<a href="change_type.php?type=3&lid=<?php echo $lid; ?>" style="font-size:2rem; color:orange;">działaniowca</a>

            <?php

            }

            ?>

        </div>

    </section>



    <footer class="royalFooter"> &copy; MUD3L</footer>

    <script src="scripts/jquery-3.2.1.min.js"></script>

    <script src="scripts/menu.js"></script>



</body>

</html>