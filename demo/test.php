<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
} else {

    $question_list = [];
    require_once "connection.php";
    try {
        $polaczenie = new mysqli($host, $db_login, $db_pass, $db_name);
        if ($polaczenie->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            $id = $_SESSION['id'];
            $course_id = $_GET['cid'];
            $test_id=$_GET['tid'];
	$lid=$_GET['lid'];

	$tests_list = [];
         $temp ='<div class="learn-type-form"> <h2 class="accept">Podejścia do testów w kursie</h2>
                        <table class="users-to-accept">
                                 <tr>
                                     <th>Nazwa</th>
                                     <th>Punkty</th>
                                     <th>Zaliczenie</th>
					<th>Data</th>
					<th>Typ</th>
                                 </tr>';
                     array_push($tests_list, $temp);

			
                    $wynik = $polaczenie->query("SELECT nazwa, wynik, zaliczenie, data, typ_uczenia from wyniki left join testy on testy.id=wyniki.id_testu where id_konta=$id ORDER BY data DESC");
$ile=0;
                     while ($r = $wynik->fetch_assoc()) {
if($r['zaliczenie']==1)
	$temp="tak";
else 
	$temp="nie";

if($r['typ_uczenia']==1)
	$temp2="słuchowiec";
else if($r['typ_uczenia']==2)
	$temp2="wzrokowiec";
else if($r['typ_uczenia']==3)
	$temp2="działaniowiec";
else
	$temp2="błąd odczytu";




if($ile >=5) break;
                         $temp =    '<tr>
                                     <td>' . $r['nazwa'] . '</td>
                                     <td>' . $r['wynik'] . '</td>
                                     <td>' . $temp. '</td>
				     <td>' . $r['data'] . '</td>
					<td>' . $temp2 . '</td>
                                 </tr>';
$ile++;
                         array_push($tests_list, $temp);
                   
                 }
                 $temp = '</table></div>';
                 array_push($tests_list, $temp);
                 $wynik->close();
            








            $count = 0;
            $wynik = $polaczenie->query("SELECT * FROM Pytania  WHERE id_testu='$test_id'");
            if (!$wynik) throw new Exception($polaczenie->error);
            while ($r = $wynik->fetch_assoc()) {
                $count+=1;
                $qid = $r['id']; // question id
if ($_SESSION['account_type'] < 3 || $id == $author_id){
                $question = ' 
                            <h2 class="lesson-title">'.$count . ". " . $r['tresc'] .'</h2> 

<a href="delete_from_questions.php?qid=' . $r['id'] . '&tid=' . $test_id . '" class="button">Usuń Pytanie</a>
                            <div>

                                <input type="radio" id="odpowiedz1" value="odpowiedz1" name="pytanie'.$count.'">
                                <label for="odpowiedz1">'.$r['odpowiedz1'].'</label>
                                </br>
                                <input type="radio" id="odpowiedz2" value="odpowiedz2" name="pytanie'.$count.'">
                                <label for="odpowiedz2">'.$r['odpowiedz2'].'</label>
                                </br>
                                <input type="radio" id="odpowiedz3-'.$count.'" value="odpowiedz3" name="pytanie'.$count.'">
                                <label for="odpowiedz3">'.$r['odpowiedz3'].'</label>
                                </br>
                                <input type="radio" id="odpowiedz4-'.$count.'" value="odpowiedz4" name="pytanie'.$count.'">
                                <label for="odpowiedz4">'.$r['odpowiedz4'].'</label>
                            </br>   
                            </div>';}
else{
$question = ' 
                            <h2 class="lesson-title">'.$count . ". " . $r['tresc'] .'</h2> 

                            <div>

                                <input type="radio" id="odpowiedz1" value="odpowiedz1" name="pytanie'.$count.'">
                                <label for="odpowiedz1">'.$r['odpowiedz1'].'</label>
                                </br>
                                <input type="radio" id="odpowiedz2" value="odpowiedz2" name="pytanie'.$count.'">
                                <label for="odpowiedz2">'.$r['odpowiedz2'].'</label>
                                </br>
                                <input type="radio" id="odpowiedz3-'.$count.'" value="odpowiedz3" name="pytanie'.$count.'">
                                <label for="odpowiedz3">'.$r['odpowiedz3'].'</label>
                                </br>
                                <input type="radio" id="odpowiedz4-'.$count.'" value="odpowiedz4" name="pytanie'.$count.'">
                                <label for="odpowiedz4">'.$r['odpowiedz4'].'</label>
                            </br>   
                            </div>';

}
                array_push($question_list, $question);
            
            } 
            $wynik->close();
        }
    }
    catch (Exception $e) {
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


<?php if ($_SESSION['account_type'] >= 3){ ?>
<section class="test">
    <div>
<?php 
foreach ($tests_list as $tests) {
            echo $tests;
        }
        ?>
</div>
</section>
<?php } ?>


<?php if ($_SESSION['account_type'] < 3 || $id == $author_id) { ?>
    <section class="test">
        <!-- Dodanie pytania -->
    <div>
        <?php
        if ($_SESSION['account_type'] < 3) {
            ob_start();
            include 'add_question_form.php';
            $result = ob_get_clean();
            echo $result;
        }?>
        </div>
    </section>
<?php } ?>

    <section class="test2">
        <div>
            <form action="check_answers.php" method="post">
            <?php  foreach ($question_list as $question) {
                echo $question;
            }?>
            <input type="hidden"  name="count" value="<?php echo $count; ?>"/>
            <input type="hidden"  name="cid" value="<?php echo $course_id; ?>"/>
            <input type="hidden"  name="tid" value="<?php echo $test_id; ?>"/>
		<input type="hidden"  name="lid" value="<?php echo $lid; ?>"/>

            <input class="sprawdzTest" type="submit"  value="Sprawdz" />
            </form>
        </div>

    </section>

    <footer class="royalFooter"> &copy; MUD3L</footer>
    <script src="scripts/jquery-3.2.1.min.js"></script>
    <script src="scripts/menu.js"></script>

</body>

</html>