<?php
include("/home/liketheviking9/incld_php/redirectFunction.php");
include("/home/liketheviking9/incld_php/loginsql.php");
include("/home/liketheviking9/incld_php/cookie_chk.php");
allowUserType("w", $userType);

$workerID = $userID;

function still_process_jobresume($workerID){
	if (($_SERVER['HTTP_REFERER']) == ('processJobResume.circus')){
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
		$current = $_POST['current'];

		$redirUrl = "addJobResume.php?";
		$redirUrl = ($redirUrl.'position='.$position.'&city='.$city.'&phone='.$phone.'&employer='.$employer);
	
		$genre = mysql_real_escape_string($genre);
		$fromMonth = mysql_real_escape_string($fromMonth);
		$fromYear = mysql_real_escape_string($fromYear);
		$toMonth = mysql_real_escape_string($toMonth);
		$toYear = mysql_real_escape_string($toYear);
		$employer = mysql_real_escape_string($employer);
		$city = mysql_real_escape_string($city);
		$state = mysql_real_escape_string($state);
		$phone = mysql_real_escape_string($phone);
		$position = mysql_real_escape_string($position);
		$responsible = mysql_real_escape_string($responsible);
 		$reasonLeaving = mysql_real_escape_string($reasonLeaving);
		$comments = mysql_real_escape_string($comments);
		$current = mysql_real_escape_string($current);
		$workerID = mysql_real_escape_string($workerID);
		
		finishRegistration($genre, $fromMonth, $fromYear, $toMonth, $toYear, $employer, $city, $state, $phone, $position, $responsible, $reasonLeaving, $comments, $current, $workerID, $redirUrl);
				
	} else { 
		redirect("addJobResume.php",false);
	}
}



function finishRegistration($genre, $fromMonth, $fromYear, $toMonth, $toYear, $employer, $city, $state, $phone, $position, $responsible, $reasonLeaving, $comments, $current, $workerID, $redirUrl){
	//Add to Job History
	
	$sql = 'INSERT INTO `WorkersJobHistory` (`workExperienceID`, `workerID`, `fromMonth`, `fromYear`, `toMonth`, `toYear`, `employer`, `city`, `state`, `phone`, `position`, `responsible`, `reasonLeaving`, `comments`, `genre`, `current`) VALUES (NULL, \''.$workerID.'\', \''.$fromMonth.'\', \''.$fromYear.'\', \''.$toMonth.'\', \''.$toYear.'\', \''.$employer.'\', \''.$city.'\', \''.$state.'\', \''.$phone.'\', \''.$position.'\', \''.$responsible.'\', \''.$reasonLeaving.'\', \''.$comments.'\', \''.$genre.'\', \''.$current.'\')';
	
	mysql_query($sql) or die("Renob.");//die(mysql_error());
	echo "You now exist";
	
}


still_process_jobresume($workerID);
?>
<?php
	mysql_close($con); 
?>