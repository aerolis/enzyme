<?php

include("../includes/pg_details.php");

$user	= getUserId($conn);

if ($user == -1)
	header("Location: " . $webroot);

$j	= $_GET['j'];

$s	= "DELETE FROM gr_jobs WHERE job_id='$j' AND job_user='$user'";
$r	= mysql_query($s,$conn);

header("Location: " . $webroot . "/repo");

?>