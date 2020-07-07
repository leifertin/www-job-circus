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
	if (isset($_GET['pID'])){

	} else {
		redirect("index.php", false);
	}
	$postingID = $_GET['pID'];
	$postingID = mysql_real_escape_string($postingID);
	
	$sql = 'SELECT * FROM `Jobs` WHERE `employerID` = '.intval($userID).' AND `postingID` = '.intval($postingID).' LIMIT 1';
	$sql_result = mysql_query($sql);
	$rows = mysql_num_rows($sql_result); 
		
	if ($rows<1 ){ 
		redirect(("index.php"),false);
	} else {
		while ($row= mysql_fetch_array($sql_result)) {
 			//extract user data for view
			$position = $row["position"];
			$wage = $row["wage"];
			$tips = $row["tips"];
			$responsible = $row["responsible"];
			$qualify = $row["qualify"];
			$comments = $row["comments"];	
		}	
	}

?>
<!DOCTYPE HTML>
<html>

	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title>Edit Help Wanted</title>
		
		<link rel="stylesheet" type="text/css" href="css/mainCode.css" />
	</head>
	<body>
	
	<?php include("/home/liketheviking9/incld_php/generateMenu.php");?>
	<form class="addJobResume_form" method="post" action="processEditHelpWanted.php" >
		<div id="pageContent" align="center">
			<p>
				<div id="middleProfileInfo" >
					<p class="pageTitle" >
						edit help wanted
					</p>
					<?php
					if (isset($_GET['err'])){
						echo("<p class=\"errorText\">".htmlspecialchars(($_GET['err']), ENT_QUOTES)."</p>");
					}
					?>
					<input type="hidden" name="pID" value="<?php echo htmlspecialchars($postingID, ENT_QUOTES);?>" required>
					<input type="hidden" name="pos" value="<?php echo htmlspecialchars($position, ENT_QUOTES);?>" required>
					<ul>
					<li class="addJobResume_form_li">
						<label for="position">Position:</label>
						<input type="text" maxlength="90" name="position" required value="<?php echo htmlspecialchars($position, ENT_QUOTES);?>">
					</li>
					<li class="addJobResume_form_li">
						<label for="wage">Starting hourly wage:</label>
						<input type="text" placeholder="10.00" maxlength="6" name="wage" required value="<?php echo htmlspecialchars($wage, ENT_QUOTES);?>">
					</li>
					<li class="addJobResume_form_li">
						<label for="tips">Tips:</label>
						<input type="checkbox" name="tips" value="yes" <?php
							if ($tips == "*"){
								echo "checked";
							}
						?>>
					</li>
					<li class="addJobResume_form_li">
						<label for="responsible">Job responsibilities:</label>
						<textarea style="resize:none;" name="responsible" maxlength="400" rows="7" cols="40" required><?php echo htmlspecialchars($responsible, ENT_QUOTES);?></textarea>
					</li>
					<li class="addJobResume_form_li">
						<label for="qualify">Qualifications:</label>
						<textarea style="resize:none;" name="qualify" maxlength="450" rows="7" cols="40"><?php echo htmlspecialchars($qualify, ENT_QUOTES);?></textarea>
					</li>
					<li class="addJobResume_form_li">
						<label for="comments">Comments:</label>
						<textarea style="resize:none;" name="comments" maxlength="350" rows="7" cols="40"><?php echo htmlspecialchars($comments, ENT_QUOTES);?></textarea>
					</li>
					<li class="addJobResume_form_li">
						<label for="email">Email:</label>
						<input type="mail" name="email" maxlength="255" required>
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
						<label for="submit"></label>
  						<button type="submit" name="submit">done</button>	
					</li>
				</ul>
			</div>
		</p>
		</div>
	</form>	
	<p align="center">
		<a href="deleteHelpWanted.php?pID=<?php echo htmlspecialchars($postingID, ENT_QUOTES);?>&pos=<?php echo htmlspecialchars($position, ENT_QUOTES);?>">delete help wanted</a>
	</p>
	<br>
	<?php include("/home/liketheviking9/incld_php/generateFooter.php");?>
	</body>
</html>
<?php
	mysql_close($con); 
?>