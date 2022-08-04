<?php
// jeśli nauczyciel-------------------------------------------------------
$at = $_SESSION['account_type'];
$course_list = [];
if ($at == 2) {
    $aid = $_SESSION['id'];
    $wynik = $polaczenie->query("SELECT id FROM courses where author_id='$aid'");
    if (!$wynik) throw new Exception($polaczenie->error);
    while ($r = $wynik->fetch_assoc()) {
        array_push($course_list, $r['id']);
    }
    $wynik->close();
}
//------------------------------------------------------------------------
$wynik = $polaczenie->query("SELECT member_id, course_id FROM course_members WHERE accepted=0");
if (!$wynik) throw new Exception($polaczenie->error);
if ($wynik->num_rows > 0) {
    echo    '<h2 class="accept">Akceptuj zapis do kursu</h2>
            <table class="users-to-accept">
                <tr>
                    <th>Kurs</th>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>Akceptuj</th>
                </tr>';
    while ($r = $wynik->fetch_assoc()) {
        $mem_id = $r['member_id'];
        $cid = $r['course_id'];
        if($at == 2 && in_array($cid, $course_list)) {
            $wynik1 = $polaczenie->query("SELECT name, surname FROM persons JOIN users ON persons.id=users.person_id WHERE users.id='$mem_id'");
            if (!$wynik1) throw new Exception($polaczenie->error);
            $wynik2 = $polaczenie->query("SELECT name FROM courses WHERE id='$cid'");
            if (!$wynik2) throw new Exception($polaczenie->error);
            $r1 = $wynik1->fetch_assoc();
            $r2 = $wynik2->fetch_assoc();
            echo    '<tr>
                        <td>' . $r2['name'] . '</td>
                        <td>' . $r1['name'] . '</td>
                        <td>' . $r1['surname'] . '</td>
                        <td><a href="accept_on_course.php?cid=' . $cid . ',&uid=' . $mem_id . '">Akceptuj</a></td>
                    </tr>';
            $wynik1->close();
            $wynik2->close();
        }

        if($at==1) {
            $cid = $r['course_id'];
            $wynik1 = $polaczenie->query("SELECT name, surname FROM persons JOIN users ON persons.id=users.person_id WHERE users.id='$mem_id'");
            if (!$wynik1) throw new Exception($polaczenie->error);
            $wynik2 = $polaczenie->query("SELECT name FROM courses WHERE id='$cid'");
            if (!$wynik2) throw new Exception($polaczenie->error);
            $r1 = $wynik1->fetch_assoc();
            $r2 = $wynik2->fetch_assoc();
            echo    '<tr>
                        <td>' . $r2['name'] . '</td>
                        <td>' . $r1['name'] . '</td>
                        <td>' . $r1['surname'] . '</td>
                        <td><a href="accept_on_course.php?cid=' . $cid . ',&uid=' . $mem_id . '">Akceptuj</a></td>
                    </tr>';
            $wynik1->close();
            $wynik2->close();
        }

    }
    echo '</table>';
}
$wynik->close();
