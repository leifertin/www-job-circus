<?php
include("/home/liketheviking9/incld_php/redirectFunction.php");
include("/home/liketheviking9/incld_php/loginsql.php");
include("/home/liketheviking9/incld_php/cookie_chk.php");
allowUserType("e", $userType);

$postingID = $_GET['pID'];

function display_applicants($userID, $postingID){ 
	
	//take the username and prevent SQL injections 
	$postingID = mysql_real_escape_string($postingID);
	$userID = mysql_real_escape_string($userID);
	
	//begin the query 
	$sql = ('SELECT `applicantIDs` FROM `Jobs` WHERE `postingID` = '.intval($postingID).' AND `employerID` = '.intval($userID).' LIMIT 1');
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
			$applicantIDs = $row["applicantIDs"];
			$applicantList = explode(",", $applicantIDs);
			$arrlength = count($applicantList);
			
			echo ("<p class=\"pageTitle\" >you have ".($arrlength-2)." applicant");
			if (($arrlength-2)!=1){
				echo("s");
			}
			echo("</p>");
			
			for($x = 0; $x < $arrlength; $x++) {
   				if ($applicantList[$x] == ""){
				} else {
					//get ready to display this user
					$sql_b = 'SELECT `firstname`, `lastname`, `workerID` FROM `Workers` WHERE `workerID` = \''.$applicantList[$x].'\' LIMIT 1';
					$sql_result_b = mysql_query($sql_b) or die("Renob.");
					$rows_b = mysql_num_rows($sql_result_b); 
					while ($row_b = mysql_fetch_array($sql_result_b)) {
 						//get worker details
						$firstName = $row_b["firstname"];
						$workerID = $row_b["workerID"];
						$lastName = $row_b["lastname"];
						$firstName = htmlspecialchars($firstName, ENT_QUOTES);
						$workerID = htmlspecialchars($workerID, ENT_QUOTES);
						$lastName = htmlspecialchars($lastName, ENT_QUOTES);
						
						//echo result
						echo("\n					");
						echo("<p class=\"jobListingList\"><a href=\"displayWorkerProfile.php?wid=".$workerID."\">".$firstName." ".$lastName."</a></p>");
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
		<title>View Applicants</title>
		
		<link rel="stylesheet" type="text/css" href="css/mainCode.css" />
	</head>
	<body>
	<?php include("/home/liketheviking9/incld_php/generateMenu.php");?>
		<div id="pageContent" align="center">
			<p>
				<div id="middleProfileInfo" >
					<?php
						display_applicants($userID, $postingID);
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