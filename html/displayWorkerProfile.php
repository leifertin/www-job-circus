<?php
include("/home/liketheviking9/incld_php/redirectFunction.php");
include("/home/liketheviking9/incld_php/loginsql.php");
include("/home/liketheviking9/incld_php/cookie_chk.php");


$workerID = $_GET['wid'];

if ($workerID != $userID){
	if ($userType != "e"){
		redirect("index.php", false);
	}
}
$workerID = mysql_real_escape_string($workerID);
/*
if get_worker id is not the same as your worker id in cookies then redirect
*/
$sql = 'SELECT * FROM `Workers` WHERE `workerID` = \''.$workerID.'\' LIMIT 1';
$sql_result = mysql_query($sql);
$rows = mysql_num_rows($sql_result); 
		
if ($rows<1 ){ 
	redirect(("index.php"),false);
} else {
	while ($row= mysql_fetch_array($sql_result)) {
 		//extract user data for view
		$firstName = $row["firstname"];
		$lastName = $row["lastname"];
		$city = $row["city"];
		$state = $row["state"];
		$email = $row["email"];
		$phone = $row["phone"];
		$describeYourself = $row["describeYourself"];
		$legalWork = $row["legalWork"];
		$transpt = $row["transpt"];
		$available = $row["available"];
		$applyTo = $row["applyTo"];
		
		//if usertype is e, only allow view if applyto contains userid
		if ($userType == "e"){
		
			$appliedList = explode(",", $applyTo);
			$arrlength = count($appliedList);
			$allowView = "no";
			for($x = 0; $x < $arrlength; $x++) {
   				if ($appliedList[$x] == ""){
				} else {
					if ($appliedList[$x] == $userID){
						$allowView = "yes";
						break;
					}
				}
    		}
			if ($allowView == "no"){
				redirect("index.php", false);
			}
		}
			
	}	
}

