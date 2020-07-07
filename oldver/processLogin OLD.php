<?php

function setLoginCookie($userID, $userType){
	$number_of_days = 7;
	$date_of_expiry = time() + 60 * 60 * 24 * $number_of_days ;
	setcookie("userID", $userID, $date_of_expiry, "/");
	setcookie("userType", $userType, $date_of_expiry, "/");
}
function redirect($url, $statusCode = 303){
   header('Location: ' . $url, true, $statusCode);
   die();
}
function encodeLoginDetails($email,$password){
	return sha1($email.$password);
}
function pleaseConfirm(){
	redirect("login.php?err=Your email is not yet confirmed", false);
}
function loginYes(){
	redirect("index.php", false);
}

include("incld/loginsql.php");
	
if (isset($_COOKIE['userID']) && isset($_COOKIE['userType'])){
	redirect("index.php", false);
} else {
	$postEmail = $_POST['email'];
	$postPassword = $_POST['password'];
	
	
	$email = mysql_real_escape_string($postEmail);
	$password = mysql_real_escape_string($postPassword);
	$loginDetails = encodeLoginDetails($email, $password);
	$loginDetails = mysql_real_escape_string($loginDetails);
	//search db for user
	
	
	//recall data from db
	$sql_a = "SELECT `employerID`, `confirmed` FROM `Employers` WHERE `loginData`='".$loginDetails."' LIMIT 1";
	$sql_result_a = mysql_query($sql_a);
	$rows_a = mysql_num_rows($sql_result_a); 
	
	if ($rows_a > 0){
		while ($row = mysql_fetch_array($sql_result_a)) {
			$userID = $row['employerID'];
			$userType = "e";
			if ($row['confirmed'] == "yes"){
				setLoginCookie($userID, $userType);
				loginYes();
			} else {
				pleaseConfirm();
			}
		}
	} else {
		$sql_c = "SELECT `workerID`, `confirmed` FROM `Workers` WHERE `loginData`='".$loginDetails."' LIMIT 1";
		$sql_result_c = mysql_query($sql_c);
		$rows_c = mysql_num_rows($sql_result_c);
		
		if ($rows_c > 0){
			while ($row = mysql_fetch_array($sql_result_c)) {
				$userID = $row['workerID'];
				$userType = "w";
				if ($row['confirmed'] == "yes"){
					setLoginCookie($userID, $userType);
					loginYes();
				} else {
					pleaseConfirm();
				}
				
			}
		} else {
			redirect("login.php?err=Login info is wrong", false);
		}
			
	}
	
}
?>