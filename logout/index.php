<?php

include("../includes/pg_details.php");
$pg_title = "Logout";

$succ = logout($conn,$cookie_domain);

//include header block to page
include("../includes/header_a.php");

?>
<div class="main_body">
<?php
if ($succ)
	echo "Successfully logged out.";
else
	echo "Logout failed.";	
?>
</div>

<?php
//include footer block into webpage
include("../includes/footer_a.php");
?>
