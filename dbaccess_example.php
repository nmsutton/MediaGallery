<?php
	session_start();
	/* db access */
	$conn= NULL;
	$servername = "localhost";
	$username = "";
	$password = "";
	$database = "mediagallery";
	$codesession = '';
	$codedb = '';
	// Create connection
	if(is_null($conn)){
		$conn = mysqli_connect($servername, $username, $password, $database);   
	}
	if(!$conn)
	{
	  die("Connection failed: " . mysqli_connect_error());
	}
?>