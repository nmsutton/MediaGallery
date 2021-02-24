<html>
<head>
<style>
</style>
</head>
<body>
<center>
<?php
	if (isset($_REQUEST['video'])) {
		echo "
		<video controls autoplay loop width='640' height='360' id='backgroundvid'>
			<source src='".$_REQUEST['video']."'>
		</video>
		";
	}
?>
</center>
</body>
</html>