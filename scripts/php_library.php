<?php
//Globals

include_once("mysql_login.php");

/*********************************
General purpose scripts with php
**********************************/

function isLoggedIn($conn)
{
	if (getUserId($conn) > 0)
		return true;
	else
		return false;
}
function logout($conn,$cookie_domain)
{
	if (isset($_COOKIE['grUser']))
	{	
		//finds the username and code from the cookie
		$cook_val	= $_COOKIE['grUser'];
		$tok 		= strtok($cook_val, "_");
		$user_id	= $tok;
		$tok		= strtok("_");
		$user_code	= $tok;
	
		$check_login	= "SELECT user_id FROM gr_users WHERE user_fname='" . $user_id . "' AND user_code='" . $user_code . "'";
		$result_login	= mysql_query($check_login, $conn);	
		if (mysql_num_rows($result_login) > 0)
		{
			$row	= mysql_fetch_row($result_login);
			//log them in
			//set up the value for the cookie
			setcookie('grUser', '0', time()-5, '/', $cookie_domain);
		
			//send that value to the database, so we can authenticate them.
			$sql_2	= "UPDATE gr_users SET user_code='' WHERE user_id='" . $row[0] . "'";
			$res_2	= mysql_query($sql_2, $conn);
			return 1;
		}
		return 0;
	}
}
function printJobStatus($status)
{
	switch($status)
	{
		case 1:
			return "Waiting in queue";
		break;
		case 2:
			return "Job in process";
		break;
		case 3:
			return "Job completed";
		break;
	}
}
function printJobCode($status, $code)
{
	switch($status)
	{
		case 3:
			return "<a class='textlink' href='../view/index.php?id=" . $code . "'>". $code . "</a>";
		break;
		default:
			return "N/A";
	}
}
function getUserId($conn)
{
	if (isset($_COOKIE['grUser']))
	{	
		//finds the username and code from the cookie
		$cook_val	= $_COOKIE['grUser'];
		$tok 		= strtok($cook_val, "_");
		$user_id	= $tok;
		$tok		= strtok("_");
		$user_code	= $tok;
	
		$check_login	= "SELECT user_id FROM gr_users WHERE user_fname='" . $user_id . "' AND user_code='" . $user_code . "'";
		$result_login	= mysql_query($check_login, $conn);	
		if (mysql_num_rows($result_login) > 0)
		{
			$row	= mysql_fetch_row($result_login);
			return $row[0];
		}
		return 0;
	}
}
function printUserName($id,$conn)
{
	if ($id > 0)
	{
		$s	= "SELECT * FROM gr_users WHERE user_id='$id'";
		$r	= mysql_query($s,$conn);
		while ($line = mysql_fetch_array($r))
		{
			$str = $line['user_fname'] . " " . $line['user_lname'];
			return $str;
		}
	}
	else
		return "Anonymous";
}
function printUserGroup($id,$conn)
{
	if ($id > 0)
	{
		$s	= "SELECT * FROM gr_users WHERE user_id='$id'";
		$r	= mysql_query($s,$conn);
		while ($line = mysql_fetch_array($r))
		{
			$str = $line['user_group'];
			return $str;
		}
	}
	else
		return "Anonymous";
}
function emailExists2($email)
{
	include ("mysql_login.php");
	$sql = "SELECT * FROM gr_users WHERE user_email='" . $email . "'";
	$res = mysql_query($sql, $conn);
	if (mysql_num_rows($res) > 0)
	{
		return true;	
	}
	return false;	
}
function generateCode($length)
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

function create_job_page($id, $webroot, $overwrite = false)
{
	//make sure the directory exists
	$jobdir = '/enzyme/jobs';
	if (!file_exists($jobdir))
		mkdir($jobdir);
		
	//check that the job directory doesn't already exists and that we can't overwrite it
	$fulldir = $jobdir . '/' . $id;
	if(file_exists($fulldir) && !$overwrite) { return false; }
	else if (file_exists($fulldir)) { clear_dir($fulldir); }
	
	//now create the directory and create index.php
	mkdir($fulldir);
	if (!($handle	= fopen($fulldir . '/index.php','w+')))
		return false;
	
	$str 	= "<?php
			header(\"Location: $webroot/view/index.php?job=$id\");
			?>";
	fwrite($handle,$str);
	fclose($handle);
	
	return true;
}

function check_viewer_code($code,$conn)
{
	$s	= "SELECT * FROM gr_jobs WHERE job_file='$code'";
	$r	= mysql_query($s,$conn);
	if (mysql_num_rows($r) > 0)
		return true;
	else
		return false;
}
?>