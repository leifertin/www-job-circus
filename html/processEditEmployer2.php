<?php
include("/home/liketheviking9/incld_php/redirectFunction.php");
include("/home/liketheviking9/incld_php/loginsql.php");
include("/home/liketheviking9/incld_php/cookie_chk.php");
allowUserType("e", $userType);

function still_process_employer(){
	if (($_SERVER['HTTP_REFERER']) == ('processEditEmployer.circus')){
		$businessName = $_POST['businessName'];
		$genre = $_POST['genre'];
		$city = $_POST['city'];
		$email = $_POST['email'];
		$state = $_POST['state'];
		$phone = $_POST['phone'];
		$password = $_POST['password'];
		$address = $_POST['address'];
		$newPassword = $_POST['newPassword'];
		
		$redirUrl = "editEmployerProfile.php?";
		
		$businessName = mysql_real_escape_string($businessName);
		$genre = mysql_real_escape_string($genre);
		$city = mysql_real_escape_string($city);
		$state = mysql_real_escape_string($state);
		$phone = mysql_real_escape_string($phone);
		$email = mysql_real_escape_string($email);
		$password = mysql_real_escape_string($password);
		$address = mysql_real_escape_string($address);
		$newPassword = mysql_real_escape_string($newPassword);

		//begin the query 
		//Check if email is in use
		$sql_a = 'SELECT * FROM `Employers` WHERE `email` = \''.$email.'\' LIMIT 1';
		$sql_result_a = mysql_query($sql_a);
		$rows_a = mysql_num_rows($sql_result_a); 
		
		$row = mysql_fetch_array($sql_result_a);
		$employerID = $row["employerID"];
		$employerID = mysql_real_escape_string($employerID);
		
		if ($row["loginData"] == encodeLoginDetails($email,$password)){ 
			finishRegistration($employerID, $businessName, $genre, $city, $state, $phone, $email, $password, $address, $newPassword, $redirUrl);		
		} else {
			echo "Your password is incorrect";
		}
	} else { 
		redirect("editEmployerProfile.php",false);

	}
}



function finishRegistration($employerID, $businessName, $genre, $city, $state, $phone, $email, $password, $address, $newPassword, $redirUrl){
	//update employer
	
	if (strlen($newPassword)>4){
		$password = $newPassword;
	}
	
	$logindatastr = encodeLoginDetails($email, $password);
	$logindatastr = mysql_real_escape_string($logindatastr);
	$sql = 'UPDATE `Employers` SET `businessName`=\''.$businessName.'\', `genre`=\''.$genre.'\', `city`=\''.$city.'\', `loginData`=\''.$logindatastr.'\', `phone`=\''.$phone.'\', `state`=\''.$state.'\', `address`=\''.$address.'\' WHERE `employerID` = \''.$employerID.'\'';
	
	mysql_query($sql) or die("error");
	echo "You now exist";
	
}

include("/home/liketheviking9/incld_php/encodeLogin.php");

still_process_employer();
?>
<?php
	mysql_close($con); 
?>