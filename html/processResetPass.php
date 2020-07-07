
<?php
	include("/home/liketheviking9/incld_php/redirectFunction.php");
	if (isset($_COOKIE['sID'])){
		redirect("index.php", false);
	}
	include("/home/liketheviking9/incld_php/loginsql.php");
	include("/home/liketheviking9/incld_php/encodeLogin.php");
	
	$confID = $_GET['n'];
	$confID = mysql_real_escape_string($confID);
	$newPass = $_POST['newPassword'];
	$newPassConf = $_POST['newPasswordConfirm'];
	
	function loginYes(){
		$redurl = "login.php?err=You now exist";
		echo "<script> window.location.replace('".$redurl."') </script>";
	}
	function validPassword($password) {
	$rettext = "good";
	if (strlen($password) < 5) {
		$rettext = "Password%20too%20short";
   	} else if (strlen($password) > 30) {
		$rettext = "Password%20too%20long";
	} else if (!preg_match("#[0-9]+#", $password)) {
		$rettext = "Password%20must%20include%20at%20least%20one%20number";
	} else if (!preg_match("#[a-zA-Z]+#", $password)) {
		$rettext = "Password%20must%20include%20at%20least%20one%20letter";
    }
		return $rettext;
	}
	
	if ($newPass == $newPassConf){
		$vPass = validPassword($newPass);
		if ($vPass == "good"){
			//recall data from db
			$sql_a = "SELECT `employerID`, `email` FROM `Employers` WHERE `emailverify`='".$confID."' LIMIT 1";
			$sql_result_a = mysql_query($sql_a);
			$rows_a = mysql_num_rows($sql_result_a); 
			if ($rows_a > 0){
				while ($row = mysql_fetch_array($sql_result_a)) {
					$employerID = $row['employerID'];
					$email = $row['email'];
					$email = mysql_real_escape_string($email);
					$newPass = mysql_real_escape_string($newPass);
					$loginData = encodeLoginDetails($email, $newPass);
					$loginData = mysql_real_escape_string($loginData);
					$employerID = mysql_real_escape_string($employerID);
					
					$sql = 'UPDATE `Employers` SET `confirmed`=\'yes\', `emailverify`=\''.sha1(mt_rand(10000000,999999999)).'\', `loginData`=\''.$loginData.'\' WHERE `employerID` = '.intval($employerID).' LIMIT 1';
					mysql_query($sql) or die("error");
					loginYes();
				}
			} else {
				$sql_c = "SELECT `workerID`, `email` FROM `Workers` WHERE `emailverify`='".$confID."' LIMIT 1";
				$sql_result_c = mysql_query($sql_c);
				$rows_c = mysql_num_rows($sql_result_c);
		
				if ($rows_c > 0){
					while ($row = mysql_fetch_array($sql_result_c)) {
						$workerID = $row['workerID'];
						$email = $row['email'];
						$email = mysql_real_escape_string($email);
						$newPass = mysql_real_escape_string($newPass);
						$loginData = encodeLoginDetails($email, $newPass);
						$loginData = mysql_real_escape_string($loginData);
						$workerID = mysql_real_escape_string($workerID);
						$sql = 'UPDATE `Workers` SET `confirmed`=\'yes\', `emailverify`=\''.sha1(mt_rand(10000000,999999999)).'\', `loginData`=\''.$loginData.'\' WHERE `workerID` = '.intval($workerID).' LIMIT 1';
						mysql_query($sql) or die("error");
						loginYes();
					}
				} else {
					$redurl = "resetPass.php?n=".$confID."&err=Your validation code is invalid";
					echo "<script> window.location.replace('".$redurl."') </script>";
				}
			}
		} else {
			//invalid password
			$redurl = "resetPass.php?n=".$confID."&err=".$vPass;
			echo "<script> window.location.replace('".$redurl."') </script>";
		}
	} else {
		//passwords dont match
		$redurl = "resetPass.php?n=".$confID."&err=Your passwords do not match";
		echo "<script> window.location.replace('".$redurl."') </script>";
		
	}
	

	mysql_close($con); 
?>