<?php
include("/home/liketheviking9/incld_php/redirectFunction.php");
include("/home/liketheviking9/incld_php/loginsql.php");
include("/home/liketheviking9/incld_php/cookie_chk.php");
allowUserType("w", $userType);

$workerID = $userID;

function still_process_schoolresume($workerID){
	if (($_SERVER['HTTP_REFERER']) == ('processSchoolResume.circus')){
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
		$current = $_POST['current'];

		$redirUrl = "addSchoolResume.php?";
		$redirUrl = ($redirUrl.'schoolName='.$schoolName.'&city='.$city.'&country='.$country.'&major='.$major);
	
		$genre = mysql_real_escape_string($genre);
		$fromMonth = mysql_real_escape_string($fromMonth);
		$fromYear = mysql_real_escape_string($fromYear);
		$toMonth = mysql_real_escape_string($toMonth);
		$toYear = mysql_real_escape_string($toYear);
		$schoolName = mysql_real_escape_string($schoolName);
		$city = mysql_real_escape_string($city);
		$state = mysql_real_escape_string($state);
		$country = mysql_real_escape_string($country);
		$major = mysql_real_escape_string($major);
		$workerID = mysql_real_escape_string($workerID);
		$current = mysql_real_escape_string($current);
		
		finishRegistration($genre, $fromMonth, $fromYear, $toMonth, $toYear, $schoolName, $city, $state, $country, $major, $current, $workerID, $redirUrl);
				
	} else { 
		redirect("addSchoolResume.php",false);
	}
}



function finishRegistration($genre, $fromMonth, $fromYear, $toMonth, $toYear, $schoolName, $city, $state, $country, $major, $current, $workerID, $redirUrl){
	//Add to School History
	
	$sql = 'INSERT INTO `WorkersSchoolHistory` (`schoolExperienceID`, `workerID`, `schoolName`, `fromMonth`, `fromYear`, `toMonth`, `toYear`, `genre`, `city`, `state`, `country`, `major`, `current`) VALUES (NULL, \''.$workerID.'\', \''.$schoolName.'\', \''.$fromMonth.'\', \''.$fromYear.'\', \''.$toMonth.'\', \''.$toYear.'\', \''.$genre.'\', \''.$city.'\', \''.$state.'\', \''.$country.'\', \''.$major.'\', \''.$current.'\')';
	
	mysql_query($sql) or die("error");//die(mysql_error());
	echo "You now exist";
	
}


still_process_schoolresume($workerID);
?>
<?php
	mysql_close($con); 
?>