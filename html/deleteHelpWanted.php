<?php
	include("/home/liketheviking9/incld_php/encodeLogin.php");
	include("/home/liketheviking9/incld_php/redirectFunction.php");
	include("/home/liketheviking9/incld_php/loginsql.php");
	include("/home/liketheviking9/incld_php/cookie_chk.php");
	allowUserType("e", $userType);
	
	$postingID = $_GET['pID'];
	$post_Position = $_GET['pos'];
	
	if (isset($_GET['err'])){
		if (($_GET['err']) == "You now exist"){
			redirect("index.php",false);
		}
	} else {
		$noteText = "Note: this will permanently remove your job posting for a ".$post_Position;
	}
	
	if (isset($_GET['pID'])){
	} else {
		redirect("index.php",false);
	}
	
	
?>
<!DOCTYPE HTML>
<html>

	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title>Delete Help Wanted</title>
		
		<link rel="stylesheet" type="text/css" href="css/mainCode.css" />
	</head>
	<body>
	<?php include("/home/liketheviking9/incld_php/generateMenu.php");?>
	<form class="addJobResume_form" method="post" action="processDeleteHelpWanted.php" >
		<div id="pageContent" align="center">
			<p>
				<div id="middleProfileInfo" >
					<p class="pageTitle" >
						delete help wanted
					</p>
					<?php
					if (isset($_GET['err'])){
						echo("<p class=\"errorText\">".htmlspecialchars(($_GET['err']), ENT_QUOTES)."</p>");
					}
					echo("<p class=\"errorText\">".htmlspecialchars($noteText, ENT_QUOTES)."</p>");
					echo("<input type=\"hidden\" name=\"pID\" value=\"".htmlspecialchars($postingID, ENT_QUOTES)."\">\n");
					echo("<input type=\"hidden\" name=\"pos\" value=\"".htmlspecialchars($post_Position, ENT_QUOTES)."\">\n");
					?>
					<ul>
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
  						<button type="submit" name="submit">delete</button>	
					</li>
				</ul>
			</div>
		</p>
		</div>
	</form>	
	<?php include("/home/liketheviking9/incld_php/generateFooter.php");?>
	</body>
</html>
<?php
	mysql_close($con); 
?>