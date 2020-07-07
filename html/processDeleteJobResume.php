<?php
	include("/home/liketheviking9/incld_php/encodeLogin.php");
	include("/home/liketheviking9/incld_php/redirectFunction.php");
	include("/home/liketheviking9/incld_php/loginsql.php");
	include("/home/liketheviking9/incld_php/cookie_chk.php");
	allowUserType("w", $userType);
	
	
	$workExperienceID = $_POST['wrkID'];
	
	if ($userType == "e"){ 
		redirect(("index.php"),false);
	}
			
	if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['passwordConfirm']) && isset($_POST['wrkID'])){
		
		$email = $_POST['email'];
		$password = $_POST['password'];
		$passwordConfirm = $_POST['passwordConfirm'];
		
		if ($password == $passwordConfirm) {
		
			$userID = mysql_real_escape_string($userID);
			$workExperienceID = mysql_real_escape_string($workExperienceID);
			
			$sql = 'SELECT loginData FROM `Workers` WHERE `workerID` = '.intval($userID).' LIMIT 1';
			$sql_result = mysql_query($sql);
			
			$rows = mysql_num_rows($sql_result); 
		
			if ($rows<1 ){ 
				redirect(("index.php"),false);
			} else {
				while ($row = mysql_fetch_array($sql_result)) {
 					//extract user data for view
					$logindatastr = $row['loginData'];
					
					$logindataput = mysql_real_escape_string(encodeLoginDetails($email, $password));
					if ($logindataput == $logindatastr){
						//if employer delete from job listings
						$sql = 'DELETE FROM `WorkersJobHistory` WHERE `workerID` = '.intval($userID).' AND `workExperienceID` = '.intval($workExperienceID).' LIMIT 1';
						
						mysql_query($sql) or die("Renob.");
						
						/*////
						you have now been deleted
						*///////////
						redirect(("index.php"),false);
						
						
					} else {
						redirect(("deleteJobResume.php?err=Email%20and/or%20password%20is%20incorrect&wrkID=".$workExperienceID),false);
					}
				}	
			}
	
		} else {
			redirect(("deleteJobResume.php?err=Email%20and/or%20password%20is%20incorrect&wrkID=".$workExperienceID),false);
		}
	} else {
		redirect(("deleteJobResume.php?err=All%20fields%20are%20required&wrkID=".$workExperienceID),false);
	}
	



?>

<?php
	mysql_close($con); 
?>