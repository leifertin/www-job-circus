<?php

$sID_m = mysql_real_escape_string($_COOKIE['sID']);
$sql_x = "SELECT `userID`, `userType` FROM Session WHERE `sessionID`='".$sID_m."' LIMIT 1";
$sql_res_x = mysql_query($sql_x);
$rows_x = mysql_num_rows($sql_res_x); 



	
if ($rows_x > 0){
	$row_x = mysql_fetch_array($sql_res_x);
	$userID = $row_x['userID'];
	$userType = $row_x['userType'];
} else {

	setcookie('sID', null, -1, '/');
}

?>