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
		<title>Reset Password</title>
		
		<link rel="stylesheet" type="text/css" href="css/mainCode.css" />
	</head>
	<body>
	
	<?php include("/home/liketheviking9/incld_php/generateMenu.php");?>
	<form class="addJobResume_form" method="post" action="processResetPass.php<?php echo "?n=".htmlspecialchars(($_GET['n']), ENT_QUOTES); ?>">
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
					if (isset($_GET['n'])){
						if ($_GET['n'] != ""){
							echo("<input type=\"hidden\" name=\"n\" value=\"".htmlspecialchars(($_GET['n']), ENT_QUOTES)."\">");
							echo("
								<ul>
								<li class=\"addJobResume_form_li\">
									<label for=\"newPassword\"><b>New</b> password:</label>
									<input type=\"password\" name=\"newPassword\" maxlength=\"30\">
								</li>
								<li class=\"addJobResume_form_li\">
									<label for=\"newPasswordConfirm\">Confirm new password:</label>
									<input type=\"password\" name=\"newPasswordConfirm\" maxlength=\"30\">
								</li>
								<li class=\"addJobResume_form_li\">
									<label for=\"submit\"></label>
  									<button type=\"submit\" name=\"submit\">reset</button>	
								</li>
								</ul>
								");
						}
					
					}
					?>
					
			</div>
		</p>
		</div>
	</form>	
	<?php include("/home/liketheviking9/incld_php/generateFooter.php");?>
	</body>
</html>
