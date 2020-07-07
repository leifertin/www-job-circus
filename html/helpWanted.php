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
	
	$wage = $_GET['wage'];
	$position = $_GET['position'];
	
?>
<!DOCTYPE HTML>
<html>

	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title>Post Help Wanted</title>
		
		<link rel="stylesheet" type="text/css" href="css/mainCode.css" />
	</head>
	<body>
	<?php include("/home/liketheviking9/incld_php/generateMenu.php");?>
	<form class="addJobResume_form" action="processHelpWanted.php" method="post">
		<div id="pageContent" align="center">
			<p>
				<div id="middleProfileInfo" >
					<p class="pageTitle" >
						post help wanted
					</p>
					<?php
					if (isset($_GET['err'])){
						echo("<p class=\"errorText\">".htmlspecialchars(($_GET['err']), ENT_QUOTES)."</p>");
					}
					?>
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
						<input type="checkbox" name="tips" value="yes">
					</li>
					<li class="addJobResume_form_li">
						<label for="responsible">Job responsibilities:</label>
						<textarea style="resize:none;" name="responsible" maxlength="400" rows="7" cols="40" required></textarea>
					</li>
					<li class="addJobResume_form_li">
						<label for="qualify">Qualifications:</label>
						<textarea style="resize:none;" name="qualify" maxlength="450" rows="7" cols="40"></textarea>
					</li>
					<li class="addJobResume_form_li">
						<label for="comments">Comments:</label>
						<textarea style="resize:none;" name="comments" maxlength="350" rows="7" cols="40"></textarea>
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
