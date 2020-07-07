<?php
	include("/home/liketheviking9/incld_php/redirectFunction.php");
	
	//redirect("index.php?err=We are not quite ready to accept new workers. Check back on the 5th of November.", false);
	
	if (isset($_COOKIE['sID'])){
		redirect(("index.php"), false);
	}
	if (isset($_GET['err'])){
		if (($_GET['err']) == "You now exist"){
			redirect("login.php?err=You now exist. Check your email to confirm your account.",false);
		}
	}
	$firstName = $_GET['firstname'];
	$lastName = $_GET['lastname'];
	$email = $_GET['email'];
	$city = $_GET['city'];
	$phone = $_GET['phone'];

?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Create Profile</title>
	<?php include("/home/liketheviking9/incld_php/generateMenu_candy.php");?>
	<form class="addJobResume_form" method="post" action="processNewWorker.php" >
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
						<label for="firstname">First name:</label>
						<input type="text" name="firstname" maxlength="50" value="<?php echo htmlspecialchars($firstName, ENT_QUOTES);?>" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="lastname">Last name:</label>
						<input type="text" name="lastname" maxlength="50" value="<?php echo htmlspecialchars($lastName, ENT_QUOTES);?>" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="email">Email:</label>
						<input type="mail" name="email" maxlength="255" value="<?php echo htmlspecialchars($email, ENT_QUOTES);?>" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="emailConfirm">Confirm email:</label>
						<input type="mail" name="emailConfirm" maxlength="255" required>
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
						<label for="city">City:</label>
						<input type="text" name="city" maxlength="45" value="<?php echo htmlspecialchars($city, ENT_QUOTES);?>" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="state">State:</label>
						<select class="stateSelect" name="state" value="<?php echo htmlspecialchars($state, ENT_QUOTES);?>">
    						<option value="--" selected>--</option>
							<option value="Alabama">Alabama</option>
  						</select>
					</li>
					<li class="addJobResume_form_li">
						<label for="phone">Phone number:</label>
						<input type="text" name="phone" placeholder="XXX-XXX-XXXX" maxlength="12" value="<?php echo htmlspecialchars($phone, ENT_QUOTES);?>" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="transpt">Reliable transportation:</label>
						<input type="checkbox" name="transpt" value="yes">
					</li>
					<li class="addJobResume_form_li">
						<label for="legalwork">Legal to work:</label>
						<input type="checkbox" name="legalwork" value="yes">
					</li>
					<li class="addJobResume_form_li">
						<label for="dayshift">I can work days:</label>
						<input type="checkbox" name="dayshift" value="yes">
					</li>
					<li class="addJobResume_form_li">
						<label for="nightshift">I can work nights:</label>
						<input type="checkbox" name="nightshift" value="yes">
					</li>
					<li class="addJobResume_form_li">
						<label for="describeYourself">Describe yourself:</label>
						<textarea style="resize:none;" name="describeYourself" maxlength="550" rows="7" cols="40" required></textarea>
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
	<?php include("/home/liketheviking9/incld_php/generateFooter_candy.php");?>
	</body>
</html>