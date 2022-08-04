<section class="test3">
    <h1 style="text-align: center;">Dodaj treść dla <?php echo $add; ?><h1>
            <form action="add_lesson_content.php" method="post">
                <label>Wprowadź treść tekstową: </label>
                <input type="text" name="context" minlength="10" required />
                <label>Link do zasobu: </label>
                <input type="text" name="link" minlength="10" placeholder="link do źródła"  required />
                <input type="hidden" name="type" value="<?php echo $temp; ?>" />
                <input type="hidden" name="lid" value="<?php echo $lid; ?>" />
                <input class="addq" type="submit" value="Dodaj Treść" />
            </form>
</section>