<?php

include("../includes/pg_details.php");
$pg_title = "Login";

//include header block to page
include("../includes/header_a.php");

?>
<div class="main_body">
<div class="login_form">
<h1>Lost password retrieval</h1>
<p>Please enter the email you used to register and your password will be forwarded to you.</p>
<form action="../scripts/lostpassword.php" method="post" id="login_form">
<input type="text" name="email" /><p>Email Address</p>
<img class="submit" src="../images/login.png" onclick="submitForm('login_form',true,'');"/>
</form>

</div>

<?php
//include footer block into webpage
include("../includes/footer_a.php");
?>
