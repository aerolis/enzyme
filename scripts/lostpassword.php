<?php

include("mysql_login.php");
include("php_library.php");
include("crypto.php");	

$email = $_POST['email'];
$sql = "SELECT * FROM gr_users WHERE user_email='" . $email . "'";
$result = mysql_query($sql, $conn) or die(mysql_error());

if( $line = mysql_fetch_array($result) )
{
	//user is found!
	$pass	= $line['user_pass'];
	$pass_decrypt	= mcrypt_decrypt($c_alg,$c_key,$pass,$c_meth,$c_iv);
	
	$s	= "SELECT * FROM gr_users WHERE user_email='$email'";
	$r	= mysql_query($s,$conn);
	if (mysql_num_rows($r)>0)
		$user	= mysql_fetch_array($r);
	
	$name = $user['user_fname'] . " " . $user['user_lname'];
	
	$to      = $email;
	$subject = 'GRAPE Lost Password';
	
	$message = '
	<html>
	<head>
	  <title>GRAPE Lost Password</title>
	</head>
	<body>
	  <p>' . $name . ';</p>
	  <p>Your password for the GRAPE protein viewer is:<br>
	  ' . $pass_decrypt  . '<br>
	  Thank you.</p>
	</body>
	</html>
	';
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Additional headers
	$headers .= 'To: ' . $name . '<' . $email . '>' . "\r\n";
	$headers .= 'From: ' . $mailserver .  '<grape@' . $mailserver . '>' . "\r\n";
	
	ini_set("SMTP","mail.' . $mailserver . '");
	
	// Please specify an SMTP Number 25 and 8889 are valid SMTP Ports.
	ini_set("smtp_port","25");
	
	// Mail function that sends the email.
	if (mail($to,$subject,$message,$headers))
		header('Location: ' . $webroot . '/login');

	
}
else
{
	header('Location: ' . $webroot . '/login');
}

?>