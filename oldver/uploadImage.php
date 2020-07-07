<?php
include("incld/redirectFunction.php");
include("incld/loginsql.php");
include("incld/recallPicture.php");

global $oldFileName;
global $userType;

$target_dir = "pimg_f/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$randFileName = mt_rand(100000,999999);



$userType = "w"; // Get from cookies
$userID = "3"; // Get from cookies
$oldFileName = recallPicture($userType, $userID);



$target_file = $target_dir . $userType . $userID . "_" . $randFileName . "." . $imageFileType;
$unlinkFile = $target_dir . $userType . $userID . "_" . $oldFileName;

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000) {
    echo "Sorry, your file is too large. 50KB is the limit.<br>";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.\n";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		insertPicture($userType, $userID, $randFileName, $imageFileType);
		echo $unlinkFile;
		unlink($unlinkFile);
			echo "Could not delete prev file.";
    } else {
        echo "Sorry, there was an error uploading your file.\n";
    }
}

function insertPicture($userType, $userID, $randFileName, $imageFileType){
	//Redefine vars
	if ($userType == "e"){
		$userTable = "Employers";
		$userIDCol = "employerID";
		$userPage = ("displayEmployerProfile.php?eid=".$userID);
	} else {
		$userTable = "Workers";
		$userIDCol = "workerID";
		$userPage = ("displayWorkerProfile.php?wid=".$userID);
	}
	
	$userID = mysql_real_escape_string($userID);
	$userTable = mysql_real_escape_string($userTable);
	$userIDCol = mysql_real_escape_string($userIDCol);
	$userPage = mysql_real_escape_string($userPage);
	$randFileName = mysql_real_escape_string($randFileName);
	$imageFileType = mysql_real_escape_string($imageFileType);
	
	$sql = "UPDATE $userTable
			SET picName='".$randFileName.".".$imageFileType."'
			WHERE ".$userIDCol."='".$userID."'";
	
	mysql_query($sql) or die("Renob.");//or die(mysql_error());
	
	//echo "You now exist";
	redirect($userPage,false);
	
}

?>













<?php

// GrabFile.php: Takes the details

// of the new file posted as part

// of the form and adds it to the

// myBlobs table of our myFiles DB.


//global $strDesc;

global $fileUpload;

global $fileUpload_name;

global $fileUpload_size;

global $fileUpload_type;


$fileUpload = $_FILES['fileUpload'];
$fileUpload_name = $_FILES['fileUpload']['name'];
$fileUpload_size = $_FILES['fileUpload']['size'];
$fileUpload_type = $_FILES['fileUpload']['type'];
$fileUpload_temp = $_FILES['fileUpload']['tmp_name'];
$fileUpload_error = $_FILES['fileUpload']['error'];
$fileContent = file_get_contents($fileUpload_temp);
$fileContent = addslashes($fileContent);

// Make sure both a description and

// file have been entered

if (($_SERVER['HTTP_REFERER']) == ('audiMate.updatePortrait')){
				
//if(empty($strDesc) || $fileUpload == "none")

//die("You must enter both a description and file");

// Database connection variables

$dbServer = "localhost";

$dbDatabase = "audimate_db";

$dbUser = "audimate8952";

$dbPass = "kr4pp33K0ala";

//$fileHandle = fopen($fileUpload, "r");

//$fileContent = fread($fileHandle, $fileUpload_size);

$sConn = mysql_connect($dbServer, $dbUser, $dbPass)

or die("Couldn't connect to database server");

$dConn = mysql_select_db($dbDatabase, $sConn)

or die("Couldn't connect to database $dbDatabase");

$userEmail = $_POST['email'];
$userPassword = $_POST['password'];

$userEmail = mysql_real_escape_string($userEmail); 
$userPassword = mysql_real_escape_string($userPassword); 
//begin the query 

$sql = 'SELECT `alias`, `email`, `password` FROM `usersTable` WHERE `email` = \''.$userEmail.'\' AND `password` = SHA1(\''.$userPassword.'\')';
//echo $sql;
$sql_result = mysql_query($sql);
//check to see how many rows were returned 
$rows = mysql_num_rows($sql_result); 

//$count = 1 + $rows;
if ($rows<=0 ){ 
	echo "0";
} else { 

	//$theAliasi = mysql_real_escape_string($strDesc);
	$row = mysql_fetch_array($sql_result);
 	$myAlias = $row["alias"];

	$sqlB = 'SELECT * FROM `portraitsTable` WHERE `alias` = \''.$myAlias.'\' LIMIT 1;';
	$sqlRes = mysql_query($sqlB);

	$rowsz = mysql_num_rows($sqlRes); 
	if ($rowsz<=0 ){ 
		echo $myAlias." is a user but does not exist in portraits.";
	} else { 
	
		$dbQuery = 'UPDATE portraitsTable SET `portraitContent` = \''.$fileContent.'\' WHERE `alias` = \''.$myAlias.'\' LIMIT 1;';
		mysql_query($dbQuery) or die("Couldn't add file to database");
		
		echo "done!";
	}

}

} else {
	echo "0";
}
?>