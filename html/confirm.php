<?php
	include("/home/liketheviking9/incld_php/redirectFunction.php");
	include("/home/liketheviking9/incld_php/loginsql.php");
	
	$confID = $_GET['n'];
	$confID = mysql_real_escape_string($confID);
	
	function loginYes(){
		redirect("login.php?err=Confirmed. You may now login.", false);
	}
	
	//recall data from db
	$sql_a = "SELECT `employerID` FROM `Employers` WHERE `emailverify`='".$confID."' AND `confirmed`='no' LIMIT 1";
	$sql_result_a = mysql_query($sql_a);
	$rows_a = mysql_num_rows($sql_result_a); 
	
	if ($rows_a > 0){
		while ($row = mysql_fetch_array($sql_result_a)) {
			$employerID = $row['employerID'];
			$employerID = mysql_real_escape_string($employerID);
			$sql = 'UPDATE `Employers` SET `confirmed`=\'yes\' WHERE `employerID` = '.intval($employerID).' LIMIT 1';
			mysql_query($sql) or die("error");
			loginYes();
		}
	} else {
		$sql_c = "SELECT `workerID` FROM `Workers` WHERE `emailverify`='".$confID."' AND `confirmed`='no' LIMIT 1";
		$sql_result_c = mysql_query($sql_c);
		$rows_c = mysql_num_rows($sql_result_c);
		
		if ($rows_c > 0){
			while ($row = mysql_fetch_array($sql_result_c)) {
				$workerID = $row['workerID'];
				$workerID = mysql_real_escape_string($workerID);
				$sql = 'UPDATE `Workers` SET `confirmed`=\'yes\' WHERE `workerID` = '.intval($workerID).' LIMIT 1';
				mysql_query($sql) or die("error");
				loginYes();
			}
		} else {
			redirect("index.php", false);
		}
			
	}
	

	mysql_close($con); 
?>