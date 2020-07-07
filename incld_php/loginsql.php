<?php
	// Check connection
	
	$con = mysql_connect("localhost","username","password");
	if (!$con) { 
		die('Could not connect.'); 
	} 

	mysql_select_db("JobPool");
?>