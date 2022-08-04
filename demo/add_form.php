<h2 class="accept">Dodaj użytkownika</h2>
<form class="addUser" action="add_user.php" method="post">
      <label class="label">Imię: </label>
      <input type="text" name="imie" class="input" placeholder="Podaj imię" maxlength="20" pattern='[\p{L}]+' required /><br>
      <label class="label">Nazwisko: </label>
      <input type="text" name="nazwisko" class="input" placeholder="Podaj nazwisko" maxlength="20" pattern='[\p{L}]+' required /><br>
      <label class="label">Login: </label>
      <input type="text" name="login" class="input" placeholder="Wprowadź login" minlength="4" maxlength="20" pattern='[\p{L}0-9]+' required /><br>
      <label class="label">E-mail: </label>
      <input type="email" name="email" class="input" placeholder="Wprowadź adres e-mail" required /><br>
      <label class="label">Numer telefonu: </label>
      <input type="tel" name="telefon" class="input" placeholder="Wprowadź numer telefonu" minlength="9" pattern="[0-9]{3}[0-9]{3}[0-9]{3}" required /><br>
      <label class="label">Hasło: </label>
      <input type="password" name="haslo" class="input" placeholder="Wprowadź hasło" minlength="8" required /><br>
      <label class="label">Powtórz hasło: </label>
      <input type="password" name="haslor" class="input" placeholder="Powtórz wprowadzone hasło" minlength="8" required /><br>
      <label class="label">Typ użytkownika:</label>
      <select name="account_type">
            <option value="3">Uczeń</option>
            <option value="2">Nauczyciel</option>
      </select>
      <input class="akceptuj" type="submit" value="Dodaj" />
</form>