<?php
session_start();
if ((!isset($_SESSION['id']))) {
    header("Location: index.php");
    exit();
}

$login = $_SESSION['login'];
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
        form p {
            margin-top: 20px;
            font-weight: 600;
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
            <li><a href="course_categories.php">Kategorie Kursów</a></li>
            <li class="active"><a href="profile.php"><?php echo $login; ?> (pokaż profil)</a></li>
            <li><a href="logout.php">Wyloguj</a></li>
        </ul>
    </nav>


    <section class="learn-type-form">
        <h1>Wypełnij ankietę i sprawdź jaki typ nauki do Ciebie pasuje.</h1><br>
        <form action="form_request.php" method="post" style="width: 60%">

            <p>1. Gdy spotykasz nieznaną ci osobę, na co zwracasz uwagę w pierwszej kolejności?</p>
            <input type="radio" name="quest1" value="wzrokowiec" required>
            <label for="wzrokowiec">A. jak wygląda i jak jest ubrana,</label><br>
            <input type="radio" name="quest1" value="sluchowiec">
            <label for="sluchowiec">B. w jaki sposób i co mówi, jaki ma głos,</label><br>
            <input type="radio" name="quest1" value="dzialaniowiec">
            <label for="dzialaniowiec">C. w jaki sposób się zachowuje i co robi</label><br>

            <p>2. Co najczęściej zostaje ci w pamięci po kilku dniach od spotkania nieznanej ci wcześniej osoby?</p>
            <input type="radio" name="quest2" value="dzialaniowiec" required>
            <label for="dzialaniowiec">A. to, co robiliście razem, nawet jeśli zapomniałeś jej imię/nazwisko lub twarz,</label><br>
            <input type="radio" name="quest2" value="sluchowiec">
            <label for="sluchowiec">B. jej imię/nazwisko,</label><br>
            <input type="radio" name="quest2" value="wzrokowiec">
            <label for="wzrokowiec">C. jej twarz.</label><br>

            <p>3. Gdy wchodzisz do nieznanego ci pomieszczenia, na co zwracasz przede wszystkim uwagę?</p>
            <input type="radio" name="quest3" value="wzrokowiec" required>
            <label for="wzrokowiec">A. na jego wygląd,</label><br>
            <input type="radio" name="quest3" value="dzialaniowiec">
            <label for="dzialaniowiec">B. na to, co się w nim dzieje i co ty mógłbyś w nim robić,</label><br>
            <input type="radio" name="quest3" value="sluchowiec">
            <label for="sluchowiec">C. na dźwięki i rozmowy, jakie się w nim toczą.</label><br>

            <p>4. Gdy uczysz się czegoś nowego, w jaki sposób robisz to najchętniej?</p>
            <input type="radio" name="quest4" value="dzialaniowiec" required>
            <label for="dzialaniowiec">A. gdy nauczyciel pozwala ci robić projekty, symulacje, eksperymenty, grać w gry, odgrywać role, odtwarzać rzeczywiste sytuacje z życia, dokonywać odkryć lub też angażować się w inne działania związane z ruchem,</label><br>
            <input type="radio" name="quest4" value="wzrokowiec">
            <label for="wzrokowiec">B. gdy nauczyciel daje ci coś do czytania na papierze lub tablicy, pokazuje ci książki, ilustracje, wykresy, mapy, szkice lub przedmioty, nie każąc ci przy tym niczego mówić, pisać, ani o niczym dyskutować,</label><br>
            <input type="radio" name="quest4" value="sluchowiec">
            <label for="sluchowiec">C. gdy nauczyciel wyjaśnia wszystko, mówiąc lub wygłaszając wykład, pozwala ci przedyskutować temat i zadawać pytania, nie każąc ci przy tym na nic patrzeć, niczego czytać, pisać ani robić.</label><br>

            <p>5. Gdy uczysz czegoś innych, co zwykle robisz?</p>
            <input type="radio" name="quest5" value="sluchowiec" required>
            <label for="sluchowiec">A. objaśniasz wszystko werbalnie, nie pokazując żadnych materiałów graficznych,</label><br>
            <input type="radio" name="quest5" value="dzialaniowiec">
            <label for="dzialaniowiec">B. demonstrujesz coś, robiąc to lub każesz uczniom robić to wspólnie z tobą,</label><br>
            <input type="radio" name="quest5" value="wzrokowiec">
            <label for="wzrokowiec">C. dajesz im coś do oglądania, na przykład jakiś przedmiot, ilustrację lub wykres, udzielając przy tym jedynie krótkiego werbalnego wyjaśnienia lub nie udzielając go wcale, dopuszczając lub nie do krótkiej dyskusji.</label><br>

            <p>6. Jaki rodzaj książek czytasz najchętniej?</p>
            <input type="radio" name="quest6" value="sluchowiec" required>
            <label for="sluchowiec">A. książki zawierające informacje faktograficzne, historyczne lub dużo dialogów,</label><br>
            <input type="radio" name="quest6" value="dzialaniowiec">
            <label for="dzialaniowiec">B. krótkie książki z wartką akcją lub książki, które pomagają ci doskonalić umiejętności w sporcie, hobby czy też rozwijać jakiś talent,</label><br>
            <input type="radio" name="quest6" value="wzrokowiec">
            <label for="wzrokowiec">C. książki, które zawierają opisy pomagające ci zobaczyć to, co się dzieje.</label><br>

            <p>7. Którą z poniższych czynności wykonujesz najchętniej w czasie wolnym?</p>
            <input type="radio" name="quest7" value="wzrokowiec" required>
            <label for="wzrokowiec">A. czytasz książkę lub przeglądasz czasopismo,</label><br>
            <input type="radio" name="quest7" value="sluchowiec">
            <label for="sluchowiec">B. słuchasz książki nagranej na kasetę, rozmowy w radiu, słuchasz muzyki lub sam muzykujesz,</label><br>
            <input type="radio" name="quest7" value="dzialaniowiec">
            <label for="dzialaniowiec">C. uprawiasz sport, budujesz coś lub grasz w grę wymagającą ruchu.</label><br>

            <p>8. Które z poniższych stwierdzeń najlepiej charakteryzuje sposób, w jaki czytasz lub uczysz się?</p>
            <input type="radio" name="quest8" value="dzialaniowiec" required>
            <label for="dzialaniowiec">A. musisz czuć się wygodnie, rozluźniony; potrafisz pracować zarówno przy muzyce, jak i w ciszy, jednak dekoncentruje cię działalność i ruchy innych osób znajdujących się w tym samym pomieszczeniu,</label><br>
            <input type="radio" name="quest8" value="wzrokowiec">
            <label for="wzrokowiec">B. potrafisz się uczyć, gdy słychać muzykę, inne dźwięki lub rozmowę, ponieważ umiesz się od nich odseparować,</label><br>
            <input type="radio" name="quest8" value="sluchowiec">
            <label for="sluchowiec">C. nie potrafisz się uczyć, gdy w twoim pobliżu słychać muzykę, inne dźwięki lub rozmowę, ponieważ nie umiesz się od nich odseparować.</label><br>

            <p>9. Gdy z kimś rozmawiasz, gdzie kierujesz wzrok? (aby odpowiedzieć na to pytanie, możesz poprosić kogoś, by cię obserwował w trakcie rozmowy).</p>
            <input type="radio" name="quest9" value="sluchowiec" required>
            <label for="sluchowiec">A. spoglądasz jedynie krótko na rozmówcę, po czym twój wzrok wędruje na prawo i lewo,</label><br>
            <input type="radio" name="quest9" value="wzorkowiec">
            <label for="wzrokowiec">B. patrzysz na twarz rozmówcy, chcesz także, by ta osoba patrzyła na twoją twarz, gdy do niej mówisz,</label><br>
            <input type="radio" name="quest9" value="dzialaniowiec">
            <label for="dzialaniowiec">C. rzadko spoglądasz na rozmówcę, patrzysz głównie w dół lub w bok, jeśli jednak pojawi się jakiś ruch lub działanie, natychmiast spoglądasz w tamtym kierunku.</label><br>

            <p>10. Które z poniższych stwierdzeń najlepiej do ciebie pasuje?</p>
            <input type="radio" name="quest10" value="dzialaniowiec" required>
            <label for="dzialaniowiec">A. trudno ci wysiedzieć nieruchomo w jednym miejscu, potrzebujesz dużo ruchu, a jeśli już musisz siedzieć garbisz się, wiercisz, stukasz w podłogę butami lub często niespokojnie poruszasz nogami,</label><br>
            <input type="radio" name="quest10" value="wzrokowiec">
            <label for="wzrokowiec">B. zwracasz uwagę na kolory, kształty, wzory i desenie w miejscach, w których się znajdziesz; masz dobre oko do barw i kształtów,</label><br>
            <input type="radio" name="quest10" value="sluchowiec">
            <label for="sluchowiec">C. nie znosisz ciszy i jeśli tam, gdzie akurat jesteś, jest za cicho, nucisz coś, podśpiewujesz lub głośno mówisz; włączasz radio, telewizor, magnetofon lub odtwarzacz CD, by w twoim otoczeniu były bodźce słuchowe,</label><br>

            <p>11. Które z poniższych stwierdzeń najlepiej do ciebie pasuje?</p>
            <input type="radio" name="quest11" value="sluchowiec" required>
            <label for="sluchowiec">A. niepokoi cię, gdy ktoś nie potrafi dobrze się wysławiać, jesteś wrażliwy na odgłos kapiącego kranu lub odgłosy wydawane przez urządzenia gospodarstwa domowego,</label><br>
            <input type="radio" name="quest11" value="wzrokowiec">
            <label for="wzrokowiec">B. zwracasz uwagę na nieodpowiednie dopasowanie części garderoby danej osoby lub na to, że jej włosy są w nieładzie i często chcesz to naprawić,</label><br>
            <input type="radio" name="quest11" value="dzialaniowiec">
            <label for="dzialaniowiec">C. niepokoisz się i czujesz się nieprzyjemnie, gdy jesteś zmuszony siedzieć nieruchomo; nie potrafisz przebywać zbyt długo w jednym miejscu.</label><br>

            <p>12. Co wywołuje u ciebie największy niepokój?</p>
            <input type="radio" name="quest12" value="sluchowiec" required>
            <label for="sluchowiec">A. miejsce, w którym jest za cicho,</label><br>
            <input type="radio" name="quest12" value="dzialaniowiec">
            <label for="dzialaniowiec">B. miejsce, w którym nie wolno niczego robić lub jest za mało przestrzeni na ruch,</label><br>
            <input type="radio" name="quest12" value="wzrokowiec">
            <label for="wzrokowiec">C. miejsce, w którym panuje bałagan i nieład.</label><br>

            <p>13. Czego najbardziej nie lubisz, podczas gdy ktoś cię uczy?</p>
            <input type="radio" name="quest13" value="dzialaniowiec" required>
            <label for="dzialaniowiec">A. patrzenia i słuchania w bezruchu,</label><br>
            <input type="radio" name="quest13" value="wzrokowiec">
            <label for="wzrokowiec">B. słuchania wykładu, na którym nie wykorzystuje się żadnych pomocy wizualnych,</label><br>
            <input type="radio" name="quest13" value="sluchowiec">
            <label for="sluchowiec">C. czytania po cichu, bez żadnych werbalnych wyjaśnień czy dyskusji.</label><br>

            <p>14. Wróć pamięcią do jakiegoś szczęśliwego momentu ze swojego życia. Przez chwilę spróbuj przypomnieć sobie jak najwięcej szczegółów związanych z tym wydarzeniem. Jakie wspomnienia utkwiły ci w pamięci?</p>
            <input type="radio" name="quest14" value="sluchowiec" required>
            <label for="sluchowiec">A. to, co słyszałeś, na przykład dialogi i rozmowy, to, co powiedziałeś, oraz dźwięki wokół ciebie,</label><br>
            <input type="radio" name="quest14" value="wzrokowiec">
            <label for="wzrokowiec">B. to, co widziałeś, na przykład wygląd ludzi, miejsc czy przedmiotów,</label><br>
            <input type="radio" name="quest14" value="dzialaniowiec">
            <label for="dzialaniowiec">C. to, co robiłeś, ruchy twojego ciała, twoje dokonania,</label><br>

            <p>15. Przypomnij sobie któryś ze swoich urlopów lub wycieczek. Przez chwilę spróbuj przypomnieć sobie jak najwięcej szczegółów związanych z tym doświadczeniem. Jakie wspomnienia utkwiły ci w pamięci?</p>
            <input type="radio" name="quest15" value="dzialaniowiec" required>
            <label for="dzialaniowiec">A. to, co robiłeś, ruchy twojego ciała, twoje dokonania,</label><br>
            <input type="radio" name="quest15" value="sluchowiec">
            <label for="sluchowiec">B. to, co słyszałeś, na przykład dialogi i rozmowy, to, co powiedziałeś, oraz dźwięki wokół ciebie,</label><br>
            <input type="radio" name="quest15" value="wzrokowiec">
            <label for="wzrokowiec">C. to, co widziałeś, na przykład wygląd ludzi, miejsc czy przedmiotów.</label><br>

            <p>16. Wyobraź sobie, że musisz przez cały czas przebywać w jednym z niżej opisanych miejsc, w którym możesz wykonywać różnego rodzaju czynności. W którym z nich czułbyś się najlepiej?</p>
            <input type="radio" name="quest16" value="wzrokowiec" required>
            <label for="wzrokowiec">A. miejsce, w którym możesz czytać; oglądać obrazy, dzieła sztuki, mapy, wykresy i fotografie; rozwiązywać zagadki wizualne, takie jak odnajdowanie drogi w labiryncie lub wyszukiwanie brakującego elementu obrazu; grać w gry słowne takie jak scrabble; zajmować się dekorowaniem wnętrz lub przymierzać ubrania,</label><br>
            <input type="radio" name="quest16" value="sluchowiec">
            <label for="sluchowiec">B. miejsce, w którym możesz słuchać nagranych na kasety opowiadań, muzyki, radiowych lub telewizyjnych; talk shows i wiadomości; grać na instrumencie lub śpiewać; bawić się głośno w gry słowne, rozprawiać o czymś, udawać dyskdżokeja; czytać na głos lub wygłaszać przemówienia, fragmenty ról ze sztuk teatralnych i filmów, czytać na głos poezję lub opowiadania,</label><br>
            <input type="radio" name="quest16" value="dzialaniowiec">
            <label for="dzialaniowiec">C. miejsce, w którym możesz uprawiać sport, grać w piłkę lub gry ruchowe, które angażują twoje ciało; odgrywać rolę w sztuce teatralnej lub przedstawieniu; robić projekty, podczas których możesz wstać i poruszać się; robić eksperymenty, badać i odkrywać nowe rzeczy, budować coś lub składać ze sobą mechaniczne elementy; brać udział w zbiorowym współzawodnictwie.</label><br>

            <p>17. Gdybyś miał zapamiętać nowe słowo, zrobiłbyś to najlepiej:</p>
            <input type="radio" name="quest17" value="wzrokowiec" required>
            <label for="wzrokowiec">A. widząc je,</label><br>
            <input type="radio" name="quest17" value="sluchowiec">
            <label for="sluchowiec">B. słysząc je,</label><br>
            <input type="radio" name="quest17" value="dzialaniowiec">
            <label for="dzialaniowiec">C. odtwarzając to słowo w umyśle lub fizycznie.</label><br>
            <input type="submit" value="Prześlij odpowiedź">
        </form>

    </section>

    <footer class="greenFooter"> &copy; MUD3L</footer>
    <script src="scripts/jquery-3.2.1.min.js"></script>
    <script src="scripts/menu.js"></script>

</body>

</html>