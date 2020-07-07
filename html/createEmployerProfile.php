<?php
	include("/home/liketheviking9/incld_php/redirectFunction.php");
	
	
	//redirect("index.php?err=We are not quite ready to accept new employers. Check back in a couple of days.", false);
	
	
	if (isset($_COOKIE['sID'])){
		redirect(("index.php"), false);
	}
	
	if (isset($_GET['err'])){
		if (($_GET['err']) == "You now exist"){
			redirect("login.php?err=You now exist. Check your email to confirm your account.",false);
		}
	}
	$business = $_GET['businessName'];
	$address = $_GET['address'];
	$city = $_GET['city'];
	$phone = $_GET['phone'];
	$email = $_GET['email'];
?>
<!DOCTYPE HTML>
<html>

	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title>Create Profile</title>
		
		<link rel="stylesheet" type="text/css" href="css/mainCode.css" />
	</head>
	<body>
	
	<?php include("/home/liketheviking9/incld_php/generateMenu.php");?>
	<form class="addJobResume_form" method="post" action="processNewEmployer.php" >
		<div id="pageContent" align="center">
			<p>
				<div id="middleProfileInfo" >
					<p class="pageTitle" >
						create profile
					</p>
					<?php
					if (isset($_GET['err'])){
						echo("<p class=\"errorText\">".htmlspecialchars(($_GET['err']), ENT_QUOTES)."</p>");
					}
					?>
					<ul>
					<li class="addJobResume_form_li">
						<label for="businessName">Business name:</label>
						<input type="text" name="businessName" maxlength="60" value="<?php echo htmlspecialchars($business, ENT_QUOTES);?>" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="genre">Genre:</label>
						<select name="genre" class="stateSelect">
    						<option value="--" selected>--</option>
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
    						<option value="--" selected>--</option>
							<option value="Alabama">Alabama</option>
  						</select>
					</li>
					<li class="addJobResume_form_li">
						<label for="phone">Phone number:</label>
						<input type="text" name="phone" placeholder="XXX-XXX-XXXX" maxlength="12" value="<?php echo htmlspecialchars($phone, ENT_QUOTES);?>" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="email">Email:</label>
						<input type="mail" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES);?>" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="emailConfirm">Confirm email:</label>
						<input type="mail" name="emailConfirm" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="password">Password:</label>
						<input type="password" maxlength="30" name="password" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="passwordConfirm">Confirm password:</label>
						<input type="password" maxlength="30" name="passwordConfirm" required>
					</li>
					<li class="addJobResume_form_li" >
						<label for="tos"></label>
						<span class="errorText">By clicking "done" you agree to our <a href="tos.php" target="_blank">TOS</a></span>
					</li>
					<li class="addJobResume_form_li">
						<label for="submit"></label>
  						<button type="submit" name="submit">done</button>	
					</li>
				</ul>
			</div>
		</p>
		</div>
	</form>	
	<?php include("/home/liketheviking9/incld_php/generateFooter.php");?>
	</body>
</html>