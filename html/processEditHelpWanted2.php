<?php
include("/home/liketheviking9/incld_php/redirectFunction.php");
include("/home/liketheviking9/incld_php/loginsql.php");
include("/home/liketheviking9/incld_php/cookie_chk.php");
allowUserType("e", $userType);

function still_process_helpwanted(){
	if (($_SERVER['HTTP_REFERER']) == ('processEditHelpWanted.circus')){
		$position = $_POST['position'];
		$wage = $_POST['wage'];
		$tips = $_POST['tips'];
		$responsible = $_POST['responsible'];
		$qualify = $_POST['qualify'];
		$comments = $_POST['comments'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$postingID = $_POST['postingID'];
		
		$redirUrl = "editHelpWanted.php?";
		
		$position = mysql_real_escape_string($position);
		$wage = mysql_real_escape_string($wage);
		$tips = mysql_real_escape_string($tips);
		$responsible = mysql_real_escape_string($responsible);
		$qualify = mysql_real_escape_string($qualify);
		$comments = mysql_real_escape_string($comments);
		$email = mysql_real_escape_string($email);
		$password = mysql_real_escape_string($password);
		$postingID = mysql_real_escape_string($postingID);

		//begin the query 
		//Check if email is in use
		$sql_a = 'SELECT * FROM `Employers` WHERE `email` = \''.$email.'\' LIMIT 1';
		$sql_result_a = mysql_query($sql_a);
		$rows_a = mysql_num_rows($sql_result_a); 
		
		$row = mysql_fetch_array($sql_result_a);
		$userID = $row["employerID"];
		$genre = $row["genre"];
		$userID = mysql_real_escape_string($userID);
		$genre = mysql_real_escape_string($genre);
		
		if ($row["loginData"] == encodeLoginDetails($email,$password)){ 
			finishRegistration($position, $wage, $tips, $responsible, $qualify, $comments, $postingID, $genre, $redirUrl);		
		} else {
			echo "Your login info is incorrect";
		}
	} else { 
		redirect(("editHelpWanted.php?pID=".$postingID),false);

	}
}



function finishRegistration($position, $wage, $tips, $responsible, $qualify, $comments, $postingID, $genre, $redirUrl){
	//update help wanted
	
	$sql = 'UPDATE `Jobs` SET `position`=\''.$position.'\', `wage`=\''.$wage.'\', `tips`=\''.$tips.'\', `responsible`=\''.$responsible.'\', `qualify`=\''.$qualify.'\', `comments`=\''.$comments.'\', `genre`=\''.$genre.'\' WHERE `postingID` = \''.$postingID.'\'';
	
	mysql_query($sql) or die("error");
	echo "You now exist";
	
}

include("/home/liketheviking9/incld_php/encodeLogin.php");

still_process_helpwanted();
?>
<?php
	mysql_close($con); 
?>