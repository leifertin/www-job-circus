<?php
	include("/home/liketheviking9/incld_php/redirectFunction.php");
	include("/home/liketheviking9/incld_php/loginsql.php");
	include("/home/liketheviking9/incld_php/cookie_chk.php");
	allowUserType("w", $userType);
	
	if (isset($_GET['err'])){
		if (($_GET['err']) == "You now exist"){
			redirect("index.php",false);
		}
	}
	
	
	//recall data from db
	/*
	get_worker id from cookies
	but for now just do this cheap way
	*/
	$workerID = $userID;
	$workerID = mysql_real_escape_string($workerID);
	
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
	<form class="addJobResume_form" method="post" action="processEditWorker.php" >
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
						<label for="firstname">First name:</label>
						<input type="text" name="firstname" maxlength="50" value="<?php echo htmlspecialchars($firstName, ENT_QUOTES);?>" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="lastname">Last name:</label>
						<input type="text" name="lastname" maxlength="50" value="<?php echo htmlspecialchars($lastName, ENT_QUOTES);?>" required>
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
						<label for="transpt">Reliable transportation:</label>
						<input type="checkbox" name="transpt" value="yes" <?php
							if ($transpt == "yes"){
								echo "checked";
							}
						?>>
					</li>
					<li class="addJobResume_form_li">
						<label for="legalwork">Legal to work:</label>
						<input type="checkbox" name="legalwork" value="yes" <?php
							if ($legalWork == "yes"){
								echo "checked";
							}
						?>>
					</li>
					<li class="addJobResume_form_li">
						<label for="dayshift">I can work days:</label>
						<input type="checkbox" name="dayshift" value="yes" <?php
							if ($available == "10"){
								echo "checked";
							} else if ($available == "11"){
								echo "checked";
							}
						?>>
					</li>
					<li class="addJobResume_form_li">
						<label for="nightshift">I can work nights:</label>
						<input type="checkbox" name="nightshift" value="yes" <?php
							if ($available == "01"){
								echo "checked";
							} else if ($available == "11"){
								echo "checked";
							}
						?>>
					</li>
					<li class="addJobResume_form_li">
						<label for="describeYourself">Describe yourself:</label>
						<textarea style="resize:none;" name="describeYourself" maxlength="550" rows="7" cols="40" required><?php echo htmlspecialchars($describeYourself, ENT_QUOTES);?></textarea>
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