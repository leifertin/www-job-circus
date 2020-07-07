<?php
	include("incld/redirectFunction.php");
	
	if (isset($_GET['err'])){
		if (($_GET['err']) == "You now exist"){
			redirect("index.php",false);
		}
	}
	
	$userID = "3";
	$userType = "w";
	$userImage = "image.php?t=".$userType."&id=".$userID;
	//$userImage = htmlspecialchars($userImage, ENT_QUOTES);
	
?>
<!DOCTYPE HTML>
<html>

	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title>Edit Profile Picture</title>
		
		<link rel="stylesheet" type="text/css" href="../css/mainCode.css" />
	</head>
	<body>
	<form class="addJobResume_form" action="uploadImage.php" method="post" enctype="multipart/form-data">	
	<div id="topNav">
		<ul>
  			<li class="topNav-jobs"><a href="#">Find A Job</a></li>
  			<li class="topNav-applicants"><a href="#">My Jobs</a></li>
			<li class="topNav-profile"><a href="#">Profile</a></li>
			<li class="topNav-logInOut"><a href="#">Log Out</a></li>
		</ul>
	</div>
		<div id="pageContent" align="center">
			<p>
				<div id="editProfilePicture" >
					<p class="pageTitle" >
						edit profile picture
					</p>
					<?php
					if (isset($_GET['err'])){
						echo("<p class=\"errorText\">".htmlspecialchars(($_GET['err']), ENT_QUOTES)."</p>");
					}
					?>
					<ul>
					<li class="addJobResume_form_li">
						<div id="employerProfilePicture" style="background-image: url('<?php echo($userImage);?>');">
						</div>
						<img src="<?php echo($userImage);?>">
					</li>
					<li class="addJobResume_form_li">
						<input type="file" name="fileToUpload" id="fileToUpload" size="10" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="submit"></label>
  						<button type="submit" name="submit">done</button>	
					</li>
				</ul>
			</div>
		</p>
		</div>
	</form>	
	</body>
</html>