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
		<title>Job Circus</title>
		
	<?php include("/home/liketheviking9/incld_php/generateMenu_candy.php");?>
	
		<div id="pageContentHome" align="center">
			<p class="pageTitleProfile" >
				Job-circus
			</p>
			<?php
					if (isset($_GET['err'])){
						echo("<p class=\"errorText\">".htmlspecialchars(($_GET['err']), ENT_QUOTES)."</p>");
					}
					
					?>
					<p style="margin-top:-.5em; font-size: 1.2em;">
					<a href="createEmployerProfile.php">Post a job</a> - <a href="createWorkerProfile.php">Find a job</a>
					</p>
		</div>
		<?php include("/home/liketheviking9/incld_php/generateFooter_candy.php");?>
	</body>
</html>
<?
	mysql_close($con);
?>