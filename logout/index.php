<?php

include("../includes/pg_details.php");
$pg_title = "Logout";

$succ = logout($conn,$cookie_domain);

//include header block to page
include("../includes/header_a.php");

?>
<div class="main_body" style="text-align:center;">
<?php
if ($succ)
	echo "<h1>Successfully logged out.</h1>";
else
	echo "<h1>Logout failed.</h1>";	
?>
</div>

<?php
//include footer block into webpage
include("../includes/footer_a.php");
?>
