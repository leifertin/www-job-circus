<?php
include("/home/liketheviking9/incld_php/redirectFunction.php");
if (isset($_COOKIE['sID'])){
	redirect(("index.php"), false);
}

$firstName = $_POST['firstname'];
$lastName = $_POST['lastname'];
$city = $_POST['city'];
$email = $_POST['email'];
$state = $_POST['state'];
$phone = $_POST['phone'];
$emailConfirm = $_POST['emailConfirm'];
$password = $_POST['password'];
$passwordConfirm = $_POST['passwordConfirm'];
$transpt = $_POST['transpt'];
$legalWork = $_POST['legalwork'];
$describeYourself = $_POST['describeYourself'];
$dayshift = $_POST['dayshift'];
$nightshift = $_POST['nightshift'];


$redirUrl = "createWorkerProfile.php?";
$redirUrl = ($redirUrl.'firstname='.$firstName.'&lastname='.$lastName.'&city='.$city.'&phone='.$phone.'&email='.$email);




if ($legalWork != "yes"){
	$legalWork = "no";
}
if ($transpt != "yes"){
	$transpt = "no";
}

$available = "";

if ($dayshift != "yes"){
	$dayshift = "0";
} else {
	$dayshift = "1";
}
if ($nightshift != "yes"){
	$nightshift = "0";
} else {
	$nightshift = "1";
}
$available = $dayshift.$nightshift;



if (isset($firstName) && isset($lastName) && isset($city) && isset($state) && isset($email) && isset($phone) && isset($emailConfirm) && isset($password) && isset($passwordConfirm) && isset($describeYourself)){
	
	if ($password == ""){
	 	//Password missing
		Redirect(($redirUrl.'err=Please%20provide%20a%20password'), false);
	} else {
		if ($password != $passwordConfirm){
			 //Passwords don't match
			Redirect(($redirUrl.'&err=Your%20passwords%20do%20not%20match'), false);
		} else {
			if ($email != $emailConfirm){
				//Emails don't match
				Redirect(($redirUrl.'&err=Your%20emails%20do%20not%20match'), false);
			} else {
				if ($state == "--"){
					//Fix State
					Redirect(($redirUrl.'&err=Please%20pick%20a%20state'), false);
				} else {
					//checks on locationinfo
					$locationInfoCheck = validLocatorInfo($phone, $firstName, $lastName, $city, $describeYourself);
					if ($locationInfoCheck != "good"){
						//Fix Locator
						Redirect(($redirUrl.'&err='.$locationInfoCheck), false);
					} else {
						//check password
						$passwordCheck = validPassword($password);
						if ($passwordCheck != "good"){
							//Fix password
							Redirect(($redirUrl.'&err='.$passwordCheck), false);
						} else {
							process_worker($firstName, $lastName, $city, $state, $phone, $email, $password, $legalWork, $transpt, $describeYourself, $available, $redirUrl);
						}
					}
				}
			}
		}
	}
} else {
	//redirect
	Redirect(($redirUrl."&err=Please%20fill%20out%20all%20required%20fields"), false);
	
}


function process_worker($firstName, $lastName, $city, $state, $phone, $email, $password, $legalWork, $transpt, $describeYourself, $available, $redirUrl){
	
	
	//////////
	sleep(1);
	$describeYourself = str_replace("&","and",$describeYourself);		
	$curl_connection = curl_init('https://job-circus.com/processNewWorker2.php');

	curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($curl_connection, CURLOPT_SSL_VERIFYHOST, 1);
	curl_setopt($curl_connection, CURLOPT_CAPATH, "/home/liketheviking9/CA_certs/cacert.pem");
	curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl_connection, CURLOPT_REFERER, 'processNewWorker.circus');
	
	$post_data['firstname'] = $firstName;
	$post_data['lastname'] = $lastName;
	$post_data['city'] = $city;
	$post_data['state'] = $state;
	$post_data['phone'] = $phone;
	$post_data['email'] = $email;
	$post_data['password'] = $password;
	$post_data['legalwork'] = $legalWork;
	$post_data['transpt'] = $transpt;
	$post_data['describeYourself'] = $describeYourself;
	$post_data['available'] = $available;
			
	
	foreach ( $post_data as $key => $value) 
	{
		$post_items[] = $key . '=' . $value;
	}
	$post_string = implode ('&', $post_items);

	curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);

	$myConfirmationReturn = curl_exec($curl_connection);
	curl_close($curl_connection);
	
	redirect(($redirUrl."&err=".$myConfirmationReturn), false);
						
	/////////////////
	
}
				

function validLocatorInfo($phone, $firstName, $lastName, $city, $describeYourself) {
	$rettext = "good";
	if (strlen($phone) < 10) {
        $rettext = "Phone%20number%20too%20short";
    } else if (strlen($phone) > 12) {
        $rettext = "Phone%20number%20too%20long";
    } else if (strlen($city) > 45) {
		$rettext = "City%20is%20too%20long";
	} else if (strlen($city) < 2) {
		$rettext = "City%20is%20too%20short";
	} else if (strlen($firstName) > 50) {
		$rettext = "First%20name%20is%20too%20long";
	} else if (strlen($lastName) > 50) {
		$rettext = "Last%20name%20is%20too%20long";
	} else if (strlen($describeYourself) > 550) {
        $rettext = "Your%20description%20of%20yourself%20is%20a%20bit%20long";
    } else if (preg_match("#[&'.!a-zA-Z]+#", $phone)) {
        $rettext = "Phone%20number%20is%20not%20valid.";
    } else if (preg_match("#[&]+#", $firstName)) {
        $rettext = "First%20name%20can%20not%20contain%20an%20ampersand.";
    } else if (preg_match("#[&]+#", $lastName)) {
        $rettext = "Last%20name%20can%20not%20contain%20an%20ampersand.";
    } else if (preg_match("#[&]+#", $city)) {
        $rettext = "City%20can%20not%20contain%20an%20ampersand.";
    }

	return $rettext;
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
    } else if (preg_match("#[&]+#", $password)) {
        $rettext = "Password%20can%20not%20contain%20an%20ampersand.";
    }

	return $rettext;
}


?>

