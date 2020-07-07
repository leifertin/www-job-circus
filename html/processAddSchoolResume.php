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
$schoolName = $_POST['schoolName'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];
$major = $_POST['major'];
$current = $_POST['currentSchool'];

$redirUrl = "addSchoolResume.php?";
$redirUrl = ($redirUrl.'schoolName='.$schoolName.'&city='.$city.'&country='.$country.'&major='.$major);

if ($current == "yes"){
	$current = "y";
} else {
	$current = "n";
}


if (isset($genre) && isset($fromMonth) && isset($fromYear) && isset($toMonth) && isset($toYear) && isset($schoolName) && isset($city) && isset($state)){
	
	if ($genre == "--"){
	 	//Genre missing
		Redirect(($redirUrl.'err=Please%20provide%20a%20genre'), false);
	} else {
		if ($state == "--"){
			//Fix State
			Redirect(($redirUrl.'&err=Please%20pick%20a%20state'), false);
		} else {
			//checks on locationinfo
			$locationInfoCheck = validLocatorInfo($schoolName, $country, $city, $major);
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
					process_schoolresume($genre, $fromMonth, $fromYear, $toMonth, $toYear, $schoolName, $city, $state, $country, $major, $current, $redirUrl);
				}
			}
		}
	}
} else {
	//redirect
	Redirect(($redirUrl."&err=Please%20fill%20out%20all%20required%20fields"), false);
	
}


function process_schoolresume($genre, $fromMonth, $fromYear, $toMonth, $toYear, $schoolName, $city, $state, $country, $major, $current, $redirUrl){
	
	
	//////////
			
	$curl_connection = curl_init('https://job-circus.com/processAddSchoolResume2.php');

	curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($curl_connection, CURLOPT_SSL_VERIFYHOST, 1);
	curl_setopt($curl_connection, CURLOPT_CAPATH, "/home/liketheviking9/CA_certs/cacert.pem");
	curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl_connection, CURLOPT_REFERER, 'processSchoolResume.circus');
	curl_setopt($curl_connection, CURLOPT_HTTPHEADER, array("Cookie: sID=".$_COOKIE['sID']));
	
	$post_data['genre'] = $genre;
	$post_data['fromMonth'] = $fromMonth;
	$post_data['fromYear'] = $fromYear;
	$post_data['toMonth'] = $toMonth;
	$post_data['toYear'] = $toYear;
	$post_data['schoolName'] = $schoolName;
	$post_data['city'] = $city;
	$post_data['state'] = $state;
	$post_data['country'] = $country;
	$post_data['major'] = $major;
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
				

function validLocatorInfo($schoolName, $country, $city, $major) {
	$rettext = "good";
	if (strlen($schoolName) < 2) {
        $rettext = "School20name%20too%20short";
    } else if (strlen($schoolName) > 100) {
        $rettext = "School%20name%20too%20long";
    } else if (strlen($city) > 45) {
		$rettext = "City%20is%20too%20long";
	} else if (strlen($city) < 2) {
		$rettext = "City%20is%20too%20short";
	} else if (strlen($country) > 85) {
		$rettext = "Country20is%20too%20long";
	} else if (strlen($major) > 100) {
		$rettext = "Major%20is%20too%20long";
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

