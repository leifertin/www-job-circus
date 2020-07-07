<?php

// CONFIG: Enable debug mode. This means we'll log requests into 'ipn.log' in the same directory.
// Especially useful if you encounter network errors or other intermittent problems with IPN (validation).
// Set this to 0 once you go live or don't require logging.
define("DEBUG", 0);

// Set to 0 once you're ready to go live
define("USE_SANDBOX", 0);


define("LOG_FILE", "/home/liketheviking9/ipn_log/ipn_errors.log");


// Read POST data
// reading posted data directly from $_POST causes serialization
// issues with array data in POST. Reading raw POST data from input stream instead.
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
	$keyval = explode ('=', $keyval);
	if (count($keyval) == 2)
		$myPost[$keyval[0]] = urldecode($keyval[1]);
}
// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')) {
	$get_magic_quotes_exists = true;
}
foreach ($myPost as $key => $value) {
	if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
		$value = urlencode(stripslashes($value));
	} else {
		$value = urlencode($value);
	}
	$req .= "&$key=$value";
}

// Post IPN data back to PayPal to validate the IPN data is genuine
// Without this step anyone can fake IPN data

if(USE_SANDBOX == true) {
	$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
} else {
	$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
}

$ch = curl_init($paypal_url);
if ($ch == FALSE) {
	return FALSE;
}

curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

if(DEBUG == true) {
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
}

// CONFIG: Optional proxy configuration
//curl_setopt($ch, CURLOPT_PROXY, $proxy);
//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);

// Set TCP timeout to 30 seconds
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

// CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
// of the certificate as shown below. Ensure the file is readable by the webserver.
// This is mandatory for some environments.

$cert = "/home/liketheviking9/CA_certs/cacert.pem";
curl_setopt($ch, CURLOPT_CAINFO, $cert);

$res = curl_exec($ch);
if (curl_errno($ch) != 0) // cURL error
	{
	if(DEBUG == true) {	
		error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
	}
	curl_close($ch);
	exit;

} else {
		// Log the entire HTTP response if debug is switched on.
		if(DEBUG == true) {
			error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" . PHP_EOL, 3, LOG_FILE);
			error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" . PHP_EOL, 3, LOG_FILE);
		}
		curl_close($ch);
}

// Inspect IPN validation result and act accordingly

// Split response headers and payload, a better way for strcmp
$tokens = explode("\r\n\r\n", trim($res));
$res = trim(end($tokens));


// assign posted variables to local variables
	$item_name = $_POST['item_name'];
	$item_number = $_POST['item_number'];
	$payment_status = $_POST['payment_status'];
	$payment_amount = $_POST['mc_gross'];
	$payment_currency = $_POST['mc_currency'];
	$txn_id = $_POST['txn_id'];
	$receiver_email = $_POST['receiver_email'];
	$payer_email = $_POST['payer_email'];
	$postingID = $_POST['custom'];
	
