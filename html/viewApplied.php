<?php
include("/home/liketheviking9/incld_php/redirectFunction.php");
include("/home/liketheviking9/incld_php/loginsql.php");
include("/home/liketheviking9/incld_php/cookie_chk.php");
allowUserType("w", $userType);


function display_applicants($userID){ 
	
	//take the username and prevent SQL injections
	$userID = mysql_real_escape_string($userID);
	
	//begin the query 
	$sql = ('SELECT `applyTo` FROM `Workers` WHERE `workerID` = '.intval($userID).' LIMIT 1');
	//echo $sql;
	$sql_result = mysql_query($sql);
	
	//check to see how many rows were returned 
	$rows = mysql_num_rows($sql_result); 
	if ($rows<=0 ){ 
		redirect("index.php", false);
	} else { 
		
		//print results
		while ($row= mysql_fetch_array($sql_result)) {
			//extract user data for view
			$applied = $row["applyTo"];
			$appliedList = explode(",", $applied);
			$arrlength = count($appliedList);
			
			echo ("<p class=\"pageTitle\" >you have applied at ".($arrlength-2)." location");
			if (($arrlength-2)!=1){
				echo("s");
			}
			echo("</p>");
			
			for($x = 0; $x < $arrlength; $x++) {
   				if ($appliedList[$x] == ""){
				} else {
					//get ready to display this user
					$sql_b = 'SELECT `businessName`, `address`, `employerID` FROM `Employers` WHERE `employerID` = \''.$appliedList[$x].'\' LIMIT 1';
					$sql_result_b = mysql_query($sql_b) or die("Renob.");
					$rows_b = mysql_num_rows($sql_result_b); 
					while ($row_b = mysql_fetch_array($sql_result_b)) {
 						//get worker details
						$businessName = $row_b["businessName"];
						$employerID = $row_b["employerID"];
						$address = $row_b["address"];
						$numJobs = $row_b["numJobs"];
						$businessName = htmlspecialchars($businessName, ENT_QUOTES);
						$employerID = htmlspecialchars($employerID, ENT_QUOTES);
						$address = htmlspecialchars($address, ENT_QUOTES);
						
						//echo result
						echo("\n					");
						echo("<p class=\"jobListingList\">");
						if ($numJobs < 1){
							echo ($businessName." - ".$address." <span class=\"errorText\">(no active listings)</span></p>");
						} else {
							echo ("<a href=\"displayEmployerProfile.php?eid=".$employerID."\">".$businessName." - ".$address."</a></p>");
						}
					}
					echo("\n");	
				}
    		}
				
		}
	}

} 
   
?>
<!DOCTYPE HTML>
<html>

	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title>View Applied</title>
		
		<link rel="stylesheet" type="text/css" href="css/mainCode.css" />
	</head>
	<body>
	<?php include("/home/liketheviking9/incld_php/generateMenu.php");?>
		<div id="pageContent" align="center">
			<p>
				<div id="middleProfileInfo" >
					<?php
						display_applicants($userID);
					?>
					
				</div>
			</p>
		</div>
		<?php include("/home/liketheviking9/incld_php/generateFooter.php");?>
	</body>
</html>
<?php
	mysql_close($con); 
?>