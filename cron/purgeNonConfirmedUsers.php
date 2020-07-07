<?php
	$con = mysql_connect("localhost","viking12","r3dBu12!");
	if (!$con) { 
		die('Could not connect.'); 
	} 

	mysql_select_db("JobPool");
	$sql = ("DELETE FROM Workers WHERE postingDate < DATE_SUB(NOW(), INTERVAL 2 DAY) AND confirmed = 'no';");
	mysql_query($sql) or die(".");
	
	$sql = ("DELETE FROM Employers WHERE postingDate < DATE_SUB(NOW(), INTERVAL 2 DAY) AND confirmed = 'no';");
	mysql_query($sql) or die(".");
	mysql_close($con); 
?>