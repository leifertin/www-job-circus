<?php
include("/home/liketheviking9/incld_php/redirectFunction.php");
include("/home/liketheviking9/incld_php/loginsql.php");
include("/home/liketheviking9/incld_php/cookie_chk.php");
allowUserType("w", $userType);

function still_process_worker(){
	if (($_SERVER['HTTP_REFERER']) == ('processEditWorker.circus')){
		$firstName = $_POST['firstname'];
		$lastName = $_POST['lastname'];
		$city = $_POST['city'];
		$email = $_POST['email'];
		$state = $_POST['state'];
		$phone = $_POST['phone'];
		$password = $_POST['password'];
		$transpt = $_POST['transpt'];
		$legalWork = $_POST['legalwork'];
		$describeYourself = $_POST['describeYourself'];
		$available = $_POST['available'];
		$newPassword = $_POST['newPassword'];
		
		$redirUrl = "editWorkerProfile.php?";
		
		$firstName = mysql_real_escape_string($firstName);
		$lastName = mysql_real_escape_string($lastName);
		$city = mysql_real_escape_string($city);
		$state = mysql_real_escape_string($state);
		$phone = mysql_real_escape_string($phone);
		$email = mysql_real_escape_string($email);
		$password = mysql_real_escape_string($password);
		$transpt = mysql_real_escape_string($transpt);
		$legalWork = mysql_real_escape_string($legalWork);
		$describeYourself = mysql_real_escape_string($describeYourself);
 		$available = mysql_real_escape_string($available);
		$newPassword = mysql_real_escape_string($newPassword);

		//begin the query 
		//Check if email is in use
		$sql_a = 'SELECT * FROM `Workers` WHERE `email` = \''.$email.'\' LIMIT 1';
		$sql_result_a = mysql_query($sql_a);
		$rows_a = mysql_num_rows($sql_result_a); 
		
		$row = mysql_fetch_array($sql_result_a);
		$workerID = $row["workerID"];
		$workerID = mysql_real_escape_string($workerID);
		
		if ($row["loginData"] == encodeLoginDetails($email,$password)){ 
			finishRegistration($workerID, $firstName, $lastName, $city, $state, $phone, $email, $password, $transpt, $legalWork, $describeYourself, $available, $newPassword, $redirUrl);		
		} else {
			echo "Your password is incorrect";
		}
	} else { 
		redirect("editWorkerProfile.php",false);

	}
}



function finishRegistration($workerID, $firstName, $lastName, $city, $state, $phone, $email, $password, $transpt, $legalWork, $describeYourself, $available, $newPassword, $redirUrl){
	//update worker
	
	if (strlen($newPassword)>4){
		$password = $newPassword;
	}
	
	$logindatastr = encodeLoginDetails($email, $password);
	$logindatastr = mysql_real_escape_string($logindatastr);
	$sql = 'UPDATE `Workers` SET `firstname`=\''.$firstName.'\', `lastname`=\''.$lastName.'\', `city`=\''.$city.'\', `loginData`=\''.$logindatastr.'\', `phone`=\''.$phone.'\', `state`=\''.$state.'\', `describeYourself`=\''.$describeYourself.'\', `legalWork`=\''.$legalWork.'\', `transpt`=\''.$transpt.'\', `available`=\''.$available.'\' WHERE `workerID` = \''.$workerID.'\'';
	
	mysql_query($sql) or die("error");
	echo "You now exist";
	
}


include("/home/liketheviking9/incld_php/encodeLogin.php");


still_process_worker();
?>
<?php
	mysql_close($con); 
?>