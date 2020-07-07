<?php
function recallPicture($userType, $userID){
	//Redefine vars
	if ($userType == "e"){
		$userPage = ("displayEmployerProfile.php?eid=".$userID);
	} else {
		$userPage = ("displayWorkerProfile.php?wid=".$userID);
	}
	
	$userID = mysql_real_escape_string($userID);
	$userPage = mysql_real_escape_string($userPage);
	
	$sql = 'SELECT `mime`, `ext`, `pic` FROM `ProfilePic` WHERE `uid` = \''.$userID.'\' AND `utype` = \''.$userType.'\'';
	$sql_result = mysql_query($sql);
	$rows = mysql_num_rows($sql_result); 
		
	if ($rows<1 ){ 
		redirect(("addProfileImage.php"),false);
	} else {
		while ($row= mysql_fetch_array($sql_result)) {
 			//extract user data for view
			$oldFileName = $row["picName"];
			//$oldFileType = $row["picType"];
		}	
	}
	return $oldFileName;
	
}

?>