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

if ($tips != "yes"){
	$tips = "";
} else {
	$tips = "*";
}

$redirUrl = "helpWanted.php?";
$redirUrl = ($redirUrl.'position='.$position.'&wage='.$wage);


if (isset($position) && isset($wage) && isset($responsible)){
	
	if ($genre == "--"){
	 	//Genre missing
		Redirect(($redirUrl.'err=Please%20provide%20a%20genre'), false);
	} else {
		//checks on locationinfo
		$locationInfoCheck = validLocatorInfo($position, $responsible, $qualify, $comments);
		if ($locationInfoCheck != "good"){
			//Fix Locator
			Redirect(($redirUrl.'&err='.$locationInfoCheck), false);
		} else {
			$wage = preg_replace('/[^0-9.]/','',$wage);
			process_helpwanted($position, $wage, $tips, $qualify, $responsible, $comments, $redirUrl);
		}
	}
} else {
	//redirect
	Redirect(($redirUrl."&err=Please%20fill%20out%20all%20required%20fields"), false);
	
}


function process_helpwanted($position, $wage, $tips, $qualify, $responsible, $comments, $redirUrl){
	
	
	//////////
			
	$curl_connection = curl_init('https://job-circus.com/processHelpWanted2.php');

	curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($curl_connection, CURLOPT_SSL_VERIFYHOST, 1);
	curl_setopt($curl_connection, CURLOPT_CAPATH, "/home/liketheviking9/CA_certs/cacert.pem");
	curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl_connection, CURLOPT_REFERER, 'processHelpWanted.circus');
	curl_setopt($curl_connection, CURLOPT_HTTPHEADER, array("Cookie: sID=".$_COOKIE['sID']));
	
	$post_data['position'] = $position;
	$post_data['wage'] = $wage;
	$post_data['tips'] = $tips;
	$post_data['qualify'] = $qualify;
	$post_data['responsible'] = $responsible;
	$post_data['comments'] = $comments;
	
	
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
				

function validLocatorInfo($position, $responsible, $qualify, $comments) {
	$rettext = "good";
	if (strlen($position) > 90) {
		$rettext = "Position20is%20too%20long";
	} else if (strlen($responsible) > 400) {
		$rettext = "Last%20name%20is%20too%20long";
	} else if (strlen($qualify) > 450) {
        $rettext = "The%20qualifications%20are%20a%20bit%20too%20long";
    } else if (strlen($comments) > 350) {
        $rettext = "Your%20description%20of%20yourself%20is%20a%20bit%20long";
   	}
	return $rettext;
}



?>