function sendJobMail($postingID){
	//get employer ID
	$postingIDsql = mysql_real_escape_string($postingID);
	$sql_t = 'SELECT `employerID`, `city`, `state` FROM `Employers` WHERE `postingID` = \''.$postingIDsql.'\' LIMIT 1';
	$sql_result_t = mysql_query($sql_t);
	$rows_t = mysql_num_rows($sql_result_t);
	if ($rows_t<1 ){ 
		redirect("index.php",false);
	} else {
		while ($row_t= mysql_fetch_array($sql_result_t)) {
 			//get employerID
			$employerID = $row_t["employerID"];
			$state = $row_t["state"];
			$city = $row_t["city"];
		}	
	}
	
	$city = mysql_real_escape_string($city);
	$state = mysql_real_escape_string($state);
	
	//get list of users in city state
	$sql = 'SELECT `email` FROM `Workers` WHERE `city` = \''.$city.'\' AND `state` = \''.$state.'\'';
	$sql_result = mysql_query($sql);
	$rows = mysql_num_rows($sql_result);
	
	//set mail text
	
	$subject = 'New job posting near you!';
	$message = 'A new job has been posted in '.$city.', '.$state.':'."\n".'https://job-circus.com/displayEmployerProfile.php?eid='.$employerID;
	$headers = 'From: Job-circus <do-not-reply@job-circus.com>' . "\r\n" .
    'Reply-To: contact@job-circus.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();


	if ($rows<1 ){ 
		//
	} else {
		while ($row= mysql_fetch_array($sql_result)) {
 			//get email of user
			$to = $row["email"];
			//mail to user
			mail($to, $subject, $message, $headers);
		}	
	}
}
if (strcmp ($res, "VERIFIED") == 0) {
	// check whether the payment_status is Completed
	// check that txn_id has not been previously processed
	// check that receiver_email is your PayPal email
	// check that payment_amount/payment_currency are correct
	// process payment and mark item as paid.
	mysql_connect('localhost', 'viking12', 'r3dBu12!') or exit(0);
    mysql_select_db('JobPool') or exit(0);
    
	$errmsg = '';   // stores errors from fraud checks
    
    // 1. Make sure the payment status is "Completed" 
    if ($payment_status != 'Completed') { 
        // simply ignore any IPN that is not completed
        exit(0); 
    }

    // 2. Make sure seller email matches your primary account email.
    if ($receiver_email != 'payments@job-circus.com') {
        $errmsg .= "'receiver_email' does not match: ";
        $errmsg .= $receiver_email."\n";
    }
    
    // 3. Make sure the amount(s) paid match
    if ($payment_amount != '20.00') {
        $errmsg .= "'mc_gross' does not match: ";
        $errmsg .= $payment_amount."\n";
    }
    
    // 4. Make sure the currency code matches
    if ($payment_currency != 'USD') {
        $errmsg .= "'mc_currency' does not match: ";
        $errmsg .= $payment_currency."\n";
    }

    // 5. Ensure the transaction is not a duplicate.

    $txn_id = mysql_real_escape_string($txn_id);
    $sql = "SELECT * FROM Orders WHERE txn_id = '".$txn_id."'";
    $r = mysql_query($sql);
	$rows = mysql_num_rows($r); 
		
	if ($rows>0 ){ 
		$errmsg .= "'txn_id' has already been processed: ".$txn_id."\n";
	}

	if ($errmsg == ""){


        // add this order to a table of completed orders
        $payer_email = mysql_real_escape_string($payer_email);
        $mc_gross = mysql_real_escape_string($payment_amount);
        $sql = "INSERT INTO Orders VALUES 
                (NULL, '$txn_id', '$payer_email', $mc_gross)";
        
        if (!mysql_query($sql)) {
            error_log(mysql_error());
            exit(0);
        }


		//activate listing
		
		$postingID = mysql_real_escape_string($postingID);
		$sql = "UPDATE `Jobs` SET `pay`='yes', `postingDate`=NOW() WHERE `postingID` = ".$postingID." LIMIT 1";
		mysql_query($sql) or die("Renob.");//die(mysql_error());
		//echo "You now exist";
		
	
		sendJobMail($postingID);
		
    
	} else {
		if(DEBUG == true) {
		error_log(date('[Y-m-d H:i e] '). "Vlap $postingID ------- $errmsg". PHP_EOL, 3, LOG_FILE);
		}
	}
	
	
	
	
	
	
	if(DEBUG == true) {
		error_log(date('[Y-m-d H:i e] '). "Verified IPN: postID: $postingID -- $req ". PHP_EOL, 3, LOG_FILE);
	}
} else if (strcmp ($res, "INVALID") == 0) {
	// log for manual investigation
	// Add business logic here which deals with invalid IPN messages
	
	mysql_connect('localhost', 'viking12', 'r3dBu12!') or exit(0);
    mysql_select_db('JobPool') or exit(0);
	
	$errmsg = '';   // stores errors from fraud checks
    
    // 1. Make sure the payment status is "Completed" 
    if ($payment_status != 'Completed') { 
        // simply ignore any IPN that is not completed
        exit(0); 
		//$errmsg .= "'payment_status' is not completed: ";
        //$errmsg .= $payment_status."\n";
    }

    // 2. Make sure seller email matches your primary account email.
    if ($receiver_email != 'payments@job-circus.com') {
        $errmsg .= "'receiver_email' does not match: ";
        $errmsg .= $receiver_email."\n";
    }
    
    // 3. Make sure the amount(s) paid match
    if ($payment_amount != '20.00') {
        $errmsg .= "'mc_gross' does not match: ";
        $errmsg .= $payment_amount."\n";
    }
    
    // 4. Make sure the currency code matches
    if ($payment_currency != 'USD') {
        $errmsg .= "'mc_currency' does not match: ";
        $errmsg .= $payment_currency."\n";
    }

    // 5. Ensure the transaction is not a duplicate.

    $txn_id = mysql_real_escape_string($txn_id);
    $sql = "SELECT * FROM Orders WHERE txn_id = '".$txn_id."'";
    $r = mysql_query($sql);
	$rows = mysql_num_rows($r); 
		
	if ($rows>0 ){ 
		$errmsg .= "'txn_id' has already been processed: ".$txn_id."\n";
	}
	
	
	
	
	if(DEBUG == true) {
		error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req ------- $errmsg" . PHP_EOL, 3, LOG_FILE);
	}
	
	
	    
	/*
    if (!$r) {
        error_log(mysql_error().PHP_EOL, 3, LOG_FILE);
        exit(0);
    }
    
    $exists = mysql_result($r, 0);
    mysql_free_result($r);
    
    if ($exists) {
        $errmsg .= "'txn_id' has already been processed: ".$txn_id."\n";
    }
	*/

	if(DEBUG == true) {
		error_log(date('[Y-m-d H:i e] '). "ZZZ ------- $errmsg" . PHP_EOL, 3, LOG_FILE);
	}
	
}

function getTextReport() {
        
        $r = '';
        
        // date and POST url
        for ($i=0; $i<80; $i++) { $r .= '-'; }
        $r .= "\n[".date('m/d/Y g:i A').'] - '.$this->getPostUri();
        if ($this->use_curl) $r .= " (curl)\n";
        else $r .= " (fsockopen)\n";
        
        // HTTP Response
        for ($i=0; $i<80; $i++) { $r .= '-'; }
        $r .= "\n{$this->getResponse()}\n";
        
        // POST vars
        for ($i=0; $i<80; $i++) { $r .= '-'; }
        $r .= "\n";
        
        foreach ($this->post_data as $key => $value) {
            $r .= str_pad($key, 25)."$value\n";
        }
        $r .= "\n\n";
        
        return $r;
    }
function getPostUri() {
        return $this->post_uri;
    }

?>
