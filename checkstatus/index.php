<?php

include("../includes/pg_details.php");
$pg_title = "Submit job";

//include header block to page
include("../includes/header_a.php");

if (!isset($_GET['code']))
	$warn = 1;
else
{
	$id	= $_GET['code'];
	$s	= "SELECT * FROM gr_jobs WHERE job_file='$id'";
	$r	= mysql_query($s,$conn);
	$job = mysql_fetch_array($r);
	if ($job['job_file'] != $id)
		$warn = 2;
	
	$user	= getUserId($conn);
}
?>
<div class="main_body" style="text-align:center">

<?php


if ($warn == 1)
{
	//shouldn't be here without an id
	echo '<h2>Oops! It looks like there has been an error.</h2>';
	echo '<p>We could not find the viewer code. Please submit again.</p>';
}
else if ($warn == 2)
{
	//job submission failed
	echo '<h2>Oops! It looks like there has been an error.</h2>';
	echo '<p>It looks like your protein file had an error or wasn\'t submitted correctly. Please correct and try again.</p>';
}
else
{
	echo '<h1>Status: '.$job['job_name'] .'</h1>';

	echo '<p>Your protein has been successfully submitted to our servers and is queued for abstraction.
				<br><br>Your viewing code for this protein is: <h3>'.$job['job_file'].'</h3>';

	switch($job['job_status'])
	{
		case 1:
			echo '<p>Your protein has been submitted and is waiting to be processed. Please check back.</p>';
		break;
		case 2:
			echo '<p>You protein has begun processing and will be ready for viewing shortly.</p>';
		break;
		case 3:
			echo '<p>Your protein has been abstracted and is ready to view! View it <a href="../view/index.php?id='.$job['job_file'].'">here</a> 
			or download the .zip directory <a href="../output/'.$job['job_file'].'/'.$job['job_file'].'.zip">here</a>.</p>';
		break;
	}

}

?>

</div>

<?php
//include footer block into webpage
include("../includes/footer_a.php");
?>
