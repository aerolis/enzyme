<?php

/********************************************************
			Code for creating a new user
			Nate Barr
*********************************************************/

include("mysql_login.php");
include("php_library.php");
include("crypto.php");	

$fname		= $_POST['fname'];
$lname		= $_POST['lname'];
$email1		= $_POST['email1'];
$email2		= $_POST['email2'];
$pass1		= $_POST['pass1'];
$pass2		= $_POST['pass2'];
$group		= $_POST['group'];
$perm		= 1;
$birthday	= $byear . "-" . $bmonth . "-" . $bday;

$back	= $_GET[back];

//error checking the submissions
if ($pass1 != $pass2)
{
	//passwords don't match
	header("Location: " . $webroot . "/register/index.php?warn=1");
}
else if ($email1 != $email2 || !strpos($email1,"@"))
{
	//emails don't match
	header("Location: " . $webroot . "/register/index.php?warn=2");	
}
else if (emailExists2($email1))
{
	//email already exists
	header("Location: " . $webroot . "/register/index.php?warn=5");	
}
else if (empty($fname) || empty($lname) || empty($email1) || empty($pass1) )
{
	header("Location: " . $webroot . "/register/index.php?warn=4");
}
else 
{
	$pass = addslashes(mcrypt_encrypt($c_alg,$c_key,$pass1,$c_meth,$c_iv));
	$sql_insert	= "INSERT INTO gr_users (user_fname, user_lname, user_email, user_group, user_pass)
	VALUES ('$fname', '$lname', '$email1', '$group', '$pass')";
	
	$res_insert = mysql_query($sql_insert, $conn);

	//check that they were added
	$sql = "SELECT * FROM gr_users WHERE user_email='" . $email1 . "' AND user_pass='" . $pass . "'";
	$result = mysql_query($sql, $conn) or die(mysql_error());
		
	if( $line = mysql_fetch_assoc($result) )
	{
		//log them in
		//set up the value for the cookie
		$code	= generateCode(64);
		$cook_val	= $line['user_fname'] . "_" . $code;
		setcookie('grUser', $cook_val, time()+60*60*24, '/', $cookie_domain);
	
		//send that value to the database, so we can authenticate them.
		$sql_2	= "UPDATE gr_users SET user_code='" . $code . "' WHERE user_id='" . $line['user_id'] . "'";
		$res_2	= mysql_query($sql_2, $conn);
		
	}
	if ($back == 1)
	{
		header("Location: " . $webroot . "/register/index.php");
	}
	else
	{
		header("Location: " . $webroot . "/register/index.php?succ=1&f=" . $fname . "&l=" . $lname);
	}
}

?>