/*
if ($workerID == $userID){
	if ($userType == "w"){
		//Get number of employers in state
		$state_sql = mysql_real_escape_string($state);
		$sql_t = 'SELECT state FROM Employers WHERE state=\''.$state_sql.'\'';
		$sql_result_t = mysql_query($sql_t);
		$numberOfEmployers = mysql_num_rows($sql_result_t);
		$numberOfEmployersText = $numberOfEmployers." employers have signed up in ".$state; 
		
		if ($numberOfEmployers > 1){ 
			$numberOfEmployersText = $numberOfEmployers." employers have signed up in ".$state; 
		} else if ($numberOfEmployers == 0){ 
			$numberOfEmployersText = "currently no employers have signed up in ".$state;
		} else if ($numberOfEmployers == 1){
			$numberOfEmployersText = "1 employer has signed up in ".$state;
		}
	} else {
		$numberOfEmployersText = "";
	}
} else {
	$numberOfEmployersText = "";
}
*/
?>
<!DOCTYPE HTML>
<html>

	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title><?php echo (htmlspecialchars($firstName, ENT_QUOTES)." ".htmlspecialchars($lastName, ENT_QUOTES)); ?>'s Profile</title>
		
		<link rel="stylesheet" type="text/css" href="css/mainCode.css" />
	</head>
	<body>
	<?php include("/home/liketheviking9/incld_php/generateMenu.php");?>
	<div id="pageContent" align="center">
		<?php
		/*if ($numberOfEmployersText != ""){
			echo("
			<p style=\"margin-top:-1em; margin-bottom:3em;\">".
			(htmlspecialchars($numberOfEmployersText, ENT_QUOTES))
			."</p>");
		}*/
		?>
		<p>
			<?php
			if ($userType =="w"){
				
				echo ("<p class=\"applyForJobButton\" style=\"margin-top:-2em; margin-bottom:2em;\">
				<a href=\"editWorkerProfile.php\"><button type=\"button\">edit profile</button></a>
				</p>");		
				
				$sql = 'SELECT * FROM `WorkersJobHistory` WHERE `workerID` = \''.$workerID.'\' ORDER BY `toYear` DESC';
				$sql_result_b = mysql_query($sql);
				$rows_b = mysql_num_rows($sql_result_b); 
				if ($rows_b < 1){
					echo("<p class=\"errorText\" style=\"margin-top:1em; margin-bottom:2em;\">scroll down to add to your employment history when ready</p>");
				}					
			}
			?>
			<div id="topProfileInfo">
				<p class="pageTitleProfile">
					<?php echo (htmlspecialchars($firstName, ENT_QUOTES)." ".htmlspecialchars($lastName, ENT_QUOTES)); ?>
				</p>
				<p class="profileAddress">
					<?php echo (htmlspecialchars($city, ENT_QUOTES).", ".htmlspecialchars($state, ENT_QUOTES)); ?>
				</p>
				<p style="margin-top:-3.5em; margin-bottom:3em;" class="contactMeLink">
					<?php echo (htmlspecialchars($phone, ENT_QUOTES)); ?> |
					<?php echo "<a href=\"mailto:".(htmlspecialchars($email, ENT_QUOTES))."\">Email</a>"; ?>
					
					
				</p>
				
				<p>
					<?php
						if ($transpt == "yes"){
							//has transportation
							echo ("<img src=\"images/checkMark.png\" height=\"20\" width=\"20\" border=\"0\"/>
					Reliable transportation");
						} else if ($transpt == "no"){
							//does not have transportation
							echo ("<img src=\"images/exMark.png\" height=\"20\" width=\"20\" border=\"0\"/>
					Does not have reliable transportation");
						}
					?>
				</p>
				<p>
					<?php
						if ($legalWork == "yes"){
							//is authorized to work
							echo ("<img src=\"images/checkMark.png\" height=\"21\" width=\"20\" border=\"0\"/>
					Authorized to work in the U.S.");
						} else if ($legalWork == "no"){
							//is not authorized to work
							echo ("<img src=\"images/exMark.png\" height=\"21\" width=\"20\" border=\"0\"/>
					Not authorized to work in the U.S.");
						}
					?>
				</p>
			</div>
			<p class="daysAndNights">
					<?php
						if ($available == "00"){
							//neither
						} else if ($available == "01") {
							//night
							echo ("available
					<span class=\"nightsText\">nights</span>");
						} else if ($available == "10") {
							//day
							echo ("available
					<span class=\"daysText\">days</span>");
						} else if ($available == "11") {
							//both
							echo ("available
					<span class=\"daysText\">days</span> &
					<span class=\"nightsText\">nights</span>");
						}
					?>
			</p>
			
			<div id="middleProfileInfo" class="content">
				<p class="profileAboutMe">
					<textarea class="profileTextArea" readonly><?php echo htmlspecialchars($describeYourself, ENT_QUOTES);?></textarea>
				</p>
			</div>
			<div id="middleProfileInfo" class="content">
				<span class="profileCategoryHeader">Employment:</span>
					<p class="profileWorkHistory">
						<?php
							
							$sql = 'SELECT * FROM `WorkersJobHistory` WHERE `workerID` = \''.$workerID.'\' ORDER BY current DESC, toYear DESC, toMonth DESC, fromYear DESC, fromMonth DESC';
							$sql_result_b = mysql_query($sql);
							$rows_b = mysql_num_rows($sql_result_b); 
							
							$i = 0;
							if ($rows_b != 0){
								if ($rows_b<1 ){ 
									redirect(("index.php"),false);
								} else {
									while ($row = mysql_fetch_array($sql_result_b)) {
										$i += 1;
 										//extract user data for view
										$city_jh = $row["city"];
										$comments_jh = $row["comments"];
										$employer_jh = $row["employer"];
										$fromMonth_jh = $row["fromMonth"];
										$fromYear_jh = $row["fromYear"];
										$genre_jh = $row["genre"];
										$phone_jh = $row["phone"];
										$position_jh = $row["position"];
										$reasonLeaving_jh = $row["reasonLeaving"];
										$responsible_jh = $row["responsible"];
										$state_jh = $row["state"];
										$toMonth_jh = $row["toMonth"];
										$toYear_jh = $row["toYear"];
										$workExperienceID_jh = $row["workExperienceID"];
										$current_jh = $row["current"];	
									
										$genre_jh = htmlspecialchars($genre_jh, ENT_QUOTES);
										$city_jh = htmlspecialchars($city_jh, ENT_QUOTES);
										$comments_jh = htmlspecialchars($comments_jh, ENT_QUOTES);
										$employer_jh = htmlspecialchars($employer_jh, ENT_QUOTES);
										$fromMonth_jh = htmlspecialchars($fromMonth_jh, ENT_QUOTES);
										$fromYear_jh = htmlspecialchars($fromYear_jh, ENT_QUOTES);
										$phone_jh = htmlspecialchars($phone_jh, ENT_QUOTES);
										$position_jh = htmlspecialchars($position_jh, ENT_QUOTES);
										$reasonLeaving_jh = htmlspecialchars($reasonLeaving_jh, ENT_QUOTES);
										$responsible_jh = htmlspecialchars($responsible_jh, ENT_QUOTES);
										$state_jh = htmlspecialchars($state_jh, ENT_QUOTES);
										$toMonth_jh = htmlspecialchars($toMonth_jh, ENT_QUOTES);
										$toYear_jh = htmlspecialchars($toYear_jh, ENT_QUOTES);
										$workExperienceID_jh = htmlspecialchars($workExperienceID_jh, ENT_QUOTES);
										$current_jh = htmlspecialchars($current_jh, ENT_QUOTES);
									
										echo ("<b>".$employer_jh."</b> - [".$genre_jh."]<br>\n");
										echo ($position_jh."\n\n");
										echo ("<p>\n<textarea class=\"jobHistoryTextArea\" readonly>\n");
										echo ($fromMonth_jh."/".$fromYear_jh." - ");
										if ($current_jh == "y"){
											echo ("Now\n");
										} else {
											echo ($toMonth_jh."/".$toYear_jh."\n");
										}
										echo ($city_jh.", ".$state_jh."\n");
										echo ($phone_jh."\n\n");
										echo ("Responsibilities:\n");
										echo ($responsible_jh."\n\n");
										
										if ($current_jh == "y"){
											echo ("\n\n");
										} else {
											echo ("Reason for leaving:\n");
											echo ($reasonLeaving_jh."\n\n");
										}
										
										
										if ((strlen($comments_jh)) > 1){
											echo ("Comments:\n");
											echo ($comments_jh."\n\n");
										}
										echo ("</textarea></p>");
										if ($userType == "w"){
											echo ("<p class=\"applyForJobButton\" style=\"padding-bottom:1em;\">
												<a href=\"deleteJobResume.php?wrkID=".$workExperienceID_jh."\"><button type=\"button\">delete job</button></a>");
										} else {
											echo ("<p>");
										}
										
										if ($i == $rows_b){
											echo ("</p><br>");
										} else {
											echo ("<br><br><hr>
												</p><br>");
										}
									}
								}	
							}
						?>
					</p>
					
				</div>
				<?php
				if ($userType == "w"){
					echo("<p class=\"applyForJobButton\" style=\"padding-bottom:1em;\">
					<a href=\"addJobResume.php\"><button type=\"button\">add job to resume</button></a></p>");
				}
				?>
				<div id="bottomProfileInfo" class="content">
					<span class="profileCategoryHeader">Education:</span>
					<p class="profileSchools">
						<?php
							
							$sql = 'SELECT * FROM `WorkersSchoolHistory` WHERE `workerID` = \''.$workerID.'\' ORDER BY current DESC, toYear DESC, toMonth DESC, fromYear DESC, fromMonth DESC';
							$sql_result_b = mysql_query($sql);
							$rows_b = mysql_num_rows($sql_result_b); 
							
							$i = 0;
							if ($rows_b != 0){
								if ($rows_b<1 ){ 
									redirect(("index.php"),false);
								} else {
									while ($row = mysql_fetch_array($sql_result_b)) {
										$i += 1;
 										//extract user data for view
										$city_sh = $row["city"];
										$country_sh = $row["country"];
										$fromMonth_sh = $row["fromMonth"];
										$fromYear_sh = $row["fromYear"];
										$genre_sh = $row["genre"];
										$major_sh = $row["major"];
										$schoolExperienceID_sh = $row["schoolExperienceID"];
										$schoolName_sh = $row["schoolName"];
										$state_sh = $row["state"];
										$toMonth_sh = $row["toMonth"];
										$toYear_sh = $row["toYear"];
										$current_sh = $row["current"];
										
										$city_sh = htmlspecialchars($city_sh, ENT_QUOTES);
										$country_sh = htmlspecialchars($country_sh, ENT_QUOTES);
										$fromMonth_sh = htmlspecialchars($fromMonth_sh, ENT_QUOTES);
										$fromYear_sh = htmlspecialchars($fromYear_sh, ENT_QUOTES);
										$genre_sh = htmlspecialchars($genre_sh, ENT_QUOTES);
										$major_sh = htmlspecialchars($major_sh, ENT_QUOTES);
										$schoolExperienceID_sh = htmlspecialchars($schoolExperienceID_sh, ENT_QUOTES);
										$schoolName_sh = htmlspecialchars($schoolName_sh, ENT_QUOTES);
										$state_sh = htmlspecialchars($state_sh, ENT_QUOTES);
										$toMonth_sh = htmlspecialchars($toMonth_sh, ENT_QUOTES);
										$toYear_sh = htmlspecialchars($toYear_sh, ENT_QUOTES);
										$current_sh = htmlspecialchars($current_sh, ENT_QUOTES);
									
										echo ("<b>".$schoolName_sh."</b>\n");
										echo ("<p>\n<textarea class=\"schoolHistoryTextArea\" readonly>\n");
										if ($genre_sh != "Other"){
											echo ($genre_sh."\n");
										}
										echo ($fromMonth_jh."/".$fromYear_jh." - ");
										if ($current_jh == "y"){
											echo ("Now\n");
										} else {
											echo ($toMonth_jh."/".$toYear_jh."\n");
										}
										if ($state_sh == "International"){
											echo ($city_sh.", ".$country_sh."\n");
										} else {	
											echo ($city_sh.", ".$state_sh."\n");
										}
										if ((strlen($major_sh)) > 1){
											echo ($major_sh."\n");
										}
										echo ("</textarea></p>");
										if ($userType == "w"){
											echo ("<p class=\"applyForJobButton\" style=\"padding-bottom:1em;\">
												<a href=\"deleteSchoolResume.php?schID=".$schoolExperienceID_sh."\"><button type=\"button\">delete school</button></a>");
										} else {
											echo ("<p>");
										}
										if ($i == $rows_b){
											echo ("</p><br>");
										} else {
											echo ("<br><br><hr>
												</p><br>");
										}
									}	
								}
							}
						?>
					</p>
				</div>
				<?php
				if ($userType == "w"){
					echo("<p class=\"applyForJobButton\" style=\"padding-bottom:1em;\">
					<a href=\"addSchoolResume.php\"><button type=\"button\">add school to resume</button></a></p>");
				}
				?>
				
			</div>
  		</p>	
	</div>
	<?php include("/home/liketheviking9/incld_php/generateFooter.php");?>
	</body>
</html>
<?php
	mysql_close($con); 
?>