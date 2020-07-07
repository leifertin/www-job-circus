<?php
include("/home/liketheviking9/incld_php/redirectFunction.php");
include("/home/liketheviking9/incld_php/loginsql.php");
include("/home/liketheviking9/incld_php/cookie_chk.php");


function display_citylistings($state,$genre){ 
	//take the username and prevent SQL injections 
	$state = mysql_real_escape_string($state);
	$genre = mysql_real_escape_string($genre); 
	//begin the query 
	$sql = ('SELECT * FROM `Jobs` WHERE `state` = \''.$state.'\' AND `genre` = \''.$genre.'\' AND `pay` = \'yes\' ORDER BY `city` DESC');
	//echo $sql;
	$sql_result = mysql_query($sql);
	//check to see how many rows were returned 
	$rows = mysql_num_rows($sql_result); 
	if ($rows<=0 ){ 
		echo("there are no jobs matching your criteria");
	} else { 
		echo ("<li class=\"addJobResume_form_li\">
						<label for=\"city\">City:</label>
						<select name=\"city\" class=\"stateSelect\">");
		//print results
		$cityList = array();
		$rep = 0;
		while ($row= mysql_fetch_array($sql_result)) {
 			$city = $row["city"];
			$cityList[$rep] = $city;
			$rep+=1;
  		}
		$cityList = array_values(array_unique($cityList));
		$arrlength = count($cityList);
		for($x = 0; $x < $arrlength; $x++) {
			echo("\n						");
			echo("<option value=\"".$cityList[$x]."\">".$cityList[$x]."</option>");
		}
		echo("\n</select>\n</li>");	
		echo("\n<input type=\"hidden\" name=\"state\" value=\"".htmlspecialchars($state, ENT_QUOTES)."\" />");
		echo("\n<input type=\"hidden\" name=\"genre\" value=\"".htmlspecialchars($genre, ENT_QUOTES)."\" />\n");
		
		echo("<li class=\"addJobResume_form_li\">
  						<label for=\"submit\"></label>
						<button type=\"submit\" name=\"submit\">done</button>
					</li>");	
	}				
}


		
if (isset($_POST['state']) && isset($_POST['genre'])){
	$pickFunction = "pg2";
	$formPage = "jobSearch_showJobs.php";
} else {
	$pickFunction = "pg1";
	$formPage = "jobSearch.php";
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
	<form class="addJobResume_form" <?php $formPage = htmlspecialchars($formPage, ENT_QUOTES); echo("action=\"".$formPage."\"");?> method="post">
		<div id="pageContent" align="center">
			<p>
				<div id="middleProfileInfo" >
					<p class="pageTitle" >
						find a job
  					</p>
					<ul>
					<?php
					if ($pickFunction == "pg1"){
  					echo ("<li class=\"addJobResume_form_li\">
						<label for=\"genre\">Genre:</label>
						<select name=\"genre\" class=\"stateSelect\">
    						<option value=\"--\" selected>--</option>
							<option value=\"Automotive\">Automotive</option>
							<option value=\"Contract\">Contract</option>
							<option value=\"Convenience\">Convenience</option>
							<option value=\"Food\">Food</option>
							<option value=\"Repair\">Repair</option>
							<option value=\"Retail\">Retail</option>
							<option value=\"Sales\">Sales</option>
							<option value=\"Tourism And Hospitality\">Tourism & Hospitality</option>
							<option value=\"Volunteer\">Volunteer</option>
							<option value=\"Other\">Other</option>
  						</select>
					</li>
					<li class=\"addJobResume_form_li\">
						<label for=\"state\">State:</label>
						<select class=\"stateSelect\" name=\"state\">
    						<option value=\"--\" selected>--</option>
							<option value=\"Alabama\">Alabama</option>
  						</select>
					</li>
					<li class=\"addJobResume_form_li\">
  						<label for=\"submit\"></label>
						<button type=\"submit\" name=\"submit\">done</button>
					</li>");
					} else {
						display_citylistings(($_POST['state']),($_POST['genre']));
						echo("</li>");
					}
					?>
					
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