<?php
	$con = mysql_connect("localhost","viking12","r3dBu12!");
	if (!$con) { 
		die('Could not connect.'); 
	} 

	mysql_select_db("JobPool");
	$sql = ("DELETE FROM Session WHERE started < DATE_SUB(NOW(), INTERVAL 1 DAY);");
	mysql_query($sql) or die(".");
	mysql_close($con); 
?>