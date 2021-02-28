<html>
<head>
<style>
	body {
		background-color: black;
		color: #3a4472;
		font-size: 48px;
		font-family: arial;
	}
	textarea {
		background-color: black;
		color: #3a4472;
		font-size: 48px;
		font-family: arial;
		overflow:hidden;
		border: 3px rgb(55,55,55) solid;
	}
	input[type='button'] {
		background-color: rgb(25,25,25);
		color: #3a4472;
		font-size: 30px;
		font-family: arial;
		border: 3px rgb(55,55,55) solid;
		height:60px;
		width:60px;
		opacity: 0.5;
	}
	.closebutton {
		position:absolute;position:fixed;top:0px;right:0px;font-size:36px;
	}	
	.fullscreenbutton {
		position:absolute;position:fixed;top:70px;right:0px;font-size:36px;
	}	
</style>
<script>
	function closewindow() {
		window.close();
	}
	function fullscreenwindow() {
		document.getElementById("video").requestFullscreen();
	}
</script>
</head>
<body>
<center>
<?php
	if (isset($_REQUEST['video'])) {
		$video = str_replace('file://', '', $_REQUEST['video']);
		echo "
		<video controls autoplay loop width='640' height='360' id='video'>
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
<input type="button" value=" o " class="fullscreenbutton" onclick="javascript:fullscreenwindow()" />
</body>
</html>