<?php
include("/home/liketheviking9/incld_php/redirectFunction.php");
include("/home/liketheviking9/incld_php/loginsql.php");
include("/home/liketheviking9/incld_php/cookie_chk.php");
allowUserType("w", $userType);
	
$genre = $_POST['genre'];
$fromMonth = $_POST['fromMonth'];
$fromYear = $_POST['fromYear'];
$toMonth = $_POST['toMonth'];
$toYear = $_POST['toYear'];
$employer = $_POST['employer'];
$city = $_POST['city'];
$state = $_POST['state'];
$phone = $_POST['phone'];
$position = $_POST['position'];
$responsible = $_POST['responsible'];
$reasonLeaving = $_POST['reasonLeaving'];
$comments = $_POST['comments'];
$current = $_POST['currentJob'];

$redirUrl = "addJobResume.php?";
$redirUrl = ($redirUrl.'position='.$position.'&city='.$city.'&phone='.$phone.'&employer='.$employer);


if ($current == "yes"){
	$current = "y";
} else {
	$current = "n";
}

if (isset($genre) && isset($fromMonth) && isset($fromYear) && isset($toMonth) && isset($toYear) && isset($employer) && isset($city) && isset($state) && isset($phone) && isset($position) && isset($responsible)){
	
	if ($genre == "--"){
	 	//Genre missing
		Redirect(($redirUrl.'err=Please%20provide%20a%20genre'), false);
	} else {
		if ($state == "--"){
			//Fix State
			Redirect(($redirUrl.'&err=Please%20pick%20a%20state'), false);
		} else {
			//checks on locationinfo
			$locationInfoCheck = validLocatorInfo($phone, $position, $city, $responsible, $reasonLeaving, $comments, $employer);
			if ($locationInfoCheck != "good"){
				//Fix Locator
				Redirect(($redirUrl.'&err='.$locationInfoCheck), false);
			} else {
				//check dates
				$datesCheck = validDates($fromMonth, $toMonth, $fromYear, $toYear);
				if ($datesCheck != "good"){
					//Fix dates
					Redirect(($redirUrl.'&err='.$datesCheck), false);
				} else {
					process_jobresume($genre, $fromMonth, $fromYear, $toMonth, $toYear, $employer, $city, $state, $phone, $position, $responsible, $reasonLeaving, $comments, $current, $redirUrl);
				}
			}
		}
	}
} else {
	//redirect
	Redirect(($redirUrl."&err=Please%20fill%20out%20all%20required%20fields"), false);
	
}


function process_jobresume($genre, $fromMonth, $fromYear, $toMonth, $toYear, $employer, $city, $state, $phone, $position, $responsible, $reasonLeaving, $comments, $current, $redirUrl){
	
	
	//////////
			
	$curl_connection = curl_init('https://job-circus.com/processAddJobResume2.php');

	curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($curl_connection, CURLOPT_SSL_VERIFYHOST, 1);
	curl_setopt($curl_connection, CURLOPT_CAPATH, "/home/liketheviking9/CA_certs/cacert.pem");
	curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl_connection, CURLOPT_REFERER, 'processJobResume.circus');
	curl_setopt($curl_connection, CURLOPT_HTTPHEADER, array("Cookie: sID=".$_COOKIE['sID']));
	
	$post_data['genre'] = $genre;
	$post_data['fromMonth'] = $fromMonth;
	$post_data['fromYear'] = $fromYear;
	$post_data['toMonth'] = $toMonth;
	$post_data['toYear'] = $toYear;
	$post_data['employer'] = $employer;
	$post_data['city'] = $city;
	$post_data['state'] = $state;
	$post_data['phone'] = $phone;
	$post_data['position'] = $position;
	$post_data['responsible'] = $responsible;
	$post_data['reasonLeaving'] = $reasonLeaving;
	$post_data['comments'] = $comments;
	$post_data['current'] = $current;
	
	
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
				

function validLocatorInfo($phone, $position, $city, $responsible, $reasonLeaving, $comments, $employer) {
	$rettext = "good";
	if (strlen($phone) < 10) {
        $rettext = "Phone%20number%20too%20short";
    } else if (strlen($phone) > 12) {
        $rettext = "Phone%20number%20too%20long";
    } else if (strlen($city) > 45) {
		$rettext = "City%20is%20too%20long";
	} else if (strlen($city) < 2) {
		$rettext = "City%20is%20too%20short";
	} else if (strlen($position) > 90) {
		$rettext = "Position20is%20too%20long";
	} else if (strlen($responsible) > 400) {
		$rettext = "Last%20name%20is%20too%20long";
	} else if (strlen($reasonLeaving) > 250) {
        $rettext = "Your%20reason%20for%20leaving%20is%20too%20long";
    } else if (strlen($comments) > 350) {
        $rettext = "Your%20description%20of%20yourself%20is%20a%20bit%20long";
    } else if (strlen($employer) > 60) {
        $rettext = "The%20name%20of%20your%20employer%20is%20a%20bit%20long";
    }
	return $rettext;
}


function validDates($fromMonth, $toMonth, $fromYear, $toYear) {
	$rettext = "good";
	if ($fromMonth == "Month") {
        $rettext = "Please%20pick%20a%20starting%20month";
    } else if ($toMonth == "Month") {
        $rettext = "Please%20pick%20an%20end%20month";
    } else if ($fromYear == "Year") {
        $rettext = "Please%20pick%20a%20starting%20year";
    } else if ($toYear == "Year") {
        $rettext = "Please%20pick%20an%20end%20year";
    }
	return $rettext;
}


?>

