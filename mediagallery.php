<html>
<head>
<?php
	include ("dbaccess.php");

	// logout
	if (isset($_GET['logout'])) {
		if ($_GET['logout'] == 'true') {
			$_SESSION["code"] = '';
		}
	}
?>

<?php 
	$origdir = 'file:///var/www/html/general/medialink/medialink2';  
	$extpattern = '/.*[.][a-zA-Z0-9]+/s';
	$imgpattern = '/.*[.](jpg|png|gif|jpeg|tif|webp)+/s';
	$vidpattern = '/.*[.](mp4|avi|mpg|mpeg|mov|webm|flv|wmv)+/s';
	$vidpattern2 = '/(.*)[.](mp4|avi|mpg|mpeg|mov|webm|flv|wmv)+/s';
	$codedb = '';
	$filelist = array();

	if (isset($_REQUEST['basedir'])) {
		$_SESSION['basedir'] = $_REQUEST['basedir'];
	}
	if (isset($_REQUEST['prevdir'])) {
		$_SESSION['prevdir'] = $_REQUEST['prevdir'];
	}
?>	
<style>
	body {background-color: black;}

	/* icon settings */
	.icon {
		position:relative;
		float:left;
		width: auto;  
		height: 250px;
		/* reduce icon quality for fast processing */
		image-resolution: 10dpi; 
	}
	.navbar {
		position:absolute;
		left:42%;
		z-index: 10;
		position: fixed;
	}
	.navicon {
		width:70px;
		height:70px;
		opacity: 0.5;		
	}
	.foldericon {
		position:relative;
		float:left;
		width: auto;  
		height: 250px;
		background-color: darkgrey;
		word-wrap: break-word;
		font-size: 26px;
		line-height: 250px;
	}
	.videoicon {
		position:relative;
		float:left;
		width: auto;  
		height: 246px;
		background-color: darkgrey;
		word-wrap: break-word;
		border:2px solid lightblue;
	}
</style>
<script>
	function subform(link) {
		document.getElementById("basedir").value = link;
		document.getElementById("prevdir").value = <?php echo "'".$_SESSION['basedir']."'" ?>;
		document.forms["setdir"].submit();
	}
	function viewimg(link) {
		document.getElementById("image").value = link;
		document.getElementById("basedirimg").value = <?php echo "'".$_SESSION['basedir']."'" ?>;
		document.forms["setimg"].submit();
	}
	function viewvid(link) {
		document.getElementById("video").value = link;
		document.getElementById("basedirvid").value = <?php echo "'".$_SESSION['basedir']."'" ?>;
		document.forms["setvid"].submit();
	}
