<?php
include("/home/liketheviking9/incld_php/redirectFunction.php");
if (isset($_COOKIE['sID'])){
	redirect(("index.php"), false);
}
include("/home/liketheviking9/incld_php/loginsql.php");

function still_process_employer(){
	if (($_SERVER['HTTP_REFERER']) == ('processNewEmployer.circus')){
		$business = $_POST['businessName'];
		$genre = $_POST['genre'];
		$address = $_POST['address'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		$redirUrl = "createEmployerProfile.php?";
		$redirUrl = ($redirUrl.'businessName='.$business.'&address='.$address.'&city='.$city.'&phone='.$phone.'&email='.$email);
	
		$business = mysql_real_escape_string($business);
		$genre = mysql_real_escape_string($genre);
		$address = mysql_real_escape_string($address);
		$city = mysql_real_escape_string($city);
		$state = mysql_real_escape_string($state);
		$phone = mysql_real_escape_string($phone);
		$email = mysql_real_escape_string($email);
		$password = mysql_real_escape_string($password);
 		

		//begin the query 
		//Check if email is in use
		$sql_a = "SELECT `email` FROM `Employers` WHERE `email`='".$email."' LIMIT 1";
		$sql_result_a = mysql_query($sql_a);
		$rows_a = mysql_num_rows($sql_result_a); 
		
		
		$sql_c = "SELECT `email` FROM `Workers` WHERE `email`='".$email."' LIMIT 1";
		$sql_result_c = mysql_query($sql_c);
		$rows_c = mysql_num_rows($sql_result_c);
		
		$rowsTotal = ($rows_a+$rows_c);
		
		if ($rowsTotal < 1){ 
			//Good, this email isn't in use.
			if (validEmail($email)){
				//Good, this email looks right
				finishRegistration($business, $genre, $address, $city, $state, $phone, $email, $password, $redirUrl);
			} else {
				echo "Please%20try%20a%20different%20email%20address";
			}		
		} else {
			echo "That%20email%20in%20use";
		}
	} else { 
		redirect("createEmployerProfile.php",false);

	}
}



function finishRegistration($business, $genre, $address, $city, $state, $phone, $email, $password, $redirUrl){
	//Add to Employers


	$emailVerify = substr(md5(rand()), 0, 25);
	$logindatastr = encodeLoginDetails($email,$password);
	$emailVerify = mysql_real_escape_string($emailVerify);
	$logindatastr = mysql_real_escape_string($logindatastr);
	$sql = 'INSERT INTO `Employers` (`employerID`, `businessName`, `genre`, `address`, `city`, `state`, `phone`, `email`, `loginData`, `emailverify`, `postingDate`) VALUES (NULL, \''.$business.'\', \''.$genre.'\', \''.$address.'\', \''.$city.'\', \''.$state.'\', \''.$phone.'\', \''.$email.'\', \''.$logindatastr.'\', \''.$emailVerify.'\', NOW())';
	
	mysql_query($sql) or die("error");
	sendConfMail($email, $emailVerify);
	echo "You now exist";
}



////http://www.linuxjournal.com/article/9585?page=0,3
/**
Validate an email address.
Provide email address (raw input)
Returns true if the email address has the email 
address format and the domain exists.
*/

function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if
(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
   }
   return $isValid;
}


include("/home/liketheviking9/incld_php/encodeLogin.php");

function sendConfMail($email, $confNumber){
	$to      = $email;
	$subject = 'Confirm your account for Job-circus.com';
	$message = 'To finish registration, copy and paste or click the link below within 48 hours:'."\n".'https://job-circus.com/confirm.php?n='.$confNumber;
	$headers = 'From: Job-circus <do-not-reply@job-circus.com>' . "\r\n" .
    'Reply-To: contact@job-circus.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message, $headers) or die("Error sending confirmation email");
}

still_process_employer();
?>
<?php
	mysql_close($con); 
?>