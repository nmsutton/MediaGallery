<html>
<head>
<?php 
	$origdir = 'file:///var/www/html/general/medialink/basedir'; 
	$extpattern = '/.*[.][a-zA-Z0-9]+/s';
	$imgpattern = '/.*[.](jpg|png|gif|jpeg|tif|webp)+/s';
	$vidpattern = '/.*[.](mp4|avi|mpg|mpeg|mov|webm|flv|wmv)+/s';
?>	
<script>
	function goback() {
		window.history.go(-1); 
		return false;
	}	
	function subform(link) {
		document.getElementById("basedir").value = link;
		document.forms["setdir"].submit();
	}
	function viewimg(link) {
		document.getElementById("image").value = link;
		document.forms["setimg"].submit();
	}
	function viewvid(link) {
		document.getElementById("video").value = link;
		document.forms["setvid"].submit();
	}
</script>
</head>
<body>
<?php
	echo "<a href='javascript:goback()'>back</a><br>";
	echo "<a href='javascript:subform(\"$origdir\")'>home</a><br>";
	if (isset($_REQUEST["basedir"])) {
		$basedir = $_REQUEST["basedir"];
	}
	else {
		$basedir = $origdir;
	}
?>
<form name='setdir' action='mediagallery.php' method = "POST">
<input type="hidden" name="basedir" id="basedir">
<?php
	/* directories */
	if ($handle = opendir($basedir)) {
	    while (false !== ($entry = readdir($handle))) {
	        if ($entry != "." && $entry != ".." && !preg_match($extpattern, $entry)) {
            	echo "<a href='javascript:subform(\"$basedir/$entry\")'>$entry</a><br>";
	        }
	    }
	    closedir($handle);
	}
?>
</form>
<form name='setimg' action='imageviewer.php' method = "POST">
<input type="hidden" name="image" id="image">
<?php
	/* images */
	if ($handle = opendir($basedir)) {
	    while (false !== ($entry = readdir($handle))) {
	        if ($entry != "." && $entry != ".." && preg_match($imgpattern, $entry)) {
	        	$basedir2 = str_replace('/var/www/html', '', $basedir);
            	echo "<a href='javascript:viewimg(\"$basedir2/$entry\")'>$entry</a><br>";
	        }
	    }
	    closedir($handle);
	}
?>
</form>
<form name='setvid' action='videoviewer.php' method = "POST">
<input type="hidden" name="video" id="video">
<?php
	/* videos */
	if ($handle = opendir($basedir)) {
	    while (false !== ($entry = readdir($handle))) {
	        if ($entry != "." && $entry != ".." && preg_match($vidpattern, $entry)) {
	        	$basedir2 = str_replace('/var/www/html', '', $basedir);
            	echo "<a href='javascript:viewvid(\"$basedir2/$entry\")'>$entry</a><br>";
	        }
	    }
	    closedir($handle);
	}
?>
</form>