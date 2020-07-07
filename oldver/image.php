
<?php
	//CHECK FOR COOKIES
	
	include("incld/redirectFunction.php");
	include("incld/loginsql.php");
	include("incld/recallPicture.php");
	
	function displayProfilePicture($name){
    	$mimes = array
    	(
        	'jpg' => 'image/jpg',
        	'jpeg' => 'image/jpg',
        	'gif' => 'image/gif',
        	'png' => 'image/png'
    	);

    	$ext = strtolower(end(explode('.', $name)));

    	$file = 'pimg_f/'.$name;
    	$fp = fopen($file, 'rb');
    	
		// send the right headers
		header('Content-Type: '. $mimes[$ext]);
		header("Content-Length: " . filesize($file));

		// dump the picture and stop the script
		fpassthru($fp);
		exit;
	}
	
	
	
	$getT = ($_GET['t']);
	$getID = ($_GET['id']);
	$getPic = recallPicture($getT,$getID);
	$getPic = $getT.$getID."_".$getPic;
	displayProfilePicture($getPic);
?>