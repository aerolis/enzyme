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
	<h1>Register</h1>';
	
	echo '<p id="form_warning"';
	if (isset($warn) && $warn != 0){ echo ' style="display:block;">'; }
	if ($warn == 1)
		echo 'Passwords do no match';
	if ($warn == 2)
		echo 'Please enter a valid email address';
	if ($warn == 4)
		echo 'Please fill all fields before submitting';
	if ($warn == 5)
		echo 'This email is already in use';
	echo '</p>';
	
	echo '<form action="../scripts/createUser.php" method="post" onkeyup="checkRegisterReady();" id="register_form">
	<input type="text" name="fname" /><p>First Name *</p>
	<input type="text" name="lname" /><p>Last Name *</p>
	<input type="text" name="group" /><p>University / Company</p>
	<input type="text" name="email1"/><p>Email Address *</p>
	<input type="text" name="email2"/><p>Confirm Email Address *</p>
	<div class="form_spacer" id="email_spacer"></div>
	<input type="password" name="pass1"/><p>Password *</p>
	<input type="password" name="pass2"/><p>Confirm Password *</p>
	<div class="form_spacer" id="pass_spacer"></div>
	<img class="submit" src="../images/register.png" onclick="submitForm(\'register_form\',true,\'group\');"/>
	<p id="form_check"></p>
	<p class="form_clear">* denotes required fields</p>
	</form>

	</div>';
}
else
{
	echo "Welcome, $fname $lname! You user account has been created successfully.\n To get started, upload a .pdb file <a href='../submit'>here.</a> To view your submitted proteins, check out your protein repository <a href='../repo'>here.</a><br><br>\n";
	
}

?>

<?php
//include footer block into webpage
include("../includes/footer_a.php");
?>
