<?php
	include("/home/liketheviking9/incld_php/redirectFunction.php");
	if (isset($_COOKIE['sID'])){
		redirect("index.php", false);
	}
?>
<!DOCTYPE HTML>
<html>

	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title>Login</title>
		
		<link rel="stylesheet" type="text/css" href="css/mainCode.css" />
	</head>
	<body>
	<?php include("/home/liketheviking9/incld_php/generateMenu.php");?>
	<form class="addJobResume_form" method="post" action="processLogin.php" >
		<div id="pageContent" align="center">
			<p>
				<div id="middleProfileInfo" >
					<p class="pageTitle" >
						login
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
						<label for="password">Password:</label>
						<input type="password" name="password" maxlength="30" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="submit"></label>
  						<button type="submit" name="submit">login</button>	
					</li>
				</ul>
			</div>
			<a href="forgot_pass.php">Forgot password</a> | <a href="send_conf.php">Resend confirmation email</a>
		</p>
		</div>
	</form>	
	<?php include("/home/liketheviking9/incld_php/generateFooter.php");?>
	</body>
</html>