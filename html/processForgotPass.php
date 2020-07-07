<?php
	include("/home/liketheviking9/incld_php/encodeLogin.php");
	if (isset($_COOKIE['sID'])){
		redirect(("index.php"), false);
	}
	function sendConfMail($email, $confNumber){
		$to      = $email;
		$subject = 'Reset your password for Job-circus.com';
		$message = 'To reset your password, copy and paste or click the link below:'."\n".'https://job-circus.com/resetPass.php?n='.$confNumber."\n".'If you did not request this then just ignore this email.';
		$headers = 'From: Job-circus <do-not-reply@job-circus.com>' . "\r\n" .
    	'Reply-To: contact@job-circus.com' . "\r\n" .
   		'X-Mailer: PHP/' . phpversion();
		mail($to, $subject, $message, $headers) or die("Error sending email");
	}
	include("/home/liketheviking9/incld_php/redirectFunction.php");
	include("/home/liketheviking9/incld_php/loginsql.php");
	
	$email = $_POST['email'];
	
	$email = mysql_real_escape_string($email);
	
	function loginYes(){
		redirect("resetPass.php?err=An email has been sent", false);
	}
	//recall data from db
	//generate rand string
	
	$combine = mt_rand(1000000,9999999);
   	$combine = sha1(crypt($combine, ('$6$rounds=8500')));
	$combine = mysql_real_escape_string($combine);
	$sql_a = "SELECT `employerID` FROM `Employers` WHERE `email`='".$email."' LIMIT 1";
	$sql_result_a = mysql_query($sql_a);
	$rows_a = mysql_num_rows($sql_result_a); 
	
	if ($rows_a > 0){
		while ($row = mysql_fetch_array($sql_result_a)) {
			$sql_b = "UPDATE `Employers` SET `emailverify`='".$combine."', `postingDate`=NOW() WHERE `email`='".$email."' LIMIT 1";
			$sql_result_b = mysql_query($sql_b);
			sendConfMail($email, $combine);
			loginYes();
		}
	} else {
		$sql_c = "SELECT `workerID` FROM `Workers` WHERE `email`='".$email."' LIMIT 1";
		$sql_result_c = mysql_query($sql_c);
		$rows_c = mysql_num_rows($sql_result_c);
		
		if ($rows_c > 0){
			while ($row = mysql_fetch_array($sql_result_c)) {
				$sql_d = "UPDATE `Workers` SET `emailverify`='".$combine."', `postingDate`=NOW() WHERE `email`='".$email."' LIMIT 1";
				$sql_result_d = mysql_query($sql_d);
				sendConfMail($email, $combine);
				loginYes();
			}
		} else {
			redirect("forgot_pass.php?err=Login info is wrong", false);
		}
			
	}
	
	mysql_close($con); 
?>