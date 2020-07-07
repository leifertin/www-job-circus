<?php
include("/home/liketheviking9/incld_php/redirectFunction.php");
include("/home/liketheviking9/incld_php/loginsql.php");
include("/home/liketheviking9/incld_php/cookie_chk.php");
allowUserType("e", $userType);

$position = $_POST['position'];
$wage = $_POST['wage'];
$tips = $_POST['tips'];
$responsible = $_POST['responsible'];
$qualify = $_POST['qualify'];
$comments = $_POST['comments'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordConfirm = $_POST['passwordConfirm'];
$postingID = $_POST['pID'];


$redirUrl = "editHelpWanted.php?pID=".$postingID;


if ($tips != "yes"){
	$tips = "";
} else {
	$tips = "*";
}


if (isset($position) && isset($wage) && isset($tips) && isset($responsible) && isset($password) && isset($passwordConfirm) && isset($email)){
	
	if ($password == ""){
	 	//Password missing
		Redirect(($redirUrl.'&err=Please%20provide%20a%20password'), false);
	} else {
		if ($password != $passwordConfirm){
			//Passwords don't match
			Redirect(($redirUrl.'&err=Your%20passwords%20do%20not%20match'), false);
		} else {
			//checks on locationinfo
			$locationInfoCheck = validLocatorInfo($position, $responsible, $qualify, $comments);
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
						$wage = preg_replace('/[^0-9.]/','',$wage);
						process_helpwanted($position, $wage, $tips, $responsible, $qualify, $comments, $email, $password, $postingID, $redirUrl);
					}
				}
			}
		}
	}
} else {
	//redirect
	Redirect(($redirUrl."&err=Please%20fill%20out%20all%20required%20fields"), false);
	
}


function process_helpwanted($position, $wage, $tips, $responsible, $qualify, $comments, $email, $password, $postingID, $redirUrl){
	
	
	//////////
			
	$curl_connection = curl_init('https://job-circus.com/processEditHelpWanted2.php');

	curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($curl_connection, CURLOPT_SSL_VERIFYHOST, 1);
	curl_setopt($curl_connection, CURLOPT_CAPATH, "/home/liketheviking9/CA_certs/cacert.pem");
	curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl_connection, CURLOPT_REFERER, 'processEditHelpWanted.circus');
	curl_setopt($curl_connection, CURLOPT_HTTPHEADER, array("Cookie: sID=".$_COOKIE['sID']));

	
	$post_data['position'] = $position;
	$post_data['wage'] = $wage;
	$post_data['tips'] = $tips;
	$post_data['responsible'] = $responsible;
	$post_data['qualify'] = $qualify;
	$post_data['email'] = $email;
	$post_data['password'] = $password;
	$post_data['comments'] = $comments;
	$post_data['postingID'] = $postingID;
			
	
	foreach ( $post_data as $key => $value) 
	{
		$post_items[] = $key . '=' . $value;
	}
	$post_string = implode ('&', $post_items);

	curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);

	$myConfirmationReturn = curl_exec($curl_connection);
	curl_close($curl_connection);
	
	redirect(($redirUrl."&err=".$myConfirmationReturn), false);
	
	//echo $myConfirmationReturn;					
	/////////////////
	
}
				

function validLocatorInfo($position, $responsible, $qualify, $comments) {
	$rettext = "good";
	if (strlen($position) > 90) {
        $rettext = "Position%20too%20long";
    } else if (strlen($responsible) > 400) {
		$rettext = "Please%20keep%20the%20responsibilities%20under%20400%20characters";
	} else if (strlen($qualify) > 450) {
		$rettext = "Please%20keep%20the%20qualifications%20under%20450%20characters";
	} else if (strlen($comments) > 350) {
		$rettext = "Please%20keep%20the%20comments%20under%20350%20characters";
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
    }

	return $rettext;
}




?>

