<?php
	include("/home/liketheviking9/incld_php/encodeLogin.php");
	if (isset($_COOKIE['sID'])){
		redirect(("index.php"), false);
	}
	function sendConfMail($email, $confNumber){
		$to      = $email;
		$subject = 'Confirm your account for Job-circus.com';
		$message = 'To finish registration, copy and paste or click the link below within 48 hours:'."\n".'https://job-circus.com/confirm.php?n='.$confNumber;
		$headers = 'From: Job-circus <do-not-reply@job-circus.com>' . "\r\n" .
    	'Reply-To: contact@job-circus.com' . "\r\n" .
   		'X-Mailer: PHP/' . phpversion();
		mail($to, $subject, $message, $headers) or die("Error sending confirmation email");
	}
	include("/home/liketheviking9/incld_php/redirectFunction.php");
	include("/home/liketheviking9/incld_php/loginsql.php");
	
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	$email = mysql_real_escape_string($email);
	$password = mysql_real_escape_string($password);
	$loginDetails = encodeLoginDetails($email, $password);
	$loginDetails = mysql_real_escape_string($loginDetails);
	
	function loginYes(){
		redirect("login.php?err=An email has been sent", false);
	}
	function alreadyThere(){
		redirect("send_conf.php?err=Your email has already been confirmed", false);
	}
	//recall data from db
	$sql_a = "SELECT `emailverify`, `confirmed` FROM `Employers` WHERE `loginData`='".$loginDetails."' LIMIT 1";
	$sql_result_a = mysql_query($sql_a);
	$rows_a = mysql_num_rows($sql_result_a); 
	
	if ($rows_a > 0){
		while ($row = mysql_fetch_array($sql_result_a)) {
			$confNumber = $row['emailverify'];
			if ($row['confirmed'] == "no"){
				sendConfMail($email, $confNumber);
				loginYes();
			} else {
				alreadyThere();
			}
		}
	} else {
		$sql_c = "SELECT `emailverify`, `confirmed` FROM `Workers` WHERE `loginData`='".$loginDetails."' LIMIT 1";
		$sql_result_c = mysql_query($sql_c);
		$rows_c = mysql_num_rows($sql_result_c);
		
		if ($rows_c > 0){
			while ($row = mysql_fetch_array($sql_result_c)) {
				$confNumber = $row['emailverify'];
				if ($row['confirmed'] == "no"){
					sendConfMail($email, $confNumber);
					loginYes();
				} else {
					alreadyThere();
				}
				
			}
		} else {
			redirect("send_conf.php?err=Login info is wrong", false);
		}
			
	}
	

	mysql_close($con); 
?>