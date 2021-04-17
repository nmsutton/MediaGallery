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
		height:15%;
		width:15%;
		opacity: 0.5;
	}
	.closebutton {
		position:absolute;position:fixed;top:0px;right:0px;font-size:36px;
	}	
	.fullscreenbutton {
		position:absolute;position:fixed;top:25%;right:0px;font-size:36px;
	}
	.playbutton {
		position:absolute;position:fixed;top:50%;right:0px;font-size:36px;
	}
	.mutebutton {
		position:absolute;position:fixed;top:75%;right:0px;font-size:36px;
	}
	.filenamearea {
		position:relative;
		background-color: black;
		color: #3a4472;
		font-size: 36px;
		font-family: arial;
		width:800px;
		height:200px;
		word-wrap: break-word;
		overflow-wrap: break-word;
		border: 0px rgb(55,55,55) solid;
	}
	a:link {color: #3a4472;}  
	a:visited {color: #3a4472}  
	a:hover {color: #3a4472}  
	a:active {color: #3a4472}  
</style>
<script>
	function closewindow() {
		window.close();
	}
	function fullscreenwindow() {
		document.getElementById("video").requestFullscreen();
	}
	function muteaudio() {
		document.getElementById("video").prop('muted', true);
	}
	function playvideo() {
		var video = document.getElementById('video');
		video.play();
	}
</script>
</head>
<body>
<center>
<?php
	function findext($link) {
		$vidext = '/.*[.](mp4|avi|mpg|mpeg|mov|webm|flv|wmv|ogv)+/s';
		$linkext = preg_replace($vidext, '$1', $link);
		if ($linkext == "mpg" || $linkext == "mpeg") {
			echo " type='video/mpeg'";
		}
		else if ($linkext == "webm") {
			echo " type='video/webm'";
		}
		else if ($linkext == "ogv") {
			echo " type='video/ogg'";
		}
	}
	if (isset($_REQUEST['video'])) {
		$video = str_replace('file://', '', $_REQUEST['video']);
		echo "<video controls autoplay loop muted controlsList='nodownload' width='640' height='360' id='video'"; 
		findext($video);
		echo ">
			<source src='$video'>
		</video>";
		echo "<br><br><center><div class='filenamearea'><a href='$video'>$video</a></div></center>";
	}
?>
</center>
<form name='setdir' action='mediagallery.php' method = "POST">
<!--input type="submit" value="back" style="position:absolute;top:0px;left:0px;font-size:28px" /-->
<input type="hidden" name="basedir" id="basedir" value=<?php echo "'".$_REQUEST['basedirvid']."'" ?>>
</form>
<input type="button" value=" x " class="closebutton" onclick="javascript:closewindow()" />
<input type="button" value=" o " class="fullscreenbutton" onclick="javascript:fullscreenwindow()" />
<input type="button" value=" p " class="playbutton" onclick="javascript:playvideo()" />
<input type="button" value=" m " class="mutebutton" onclick="javascript:muteaudio()" />
<script>
	muteaudio();
	fullscreenwindow();

	var video = document.getElementById('video');
	video.addEventListener('click',function(){
	  video.play();
	},false);
</script>
</body>
</html>