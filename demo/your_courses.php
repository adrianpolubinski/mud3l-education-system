<?php
$id = $_SESSION['id'];
$wynik = $polaczenie->query("SELECT * FROM course_members WHERE member_id='$id'");
if (!$wynik) throw new Exception($polaczenie->error);
if ($wynik->num_rows > 0) {
    echo    '<h2 class="accept">Twoje kursy</h2>
            <table class="users-to-accept">
                <tr>
                    <th>Kategoria</th>
                    <th>Kurs</th>
                    <th>Data dołączenia</th>
                    <th>Akcja</th>
                </tr>';
    while ($r = $wynik->fetch_assoc()) {
        $cid = $r['course_id'];
        $wynik1 = $polaczenie->query("SELECT categories.name as name1, courses.name as name2 FROM courses JOIN categories ON courses.category_id=categories.id WHERE courses.id='$cid'");
        if (!$wynik1) throw new Exception($polaczenie->error);
        $r1 = $wynik1->fetch_assoc();
        if ($r['accepted'] == 1) $temp = '<a href="lessons.php?cid=' . $cid . '" class="button">Przejdź do kursu</a>';
        else $temp = "Zapis na kurs oczekuje na akceptacje.";

        echo    '<tr>
                        <td>' . $r1['name1'] . '</td>
                        <td>' . $r1['name2'] . '</td>
                        <td>' . $r['date'] . '</td>
                        <td>'.$temp.'</td>
                    </tr>';
        $wynik1->close();
    }
    echo '</table>';
}
$wynik->close();
