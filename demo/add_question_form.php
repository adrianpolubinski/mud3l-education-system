<section class="add_question">
    <h1 style="text-align: center;">Dodawanie Pytania<h1>

    <form action="add_question.php" method="post">
        <label >Treść: </label>
        <input type="text" name="tresc" required />

        <label>Odpowiedz 1: </label>
        <input type="text"  name="odpowiedz1" required />

        <label>Odpowiedz 2: </label>
        <input type="text"  name="odpowiedz2" required />

        <label>Odpowiedz 3: </label>
        <input type="text"  name="odpowiedz3" required />

        <label>Odpowiedz 4: </label>
        <input type="text"  name="odpowiedz4" required />

        <label>Zaznacz prawidłową odpowiedz: </label>
        <select name="prawidlowa" id="cars">
            <option value="odpowiedz1">Odpowiedz 1:</option>
            <option value="odpowiedz2">Odpowiedz 2:</option>
            <option value="odpowiedz3">Odpowiedz 3:</option>
            <option value="odpowiedz4">Odpowiedz 4:</option>
        </select>

        <input type="hidden"  name="cid" value="<?php echo $course_id; ?>"/>
        <input type="hidden"  name="tid" value="<?php echo $test_id; ?>"/>
        <input class="addq" type="submit" value="Dodaj Pytanie" />
    </form>
</section>