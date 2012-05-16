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
	echo '<h1>Job submission successful!</h1>';
	echo '<p>Your protein has been successfully submitted to our servers and is queued for abstraction.
				<br><br>Your viewing code for this protein is: <h3>'.$job['job_file'].'</h3>';
	/*if (isLoggedIn($conn))
		echo ' <i><a href="mailto:'.printUserEmail($user,$conn).'">email me this code</a></i>';*/
	
	echo '</p><br>';
	
	if (isPublic($job['job_file'],$conn))
	{
		echo '<p>The status of this protein can be monitored on the <a href="../status">status page</a>';
		if (isLoggedIn($conn) && $job['job_user']==$user)
			echo ' or at your <a href="../repo">private repository</a>';
		echo '.</p>';
	}
	else
	{
		if (isLoggedIn($conn) && $job['job_user']==$user)
			echo '<p>The status of this protein can be viewed at your <a href="../repo">private repository.</a></p>';
		else
			echo '<p>You can check the status of your protein submission <a href="../checkstatus/index.php?id='.$job['job_code'].'">here.</a></p>
					<p>Please save this viewer code as you will not be able to view or download your protein without.</p>';
	}
}

?>

</div>

<?php
//include footer block into webpage
include("../includes/footer_a.php");
?>
