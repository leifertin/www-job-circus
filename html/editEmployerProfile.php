<?php
	include("/home/liketheviking9/incld_php/redirectFunction.php");
	include("/home/liketheviking9/incld_php/loginsql.php");
	include("/home/liketheviking9/incld_php/cookie_chk.php");
	allowUserType("e", $userType);
	
	if (isset($_GET['err'])){
		if (($_GET['err']) == "You now exist"){
			redirect("index.php",false);
		}
	}
	
	$userID = mysql_real_escape_string($userID);
	
	$sql = 'SELECT * FROM `Employers` WHERE `employerID` = \''.$userID.'\' LIMIT 1';
	$sql_result = mysql_query($sql);
	$rows = mysql_num_rows($sql_result); 
		
	if ($rows<1 ){ 
		redirect(("index.php"),false);
	} else {
		while ($row= mysql_fetch_array($sql_result)) {
 			//extract user data for view
			$address = $row["address"];
			$businessName = $row["businessName"];
			$city = $row["city"];
			$genre = $row["genre"];
			$phone = $row["phone"];
			$state = $row["state"];
			$email = $row['email'];
		}	
	}

?>
<!DOCTYPE HTML>
<html>

	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title>Edit Profile</title>
		
		<link rel="stylesheet" type="text/css" href="css/mainCode.css" />
	</head>
	<body>
	<?php include("/home/liketheviking9/incld_php/generateMenu.php");?>
	<form class="addJobResume_form" method="post" action="processEditEmployer.php" >
		<div id="pageContent" align="center">
			<p>
				<div id="middleProfileInfo" >
					<p class="pageTitle" >
						edit profile
					</p>
					<?php
					if (isset($_GET['err'])){
						echo("<p class=\"errorText\">".htmlspecialchars(($_GET['err']), ENT_QUOTES)."</p>");
					}
					?>
					<input type="hidden" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES);?>" required>
					<ul>
					<li class="addJobResume_form_li">
						<label for="businessName">Business name:</label>
						<input type="text" name="businessName" maxlength="50" value="<?php echo htmlspecialchars($businessName, ENT_QUOTES);?>" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="genre">Genre:</label>
						<select name="genre" class="stateSelect">
    						<option value="<?php echo htmlspecialchars($genre, ENT_QUOTES);?>" selected><?php
							echo htmlspecialchars($genre, ENT_QUOTES);?></option>
								<option value="Automotive">Automotive</option>
								<option value="Contract">Contract</option>
								<option value="Convenience">Convenience</option>
								<option value="Food">Food</option>
								<option value="Repair">Repair</option>
								<option value="Retail">Retail</option>
								<option value="Sales">Sales</option>
								<option value="Tourism And Hospitality">Tourism & Hospitality</option>
								<option value="Volunteer">Volunteer</option>
								<option value="Other">Other</option>
  						</select>
					</li>
					<li class="addJobResume_form_li">
						<label for="password">Password:</label>
						<input type="password" name="password" maxlength="30" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="passwordConfirm">Confirm password:</label>
						<input type="password" name="passwordConfirm" maxlength="30" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="newPassword"><b>New</b> password:</label>
						<input type="password" name="newPassword" maxlength="30">
					</li>
					<li class="addJobResume_form_li">
						<label for="newPasswordConfirm">Confirm new password:</label>
						<input type="password" name="newPasswordConfirm" maxlength="30">
					</li>
					<li class="addJobResume_form_li">
						<label for="address">Address:</label>
						<input type="text" name="address" maxlength="95" value="<?php echo htmlspecialchars($address, ENT_QUOTES);?>" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="city">City:</label>
						<input type="text" name="city" maxlength="45" value="<?php echo htmlspecialchars($city, ENT_QUOTES);?>" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="state">State:</label>
						<select class="stateSelect" name="state">
							<option value="<?php echo htmlspecialchars($state, ENT_QUOTES);?>" selected><?php echo htmlspecialchars($state, ENT_QUOTES);?></option>
    						<option value="--">--</option>
							<option value="Alabama">Alabama</option>							<option value="Alaska">Alaska</option>							<option value="Arizona">Arizona</option>							<option value="Arkansas">Arkansas</option>							<option value="California">California</option>							<option value="Colorado">Colorado</option>							<option value="Connecticut">Connecticut</option>							<option value="Delaware">Delaware</option>							<option value="Florida">Florida</option>							<option value="Georgia">Georgia</option>							<option value="Hawaii">Hawaii</option>							<option value="Idaho">Idaho</option>							<option value="Illinois">Illinois</option>							<option value="Indiana">Indiana</option>							<option value="Iowa">Iowa</option>							<option value="Kansas">Kansas</option>							<option value="Kentucky">Kentucky</option>							<option value="Louisiana">Louisiana</option>							<option value="Maine">Maine</option>							<option value="Maryland">Maryland</option>							<option value="Massachusetts">Massachusetts</option>							<option value="Michigan">Michigan</option>							<option value="Minnesota">Minnesota</option>							<option value="Mississippi">Mississippi</option>							<option value="Missouri">Missouri</option>							<option value="Montana">Montana</option>							<option value="Nebraska">Nebraska</option>							<option value="Nevada">Nevada</option>							<option value="New Hampshire">New Hampshire</option>							<option value="New Jersey">New Jersey</option>							<option value="New Mexico">New Mexico</option>							<option value="New York">New York</option>							<option value="North Carolina">North Carolina</option>							<option value="North Dakota">North Dakota</option>							<option value="Ohio">Ohio</option>							<option value="Oklahoma">Oklahoma</option>							<option value="Oregon">Oregon</option>							<option value="Pennsylvania">Pennsylvania</option>							<option value="Rhode Island">Rhode Island</option>							<option value="South Carolina">South Carolina</option>							<option value="South Dakota">South Dakota</option>							<option value="Tennessee">Tennessee</option>							<option value="Texas">Texas</option>							<option value="Utah">Utah</option>							<option value="Vermont">Vermont</option>							<option value="Virginia">Virginia</option>							<option value="Washington">Washington</option>							<option value="West Virginia">West Virginia</option>							<option value="Wisconsin">Wisconsin</option>							<option value="Wyoming">Wyoming</option>							<option value="American Samoa">American Samoa</option>							<option value="District of Columbia">District of Columbia</option>							<option value="Federated States of Micronesia">Federated States of Micronesia</option>							<option value="Guam">Guam</option>							<option value="Marshall Islands">Marshall Islands</option>							<option value="Northern Mariana Islands">Northern Mariana Islands</option>							<option value="Palau">Palau</option>							<option value="Puerto Rico">Puerto Rico</option>							<option value="Virgin Islands">Virgin Islands</option>
  						</select>
					</li>
					<li class="addJobResume_form_li">
						<label for="phone">Phone number:</label>
						<input type="text" name="phone" placeholder="XXX-XXX-XXXX" maxlength="12" value="<?php echo htmlspecialchars($phone, ENT_QUOTES);?>" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="submit"></label>
  						<button type="submit" name="submit">done</button>	
					</li>
				</ul>
			</div>
		</p>
		</div>
		<p align="center" style="margin-left:-2.0em; margin-top:-2em; margin-bottom:2em;">
			<a href="deleteMyProfile.php">delete profile</a>
		</p>
	</form>	
	
	<br>
	<?php include("/home/liketheviking9/incld_php/generateFooter.php");?>
	</body>
</html>
<?php
	mysql_close($con); 
?>