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
		position:absolute;position:fixed;top:20%;right:0px;font-size:36px;
	}
	.zoomout {
		position:absolute;position:fixed;top:40%;right:0px;font-size:36px;
	}	
	.nextimg {
		position:absolute;position:fixed;top:55%;left:0px;font-size:36px;
	}	
	.previmg {
		position:absolute;position:fixed;top:40%;left:0px;font-size:36px;
	}		
	.linkpos {
		position:absolute;position:fixed;top:60%;right:3%;font-size:36px;
		width:10%;height:15%;
	}
	.menushow2 {
		position:absolute;position:fixed;top:80%;right:0px;font-size:36px;
	}
	.menushow {
		position:absolute;position:fixed;top:90%;right:0px;font-size:36px;
	}		
	.hiddenelement {
		display: none;
	}
	.menuitem {
		/*display: none;*/
	}
	.menuitem2 {
		/*display: visible;*/
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
	function viewimg(link) {
		document.getElementById("image").value = link;
		document.forms["setlink"].action = "imageviewer.php";
		document.forms["setlink"].target = "_self";
		document.forms["setlink"].submit();
	}
	function togglemenu() {
		var labels = document.getElementsByClassName("menuitem");
		for(var i = 0; i < labels.length; i++)
		{
		    labels[i].classList.toggle('hiddenelement');
		}		
	}
	function togglemenu2() {
		var labels = document.getElementsByClassName("menuitem2");
		for(var i = 0; i < labels.length; i++)
		{
		    labels[i].classList.toggle('hiddenelement');
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
	/*if (isset($_REQUEST['menustate'])) {
		$_REQUEST['menustate'] = "false";
	}
	else {
		$_REQUEST['menustate'] = "false";
	}*/
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
	function menustate() {
		$state = "";
		if (isset($_REQUEST['menustate'])) {
			if ($_REQUEST['menustate']=='true') {
				$state = " hiddenelement";
			}
		}
		else {
			$state = " hiddenelement";
		}
		return $state;
	}
	function menustate2() {
		$state = "";
		if (isset($_REQUEST['menustate2'])) {
			if ($_REQUEST['menustate2']=='true') {
				//$state = " hiddenelement";
			}
		}
		else {
			//$state = " hiddenelement";
		}
		return $state;
	}
	
echo "<img src='$image' id='imagedisplay' class='responsive-image'>";

echo "<form name='setlink' id='setlink' action='imageviewer.php' method = 'POST' target='_self'>
<input type='hidden' name='image' id='image' value='".$image."'>
<input type='hidden' name='basedirimg' id='basedirimg' value='".$_REQUEST['basedirimg']."'>";

echo "<input type='hidden' name='menustate' id='menustate' value=";
if (isset($_REQUEST['menustate'])) {echo '"'.$_REQUEST['menustate'].'"';}
else{echo '"true"';}
echo ">";
echo "<input type='hidden' name='menustate2' id='menustate2' value=";
if (isset($_REQUEST['menustate2'])) {echo '"'.$_REQUEST['menustate2'].'"';}
else{echo '"false"';}
echo ">";

$imagelist = $_REQUEST['imagelist'];
foreach ($imagelist as $entry) {
	echo "<input type=\"hidden\" name=\"imagelist[]\" value=\"".$entry."\"/>";
}
$imgindex = array_search($image, $imagelist);
$images_count = count($imagelist);
$nextimg = $imagelist[($imgindex+1)];
$previmg = $imagelist[($imgindex-1)];
// wrap around
if (($imgindex+1) > ($images_count-1)) {
	$nextimg = $imagelist[0];
}
if (($imgindex-1) < 0) {
	$previmg = $imagelist[($images_count-1)];
}

echo "</form>";
?>
</center>
<form name='setdir' action='mediagallery.php' method = "POST">
<!-- input type="submit" value="back" style="position:absolute;top:0px;left:0px;font-size:28px" /-->
<input type="hidden" name="basedir" id="basedir" value=<?php echo "'".$_REQUEST['basedirimg']."'" ?>>
</form>
<input type="button" value=" x " class="closebutton menuitem2 <?php echo menustate2() ?>" onclick="javascript:closewindow()" />
<input type="button" value=" + " class="zoomin hiddenelement menuitem <?php echo menustate() ?>" onclick="javascript:zoomin()" />
<input type="button" value=" - " class="zoomout hiddenelement menuitem <?php echo menustate() ?>" onclick="javascript:zoomout()" />
<input type="button" value=" > " class="nextimg menuitem2 <?php echo menustate2() ?>" onclick="javascript:viewimg('<?php echo $nextimg ?>')" />
<input type="button" value=" < " class="previmg menuitem2 <?php echo menustate2() ?>" onclick="javascript:viewimg('<?php echo $previmg ?>')" />
<input type="button" value="[=]" class="menushow2 hiddenelement menuitem <?php echo menustate() ?>" onclick="javascript:togglemenu2()" />
<input type="button" value="[=]" class="menushow" onclick="javascript:togglemenu()" />
<a href="<?php echo $image ?>"><img class="linkpos hiddenelement menuitem <?php echo menustate() ?>" src="media/folderlink.jpg"></a>
</body>
</html>