<?php

include("../includes/pg_details.php");
$pg_title = "Login";

//include header block to page
include("../includes/header_a.php");

?>
<div class="main_body">
<div class="login_form">
<h1>Login</h1>
<form action="../scripts/login.php" method="post">
<input type="text" name="email" /><p>Email Address</p>
<input type="password" name="pass" /><p>Password</p>
<input type="submit" value="Login" style="width: 100px; background-color:#CCC; color: black; border:#666 3px solid; padding: 0 0 0 0;" />
<p><a href="lostpassword/">I forgot my password</a></p>
</form>

</div>

<?php
//include footer block into webpage
include("../includes/footer_a.php");
?>
