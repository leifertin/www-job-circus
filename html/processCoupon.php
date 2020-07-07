<?php
include("/home/liketheviking9/incld_php/redirectFunction.php");
include("/home/liketheviking9/incld_php/loginsql.php");
include("/home/liketheviking9/incld_php/cookie_chk.php");
allowUserType("e", $userType);

function still_process_coupon($employerID){
	$postingID = $_POST['pID'];
	$couponCode = $_POST['couponCode'];
		
	$redirUrl = "publishHelpWanted.php?";
	$redirUrl = ($redirUrl.'pID='.$postingID);
		
	$employerID = mysql_real_escape_string($employerID);
	$postingID = mysql_real_escape_string($postingID);
	$couponCode = mysql_real_escape_string($couponCode);
		
	finishRegistration($postingID, $employerID, $couponCode, $redirUrl);
}



function finishRegistration($postingID, $employerID, $couponCode, $redirUrl){
	//Apply to Job
	
	$sql = 'SELECT `couponID` FROM `Coupons` WHERE `couponCode` = \''.$couponCode.'\' LIMIT 1';
	$sql_result = mysql_query($sql);
	$rows = mysql_num_rows($sql_result); 
	
	if ($rows<1 ){ 
		redirect(($redirUrl."&err=Invalid%20coupon%20code."),false);
	} else {
		while ($row= mysql_fetch_array($sql_result)) {
 			//extract user data for view
			$couponID = $row["couponID"];
		}	
	}
	$couponID = mysql_real_escape_string($couponID);
	//set to paid
	$sql = "UPDATE `Jobs` SET `pay`='yes' WHERE `postingID` = '".$postingID."' AND `employerID` = '".$employerID."'";
	mysql_query($sql) or die("Renob.");//die(mysql_error());
	
	//////
	//delete from table
	
	$sql = 'DELETE FROM `Coupons` WHERE `couponID`='.$couponID.' LIMIT 1';
	mysql_query($sql) or die("Renob.");
	
	
	//Get ready to email in city users
	$sql = 'SELECT `city`, `state`  FROM `Employers` WHERE `employerID` = \''.$employerID.'\' LIMIT 1';
	$sql_result = mysql_query($sql);
	$rows = mysql_num_rows($sql_result); 
		
	if ($rows<1 ){ 
		redirect(($redirUrl."&err=Error%20processing"),false);
	} else {
		while ($row= mysql_fetch_array($sql_result)) {
 			//extract user data for view
			$city = $row["city"];
			$state = $row["state"];
		}	
	}
	$city = mysql_real_escape_string($city);
	$state = mysql_real_escape_string($state);
	
	sendJobMail($city, $state, $employerID);
	redirect("index.php", false);
}

function sendJobMail($city, $state, $employerID){

	//get list of users in city state
	$sql = 'SELECT `email` FROM `Workers` WHERE `city` = \''.$city.'\' AND `state` = \''.$state.'\'';
	$sql_result = mysql_query($sql);
	$rows = mysql_num_rows($sql_result);
	
	//set mail text
	
	$subject = 'New job posting near you!';
	$message = 'A new job has been posted in '.$city.', '.$state.':'."\n".'https://job-circus.com/displayEmployerProfile.php?eid='.$employerID;
	$headers = 'From: Job-circus <do-not-reply@job-circus.com>' . "\r\n" .
    'Reply-To: contact@job-circus.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();


	if ($rows<1 ){ 
		//
	} else {
		while ($row= mysql_fetch_array($sql_result)) {
 			//get email of user
			$to = $row["email"];
			//mail to user
			mail($to, $subject, $message, $headers);
		}	
	}
}


still_process_coupon($userID);
mysql_close($con); 

?>