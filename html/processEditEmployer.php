<?php
include("/home/liketheviking9/incld_php/redirectFunction.php");
include("/home/liketheviking9/incld_php/loginsql.php");
include("/home/liketheviking9/incld_php/cookie_chk.php");
allowUserType("e", $userType);

$businessName = $_POST['businessName'];
$genre = $_POST['genre'];
$city = $_POST['city'];
$state = $_POST['state'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordConfirm = $_POST['passwordConfirm'];
$newPassword = $_POST['newPassword'];
$newPasswordConfirm = $_POST['newPasswordConfirm'];
$address = $_POST['address'];


$redirUrl = "editEmployerProfile.php?";



if (isset($businessName) && isset($genre) && isset($city) && isset($state) && isset($phone) && isset($password) && isset($passwordConfirm) && isset($address)){
	
	if ($password == ""){
	 	//Password missing
		Redirect(($redirUrl.'err=Please%20provide%20a%20password'), false);
	} else {
		if ($password != $passwordConfirm){
			//Passwords don't match
			Redirect(($redirUrl.'&err=Your%20passwords%20do%20not%20match'), false);
		} else {
			if ($newPassword != $newPasswordConfirm){
				//Passwords don't match
				Redirect(($redirUrl.'&err=Your%20new%20passwords%20do%20not%20match'), false);
			} else {
				if ($state == "--"){
					//Fix State
					Redirect(($redirUrl.'&err=Please%20pick%20a%20state'), false);
				} else {
					//checks on locationinfo
					$locationInfoCheck = validLocatorInfo($phone, $businessName, $address, $city, $genre);
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
							if ((strlen($newPassword)) > 0){
								$passwordCheck = validPassword($newPassword);
							}
							if ($passwordCheck != "good"){
								//Fix password
								Redirect(($redirUrl.'&err='.$passwordCheck), false);
							} else {
								process_employer($businessName, $genre, $city, $state, $phone, $email, $address, $password, $newPassword, $redirUrl);
							}
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


function process_employer($businessName, $genre, $city, $state, $phone, $email, $address, $password, $newPassword, $redirUrl){
	
	
	//////////
			
	$curl_connection = curl_init('https://job-circus.com/processEditEmployer2.php');

	curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($curl_connection, CURLOPT_SSL_VERIFYHOST, 1);
	curl_setopt($curl_connection, CURLOPT_CAPATH, "/home/liketheviking9/CA_certs/cacert.pem");
	curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl_connection, CURLOPT_REFERER, 'processEditEmployer.circus');
	curl_setopt($curl_connection, CURLOPT_HTTPHEADER, array("Cookie: sID=".$_COOKIE['sID']));
	
	$post_data['businessName'] = $businessName;
	$post_data['genre'] = $genre;
	$post_data['city'] = $city;
	$post_data['state'] = $state;
	$post_data['phone'] = $phone;
	$post_data['email'] = $email;
	$post_data['password'] = $password;
	$post_data['address'] = $address;
	$post_data['newPassword'] = $newPassword;
			
	
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
				

function validLocatorInfo($phone, $businessName, $address, $city, $genre){
	$rettext = "good";
	if (strlen($phone) < 10) {
        $rettext = "Phone%20number%20too%20short";
    } else if (strlen($phone) > 12) {
        $rettext = "Phone%20number%20too%20long";
    } else if (strlen($city) > 45) {
		$rettext = "City%20is%20too%20long";
	} else if (strlen($city) < 2) {
		$rettext = "City%20is%20too%20short";
	} else if (strlen($businessName) > 60) {
		$rettext = "Business%20name%20is%20too%20long";
	} else if (strlen($address) > 95) {
		$rettext = "Last%20name%20is%20too%20long";
	} else if ($genre == "--") {
        $rettext = "Please%20pick%20a%20genre";
    } else if (preg_match("#[&'.!a-zA-Z]+#", $phone)) {
        $rettext = "Phone%20number%20is%20not%20valid.";
    } else if (preg_match("#[&]+#", $businessName)) {
        $rettext = "Business%20name%20can%20not%20contain%20an%20ampersand.";
    } else if (preg_match("#[&]+#", $address)) {
        $rettext = "Address%20can%20not%20contain%20an%20ampersand.";
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

