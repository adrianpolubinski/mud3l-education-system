<?php session_start();
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
      <title>Rejestracja</title>
   </head>

   <body>
      <div class="rejestracja">
         <form action="register.php" method="post">
            <div><img src="../img/logo.png" alt=""></div>
            <div><label class="label">Imię: </label><input type="text" name="imie" class="input"
                  placeholder="Podaj imię" maxlength="20" pattern='[\p{L}]+' <?php if (isset($_SESSION['imie'])) echo 'value="'. $_SESSION['imie'] . '"';
                  unset($_SESSION['imie']);
                  ?>required /></div>
            <div><label class="label">Nazwisko: </label><input type="text" name="nazwisko" class="input"
                  placeholder="Podaj nazwisko" maxlength="20" pattern='[\p{L}]+' <?php if (isset($_SESSION['nazwisko'])) echo 'value="'. $_SESSION['nazwisko'] . '"';
               unset($_SESSION['nazwisko']);
               ?>required /></div>
            <div><label class="label">Login: </label><input type="text" name="login" class="input"
                  placeholder="Wprowadź login" minlength="4" maxlength="20" pattern='[\p{L}0-9]+' <?php if (isset($_SESSION['login'])) echo 'value="'. $_SESSION['login'] . '"';
unset($_SESSION['login']);
?>required /></div>
            <div><label class="label">E-mail: </label><input type="email" name="email" class="input"
                  placeholder="Wprowadź adres e-mail" <?php if (isset($_SESSION['email'])) echo 'value="'. $_SESSION['email'] . '"';
unset($_SESSION['email']);
?>required /></div>
            <div><label class="label">Numer telefonu: </label><input type="tel" name="telefon" class="input"
                  placeholder="Wprowadź numer telefonu" minlength="9" pattern="[0-9]{3}[0-9]{3}[0-9]{3}" <?php if (isset($_SESSION['telefon'])) echo 'value="'. $_SESSION['telefon'] . '"';
unset($_SESSION['telefon']);
?>required /></div>
            <div><label class="label">Hasło: </label><input type="password" name="haslo" class="input"
                  placeholder="Wprowadź hasło" minlength="8" required /></div>
            <div><label class="label">Powtórz hasło: </label><input type="password" name="haslor" class="input"
                  placeholder="Powtórz wprowadzone hasło" minlength="8" required /></div>
            <div><label class="label">Typ użytkownika:</label>
            <select name="account_type">
                  <option value="3">Uczeń</option>
                  <option value="4">Nauczyciel</option>
               </select></div>
          
            <?php if (isset($_SESSION['blad'])) echo '<div class="blad">'. $_SESSION['blad'] . '</div>';
         unset($_SESSION['blad']);
?>
<input class="zarejestruj" type="submit" value="Zarejestruj się" />
         </form>
      </div>
   </body>

   </html>