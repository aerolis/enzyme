<?php

include("../includes/pg_details.php");
$pg_title = "Register";

//include header block to page
include("../includes/header_a.php");

?>
<div class="main_body">
<?php

$succ = $_GET['succ'];
$warn = $_GET['warn'];
$fname = $_GET['f'];
$lname = $_GET['l'];


if (empty($succ))
{
	echo '
	<div class="login_form">
	<h1>Register</h1>
	<form action="../scripts/createUser.php" method="post" onkeyup="checkRegisterReady();">
	<input type="text" name="fname" /><p>First Name *</p>
	<input type="text" name="lname" /><p>Last Name *</p>
	<input type="text" name="group" /><p>University / Company</p>
	<input type="text" name="email1"/><p>Email Address *</p>
	<input type="text" name="email2"/><p>Confirm Email Address *</p>
	<div class="form_spacer" id="email_spacer"></div>
	<input type="password" name="pass1"/><p>Password *</p>
	<input type="password" name="pass2"/><p>Confirm Password *</p>
	<div class="form_spacer" id="pass_spacer"></div>
	<input type="submit" value="Submit" id="form_submit" style="width: 100px; background-color:#CCC; color: black; border:#666 3px solid; padding: 0 0 0 0;" />
	<p id="form_check"></p>
	<p class="form_clear">* denotes required fields</p>
	</form>

	</div>';
}
else
{
	echo "Welcome, $fname $lname! You user account has been created successfully.\n To get started, upload a .pdb file <a href='../submit'>here.</a> To view your sumbitted proteins, check out your protein repository <a href='../repo'>here.</a>";
}

?>

<?php
//include footer block into webpage
include("../includes/footer_a.php");
?>
