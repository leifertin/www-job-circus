<?php
	include("/home/liketheviking9/incld_php/redirectFunction.php");
	if (isset($_COOKIE['sID'])){
		redirect(("index.php"), false);
	}
?>
<!DOCTYPE HTML>
<html>

	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title>Reset Password</title>
		
		<link rel="stylesheet" type="text/css" href="css/mainCode.css" />
	</head>
	<body>
	<?php include("/home/liketheviking9/incld_php/generateMenu.php");?>
	<form class="addJobResume_form" method="post" action="processForgotPass.php" >
		<div id="pageContent" align="center">
			<p>
				<div id="middleProfileInfo" >
					<p class="pageTitle" >
						reset password
					</p>
					<?php
					if (isset($_GET['err'])){
						echo("<p class=\"errorText\">".htmlspecialchars(($_GET['err']), ENT_QUOTES)."</p>");
					}
					
					?>
					<ul>
					<li class="addJobResume_form_li">
						<label for="email">Email:</label>
						<input type="mail" name="email" maxlength="255" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="submit"></label>
  						<button type="submit" name="submit">send</button>	
					</li>
				</ul>
			</div>
		</p>
		</div>
	</form>	
	<?php include("/home/liketheviking9/incld_php/generateFooter.php");?>
	</body>
</html>