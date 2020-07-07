<?php
include("/home/liketheviking9/incld_php/redirectFunction.php");
include("/home/liketheviking9/incld_php/loginsql.php");
include("/home/liketheviking9/incld_php/cookie_chk.php");
allowUserType("w", $userType);

$workerID = $userID;
$employerID = $_POST['employerID'];

$checksite = "https://job-circus.com/displayEmployerProfile.php?eid=".$employerID;
function still_process_applyjob($workerID, $employerID){
	//if (($_SERVER['HTTP_REFERER']) == ($checksite)){
		$postingID = $_POST['postingID'];
		
		$redirUrl = "displayEmployerProfile.php?";
		$redirUrl = ($redirUrl.'eid='.$employerID);
		
		$employerID = mysql_real_escape_string($employerID);
		$postingID = mysql_real_escape_string($postingID);
		$workerID = mysql_real_escape_string($workerID);
		
		finishRegistration($postingID, $employerID, $workerID, $redirUrl);
				
	/*} else { 
		redirect("index.php?sd",false);
	}*/
}



function finishRegistration($postingID, $employerID, $workerID, $redirUrl){
	//Apply to Job
	
	$sql = 'SELECT `applicantIDs`, `position` FROM `Jobs` WHERE `postingID` = \''.$postingID.'\' LIMIT 1';
	$sql_result = mysql_query($sql);
	$rows = mysql_num_rows($sql_result); 
		
	if ($rows<1 ){ 
		redirect(("index.php"),false);
	} else {
		while ($row= mysql_fetch_array($sql_result)) {
 			//extract user data for view
			$applicantIDs = $row["applicantIDs"];
			$job_position = $row["position"];
			$applicantIDs = str_replace((",".$workerID.","), ",", $applicantIDs);
			$applicantIDs = ($applicantIDs.$workerID.",");
		}	
	}
	$applicantIDs = mysql_real_escape_string($applicantIDs);
	$sql = "UPDATE `Jobs` SET `applicantIDs`='".$applicantIDs."' WHERE `postingID` = '".$postingID."'";
	mysql_query($sql) or die("Renob.");//die(mysql_error());
	
	//////
	
	
	$sql = 'SELECT `applyTo` FROM `Workers` WHERE `workerID` = \''.$workerID.'\' LIMIT 1';
	$sql_result = mysql_query($sql);
	$rows = mysql_num_rows($sql_result); 
		
	if ($rows<1 ){ 
		redirect(("index.php"),false);
	} else {
		while ($row= mysql_fetch_array($sql_result)) {
 			//extract user data for view
			$applyTo = $row["applyTo"];
			$applyTo = str_replace((",".$employerID.","), ",", $applyTo);
			$applyTo = ($applyTo.$employerID.",");
		}	
	}
	
	$applyTo = mysql_real_escape_string($applyTo);
	$sql = "UPDATE `Workers` SET `applyTo`='".$applyTo."' WHERE `workerID` = '".$workerID."' LIMIT 1";
	//$sql = 'INSERT INTO `Employers` (`applicantIDs`) VALUES (\''.$applicantIDs.'\')';
	mysql_query($sql) or die("Renob.");//die(mysql_error());
	//echo "You now exist";
	
	
	//email employer
	$sql = 'SELECT `email` FROM `Employers` WHERE `employerID` = \''.$employerID.'\' LIMIT 1';
	$sql_result = mysql_query($sql);
	
	if ($rows<1 ){ 
		//redirect(("index.php"),false);
	} else {
		while ($row= mysql_fetch_array($sql_result)) {
 			//extract user data for view
			$employerEmail = $row["email"];
		}	
	}
	sendApplyMail($employerEmail, $job_position);
	redirect($redirUrl, false);
}


function sendApplyMail($employerEmail, $job_position){
	$to      = $employerEmail;
	$subject = 'New applicant!';
	$message = 'Someone just applied for the '.$job_position.' job!'."\n".'Login to see who it is:'."\n".'https://job-circus.com/login.php';
	$headers = 'From: Job-circus <do-not-reply@job-circus.com>' . "\r\n" .
    'Reply-To: contact@job-circus.com' . "\r\n" .
   	'X-Mailer: PHP/' . phpversion();
	mail($to, $subject, $message, $headers);// or die("Error sending confirmation email");
}


still_process_applyjob($workerID, $employerID);
?>
<?php
	mysql_close($con); 
?>