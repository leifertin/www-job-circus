<?php
include("incld/redirectFunction.php");
include("incld/loginsql.php");

$workerID = $_GET['wid'];
$workerID = mysql_real_escape_string($workerID);
/*
if get_worker id is not the same as your worker id in cookies then redirect
*/
$sql = 'SELECT * FROM `Workers` WHERE `workerID` = \''.$workerID.'\'';
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
		$picture = $row["picture"];
		$describeYourself = $row["describeYourself"];
		$legalWork = $row["legalWork"];
		$transpt = $row["transpt"];
		$available = $row["available"];	
	}	
}

?>
<!DOCTYPE HTML>
<html>

	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title>Display Worker Profile</title>
		
		<link rel="stylesheet" type="text/css" href="../css/mainCode.css" />
	</head>
	<body>
	<div id="topNav">
		<ul>
  			<li class="topNav-jobs"><a href="#">Search</a></li>
  			<li class="topNav-applicants"><a href="#">Applied</a></li>
			<li class="topNav-profile"><a href="#">Profile</a></li>
			<li class="topNav-logInOut"><a href="#">Log Out</a></li>
		</ul>
	</div>
	<div id="pageContent" align="center">
		<p>
			
			<div id="topProfileInfo">
				<div id="employerProfilePicture" style="background-image: url('../images/testProfilePic.jpg');">
				</div><br><br>
				<p class="pageTitleProfile">
					<?php echo (htmlspecialchars($firstName, ENT_QUOTES)." ".htmlspecialchars($lastName, ENT_QUOTES)); ?>
				</p>
				<p class="profileAddress">
					<?php echo (htmlspecialchars($city, ENT_QUOTES).", ".htmlspecialchars($state, ENT_QUOTES)); ?>
				</p>
				<p>
					<?php
						if ($transpt == "yes"){
							//has transportation
							echo ("<img src=\"../images/checkMark.png\" height=\"20\" width=\"20\" border=\"0\"/>
					Reliable transportation.");
						} else if ($transpt == "no"){
							//does not have transportation
							echo ("<img src=\"../images/exMark.png\" height=\"20\" width=\"20\" border=\"0\"/>
					Does not have reliable transportation.");
						}
					?>
				</p>
				<p>
					<?php
						if ($legalWork == "yes"){
							//is authorized to work
							echo ("<img src=\"../images/checkMark.png\" height=\"21\" width=\"20\" border=\"0\"/>
					Authorized to work in the U.S.");
						} else if ($legalWork == "no"){
							//is not authorized to work
							echo ("<img src=\"../images/exMark.png\" height=\"21\" width=\"20\" border=\"0\"/>
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
							
							$sql = 'SELECT * FROM `WorkersJobHistory` WHERE `workerID` = \''.$workerID.'\' ORDER BY `toYear` DESC';
							$sql_result_b = mysql_query($sql);
							$rows_b = mysql_num_rows($sql_result_b); 
							
							if ($rows_b<1 ){ 
								redirect(("index.php"),false);
							} else {
								while ($row = mysql_fetch_array($sql_result_b)) {
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
									
									echo ("<b>".$employer_jh."</b> - [".$genre_jh."]<br>\n");
									echo ("<p>\n<textarea class=\"jobHistoryTextArea\" readonly>\n");
									echo ($fromMonth_jh."/".$fromYear_jh." - ".$toMonth_jh."/".$toYear_jh."\n");
									echo ($city_jh.", ".$state_jh."\n");
									echo ($phone_jh."\n");
									echo ($position_jh."\n\n");
									echo ("Responsibilities:\n");
									echo ($responsible_jh."\n\n");
									echo ("Reason for leaving:\n");
									echo ($reasonLeaving_jh."\n\n");
									if ((strlen($comments_jh)) > 1){
										echo ("Comments:\n");
										echo ($comments_jh."\n\n");
									}
									echo ("</textarea></p>");
								}	
							}
						?>
					</p>
				</div>
				<div id="bottomProfileInfo" class="content">
					<span class="profileCategoryHeader">Education:</span>
					<p class="profileSchools">
						<?php
							
							$sql = 'SELECT * FROM `WorkersSchoolHistory` WHERE `workerID` = \''.$workerID.'\' ORDER BY `toYear` DESC';
							$sql_result_b = mysql_query($sql);
							$rows_b = mysql_num_rows($sql_result_b); 
							
							if ($rows_b<1 ){ 
								redirect(("index.php"),false);
							} else {
								while ($row = mysql_fetch_array($sql_result_b)) {
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
									
									echo ("<b>".$schoolName_sh."</b>\n");
									echo ("<p>\n<textarea class=\"schoolHistoryTextArea\" readonly>\n");
									echo ($genre_sh."\n");
									echo ($fromMonth_sh."/".$fromYear_sh." - ".$toMonth_sh."/".$toYear_sh."\n");
									if ($state_sh == "International"){
										echo ($city_sh.", ".$country_sh."\n");
									} else {	
										echo ($city_sh.", ".$state_sh."\n");
									}
									if ((strlen($major_sh)) > 1){
										echo ($major_sh."\n\n");
									}
									echo ("</textarea></p>");
								}	
							}
						?>
					</p>
				</div>
				<p class="contactMeLink" align="center">
					<p>
						Phone: <?php echo htmlspecialchars($phone, ENT_QUOTES);?> |
						Email: <?php echo htmlspecialchars($email, ENT_QUOTES);?>
					</p>
				</p>
			</div>
  		</p>	
	</div>
	</body>
</html>
<?php
	mysql_close($con); 
?>