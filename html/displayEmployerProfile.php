<?php
include("/home/liketheviking9/incld_php/redirectFunction.php");
include("/home/liketheviking9/incld_php/loginsql.php");
include("/home/liketheviking9/incld_php/cookie_chk.php");

function contains($needle, $haystack){
	return strpos($haystack, $needle) !== false;
}

$employerID = $_GET['eid'];
$employerID = mysql_real_escape_string($employerID);
$userID = mysql_real_escape_string($userID);

if ($userType == "e"){
	if ($employerID != $userID){
		redirect("index.php", false);
	}
}

$sql = 'SELECT * FROM `Employers` WHERE `employerID` = \''.$employerID.'\'';
$sql_result = mysql_query($sql);
$rows = mysql_num_rows($sql_result); 
		
if ($rows<1 ){ 
	redirect(("index.php"),false);
} else {
	while ($row = mysql_fetch_array($sql_result)) {
 		//extract user data for view
		$businessName = $row["businessName"];
		$genre = $row["genre"];
		$address = $row["address"];
		$city = $row["city"];
		$state = $row["state"];
		$phone = $row["phone"];
		$email = $row["email"];
		$numJobs = $row["numJobs"];
		if (intval($numJobs) < 1){
			if ($userType == "w"){
				redirect(("index.php"),false);
			}
		}	
	}	
}

