<?php 
	$link= str_replace("https://www.youtube.com/watch?v=", "https://www.youtube.com/embed/",$link);
?>
<iframe width="560" height="315" src="<?php echo $link; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
</iframe>
<?php if ($_SESSION['account_type'] < 3 || $id == $author_id){ ?>
	<a href="remove_video.php?aid=<?php echo $aid[$licznik]; ?>&lid=<?php echo $lid; ?>&tol=<?php echo $tol; ?>" style="color:red; display:block; text-align:center; font-size:2rem; margin-bottom: 10px;">Usuń plik video</a>
<?php } ?>