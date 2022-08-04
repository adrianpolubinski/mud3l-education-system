<section class="test3">
    <h1 style="text-align: center;">Dodawanie testu<h1>

    <form action="add_test.php" method="post">
        <label >Nazwa: </label>
        <input type="text" name="nazwa" required />

        <label>Opis: </label>
        <input type="text"  name="opis" required />

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




	$wynik = $polaczenie->query("select * from lessons where course_id = $course_id "); ?>

	<label>Wybierz lekcje: </label>
	<select name="lid">
       <?php  while($dane = $wynik->fetch_assoc()) { ?>
                 <option value=" <?php echo $dane['id'] ?>"> <?php echo $dane["subject"] ?></option>';
               <?php } ?>
              
              </select>

        
		<?php
        $polaczenie->close();
    }
} catch (Exception $e) {
    echo $e;
}
?>

        <input type="hidden"  name="cid" value="<?php echo $course_id; ?>"/>
        <input class="addq" type="submit" value="Dodaj Test" />
    </form>
</section>