/*
if ($employerID == $userID){
	if ($userType == "e"){
		//Get number of employers in state
		$state_sql = mysql_real_escape_string($state);
		$sql_t = 'SELECT state FROM Workers WHERE state=\''.$state_sql.'\'';
		$sql_result_t = mysql_query($sql_t);
		$numberOfWorkers = mysql_num_rows($sql_result_t);
		$numberOfWorkersText = $numberOfWorkers." job-seekers have signed up in ".$state; 
		
		if ($numberOfWorkers > 1){ 
			$numberOfWorkersText = $numberOfWorkers." job-seekers have signed up in ".$state; 
		} else if ($numberOfWorkers == 0){ 
			$numberOfWorkersText = "currently no job-seekers have signed up in ".$state;
		} else if ($numberOfWorkers == 1){
			$numberOfWorkersText = "1 job-seeker has signed up in ".$state;
		}
	} else {
		$numberOfWorkersText = "";
	}
} else {
	$numberOfWorkersText = "";
}*/
?>
<!DOCTYPE HTML>
<html>

	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title><?php echo (htmlspecialchars($businessName, ENT_QUOTES)); ?>'s Profile</title>
		
		<link rel="stylesheet" type="text/css" href="css/mainCode.css" />
	</head>
	<body>
	<?php include("/home/liketheviking9/incld_php/generateMenu.php");?>
	<div id="pageContent" align="center">
		<?php
		/*if ($numberOfWorkersText != ""){
			echo("
			<p style=\"margin-top:-1em; margin-bottom:3em;\">".
			(htmlspecialchars($numberOfWorkersText, ENT_QUOTES))
			."</p>");
		}*/
		?>
		<p>
			<?php
			if ($userType =="e"){
				echo ("<p class=\"applyForJobButton\" style=\"margin-top:-2em; margin-bottom:2em;\">
				<a href=\"editEmployerProfile.php\"><button type=\"button\">edit profile</button></a>
				</p>");
			}
			?>
			<div id="topProfileInfo">
				<p class="pageTitleProfile">
					<?php echo (htmlspecialchars($businessName, ENT_QUOTES)); ?>
				</p>
				<p class="profileAddress">
					<?php
						echo ("<p class=\"employerAddress\">".(htmlspecialchars($genre, ENT_QUOTES))."</p>\n");
						echo ("<p class=\"employerAddress\">".(htmlspecialchars($address, ENT_QUOTES))."</p>\n");
						echo ("<p class=\"employerAddress\">".htmlspecialchars($city, ENT_QUOTES).", ".htmlspecialchars($state, ENT_QUOTES));
						//echo ("<p class=\"employerAddress\">".(htmlspecialchars($phone, ENT_QUOTES))."</p>\n");
						
					?>
				</p>
				<p style="margin-top:-5.5em; margin-bottom:4em;" class="contactMeLink">
					<?php echo (htmlspecialchars($phone, ENT_QUOTES)); ?> |
					<?php echo "<a href=\"mailto:".(htmlspecialchars($email, ENT_QUOTES))."\">Email</a>"; ?>
				</p>
			</div>
			
			<div id="middleProfileInfo" class="content">
				<span class="profileCategoryHeader">Help wanted:</span>
					<p class="profileWorkHistory">
						<?php
							
							$sql = 'SELECT * FROM `Jobs` WHERE `employerID` = \''.$employerID.'\' ORDER BY `postingID` ASC';
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
										$applicantIDs = $row["applicantIDs"];
										$position = $row["position"];
										$postingID = $row["postingID"];	
										$pay = $row["pay"];
									
										if ($userType == "e"){
											//if employer
											//count applicants
											$noApplicants = (count(explode(",",$applicantIDs)))-2;
											if ($pay != "no"){
												if ($noApplicants == 1) {
       												$applyButtText = "<p class=\"applyForJobButton\">
													<a href=\"viewApplicants.php?pID=".htmlspecialchars($postingID, ENT_QUOTES)."\"><button type=\"button\">view applicant (1)</button></a>";
    											} else if ($noApplicants < 1){
													$applyButtText = "<p class=\"appliedForJobButton\" style=\"margin-bottom:-3em;\">
													<button type=\"button\">no applicants yet</button>";
												} else {
													$postingID_b = htmlspecialchars($postingID, ENT_QUOTES);
													$noApplicants_b = htmlspecialchars($noApplicants, ENT_QUOTES);
													
													$applyButtText = "<p class=\"applyForJobButton\">
													<a href=\"viewApplicants.php?pID=".$postingID_b."\"><button type=\"button\">view applicants (".$noApplicants_b.")</button></a>";
												}
											} else {
													$applyButtText = "<p class=\"applyForJobButton\">
													<a href=\"publishHelpWanted.php?pID=".htmlspecialchars($postingID, ENT_QUOTES)."\"><button type=\"button\">publish listing</button></a>";
											}
											$applyButtText = ($applyButtText."<p class=\"applyForJobButton\">
													<a href=\"editHelpWanted.php?pID=".htmlspecialchars($postingID, ENT_QUOTES)."\"><button type=\"button\">edit listing</button></a>");
											$applyButtText = ($applyButtText."</p>");	
										} else {
											//if worker
											//check if worker has applied for this job
											if ($pay != "no"){
												if (contains((",".$userID.","), $applicantIDs)) {
       												$applyButtText = "<p class=\"appliedForJobButton\">
													<button type=\"button\">applied</button>";
    											} else {
													$applyButtText = "<p class=\"applyForJobButton\">
													<a href=\"#\"><button type=\"submit\">apply</button></a>";
												}
											}
										}
									
										$wage = $row["wage"];
										$tips = $row["tips"];
										$responsible = $row["responsible"];
										$qualify = $row["qualify"];
										$comments = $row["comments"];
										
										
										
										
										
										$sqlo = 'SELECT DATE(postingDate) AS postingDate FROM Jobs WHERE `postingID` = \''.$postingID.'\'';
										$sqlo_r = mysql_query($sqlo);
										$rows_r = mysql_num_rows($sqlo_r); 
										if ($rows_r != 0){
											if ($rows_r<1 ){ 
												//
											} else {
												while ($row_r = mysql_fetch_array($sqlo_r)) {
													$postingDate = $row_r["postingDate"];
												}
											}
										}

										
										if ($tips == "*"){
											$tips = " (plus tips)";
										} else {
											$tips = "";
										}
									
										$position = htmlspecialchars($position, ENT_QUOTES);
										$wage = htmlspecialchars($wage, ENT_QUOTES);
										$tips = htmlspecialchars($tips, ENT_QUOTES);
										$responsible = htmlspecialchars($responsible, ENT_QUOTES);
										$qualify = htmlspecialchars($qualify, ENT_QUOTES);
										$comments = htmlspecialchars($comments, ENT_QUOTES);
										$applicantIDs = htmlspecialchars($applicantIDs, ENT_QUOTES);
										$postingID = htmlspecialchars($postingID, ENT_QUOTES);
										$employerID_b = htmlspecialchars($employerID, ENT_QUOTES);
										$postingDate = htmlspecialchars($postingDate, ENT_QUOTES);
										
										//$applyButtText = htmlspecialchars($applyButtText, ENT_QUOTES);
										
										
										if ($userType == "w"){
											
											
											if ($pay != "no"){
												echo ("<b>".$position."</b><br>\n");
												echo ("$".$wage." per hour".$tips."<br>\n");
												echo ("<p>\n<textarea class=\"helpWantedTextArea\" readonly>\n");
												echo ("Responsibilities:\n".$responsible."\n\nQualifications:\n".$qualify."\n\n");
												if ((strlen($comments)) > 1){
													echo ("Comments:\n");
													echo ($comments."\n\n");
												}
												echo ("</textarea></p>");
												echo ("<i>posted ".$postingDate."</i>\n<br><br>");
												
												echo ("<form action=\"processApplyJob.php\" method=\"post\">");
												echo ("<input type=\"hidden\" name=\"postingID\" value=\"".$postingID."\">");
												echo ("<input type=\"hidden\" name=\"employerID\" value=\"".$employerID_b."\">");
									
												if ($i == $rows_b){
													echo ($applyButtText."
														</p><br>");
												} else {
													echo ($applyButtText);
													echo ("<br><br><hr>
														</p><br>");
												}
												echo ("</form>");
											}	
										} else {
											
											echo ("<b>".$position."</b><br>\n");
											echo ("$".$wage." per hour".$tips."<br>\n");
											echo ("<p>\n<textarea class=\"helpWantedTextArea\" readonly>\n");
											echo ("Responsibilities:\n".$responsible."\n\nQualifications:\n".$qualify."\n\n");
											if ((strlen($comments)) > 1){
												echo ("Comments:\n");
												echo ($comments."\n\n");
											}
											echo ("</textarea></p>");
											
											
											echo ("<i>posted ".$postingDate."</i>\n<br><br>");
										
											if ($pay == "no"){
												echo ("<span class=\"errorText\">Listing is not visible to applicants until it is published</a><br>\n");
											
												//echo ("<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" target=\"_top\">");
												//echo ("<input type=\"hidden\" name=\"custom\" value=\"".$postingID."\">");
												//echo ("<input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\">");
												//echo ("<input type=\"hidden\" name=\"hosted_button_id\" value=\"QSME9JL4AMG4W\">");
												//echo ("<input type=\"image\" src=\"http://www.paypal.com/en_US/i/btn/btn_buynow_LG.gif\" 
        //border=\"0\" name=\"submit\" alt=\"Make payments with PayPal - it's fast, free and secure!\">");
												
												
												
											}
											
											if ($i == $rows_b){
												echo ($applyButtText."
													</p><br>");
											} else {
												echo ($applyButtText);
												echo ("<br><br><hr>
													</p><br>");
											}
											//echo ("</form>");
										}
										
										
									}
								}
							}
						?>
					</p>
				</div>
				<?php
				if ($userType == "e"){
					echo("<p class=\"applyForJobButton\" style=\"padding-bottom:1em;\">
					<a href=\"helpWanted.php\"><button type=\"button\">post help wanted</button></a></p>");
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