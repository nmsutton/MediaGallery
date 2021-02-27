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
	echo "<a href='javascript:subform(\"".$_SESSION['prevdir']."\")'><img src='media/back.jpg' style='position:absolute;top:0px;left:45%;width:50px;height:50px;' /></a><br>";	
	echo "<a href='javascript:subform(\"$updir\")'><img src='media/up.jpg' style='position:absolute;top:0px;left:50%;width:50px;height:50px;' /></a><br>";
	echo "<a href='javascript:subform(\"$origdir\")'><img src='media/home.jpg' style='position:absolute;top:0px;left:55%;width:50px;height:50px;' /></a><br>";
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
?>
<!-- directories -->
<form name='setdir' action='mediagallery.php' method = "POST">
<input type="hidden" name="basedir" id="basedir">
<input type="hidden" name="prevdir" id="prevdir">
<?php
	foreach ($filelist as $entry) {
		if (!preg_match($extpattern, $entry)) {
			echo "<a href='javascript:subform(\"$basedir/$entry\")'>$entry</a><br>";
		}
	}
?>
</form>
<!-- images -->
<form name='setimg' action='imageviewer.php' method = "POST">
<input type="hidden" name="image" id="image">
<input type="hidden" name="basedirimg" id="basedirimg">
<?php
	foreach ($filelist as $entry) {
		if (preg_match($imgpattern, $entry)) {
			$basedir2 = str_replace('/var/www/html', '', $basedir);
            echo "<a href='javascript:viewimg(\"$basedir2/$entry\")'>$entry</a><br>";
		}
	}
?>
</form>
<!-- videos -->
<form name='setvid' action='videoviewer.php' method = "POST">
<input type="hidden" name="video" id="video">
<input type="hidden" name="basedirvid" id="basedirvid">
<?php
	foreach ($filelist as $entry) {
		if (preg_match($vidpattern, $entry)) {
        	$basedir2 = str_replace('/var/www/html', '', $basedir);
        	echo "<a href='javascript:viewvid(\"$basedir2/$entry\")'>$entry</a><br>";
		}
	}
?>
</form>