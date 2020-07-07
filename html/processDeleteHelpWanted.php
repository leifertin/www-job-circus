<?php
	include("/home/liketheviking9/incld_php/encodeLogin.php");
	include("/home/liketheviking9/incld_php/redirectFunction.php");
	include("/home/liketheviking9/incld_php/loginsql.php");
	include("/home/liketheviking9/incld_php/cookie_chk.php");
	allowUserType("e", $userType);
	
	$postingID = $_POST['pID'];
	$position = $_POST['pos'];
	
	if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['passwordConfirm']) && isset($_POST['pID'])){
		
		$email = $_POST['email'];
		$password = $_POST['password'];
		$passwordConfirm = $_POST['passwordConfirm'];
		
		if ($password == $passwordConfirm) {
		
			$userID = mysql_real_escape_string($userID);
			$postingID = mysql_real_escape_string($postingID);
			$position = mysql_real_escape_string($position);
			
			$sql = 'SELECT * FROM `Employers` WHERE `employerID` = '.intval($userID).' LIMIT 1';
			$sql_result = mysql_query($sql);
			
			$rows = mysql_num_rows($sql_result); 
		
			if ($rows<1 ){ 
				redirect(("index.php"),false);
			} else {
				while ($row = mysql_fetch_array($sql_result)) {
 					//extract user data for view
					$logindatastr = $row['loginData'];
					$numJobs = $row['numJobs'];
					
					$logindataput = mysql_real_escape_string(encodeLoginDetails($email, $password));
					if ($logindataput == $logindatastr){
						$numJobs -= 1;
						$numJobs = mysql_real_escape_string($numJobs);
						
						$sql = 'UPDATE `Employers` SET `numJobs`=\''.$numJobs.'\' WHERE `employerID` = '.intval($userID).' LIMIT 1';
						mysql_query($sql) or die("error");
						
						//if employer delete from job listings
						$sql = 'DELETE FROM `Jobs` WHERE `employerID` = '.intval($userID).' AND `postingID` = '.intval($postingID).' LIMIT 1';
						mysql_query($sql) or die("error");
						
						/*////
						you have now been deleted
						*///////////
						redirect(("index.php"),false);
						
						
					} else {
						redirect(("deleteHelpWanted.php?err=Email%20and/or%20password%20is%20incorrect&pID=".$postingID."&pos=".$position),false);
					}
				}	
			}
	
		} else {
			redirect(("deleteHelpWanted.php?err=Email%20and/or%20password%20is%20incorrect&pID=".$postingID."&pos=".$position),false);
		}
	} else {
		redirect(("deleteHelpWanted.php?err=All%20fields%20are%20required&pID=".$postingID."&pos=".$position),false);
	}
	



?>

<?php
	mysql_close($con); 
?>