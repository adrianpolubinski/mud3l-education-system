<?php
session_start();
?>
<section class="test3">
    <h1>Dodaj Lekcje</h2>
    <form action="add_lesson.php" method="post">
        <label>Tytuł: </label>
        <input type="text" name="title" minlength="5" required />
        <label>Opis: </label>
        <input type="text" name="desc" minlength="10" required />
        <input class="addq" type="submit" value="Dodaj Lekcje" />
    </form>
</section>