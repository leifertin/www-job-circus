<?php
	include("/home/liketheviking9/incld_php/encodeLogin.php");
	include("/home/liketheviking9/incld_php/redirectFunction.php");
	include("/home/liketheviking9/incld_php/loginsql.php");
	include("/home/liketheviking9/incld_php/cookie_chk.php");
	
	if ($userType == "w"){
		$userTypeL = "Workers";
		$userTypeCol = "workerID";
		
	} else {
		$userTypeL = "Employers";
		$userTypeCol = "employerID";
	}
	
	if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['passwordConfirm'])){
		
		$email = $_POST['email'];
		$password = $_POST['password'];
		$passwordConfirm = $_POST['passwordConfirm'];
		
		if ($password == $passwordConfirm) {
		
			$userID = mysql_real_escape_string($userID);
			$userTypeL = mysql_real_escape_string($userTypeL);
			$userTypeCol = mysql_real_escape_string($userTypeCol);
	
			$sql = 'SELECT loginData FROM `'.$userTypeL.'` WHERE `'.$userTypeCol.'` = '.intval($userID).' LIMIT 1';
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
						//delete profile
						
						
						if ($userTypeL == "Workers"){
							//delete from job history
							$sql = 'DELETE FROM `WorkersJobHistory` WHERE `workerID` = '.intval($userID);
							mysql_query($sql) or die("Renob.");
							
							//delete from school history
							$sql = 'DELETE FROM `WorkersSchoolHistory` WHERE `workerID` = '.intval($userID);
							mysql_query($sql) or die("Renob.");
							
							//gather list of employers applied to
							$sql_a = 'SELECT `applyTo` FROM `Workers` WHERE `workerID` = '.intval($userID).' LIMIT 1';
							$sql_result_a = mysql_query($sql_a) or die("Renob.");
							$rows_a = mysql_num_rows($sql_result_a); 
		
							if ($rows_a<1 ){ 
								redirect(("index.php"),false);
							} else {
								while ($row_a = mysql_fetch_array($sql_result_a)) {
 									//extract user data for view
									$applyTo = $row_a["applyTo"];
									$applyToList = explode(",", $applyTo);
									$arrlength = count($applyToList);
									for($x = 0; $x < $arrlength; $x++) {
   										if ($applyToList[$x] == ""){
											
										} else {
										
											//delete from job postings
											$sql_b = 'SELECT `applicantIDs`, `postingID` FROM `Jobs` WHERE `employerID` = \''.$applyToList[$x].'\'';
											$sql_result_b = mysql_query($sql_b) or die("Renob.");
											$rows_b = mysql_num_rows($sql_result_b); 
											
											//if ($rows_b<1 ){ 
												//redirect(("index.php"),false);
											//} else {
												while ($row_b = mysql_fetch_array($sql_result_b)) {
 													//search and replace to remove worker from applicant IDs
													$applicantIDs = $row_b["applicantIDs"];
													$postingID = $row_b["postingID"];
													
													$applicantIDback = str_replace((",".$userID.","), ",", $applicantIDs);
													$applicantIDback = mysql_real_escape_string($applicantIDback);
													$postingID = mysql_real_escape_string($postingID);
													$sql_c = "UPDATE `Jobs` SET `applicantIDs`='".$applicantIDback."' WHERE `postingID` = '".$postingID."'";
													mysql_query($sql_c) or die("Renob.");//die(mysql_error());
													
													
												}	
											//}
														
										}
    									
									}
								}	
							}
							
							
						} else if ($userTypeL == "Employers"){
							//if employer delete from job listings
						
							//delete from job postings
							$sql_b = 'SELECT * FROM `Jobs` WHERE `employerID` = '.intval($userID);
							$sql_result_b = mysql_query($sql_b) or die("Renob.");
							$rows_b = mysql_num_rows($sql_result_b); 
							while ($row_b = mysql_fetch_array($sql_result_b)) {
 								//search and replace to remove worker from applicant IDs
								$sql = 'DELETE FROM `Jobs` WHERE `employerID` = '.intval($userID);
								mysql_query($sql) or die("Renob.");
							}
							
							
							//delete from workers' applyTo boxes
							$sql_a = 'SELECT `applyTo`, `workerID` FROM `Workers`';
							$sql_result_a = mysql_query($sql_a) or die("Renob.");
							$rows_a = mysql_num_rows($sql_result_a); 
		
							if ($rows_a<1 ){ 
								//redirect(("index.php"),false);
							} else {
								while ($row_a = mysql_fetch_array($sql_result_a)) {
 									//extract user data for view
									$applyTo = $row_a["applyTo"];
									$applyTo_workID = $row_a["workerID"];
									$applicantIDback = str_replace((",".$userID.","), ",", $applyTo);
									$applicantIDback = mysql_real_escape_string($applicantIDback);
									$applyTo_workID = mysql_real_escape_string($applyTo_workID);
									$sql_c = "UPDATE `Workers` SET `applyTo`='".$applicantIDback."' WHERE `workerID` = '".$applyTo_workID."'";
									mysql_query($sql_c) or die("error");//die(mysql_error());
								}
							}
							
						} else {
							redirect(("index.php"),false);
							exit;
						}
						
						//delete from workers or employers table
						$sql = 'DELETE FROM `'.$userTypeL.'` WHERE `'.$userTypeCol.'` = '.intval($userID).' LIMIT 1';
						mysql_query($sql) or die("Renob.");
						/*////
						you have now been deleted
						*///////////
						
						//clear cookies
						setcookie('sID', null, -1, '/');

						redirect(("index.php"),false);
						
						
					} else {
						redirect(("deleteMyProfile.php?err=Email%20and/or%20password%20is%20incorrect"),false);
					}
				}	
			}
	
		} else {
			redirect(("deleteMyProfile.php?err=Email%20and/or%20password%20is%20incorrect"),false);
		}
	} else {
		redirect(("deleteMyProfile.php?err=All%20fields%20are%20required"),false);
	}
	



?>

<?php
	mysql_close($con); 
?>