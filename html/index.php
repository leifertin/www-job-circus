<?php
	include("/home/liketheviking9/incld_php/redirectFunction.php");
	include("/home/liketheviking9/incld_php/loginsql.php");
	
	if (isset($_COOKIE['sID'])){
		//get userID and userType from session table
		
		include("/home/liketheviking9/incld_php/getInfoFromSession.php");
		
		if ($userType == "e"){
			redirect(("displayEmployerProfile.php?eid=".$userID), false);
		} else if ($userType == "w"){
			redirect(("displayWorkerProfile.php?wid=".$userID), false);
		}
	}
?>
<!DOCTYPE HTML>
<html>

	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title>Job-circus</title>
		
		<link rel="stylesheet" type="text/css" href="css/mainCode.css" />
	</head>
	<body>
	<?php include("/home/liketheviking9/incld_php/generateMenu.php");?>
	
		<div id="pageContent" align="center">
			<p class="pageTitle" >
				job-circus
			</p>
			<?php
					if (isset($_GET['err'])){
						echo("<p class=\"errorText\">".htmlspecialchars(($_GET['err']), ENT_QUOTES)."</p>");
					}
					
					?>
					<p style="margin-top:.5em; font-size: 1.4em;">
						job hunting shouldn't be a full time job
					</p>
					
			<p style="margin-top:2.5em; font-size: 1.5em;">
				<a href="createWorkerProfile.php">job wanted</a> | <a href="createEmployerProfile.php">help wanted</a>
			</p>
			<p style="margin-top:.5em; font-size: 1.2em;">
				it's free to sign up!
			</p>
		</div>
		<?php include("/home/liketheviking9/incld_php/generateFooter.php");?>
	</body>
</html>
<?
	mysql_close($con);
?>