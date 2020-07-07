<?php
	include("/home/liketheviking9/incld_php/redirectFunction.php");
	include("/home/liketheviking9/incld_php/loginsql.php");
	include("/home/liketheviking9/incld_php/cookie_chk.php");
	allowUserType("w", $userType);
	
	if (isset($_GET['err'])){
		if (($_GET['err']) == "You now exist"){
			redirect("index.php",false);
		}
	}
	$city = $_GET['city'];
	$phone = $_GET['phone'];
	$position = $_GET['position'];
	$employer = $_GET['employer'];
?>
<!DOCTYPE HTML>
<html>

	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title>Add Job to Resume</title>
		
		<link rel="stylesheet" type="text/css" href="css/mainCode.css" />
	</head>
	<body>
	<?php include("/home/liketheviking9/incld_php/generateMenu.php");?>
	<form class="addJobResume_form" action="processAddJobResume.php" method="post">
		<div id="pageContent" align="center">
			<p>
				<div id="middleProfileInfo" >
					<p class="pageTitle" >
						add job to resume
					</p>
					<?php
					if (isset($_GET['err'])){
						echo("<p class=\"errorText\">".htmlspecialchars(($_GET['err']), ENT_QUOTES)."</p>");
					}
					?>
					<ul>
  					<li class="addJobResume_form_li">
						<label for="genre">Genre:</label>
						<select name="genre" class="stateSelect">
    						<option value="--" selected>--</option>
								<option value="Automotive">Automotive</option>
								<option value="Contract">Contract</option>
								<option value="Convenience">Convenience</option>
								<option value="Food">Food</option>
								<option value="Repair">Repair</option>
								<option value="Retail">Retail</option>
								<option value="Sales">Sales</option>
								<option value="Tourism And Hospitality">Tourism & Hospitality</option>
								<option value="Volunteer">Volunteer</option>
								<option value="Other">Other</option>
  						</select>
					</li>
					<li class="addJobResume_form_li">
						<label for="fromMonth">Start date:</label>
						<select name="fromMonth">
    						<option value="Month" selected>Month</option>
    						<option value="01">01</option>
    						<option value="02">02</option>
							<option value="03">03</option>
							<option value="04">04</option>
    						<option value="05">05</option>
							<option value="06">06</option>
							<option value="07">07</option>
    						<option value="08">08</option>
							<option value="09">09</option>
							<option value="10">10</option>
    						<option value="11">11</option>
							<option value="12">12</option>
  						</select>
						&emsp;&emsp;&emsp;
						<select name="fromYear">
    						<option value="Year" selected>Year</option>
    						<option value="2016">2016</option>
							<option value="2015">2015</option>
    						<option value="2014">2014</option>
							<option value="2013">2013</option>
							<option value="2012">2012</option>
    						<option value="2011">2011</option>
							<option value="2010">2010</option>
							<option value="2009">2009</option>
    						<option value="2008">2008</option>
							<option value="2007">2007</option>
							<option value="2006">2006</option>
    						<option value="2005">2005</option>
							<option value="2004">2004</option>
							<option value="2003">2003</option>
    						<option value="2002">2002</option>
							<option value="2001">2001</option>
							<option value="2000">2000</option>
							<option value="1999">1999</option>
							<option value="1998">1998</option>
							<option value="1997">1997</option>
							<option value="1996">1996</option>
							<option value="1995">1995</option>
							<option value="1994">1994</option>
							<option value="1993">1993</option>
							<option value="1992">1992</option>
							<option value="1991">1991</option>
							<option value="1990">1990</option>
							<option value="1989">1989</option>
							<option value="1988">1988</option>
							<option value="1987">1987</option>
							<option value="1986">1986</option>
							<option value="1985">1985</option>
							<option value="1984">1984</option>
							<option value="1983">1983</option>
							<option value="1982">1982</option>
							<option value="1981">1981</option>
							<option value="1980">1980</option>
							<option value="1979">1979</option>
							<option value="1978">1978</option>
							<option value="1977">1977</option>
							<option value="1976">1976</option>
							<option value="1975">1975</option>
							<option value="1974">1974</option>
							<option value="1973">1973</option>
							<option value="1972">1972</option>
							<option value="1971">1971</option>
							<option value="1970">1970</option>
							<option value="1969">1969</option>
							<option value="1968">1968</option>
							<option value="1967">1967</option>
							<option value="1966">1966</option>
							<option value="1965">1965</option>
							<option value="1964">1964</option>
							<option value="1963">1963</option>
							<option value="1962">1962</option>
							<option value="1961">1961</option>
							<option value="1960">1960</option>
							<option value="1959">1959</option>
							<option value="1958">1958</option>
							<option value="1957">1957</option>
							<option value="1956">1956</option>
							<option value="1955">1955</option>
							<option value="1954">1954</option>
							<option value="1953">1953</option>
							<option value="1952">1952</option>
  					</select>
					</li>
					<li class="addJobResume_form_li">
					<label for="toMonth">End date:</label>
					<select name="toMonth">
    						<option value="Month" selected>Month</option>
    						<option value="01">01</option>
    						<option value="02">02</option>
							<option value="03">03</option>
							<option value="04">04</option>
    						<option value="05">05</option>
							<option value="06">06</option>
							<option value="07">07</option>
    						<option value="08">08</option>
							<option value="09">09</option>
							<option value="10">10</option>
    						<option value="11">11</option>
							<option value="12">12</option>
  					</select>
					&emsp;&emsp;&emsp;
					<select name="toYear">
    						<option value="Year" selected>Year</option>
    						<option value="2016">2016</option>
							<option value="2015">2015</option>
    						<option value="2014">2014</option>
							<option value="2013">2013</option>
							<option value="2012">2012</option>
    						<option value="2011">2011</option>
							<option value="2010">2010</option>
							<option value="2009">2009</option>
    						<option value="2008">2008</option>
							<option value="2007">2007</option>
							<option value="2006">2006</option>
    						<option value="2005">2005</option>
							<option value="2004">2004</option>
							<option value="2003">2003</option>
    						<option value="2002">2002</option>
							<option value="2001">2001</option>
							<option value="2000">2000</option>
							<option value="1999">1999</option>
							<option value="1998">1998</option>
							<option value="1997">1997</option>
							<option value="1996">1996</option>
							<option value="1995">1995</option>
							<option value="1994">1994</option>
							<option value="1993">1993</option>
							<option value="1992">1992</option>
							<option value="1991">1991</option>
							<option value="1990">1990</option>
							<option value="1989">1989</option>
							<option value="1988">1988</option>
							<option value="1987">1987</option>
							<option value="1986">1986</option>
							<option value="1985">1985</option>
							<option value="1984">1984</option>
							<option value="1983">1983</option>
							<option value="1982">1982</option>
							<option value="1981">1981</option>
							<option value="1980">1980</option>
							<option value="1979">1979</option>
							<option value="1978">1978</option>
							<option value="1977">1977</option>
							<option value="1976">1976</option>
							<option value="1975">1975</option>
							<option value="1974">1974</option>
							<option value="1973">1973</option>
							<option value="1972">1972</option>
							<option value="1971">1971</option>
							<option value="1970">1970</option>
							<option value="1969">1969</option>
							<option value="1968">1968</option>
							<option value="1967">1967</option>
							<option value="1966">1966</option>
							<option value="1965">1965</option>
							<option value="1964">1964</option>
							<option value="1963">1963</option>
							<option value="1962">1962</option>
							<option value="1961">1961</option>
							<option value="1960">1960</option>
							<option value="1959">1959</option>
							<option value="1958">1958</option>
							<option value="1957">1957</option>
							<option value="1956">1956</option>
							<option value="1955">1955</option>
							<option value="1954">1954</option>
							<option value="1953">1953</option>
							<option value="1952">1952</option>
  						</select>
					</li>
					<li class="addJobResume_form_li">
						<label for="currentJob">Current job:</label>
						<input type="checkbox" name="currentJob" value="yes">
					</li>
					<li class="addJobResume_form_li">
						<label for="employer">Employer:</label>
						<input type="text" name="employer" maxlength="60" value="<?php echo htmlspecialchars($employer, ENT_QUOTES);?>" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="city">City:</label>
						<input type="text" name="city" maxlength="45" value="<?php echo htmlspecialchars($city, ENT_QUOTES);?>" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="state">State:</label>
						<select class="stateSelect" name="state">
    						<option value="--" selected>--</option>
							<option value="Alabama">Alabama</option>							<option value="Alaska">Alaska</option>							<option value="Arizona">Arizona</option>							<option value="Arkansas">Arkansas</option>							<option value="California">California</option>							<option value="Colorado">Colorado</option>							<option value="Connecticut">Connecticut</option>							<option value="Delaware">Delaware</option>							<option value="Florida">Florida</option>							<option value="Georgia">Georgia</option>							<option value="Hawaii">Hawaii</option>							<option value="Idaho">Idaho</option>							<option value="Illinois">Illinois</option>							<option value="Indiana">Indiana</option>							<option value="Iowa">Iowa</option>							<option value="Kansas">Kansas</option>							<option value="Kentucky">Kentucky</option>							<option value="Louisiana">Louisiana</option>							<option value="Maine">Maine</option>							<option value="Maryland">Maryland</option>							<option value="Massachusetts">Massachusetts</option>							<option value="Michigan">Michigan</option>							<option value="Minnesota">Minnesota</option>							<option value="Mississippi">Mississippi</option>							<option value="Missouri">Missouri</option>							<option value="Montana">Montana</option>							<option value="Nebraska">Nebraska</option>							<option value="Nevada">Nevada</option>							<option value="New Hampshire">New Hampshire</option>							<option value="New Jersey">New Jersey</option>							<option value="New Mexico">New Mexico</option>							<option value="New York">New York</option>							<option value="North Carolina">North Carolina</option>							<option value="North Dakota">North Dakota</option>							<option value="Ohio">Ohio</option>							<option value="Oklahoma">Oklahoma</option>							<option value="Oregon">Oregon</option>							<option value="Pennsylvania">Pennsylvania</option>							<option value="Rhode Island">Rhode Island</option>							<option value="South Carolina">South Carolina</option>							<option value="South Dakota">South Dakota</option>							<option value="Tennessee">Tennessee</option>							<option value="Texas">Texas</option>							<option value="Utah">Utah</option>							<option value="Vermont">Vermont</option>							<option value="Virginia">Virginia</option>							<option value="Washington">Washington</option>							<option value="West Virginia">West Virginia</option>							<option value="Wisconsin">Wisconsin</option>							<option value="Wyoming">Wyoming</option>							<option value="American Samoa">American Samoa</option>							<option value="District of Columbia">District of Columbia</option>							<option value="Federated States of Micronesia">Federated States of Micronesia</option>							<option value="Guam">Guam</option>							<option value="Marshall Islands">Marshall Islands</option>							<option value="Northern Mariana Islands">Northern Mariana Islands</option>							<option value="Palau">Palau</option>							<option value="Puerto Rico">Puerto Rico</option>							<option value="Virgin Islands">Virgin Islands</option>
  						</select>
					</li>
					<li class="addJobResume_form_li">
						<label for="phone">Phone number:</label>
						<input type="text" name="phone" placeholder="XXX-XXX-XXXX" maxlength="12" value="<?php echo htmlspecialchars($phone, ENT_QUOTES);?>" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="position">Position:</label>
						<input type="text" name="position" maxlength="90" value="<?php echo htmlspecialchars($position, ENT_QUOTES);?>" required>
					</li>
					<li class="addJobResume_form_li">
						<label for="responsible">Job responsibilities:</label>
						<textarea style="resize:none;" name="responsible" maxlength="400" rows="7" cols="40" required></textarea>
					</li>
					<li class="addJobResume_form_li">
						<label for="reasonLeaving">Reason for leaving:</label>
						<textarea style="resize:none;" name="reasonLeaving" maxlength="250" rows="5" cols="40"></textarea>
					</li>
					<li class="addJobResume_form_li">
						<label for="comments">Comments:</label>
						<textarea style="resize:none;" name="comments" maxlength="350" rows="6" cols="40"></textarea>
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
	<?php include("/home/liketheviking9/incld_php/generateFooter.php");?>
	</body>
</html>
