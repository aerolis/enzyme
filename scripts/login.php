<?php

function generateCode($length = 64)
{

  // start with a blank string
  $name = "";

  // define possible characters
  $possible = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
    
  // set up a counter
  $i = 0; 
    
  // add random characters to $name until $length is reached
  while ($i < $length) { 

    // pick a random character from the possible ones
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
    $name .= $char;
    $i++;

  }

  // done!
  return $name;
}

include("crypto.php");
include("mysql_login.php");

$email = $_POST['email'];
$password_post = $_POST['pass'];
$password = mcrypt_encrypt($c_alg,$c_key,$password_post,$c_meth,$c_iv);

if ($password == NULL)
	header('Location: ' . $webroot . '/login.php');


$sql = "SELECT * FROM gr_users WHERE user_email='" . $email . "'";
$result = mysql_query($sql, $conn) or die(mysql_error());

if( $line = mysql_fetch_assoc($result) )
{
	//user is found!
	$pass	= $line['user_pass'];
	
	if (strcmp($password,$pass) == 0)
	{
	
		if ($line['user_email'] == '' || $line['user_pass'] == "")
		{		
			header('Location: ' . $webroot . '/register');	
		}
	
		//set up the value for the cookie
		$code	= generateCode();
		$cook_val	= $line['user_fname'] . "_" . $code;	
		setcookie('grUser', $cook_val, time()+60*60*24, '/', $cookie_domain);
	
		//send that value to the database, so we can authenticate them.
		$sql_2	= "UPDATE gr_users SET user_code='" . $code . "' WHERE user_id='" . $line['user_id'] . "'";
		$res_2	= mysql_query($sql_2, $conn);
		
		header('Location: ' . $webroot);
	}
	else
		header('Location: ' . $webroot);
}
else
{
	header('Location: ' . $webroot . '/login');
}
?>