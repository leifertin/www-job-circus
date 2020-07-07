<?php

include("incld/redirectFunction.php");
include("incld/loginsql.php");



$employerID = $_GET['eid'];
$employerID = mysql_real_escape_string($employerID);
/*
if get_worker id is not the same as your worker id in cookies then redirect
*/
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
		$picture = $row["picture"];
		$applicantIDs = $row["applicantIDs"];	
	}	
}

?>
<!DOCTYPE HTML>
<html>

	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title>Display Employer Profile</title>
		
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
					<?php echo (htmlspecialchars($businessName, ENT_QUOTES)); ?>
				</p>
				<p class="profileAddress">
					<?php
						echo ("<p class=\"employerAddress\">".(htmlspecialchars($genre, ENT_QUOTES))."</p>\n");
						echo ("<p class=\"employerAddress\">".(htmlspecialchars($address, ENT_QUOTES))."</p>\n");
						echo ("<p class=\"employerAddress\">".htmlspecialchars($city, ENT_QUOTES).", ".htmlspecialchars($state, ENT_QUOTES));
						echo ("<p class=\"employerAddress\">".(htmlspecialchars($phone, ENT_QUOTES))."</p>\n");
					?>
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
							if ($rows_b<1 ){ 
								redirect(("index.php"),false);
							} else {
								while ($row = mysql_fetch_array($sql_result_b)) {
									$i += 1;
 									//extract user data for view
									$position = $row["position"];
									$wage = $row["wage"];
									$tips = $row["tips"];
									$responsible = $row["responsible"];
									$qualify = $row["qualify"];
									$comments = $row["comments"];
									$applicantIDs = $row["applicantIDs"];
									$postingID = $row["postingID"];	
									
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
									
									echo ("<b>".$position."</b><br>\n");
									echo ("$".$wage." per hour".$tips."<br>\n");
									echo ("<p>\n<textarea class=\"helpWantedTextArea\" readonly>\n");
									echo ("Responsibilities:\n".$responsible."\n\nQualifications:\n".$qualify."\n\n");
									if ((strlen($comments)) > 1){
										echo ("Comments:\n");
										echo ($comments."\n\n");
									}
									echo ("</textarea></p>");
									echo ("<form action=\"processApplyJob.php\" method=\"post\">");
									echo ("<input type=\"hidden\" name=\"postingID\" value=\"".$postingID."\">");
									echo ("<input type=\"hidden\" name=\"employerID\" value=\"".$employerID_b."\">");
									if ($i == $rows_b){
										echo ("<p class=\"applyForJobButton\">
											<a href=\"#\"><button type=\"submit\">apply</button></a>
											</p><br>");
									} else {
										echo ("<p class=\"applyForJobButton\">
											<a href=\"#\"><button type=\"submit\">apply</button></a><hr>
											</p><br>");
									}
									echo ("</form>");
									
									
								}	
							}
						?>
					</p>
				</div>
				<p class="contactMeLink" align="center">
					<p>
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