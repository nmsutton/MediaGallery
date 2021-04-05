<html>
<!--
	References: https://www.plus2net.com/javascript_tutorial/clock.php
	https://stackoverflow.com/questions/10556879/changing-the-1-24-hour-to-1-12-hour-for-the-gethours-method
-->
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
	$origdir = 'file:///var/www/html/general/medialink/medialink';  
	$specialicons = '/var/www/html/general/medialink/special_icons.php';
	$extpattern = '/.*[.][a-zA-Z0-9]+$/s';
	$imgpattern = '/.*[.](jpg|png|gif|jpeg|tif|webp)+$/s';
	$vidpattern = '/.*[.](mp4|avi|mpg|mpeg|mov|webm|flv|wmv|f4v)+$/s';
	$vidpattern2 = '/(.*)[.](mp4|avi|mpg|mpeg|mov|webm|flv|wmv|f4v)+$/s';
	$zippattern = '/.*[.](zip)+$/s';
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
	body {
		background-color: black;
		color: #3a4472;
		font-size: 36px;
		font-family: arial;
		word-wrap: break-word;
		overflow-wrap: break-word;
	}
	textarea {
		background-color: black;
		color: #3a4472;
		font-size: 36px;
		font-family: arial;
		overflow:hidden;
		border: 3px rgb(55,55,55) solid;
		word-wrap: break-word;
	}
	input[type='button'] {
		background-color: rgb(25,25,25);
		color: #3a4472;
		font-size: 36px;
		font-family: arial;
		border: 3px rgb(55,55,55) solid;
		word-wrap: break-word;
		width:10%;
		height:16%;
	}
	input[type=submit] {
		padding: 2px 4px;
		background-color: rgb(25,25,25);
		color: #3a4472;
		font-size: 20px;
		font-family: arial;
		border: 3px rgb(55,55,55) solid;
	}
	/* icon settings */
	.icon {
		position:relative;
		display:inline-block;
		width: auto;  
		height: 250px;
		min-width: 100px;
		/* reduce icon quality for fast processing */
		image-resolution: 10dpi; 
		word-wrap: break-word;
		/*max-width: 400px;*/
		overflow-wrap: break-word;
	}
	.navbar {
		position:absolute;
		left:42%;
		z-index: 10;
		position: fixed;
	}
	.navicon {
		/*width:70px;
		height:70px;*/
		width:10%;
		height:16%;
		opacity: 0.95;		
	}
	@media screen and (max-width: 1400px) {
		.upbuttoncenter {
			position:absolute;
			left:47%;
			bottom:0px;
			width:15%;
			height:14%;
			opacity: 0.75;		
			z-index: 10;
			position: fixed;
		}
	}
	@media screen and (max-width: 1920px) {
		.upbuttoncenter {
			position:absolute;
			left:47%;
			bottom:0px;
			width:7%;
			height:14%;
			opacity: 0.75;		
			z-index: 10;
			position: fixed;
		}
	}	
	.foldercontainer {
		position:relative;
		display:inline-block;
		width: auto;  	
		height: 246px;
		max-width: 600px;
		min-width: 100px;
		background-color: black;
		word-wrap: break-word;
		overflow-wrap: break-word;
		font-size: 26px;
		text-align: center;
	}
	.foldercontainernoicon {
		position:relative;
		display:inline-block;
		width: auto;  	
		height: 216px;
		background-color: black;
		word-wrap: break-word;
		overflow-wrap: break-word;
		font-size: 26px;
		text-align: center;
	}
	.foldericon {
		position:relative;
		display:inline-block;
		width: auto;  
		height: 246px;
		max-width: 600px;
		min-width: 100px;
		background-color: black;
		word-wrap: break-word;
		overflow-wrap: break-word;
		font-size: 26px;
		/*line-height: 250px;*/
		border:2px solid darkgrey;
		text-align:center;
	}
	.foldericongeneric {
		position:relative;
		width: 160px;  
		height: 220px;
		background-color: black;
		word-wrap: break-word;
		overflow-wrap: break-word;
		font-size: 26px;
		/*border:2px solid darkgrey;*/
		text-align:center;
	}
	.foldertext {
		/*width: auto !important; 
		height: 228px !important;*/
		/*padding: 9px;*/
	}
	.videoicon {
		position:relative;
		display:inline-block;
		width: auto;  
		height: 246px;
		min-width: 100px;
		background-color: black;
		word-wrap: break-word;
		overflow-wrap: break-word;
		border:2px solid lightblue;
		max-width: 400px;
	}
	.zipicon {
		position:relative;
		display:inline-block;
		width: auto;  
		/*height: 246px;
		min-width: 100px;*/
		background-color: black;
		word-wrap: break-word;
		overflow-wrap: break-word;
		/*border:2px solid lightblue;*/
		font-size: 16px;
		max-width: 150px;
	}
	.backbutton {
		position:absolute;position:fixed;top:0%;right:0px;font-size:36px;opacity:0.95;z-index:10;
	}
	.closebutton {
		position:absolute;position:fixed;top:20%;right:0px;font-size:36px;opacity:0.95;z-index:10;
	}	
	.newtabbutton {
		position:absolute;position:fixed;top:40%;right:0px;font-size:36px;opacity:0.95;z-index:10;
	}	
	.labelsbutton {
		position:absolute;position:fixed;top:60%;right:0px;font-size:36px;opacity:0.95;z-index:10;
	}
	.menubutton {
		position:absolute;position:fixed;bottom:0%;right:0px;font-size:36px;opacity:0.95;z-index:10;
	}
	.homebutton {
		position:absolute;position:fixed;top:0%;right:10%;font-size:36px;opacity:0.95;z-index:10;
	}
	.statebutton {
		position:absolute;position:fixed;top:20%;right:10%;font-size:36px;opacity:0.95;z-index:10;
	}	
	.makeiconbutton {
		position:absolute;position:fixed;top:40%;right:10%;font-size:36px;opacity:0.95;z-index:10;
	}
	.copyimgbutton {
		position:absolute;position:fixed;top:60%;right:10%;font-size:36px;opacity:0.95;z-index:10;
	}
	.reloadbutton {
		position:absolute;position:fixed;bottom:0%;right:10%;font-size:36px;opacity:0.95;z-index:10;
	}
	.folderlinkbutton {
		position:absolute;position:fixed;bottom:0%;right:20%;font-size:36px;opacity:0.95;z-index:10;
	}
	.labelarea {
		position:relative;
		bottom:40px;
		z-index:5;
		background-color:rgba(0, 0, 0, 0.5);
		color:#3391ff;
	}
	.labelareanonhidden {
		position:relative;
		bottom:10px;
		z-index:5;
		background-color:rgba(0, 0, 0, 0.5);
		color:#3391ff;
	}
	.hiddenelement {
		display: none;
	}
	.shiftup {
		position:relative;
		bottom:30px;
	}
	.clock {
		position:absolute;
		position:fixed;
		bottom:16%;
		right:2.6%;
		font-size:24px;
		opacity:0.95;
		z-index:20;
		background-color:rgba(0, 0, 0, 0.75);
		padding:7px;
	}
	a { color: #3391ff; }
</style>
<script>
	function subform(link) {
		document.getElementById("basedir").value = link;
		document.getElementById("prevdir").value = <?php echo "'".$_SESSION['basedir']."'" ?>;
		document.forms["setlink"].action = "mediagallery.php";
		document.forms["setlink"].submit();
	}
	function viewimg(link) {
		document.getElementById("image").value = link;
		document.getElementById("basedirimg").value = <?php echo "'".$_SESSION['basedir']."'" ?>;
		document.forms["setlink"].action = "imageviewer.php";
		document.forms["setlink"].target = "_blank";
		//document.forms["setimg"].submit();
		document.forms["setlink"].submit();
		document.forms["setlink"].target = <?php
			if (isset($_REQUEST['newtab'])) {
				if ($_REQUEST['newtab'] == "false") {
					echo "\"_self\";";
				}
				else {
					echo "\"_blank\";";
				}
			}
			else{echo "\"_self\";";}
		?> 
	}
	function viewvid(link) {
		document.getElementById("video").value = link;
		document.getElementById("basedirvid").value = <?php echo "'".$_SESSION['basedir']."'" ?>;
		document.forms["setlink"].action = "videoviewer.php";
		document.forms["setlink"].target = "_blank";
		//document.forms["setvid"].submit();
		document.forms["setlink"].submit();
		document.forms["setlink"].target = <?php
			if (isset($_REQUEST['newtab'])) {
				if ($_REQUEST['newtab'] == "false") {
					echo "\"_self\";";
				}
				else {
					echo "\"_blank\";";
				}
			}
			else{echo "\"_self\";";}
		?> 
	}
	function closewindow() {
		window.close();
	}	
	function newtab() {
		if (document.getElementById("setlink").target == "_self") {
			document.getElementById("setlink").target = "_blank";	
			document.getElementById("newtabbutton").value = "[x]";
			document.getElementById("newtab").value = "true";
		}		
		else {
			document.getElementById("setlink").target = "_self";
			document.getElementById("newtabbutton").value = "[_]";
			document.getElementById("newtab").value = "false";
		}
		togglemenu();
	}
	function togglelabels() {
		var labels = document.getElementsByClassName("labelarea");
		for(var i = 0; i < labels.length; i++)
		{
		    labels[i].classList.toggle('hiddenelement');
		}
		if (document.getElementById("labelvisibility").value == "true") {
			document.getElementById("labelvisibility").value = "false";
		}
		else {
			document.getElementById("labelvisibility").value = "true";
		}
		togglemenu();
		shiftlabels();
	}
	function togglemenu() {
		var labels = document.getElementsByClassName("menuitem");
		for(var i = 0; i < labels.length; i++)
		{
		    labels[i].classList.toggle('hiddenelement');
		}		
	}
	function togglestate() {		
		if (document.getElementById("menustate").value == "true") {
			document.getElementById("menustate").value = "false";
		}
		else {
			document.getElementById("menustate").value = "true";
		}
		togglemenu();
	}
	function makeicontoggle() {
		if (document.getElementById("makeicon").value == "true") {
			document.getElementById("makeicon").value = "false";
			document.getElementById("makeiconbutton").value = " i ";
		}
		else {
			document.getElementById("makeicon").value = "true";
			document.getElementById("makeiconbutton").value = "[i]";
		}
		togglemenu();
	}
	function copyimgtoggle() {
		if (document.getElementById("copyimg").value == "true") {
			document.getElementById("copyimg").value = "false";
			document.getElementById("copyimgbutton").value = " c ";
		}
		else {
			document.getElementById("copyimg").value = "true";
			document.getElementById("copyimgbutton").value = "[c]";
		}
		togglemenu();
	}
	function reload() {
		location.reload();
	}
	function shiftlabels() {
		var genlabels = document.getElementsByClassName("genlabel");
		if (document.getElementById("labelvisibility").value == "true") {
			for(var i = 0; i < genlabels.length; i++)
			{
			    genlabels[i].classList.add('shiftup');
			}
		}
		else {
			for(var i = 0; i < genlabels.length; i++)
			{
			    genlabels[i].classList.remove('shiftup');
			}
		}
	}
</script>
<script type="text/javascript"> 
	function hours12(date) { return (date.getHours() + 24) % 12 || 12; }
	function display_c(){
	var refresh=1000; // Refresh rate in milli seconds
	mytime=setTimeout('display_ct()',refresh)
	}

	function display_ct() {
	var x = new Date()
	var h12 = (x.getHours() + 24) % 12 || 12
	var x2 = h12 + ":" + x.getMinutes()
	document.getElementById('ct').innerHTML = x2;
	display_c();
	 }
</script>
<?php
		copy('file:///var/www/html/general/medialink/medialink/0_Pornsites/AMKingdom/marianna/marianna_all_3/mar316VOO_209603039.jpg', 'file:///var/www/html/general/medialink/medialink/0_Pornsites/AMKingdom/marianna/mar316VOO_209603039.jpg');
		?>
</head>
<body onload=display_ct();>
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
		<br><br><input textarea name='code' id='code' style='font-size:52px;background-color:black;color: #3a4472;'></input>
		<input type='submit' value='go' style='font-size:49px' />
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
	$folderlink = preg_replace('/file\:\/\/(.*)$/', '$1/', $basedir);
	//$folderlink = preg_replace('(.*)$/', '/var/$1/', $folderlink);
	//$folderlink = preg_replace('/(.*)$/', '$1/', $basedir);
	// navigation bar
	echo "<a href='javascript:subform(\"".$_SESSION['prevdir']."\")'><img src='media/back.jpg' class='navicon backbutton menuitem".menustate()."' /></a>";	
	echo "<a href='javascript:subform(\"$updir\")'><img src='media/up.jpg' class='upbuttoncenter' /></a>";
	echo "<a href='javascript:subform(\"$origdir\")'><img src='media/home.jpg' class='navicon homebutton menuitem".menustate()."' /></a>";
	echo "<a href='$folderlink'><img src='media/folderlink.jpg' class='navicon folderlinkbutton menuitem".menustate()."' /></a>";
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
	function foldericon($link, $imgpattern, $specialicons) {
		/*
			Try to find icon first in icon directory. Then with
			any image in the folder.
		*/
		$foldericon = "<span class='foldercontainernoicon genlabel'><img src='media/folder.jpg' class='foldericongeneric' /><span class='labelareanonhidden'><br>".substr($link, 0, 10)."</span></span>";
		$icondir = $_SESSION['basedir']."/"."$link/icon/";
		$picdir = $_SESSION['basedir']."/"."$link/";
		$sipresent = false;
		$updateicon = false;
		if (file_exists($specialicons)) {include ($specialicons);$sipresent=true;}
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
			// icon folder found
			$icon = $icondir."/".$iconlist[0];
			$icon2 = str_replace('file://', '', "$icon");			
			$icon3 = str_replace('/var/www/html', '', "$icon2");
			$updateicon = true;
		}
		else if ($sipresent==true && $siconsdict[$link] != "") {
			// special icons
			$icon3 = $siconsdict[$link];
			
			$updateicon = true;
		}
		else {
			// any image in folder for icon
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
				$updateicon = true;
			}
		}
		if ($updateicon) {
			$foldericon = "<span class='foldercontainer'><img src='$icon3' class='foldericon' /><span class='labelarea";
			if (isset($_REQUEST['labelvisibility'])) {
				if ($_REQUEST['labelvisibility']=='false') {
					$foldericon = $foldericon." hiddenelement";
				}
			}
			else {
				$foldericon = $foldericon." hiddenelement";
			}
			$foldericon = $foldericon."'><br>".substr($link, 0, 10)."</span></span>";
			//$foldericon = $foldericon."'></span></span>";
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
	function zipicon($link, $zippattern) {
		$videoicon = "<span class='zipicon'>$link</span>";
		$link_noext = preg_replace($zippattern, '$1', $link);

		//$icondir = $_SESSION['basedir']."/icon/videos/";
		//$iconpath = $icondir.$link_noext."_thumb.jpg";
		if (file_exists($iconpath)) {			
			$icon2 = str_replace('file://', '', "$iconpath");			
			$icon3 = str_replace('/var/www/html', '', "$icon2");
			$videoicon = "<img src='media/zipfile.jpg' class='zipicon' />";
		}
		$videoicon = "<span class='zipicon'><img src='media/zipfile.jpg' class='zipicon' />$link</span>";

		return $videoicon;
	}
?>
<div class="clock" id='ct'>Clock</div>
<input type="button" value="|&#8801;|" class="menubutton" id="menubutton" onclick="javascript:togglemenu()" />
<input type="button" value=" x " class=<?php echo "\"closebutton menuitem".menustate()."\""; ?> onclick="javascript:closewindow()" />
<input type="button" value="[_]" class=<?php echo "\"newtabbutton menuitem".menustate()."\""; ?> id="newtabbutton" onclick="javascript:newtab()" />
<input type="button" value=" t " class=<?php echo "\"labelsbutton menuitem".menustate()."\""; ?> id="labelsbutton" onclick="javascript:togglelabels()" />
<input type="button" value="[&#8801;]" class=<?php echo "\"statebutton menuitem".menustate()."\""; ?> id="statebutton" onclick="javascript:togglestate()" />
<input type="button" value=" i " class=<?php echo "\"makeiconbutton menuitem".menustate()."\""; ?> id="makeiconbutton" onclick="javascript:makeicontoggle()" />
<input type="button" value=" c " class=<?php echo "\"copyimgbutton menuitem".menustate()."\""; ?> id="copyimgbutton" onclick="javascript:copyimgtoggle()" />
<input type="button" value=" r " class=<?php echo "\"reloadbutton menuitem".menustate()."\""; ?> id="reloadbutton" onclick="javascript:reload()" />
<form name='setlink' id='setlink' action='mediagallery.php' method = "POST" target="_self">
<input type="hidden" name="basedir" id="basedir">
<input type="hidden" name="prevdir" id="prevdir">
<input type="hidden" name="newtab" id="newtab" value=
<?php
if (isset($_REQUEST['newtab'])) {echo "\"".$_REQUEST['newtab']."\"";}
else{echo "\"false\"";}
?> 
>
<input type="hidden" name="labelvisibility" id="labelvisibility" value=
<?php
if (isset($_REQUEST['labelvisibility'])) {echo "\"".$_REQUEST['labelvisibility']."\"";}
else{echo "\"false\"";}
?> 
>
<input type="hidden" name="menustate" id="menustate" value=
<?php
if (isset($_REQUEST['menustate'])) {echo "\"".$_REQUEST['menustate']."\"";}
else{echo "\"false\"";}
?> 
>
<input type="hidden" name="makeicon" id="makeicon" value="false">
<input type="hidden" name="copyimg" id="copyimg" value="false">
<?php 
	if (isset($_REQUEST['newtab'])) {
		$ntval = $_REQUEST['newtab'];
		if ($ntval == "true") {
			echo "<script>
			document.getElementById('setlink').target = '_blank';	
			document.getElementById('newtabbutton').value = '[x]';
			</script>";
		}
		else if ($ntval == "false") {
			echo "<script>
			document.getElementById('setlink').target = '_self';	
			document.getElementById('newtabbutton').value = '[_]';
			</script>";
		}
	}
?>
<!-- directories -->
<center>
<?php
	foreach ($filelist as $entry) {
		if (!preg_match($extpattern, $entry)) {
			echo "<a href='javascript:subform(\"$basedir/$entry\")'>".foldericon("$entry", $imgpattern, $specialicons)."</a>";
		}
	}
?>
<!--/form-->
<!-- images -->
<!--form name='setimg' action='imageviewer.php' method = "POST" target="_blank"-->
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
<!--/form-->
<!-- videos -->
<!--form name='setvid' action='videoviewer.php' method = "POST" target="_blank"-->
<input type="hidden" name="video" id="video">
<input type="hidden" name="basedirvid" id="basedirvid">
<?php
	foreach ($filelist as $entry) {
		if (preg_match($vidpattern, $entry)) {
        	$basedir2 = str_replace('/var/www/html', '', $basedir);
        	echo "<a href='javascript:viewvid(\"$basedir2/$entry\")'>".videoicon("$entry", $vidpattern2)."</a>";
		}
	}
	if (isset($_REQUEST['labelvisibility'])) {
		echo "<script>shiftlabels();</script>";
	}
?>
<!-- zip files -->
<input type="hidden" name="zipfile" id="zipfile">
<?php
	foreach ($filelist as $entry) {
		if (preg_match($zippattern, $entry)) {
        	$basedir2 = str_replace('/var/www/html', '', $basedir);
        	//echo "<a href='$basedir2/$entry'>".zipicon("$entry", $zippattern)."</a>";
        	echo zipicon("$entry", $zippattern);
		}
	}
?>
</form>
</center>
</form>