<section class="test3">
  <h1 style="text-align: center;">Dodaj treść dla <?php echo $add; ?><h1>
      <form action="add_lesson_content.php" method="post" enctype="multipart/form-data">
        <label>Wprowadź treść tekstową: </label>
        <input type="text" name="context" minlength="10" required />
        <label>Wybierz plik *.mp3:</label>
        <input type="file" name="fileToUpload" id="fileToUpload" accept=".mp3">
        <input type="hidden" name="link" value="<?php echo $filename; ?>" />
        <input type="hidden" name="type" value="<?php echo $temp; ?>" />
        <input type="hidden" name="lid" value="<?php echo $lid; ?>" />
        <input type="submit" value="Prześlij" name="submit">
      </form>
</section>