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
		/*height:60px;
		width:60px;*/
		height:10%;
		width:15%;
		opacity: 0.5;
	}
	.responsive-image {  
		width: auto;  
		height: 100%; 
	}
	.responsive-image2 {  
		width: 63%;  
		height: auto; 
	}
	.responsive-image2b {  
		width: 75%;  
		height: auto; 
	}  	
	.responsive-image2c {  
		width: 100%;  
		height: auto; 
	} 
	.responsive-image3 {  
		width: 1600px;  
		height: auto; 
	}
	.responsive-image4 {  
		width: 1800px;  
		height: auto; 
	}
	.responsive-image5 {  
		width: 2000px;  
		height: auto; 
	}
	.responsive-image6 {  
		width: auto;  
		height: auto; 
	}			
	.closebutton {
		position:absolute;position:fixed;top:0%;right:0px;font-size:36px;
	}
	.zoomin {
		position:absolute;position:fixed;top:33%;right:0px;font-size:36px;
	}
	.zoomout {
		position:absolute;position:fixed;top:66%;right:0px;font-size:36px;
	}	
</style>
<script>
	function closewindow() {
		window.close();
	}
	function zoomin() {
		if ( document.getElementById("image").classList.contains('responsive-image') ) {
			document.getElementById("image").classList.remove('responsive-image');
			document.getElementById("image").classList.add('responsive-image2');
		}
		else if ( document.getElementById("image").classList.contains('responsive-image2') ) {
			document.getElementById("image").classList.remove('responsive-image2');
			document.getElementById("image").classList.add('responsive-image2b');
		}
		else if ( document.getElementById("image").classList.contains('responsive-image2b') ) {
			document.getElementById("image").classList.remove('responsive-image2b');
			document.getElementById("image").classList.add('responsive-image2c');
		}
		else if ( document.getElementById("image").classList.contains('responsive-image2c') ) {
			document.getElementById("image").classList.remove('responsive-image2c');
			document.getElementById("image").classList.add('responsive-image3');
		}
		else if ( document.getElementById("image").classList.contains('responsive-image3') ) {
			document.getElementById("image").classList.remove('responsive-image3');
			document.getElementById("image").classList.add('responsive-image4');
		}
		else if ( document.getElementById("image").classList.contains('responsive-image4') ) {
			document.getElementById("image").classList.remove('responsive-image4');
			document.getElementById("image").classList.add('responsive-image5');
		}		
		else if ( document.getElementById("image").classList.contains('responsive-image5') ) {
			document.getElementById("image").classList.remove('responsive-image5');
			document.getElementById("image").classList.add('responsive-image6');
		}			
	}
	function zoomout() {
		if ( document.getElementById("image").classList.contains('responsive-image6') ) {
			document.getElementById("image").classList.remove('responsive-image6');
			document.getElementById("image").classList.add('responsive-image5');
		}
		else if ( document.getElementById("image").classList.contains('responsive-image5') ) {
			document.getElementById("image").classList.remove('responsive-image5');
			document.getElementById("image").classList.add('responsive-image4');
		}
		else if ( document.getElementById("image").classList.contains('responsive-image4') ) {
			document.getElementById("image").classList.remove('responsive-image4');
			document.getElementById("image").classList.add('responsive-image3');
		}
		else if ( document.getElementById("image").classList.contains('responsive-image3') ) {
			document.getElementById("image").classList.remove('responsive-image3');
			document.getElementById("image").classList.add('responsive-image2c');
		}
		else if ( document.getElementById("image").classList.contains('responsive-image2c') ) {
			document.getElementById("image").classList.remove('responsive-image2c');
			document.getElementById("image").classList.add('responsive-imageb');
		}
		else if ( document.getElementById("image").classList.contains('responsive-image2b') ) {
			document.getElementById("image").classList.remove('responsive-image2b');
			document.getElementById("image").classList.add('responsive-image2');
		}		
		else if ( document.getElementById("image").classList.contains('responsive-image2') ) {
			document.getElementById("image").classList.remove('responsive-image2');
			document.getElementById("image").classList.add('responsive-image');
		}			
	}	
</script>
</head>
<body>
<center>
<?php
	$image = "";
	$imagename = "";
	$targetpath = "";
	$targetfldr = "";
	$icondir = "/icon/";
	$html_root = "/var/www/html";
	if (isset($_REQUEST['image'])) {
		$image = str_replace('file://', '', $_REQUEST['image']);
		$image_copy = $html_root.$image;
		$imagename = basename($image);
		$targetpath = str_replace('file://', '', $_REQUEST['basedirimg'].$icondir.$imagename);
		$targetfldr = str_replace('file://', '', dirname($_REQUEST['basedirimg'])."/".$imagename);
	}
	if (isset($_REQUEST['makeicon'])) {
		if ($_REQUEST['makeicon'] == "true") {			
			$icondirpath = $_REQUEST['basedirimg'].$icondir;
			$icondirpath = str_replace('file://', '', $icondirpath);
			if (!file_exists($icondirpath)) {
			    mkdir($icondirpath);
			}
			copy($image_copy, $targetpath);
			echo "<script>window.close();</script>";
		}
	}
	if (isset($_REQUEST['copyimg'])) {
		if ($_REQUEST['copyimg'] == "true") {
			//echo $image_copy;
			//echo "<br>".$targetfldr;
			//exit;
			copy($image_copy, $targetfldr);
			echo "<script>window.close();</script>";
		}
	}
	
	echo "<img src='$image' id='image' class='responsive-image'>";
?>
</center>
<form name='setdir' action='mediagallery.php' method = "POST">
<!-- input type="submit" value="back" style="position:absolute;top:0px;left:0px;font-size:28px" /-->
<input type="hidden" name="basedir" id="basedir" value=<?php echo "'".$_REQUEST['basedirimg']."'" ?>>
</form>
<input type="button" value=" x " class="closebutton" onclick="javascript:closewindow()" />
<input type="button" value=" + " class="zoomin" onclick="javascript:zoomin()" />
<input type="button" value=" - " class="zoomout" onclick="javascript:zoomout()" />
</body>
</html>