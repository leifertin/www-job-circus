<?php
echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\" />
<link rel=\"stylesheet\" type=\"text/css\" href=\"tst_.css\" />
	</head>
	<body>
<div id=\"topNav\">";
if ($userType == "e"){
	//employers menu
	echo("
	<ul>
  		<li class=\"topNav-jobs\"><a href=\"jobSearch.php\">Search</a></li>
		<li class=\"topNav-profile\"><a href=\"index.php\">Profile</a></li>
		<li class=\"topNav-logInOut\"><a href=\"logout.php\">Log Out</a></li>
	</ul>
	");
} else if ($userType == "w"){
	//workers menu
	echo("
	<ul>
  		<li class=\"topNav-jobs\"><a href=\"jobSearch.php\">Search</a></li>
  		<li class=\"topNav-applicants\"><a href=\"viewApplied.php\">Applied</a></li>
		<li class=\"topNav-profile\"><a href=\"index.php\">Profile</a></li>
		<li class=\"topNav-logInOut\"><a href=\"logout.php\">Log Out</a></li>
	</ul>
	");

} else {
	//empty menu
	echo("
	<ul>
		<li class=\"topNav-jobs\"><a href=\"index.php\">Job-circus.com</a></li>
		<li class=\"topNav-profile\"><a href=\"login.php\">Login</a></li>
	</ul>
	");
}
echo "</div><div style=\"background-color: rgba(239,170,163,0.8); height:1em; margin-bottom:.3em;\"></div>";
?>