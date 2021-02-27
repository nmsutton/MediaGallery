<html>
<head>
<style>	
	#responsive-image {  width: auto;  height: 100%; } 
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
	if (isset($_REQUEST['image'])) {
		$image = str_replace('file://', '', $_REQUEST['image']);
		echo "<img src='$image' id='responsive-image'>";
	}
?>
</center>
<form name='setdir' action='mediagallery.php' method = "POST">
<!-- input type="submit" value="back" style="position:absolute;top:0px;left:0px;font-size:28px" /-->
<input type="hidden" name="basedir" id="basedir" value=<?php echo "'".$_REQUEST['basedirimg']."'" ?>>
</form>
<input type="button" value=" x " class="closebutton" onclick="javascript:closewindow()" />
</body>
</html>