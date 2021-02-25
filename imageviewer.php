<html>
<center>
<?php
	if (isset($_REQUEST['image'])) {
		$image = str_replace('file://', '', $_REQUEST['image']);
		echo "<img src='$image'>";
	}
?>
</center>