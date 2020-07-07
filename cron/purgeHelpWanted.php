<?php
	$con = mysql_connect("localhost","viking12","r3dBu12!");
	if (!$con) { 
		die('Could not connect.'); 
	} 

	mysql_select_db("JobPool");
	$sql = ("SELECT `employerID` FROM Jobs WHERE postingDate < DATE_SUB(NOW(), INTERVAL 30 DAY);");
	$sql_result = mysql_query($sql);
	
	$rows = mysql_num_rows($sql_result); 
	if ($rows>0){ 
		while ($row = mysql_fetch_array($sql_result)) {
 			
			$employerID = $row['employerID'];
			$employerID = mysql_real_escape_string($employerID);
			
			$sql_b = ("SELECT `numJobs` FROM Employers WHERE `employerID`='".$employerID."' LIMIT 1");
			$sql_result_b = mysql_query($sql_b);
			
			while ($row_b = mysql_fetch_array($sql_result_b)) {
				$numJobs = $row_b['numJobs'];
				$numJobs -= 1;
				$numJobs = mysql_real_escape_string($numJobs);
						
				$sql_c = 'UPDATE `Employers` SET `numJobs`=\''.$numJobs.'\' WHERE `employerID` = '.intval($employerID).' LIMIT 1';
				mysql_query($sql_c) or die("error");
			}	
		}
	}
				
	$sql = ("DELETE FROM Jobs WHERE postingDate < DATE_SUB(NOW(), INTERVAL 30 DAY);");
	mysql_query($sql) or die(".");
	mysql_close($con); 
?>