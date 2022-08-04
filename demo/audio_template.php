<div style="display:inline-block;">
<audio controls>
    <source src="<?php echo "audio/".$link; ?>" type="audio/mpeg">\
</audio>
<?php if ($_SESSION['account_type'] < 3 || $id == $author_id){ ?>
	<a href="remove_audio.php?aid=<?php echo $aid[$licznik]; ?>&lid=<?php echo $lid; ?>&tol=<?php echo $tol; ?>" style="color:red; display:block; text-align:center; font-size:2rem; margin-bottom: 10px;">Usuń plik audio</a>
<?php } ?>
</div>