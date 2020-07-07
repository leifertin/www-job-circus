<?php
include("/home/liketheviking9/incld_php/redirectFunction.php");
if (isset($_COOKIE['sID'])){
	redirect(("index.php"), false);
}
$business = $_POST['businessName'];
$genre = $_POST['genre'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$emailConfirm = $_POST['emailConfirm'];
$password = $_POST['password'];
$passwordConfirm = $_POST['passwordConfirm'];

$redirUrl = "createEmployerProfile.php?";
$redirUrl = ($redirUrl.'businessName='.$business.'&genre='.$genre.'&address='.$address.'&city='.$city.'&state='.$state.'&phone='.$phone.'&email='.$email);

if (isset($business) && isset($genre) && isset($address) && isset($city) && isset($state) && isset($phone) && isset($email) && isset($emailConfirm) && isset($password) && isset($passwordConfirm)){
	
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
					if ($genre == "--"){
						//Fix Genre
						Redirect(($redirUrl.'&err=Please%20pick%20a%20genre'), false);
					} else {
						//checks on business
						if (validBusinessName($business) != "good"){
							//Fix Business
							Redirect(($redirUrl.'&err=Your%20business%20name%20is%20too%20long'), false);
						} else {
							//checks on locationinfo
							$locationInfoCheck = validLocatorInfo($phone,$address,$city);
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
									process_employer($business, $genre, $address, $city, $state, $phone, $email, $password, $redirUrl);
								}
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


function process_employer($business, $genre, $address, $city, $state, $phone, $email, $password, $redirUrl){
			
			
	//////////
	sleep(1);
	$businessName = str_replace("&","and",$businessName);		
	$curl_connection = curl_init('https://job-circus.com/processNewEmployer2.php');

	curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($curl_connection, CURLOPT_SSL_VERIFYHOST, 1);
	curl_setopt($curl_connection, CURLOPT_CAPATH, "/home/liketheviking9/CA_certs/cacert.pem");
	curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl_connection, CURLOPT_REFERER, 'processNewEmployer.circus');


	$post_data['businessName'] = $business;
	$post_data['genre'] = $genre;
	$post_data['address'] = $address;
	$post_data['city'] = $city;
	$post_data['state'] = $state;
	$post_data['phone'] = $phone;
	$post_data['email'] = $email;
	$post_data['password'] = $password;
			
	
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
				


function validBusinessName($business){
	$isValid = "good";
	$aliasLen = strlen($business);
      
	if ($aliasLen > 60){
    	// length is wrong
     	$isValid = "bad";
     }
	
   return $isValid;
}

function validLocatorInfo($phone,$address,$city) {
	$rettext = "good";
	if (strlen($phone) < 10) {
        $rettext = "Phone%20number%20too%20short";
    } else if (strlen($phone) > 12) {
        $rettext = "Phone%20number%20too%20long";
    } else if (strlen($address) < 4) {
		$rettext = "Address%20is%20too%20short";
	} else if (strlen($address) > 95) {
		$rettext = "Address%20is%20too%20long";
	} else if (strlen($city) > 45) {
		$rettext = "City%20is%20too%20long";
	} else if (strlen($city) < 2) {
		$rettext = "City%20is%20too%20short";
	} else if (preg_match("#[&'.!a-zA-Z]+#", $phone)) {
        $rettext = "Phone%20number%20is%20not%20valid.";
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

<?php
	mysql_close($con); 
?>
