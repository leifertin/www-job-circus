<?php
function encodeLoginDetails($email,$password){
	$combine = ($email.$password);
   	return sha1(crypt($combine, ('$6$rounds=7500')));
}
?>