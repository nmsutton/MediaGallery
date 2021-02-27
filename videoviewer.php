<html>
<head>
<style>
	body {background-color: black;}
	.closebutton {
		position:absolute;position:fixed;top:0px;right:0px;font-size:36px;
	}	
</style>
<script>
	function closewindow() {
		window.close();
	}
</script>
</head>
<body>
<center>
<?php
	if (isset($_REQUEST['video'])) {
		$video = str_replace('file://', '', $_REQUEST['video']);
		echo "
		<video controls autoplay loop width='640' height='360' id='backgroundvid'>
			<source src='$video'>
		</video>
		";
	}
?>
</center>
<form name='setdir' action='mediagallery.php' method = "POST">
<!--input type="submit" value="back" style="position:absolute;top:0px;left:0px;font-size:28px" /-->
<input type="hidden" name="basedir" id="basedir" value=<?php echo "'".$_REQUEST['basedirvid']."'" ?>>
</form>
<input type="button" value=" x " class="closebutton" onclick="javascript:closewindow()" />
</body>
</html>