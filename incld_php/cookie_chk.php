<?php

if (isset($_COOKIE['sID'])){
	include("/home/liketheviking9/incld_php/getInfoFromSession.php");
} else {
	$b_url = "index.php";
	header('Location: ' . $b_url, true, false);
	die();
}
function allowUserType($u, $userType){
	if ($userType != $u){
		$b_url = "index.php";
		header('Location: ' . $b_url, true, false);
		die();
	}
}
?>