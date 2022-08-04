<?php
session_start();
if (isset($_GET['uid'])) {
    require_once "connection.php";
    try {
        $polaczenie = new mysqli($host, $db_login, $db_pass, $db_name);
        if ($polaczenie->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            $id = $_GET['uid'];
            if ($polaczenie->query("UPDATE users SET account_type=2 WHERE id='$id'")) {
                header("Location: profile.php");
            }
            $polaczenie->close();
        }
    } catch (Exception $e) {
        echo $e;
    }
} else {
    $wynik = $polaczenie->query("SELECT id, login FROM users WHERE account_type=4");
    if (!$wynik) throw new Exception($polaczenie->error);
    if ($wynik->num_rows > 0) {
        echo    '<h2 class="accept">Akceptuj konto nauczyciela</h2>
            <table class="users-to-accept">
                <tr>
                    <th>Login</th>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>Akceptuj</th>
                </tr>';
        while ($r = $wynik->fetch_assoc()) {
            $user_id = $r['id'];
            $wynik1 = $polaczenie->query("SELECT name, surname FROM persons JOIN users ON persons.id=users.person_id WHERE users.id='$user_id'");
            if (!$wynik1) throw new Exception($polaczenie->error);
            $r1 = $wynik1->fetch_assoc();
            echo    '<tr>
                    <td>' . $r['login'] . '</td>
                    <td>' . $r1['name'] . '</td>
                    <td>' . $r1['surname'] . '</td>
                    <td><a href="accept_teacher.php?uid=' . $user_id . '">Akceptuj</a></td>
                </tr>';
            $wynik1->close();
        }
        echo '</table>';
    }
    $wynik->close();
}
