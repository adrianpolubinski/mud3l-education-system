<?php
session_start();
if ((isset($_SESSION['id']))) {
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
   <link rel="stylesheet" href="css/style.css">
   <title>Logowanie</title>
</head>
<body>
<div class="logowanie">
      <div>
         <img src="../img/logo.png" alt="">
      </div>
      <form action="login.php" method="post">
         <label class="label">Login: </label>
         <input type="text" name="login" placeholder="Wprowadź login" required />
         <label class="label">Hasło: </label>
         <input type="password" name="haslo" placeholder="Wprowadź hasło" required />
         <?php
               if (isset($_SESSION['blad']))
                  echo '<div class="blad">' . $_SESSION['blad'] . '</div>';
               unset($_SESSION['blad']);
               ?>
         <input class="zaloguj" type="submit" value="Zaloguj się" />
      </form>
      <p>Nie masz jeszcze założonego konta?</p>
      <p><a href="rejestracja.php">Zarejestruj się!</a></p>
   </div>
</body>
</html>


