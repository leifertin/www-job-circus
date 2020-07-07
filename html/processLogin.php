<?php
function sessID(){
	$randn = mt_rand(1000000,9999999);
	return sha1($randn);
}

function setLoginCookie($userID, $userType){
	$number_of_days = 1;
	$date_of_expiry = time() + 60 * 60 * 24 * $number_of_days ;
	
	//insert into table
	$sessionEnter = "no";
	
	while($sessionEnter == "no"){
		$sID = sessID();
		$sID_m = mysql_real_escape_string($sID);
		$userID_m = mysql_real_escape_string($userID);
		$userType_m = mysql_real_escape_string($userType);
		$sql = "SELECT `sessionID` FROM Session WHERE `sessionID`='".$sID_m."' LIMIT 1";
		$sql_res = mysql_query($sql);
		$rows = mysql_num_rows($sql_res); 
	
		if ($rows > 0){
		} else {
			//sessionID not taken, proceed
			$sql2 = "INSERT INTO `JobPool`.`Session` (`sessionID`, `userID`, `userType`, `started`) VALUES ('".$sID_m."', '".$userID_m."', '".$userType_m."', NOW())";
			mysql_query($sql2) or die("error");
			//set cookie
			setcookie("sID", $sID_m, $date_of_expiry, "/");
			$sessionEnter = "yes";
		}
		
	}
}
function redirect($url, $statusCode = 303){
   header('Location: ' . $url, true, $statusCode);
   die();
}
include("/home/liketheviking9/incld_php/encodeLogin.php");
function pleaseConfirm(){
	redirect("login.php?err=Your email is not yet confirmed", false);
}
function loginYes(){
	redirect("index.php", false);
}

include("/home/liketheviking9/incld_php/loginsql.php");
	
if (isset($_COOKIE['sID'])){
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
			sleep(1);
			redirect("login.php?err=Login info is wrong", false);
		}
			
	}
	
}
?>