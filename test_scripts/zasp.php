<?php
function encodeLoginDetails($email,$password){
	$combine = ($email.$password);
   	return sha1(crypt($combine, ('$6$rounds=7500')));
}	

	echo encodeLoginDetails("crawfoct@dukes.jmu.edu","uu82.4Af");
	//back();
?>