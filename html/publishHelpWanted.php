<?php
include("/home/liketheviking9/incld_php/redirectFunction.php");
include("/home/liketheviking9/incld_php/loginsql.php");
include("/home/liketheviking9/incld_php/cookie_chk.php");
allowUserType("e", $userType);


if (isset($_GET['pID'])){
	$postingID = $_GET['pID'];
} else {
	redirect(("index.php"), false);
}
$postingID_m = mysql_real_escape_string($postingID);
$sql = 'SELECT postingID FROM `Jobs` WHERE `postingID` = \''.$postingID_m.'\' AND `pay` = \'no\'';
$sql_result = mysql_query($sql);
$rows = mysql_num_rows($sql_result); 
		
if ($rows<1 ){ 
	redirect(("index.php"),false);
}


?>
<!DOCTYPE HTML>
<html>

	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title>Publish Help Wanted</title>
		
		<link rel="stylesheet" type="text/css" href="css/mainCode.css" />
	</head>
	<body>
	
	<?php include("/home/liketheviking9/incld_php/generateMenu.php");?>
	
		<div id="pageContent" align="center">
			<p>
				<div id="middleProfileInfo" >
					<p class="pageTitle" >
						publish help wanted
					</p>
					<?php
					if (isset($_GET['err'])){
						echo("<p class=\"errorText\">".htmlspecialchars(($_GET['err']), ENT_QUOTES)."</p>");
					}
					$postingID = htmlspecialchars($postingID, ENT_QUOTES);
					?>
					<form class="addJobResume_form" method="post" action="processCoupon.php">
					<?php echo("<input type=\"hidden\" name=\"pID\" value=\"".$postingID."\">\n"); ?>
					
					<ul>
					<li class="addJobResume_form_li">
						<label for="couponCode">Coupon code:</label>
						<input type="text" name="couponCode" maxlength="14">
					</li>
					<li class="addJobResume_form_li">
						<label for="submit"></label>
  						<button type="submit" name="submit">submit</button>	
					</li>
					</ul>
					</form>
					<form class="addJobResume_form" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
					<ul>
					<li class="addJobResume_form_li">
						<label for="or"></label>
						<span name="or" class="errorText">or</span>
					</li>
					<li class="addJobResume_form_li">
						<label for="submit"></label>
						<?php
						echo("<input type=\"hidden\" name=\"custom\" value=\"".$postingID."\">\n");
						echo("<input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\">\n");
						echo("<input type=\"hidden\" name=\"hosted_button_id\" value=\"QSME9JL4AMG4W\">\n");
						echo("<button type=\"submit\" name=\"submit\">pay using PayPal</button>");
						?>
					</li>
					</ul>
					</form>
					<p class="errorText">
					A published listing remains active for 30 days.<br>
					If you are using PayPal, the publishing fee is $20 USD
					</p>
			</div>
		</p>
		</div>
	<?php include("/home/liketheviking9/incld_php/generateFooter.php");?>
	</body>
</html>
<?
	mysql_close($con);
?>