<?php
include("/home/liketheviking9/incld_php/redirectFunction.php");
include("/home/liketheviking9/incld_php/loginsql.php");
include("/home/liketheviking9/incld_php/cookie_chk.php");
	
function display_joblistings($city,$state,$genre){ 
	//take the username and prevent SQL injections 
	$city = mysql_real_escape_string($city);
	$state = mysql_real_escape_string($state); 
	//begin the query 
	$sql = ('SELECT * FROM `Jobs` WHERE `city` = \''.$city.'\' AND `state` = \''.$state.'\' AND `pay` = \'yes\' ORDER BY `wage` DESC');
	//echo $sql;
	$sql_result = mysql_query($sql);
	
	//check to see how many rows were returned 
	$rows = mysql_num_rows($sql_result); 
	if ($rows<=0 ){ 
		redirect("index.php", false);
	} else { 
		echo ("<p class=\"pageTitle\" >found ".$rows." choice");
		if ($rows!=1){
			echo("s");
		}
		echo("</p>");
		//print results
		while ($row= mysql_fetch_array($sql_result)) {
 			$employerID = htmlspecialchars(($row["employerID"]), ENT_QUOTES);
			$wage = htmlspecialchars(($row["wage"]), ENT_QUOTES);
			$position = htmlspecialchars(($row["position"]), ENT_QUOTES);
			$businessName = htmlspecialchars(($row["businessName"]), ENT_QUOTES);
			$tips = htmlspecialchars(($row["tips"]), ENT_QUOTES);
			$genre = htmlspecialchars(($row["genre"]), ENT_QUOTES);
			
			if ($tips != "*"){
				$tips = "";
			}
			echo("\n					");
			echo("<p class=\"jobListingList\"><a href=\"displayEmployerProfile.php?eid=".$employerID."\">$".$wage.$tips." - ".$genre." - ".$position."</a></p>");
  		}
		echo("\n");	
	}		
}

$showJobs = 0;
if (isset($_POST['state']) && isset($_POST['city'])){
	//ready to show jobs
	$showJobs = 1;
} else {
	//redirect
	Redirect('jobSearch.php', false);
	
}
  
   
?>
<!DOCTYPE HTML>
<html>

	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title>Search Jobs</title>
		
		<link rel="stylesheet" type="text/css" href="css/mainCode.css" />
	</head>
	<body>
	<?php include("/home/liketheviking9/incld_php/generateMenu.php");?>
		<div id="pageContent" align="center">
			<p>
				<div id="middleProfileInfo" >
					<?php
						if($showJobs == 1){
							display_joblistings(($_POST['city']),($_POST['state']));
						}
					?>
					<p>
						*Plus tips
					</p>
				</div>
			</p>
		</div>
		<?php include("/home/liketheviking9/incld_php/generateFooter.php");?>
	</body>
</html>
<?php
	mysql_close($con); 
?>