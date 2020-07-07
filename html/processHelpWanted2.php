<?php
include("/home/liketheviking9/incld_php/redirectFunction.php");
include("/home/liketheviking9/incld_php/loginsql.php");
include("/home/liketheviking9/incld_php/cookie_chk.php");
allowUserType("e", $userType);

$employerID = $userID;

function still_process_helpwanted($employerID){
	if (($_SERVER['HTTP_REFERER']) == ('processHelpWanted.circus')){
		$position = $_POST['position'];
		$wage = $_POST['wage'];
		$tips = $_POST['tips'];
		$responsible = $_POST['responsible'];
		$qualify = $_POST['qualify'];
		$comments = $_POST['comments'];

		$redirUrl = "helpWanted.php?";
		$redirUrl = ($redirUrl.'position='.$position.'&wage='.$wage);
		
		$employerID = mysql_real_escape_string($employerID);
		$sql = 'SELECT * FROM `Employers` WHERE `employerID` = \''.$employerID.'\'';
		$sql_result_b = mysql_query($sql);
		$rows_b = mysql_num_rows($sql_result_b); 
		if ($rows_b!=1 ){ 
			redirect(("index.php"),false);
		} else {
			while ($row = mysql_fetch_array($sql_result_b)) {
 				//extract user data for view
				$city = $row["city"];
				$state = $row["state"];
				$businessName = $row["businessName"];
				$genre = $row["genre"];
			}	
		}
						
		$genre = mysql_real_escape_string($genre);
		$position = mysql_real_escape_string($position);
		$wage = mysql_real_escape_string($wage);
		$tips = mysql_real_escape_string($tips);
		$responsible = mysql_real_escape_string($responsible);
		$qualify = mysql_real_escape_string($qualify);
		$comments = mysql_real_escape_string($comments);
		
		$city = mysql_real_escape_string($city);
		$state = mysql_real_escape_string($state);
		$businessName = mysql_real_escape_string($businessName);
		
		finishRegistration($genre, $position, $wage, $tips, $responsible, $qualify, $comments, $employerID, $city, $state, $businessName, $redirUrl);
				
	} else { 
		redirect("helpWanted.php",false);
	}
}



function finishRegistration($genre, $position, $wage, $tips, $responsible, $qualify, $comments, $employerID, $city, $state, $businessName, $redirUrl){
	//Add to Job History
	
	$sql = 'INSERT INTO `Jobs` (`postingID`, `employerID`, `businessName`, `position`, `genre`, `wage`, `tips`, `responsible`, `qualify`, `comments`, `applicantIDs`, `city`, `state`, `postingDate`) VALUES (NULL, \''.$employerID.'\', \''.$businessName.'\', \''.$position.'\', \''.$genre.'\', \''.$wage.'\', \''.$tips.'\', \''.$responsible.'\', \''.$qualify.'\', \''.$comments.'\', \',\', \''.$city.'\', \''.$state.'\', NOW())';
	
	mysql_query($sql) or die("Renob.");
	
	//////
	
	
	$sql = 'SELECT `numJobs` FROM `Employers` WHERE `employerID` = \''.$employerID.'\'';
	$sql_result = mysql_query($sql);
	$rows = mysql_num_rows($sql_result); 
		
	if ($rows<1 ){ 
		redirect(("index.php"),false);
	} else {
		while ($row= mysql_fetch_array($sql_result)) {
 			//extract user data for view
			$numJobs = $row["numJobs"];
			$numJobs += 1;
		}	
	}
	$numJobs = mysql_real_escape_string($numJobs);
	$sql = "UPDATE `Employers` SET `numJobs`='".$numJobs."' WHERE `employerID` = '".$employerID."'";
	//$sql = 'INSERT INTO `Employers` (`applicantIDs`) VALUES (\''.$applicantIDs.'\')';
	mysql_query($sql) or die("Renob.");//die(mysql_error());
	echo "You now exist";
	
}


still_process_helpwanted($employerID);
?>
<?php
	mysql_close($con); 
?>