</script>
</head>
<body>
<?php
	// process login
	if (isset($_POST['code'])) {
		$_SESSION["code"] = $_POST['code'];
	}
	$query = "SELECT DISTINCT code FROM access";	
	$rs = mysqli_query($GLOBALS['conn'],$query);
	while(list($code) = mysqli_fetch_row($rs))		
	{	
		$codedb = $code;
	}
	if ($_SESSION["code"] != $codedb) { 
		echo "
		<form name='setcode' action='mediagallery.php' method='POST'>
		<center>
		<br><br><input textarea name='code' id='code' style='font-size:28px'></input>
		<input type='submit' value='go' style='font-size:28px' />
		</center>
		</form>";		
		exit;
	}
	// collect files
	if (isset($_REQUEST["basedir"])) {
		$basedir = $_REQUEST["basedir"];
	}
	else {
		$basedir = $origdir;
	}
	// display back and home links
	$updir = preg_replace('/(.*)\/.*$/', '$1', $basedir);
	// do not go past home directory
	if ($updir == preg_replace('/(.*)\/.*$/', '$1', $origdir)) {
		$updir = $origdir;
	}
	// navigation bar
	echo "<span class='navbar'>";
	echo "<a href='javascript:subform(\"".$_SESSION['prevdir']."\")'><img src='media/back.jpg' class='navicon' /></a>";	
	echo "<a href='javascript:subform(\"$updir\")'><img src='media/up.jpg' class='navicon' /></a>";
	echo "<a href='javascript:subform(\"$origdir\")'><img src='media/home.jpg' class='navicon' /></a>";
	echo "</span>";
	// sort	
	if ($handle = opendir($basedir)) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				array_push($filelist, $entry);
			}
		}
	    closedir($handle);
	}
	sort($filelist);
	function foldericon($link, $imgpattern) {
		/*
			Try to find icon first in icon directory. Then with
			any image in the folder.
		*/
		$foldericon = "<span class='foldericon'>$link</span>";

		$icondir = $_SESSION['basedir']."/"."$link/icon/";
		$picdir = $_SESSION['basedir']."/"."$link/";
		//echo $icondir."<br>";
		$iconlist = array();
		if ($handle = opendir($icondir)) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != ".." && preg_match($imgpattern, $entry)) {
					array_push($iconlist, $entry);
				}
			}
		    closedir($handle);
		}
		if ($iconlist[0] != "") {
			$icon = $icondir."/".$iconlist[0];
			$icon2 = str_replace('file://', '', "$icon");			
			$icon3 = str_replace('/var/www/html', '', "$icon2");
			$foldericon = "<img src='$icon3' class='foldericon' />";
		}
		else {
			$piclist = array();
			if ($handle = opendir($picdir)) {
				while (false !== ($entry = readdir($handle))) {
					if ($entry != "." && $entry != ".." && preg_match($imgpattern, $entry)) {
						array_push($piclist, $entry);
					}
				}
			    closedir($handle);
			}
			if ($piclist[0] != "") {
				$icon = $picdir."/".$piclist[0];
				$icon2 = str_replace('file://', '', "$icon");			
				$icon3 = str_replace('/var/www/html', '', "$icon2");
				$foldericon = "<img src='$icon3' class='foldericon' />";
			}
		}

		return $foldericon;
	}
	function videoicon($link, $vidpattern2) {
		$videoicon = "<span class='videoicon'>$link</span>";
		$link_noext = preg_replace($vidpattern2, '$1', $link);

		$icondir = $_SESSION['basedir']."/icon/videos/";
		$iconpath = $icondir.$link_noext."_thumb.jpg";
		if (file_exists($iconpath)) {			
			$icon2 = str_replace('file://', '', "$iconpath");			
			$icon3 = str_replace('/var/www/html', '', "$icon2");
			$videoicon = "<img src='$icon3' class='videoicon' />";
		}

		return $videoicon;
	}
?>
<!-- directories -->
<form name='setdir' action='mediagallery.php' method = "POST">
<input type="hidden" name="basedir" id="basedir">
<input type="hidden" name="prevdir" id="prevdir">
<?php
	foreach ($filelist as $entry) {
		if (!preg_match($extpattern, $entry)) {
			echo "<a href='javascript:subform(\"$basedir/$entry\")'>".foldericon("$entry", $imgpattern)."</a>";
		}
	}
?>
</form>
<!-- images -->
<form name='setimg' action='imageviewer.php' method = "POST" target="_blank">
<input type="hidden" name="image" id="image">
<input type="hidden" name="basedirimg" id="basedirimg">
<?php
	foreach ($filelist as $entry) {
		if (preg_match($imgpattern, $entry)) {
			$basedir2 = str_replace('/var/www/html', '', $basedir);
			$image = str_replace('file://', '', "$basedir2/$entry");
            echo "<a href='javascript:viewimg(\"$basedir2/$entry\")'><img src='$image' class='icon' /></a>";
		}
	}
?>
</form>
<!-- videos -->
<form name='setvid' action='videoviewer.php' method = "POST" target="_blank">
<input type="hidden" name="video" id="video">
<input type="hidden" name="basedirvid" id="basedirvid">
<?php
	foreach ($filelist as $entry) {
		if (preg_match($vidpattern, $entry)) {
        	$basedir2 = str_replace('/var/www/html', '', $basedir);
        	echo "<a href='javascript:viewvid(\"$basedir2/$entry\")'>".videoicon("$entry", $vidpattern2)."</a>";
		}
	}
?>
</form>