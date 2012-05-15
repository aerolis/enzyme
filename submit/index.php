<?php

include("../includes/pg_details.php");
$pg_title = "Submit job";

//include header block to page
include("../includes/header_a.php");



?>
<div class="main_body">
<div class="login_form">
<h1>Submit Protein</h1>
<form enctype="multipart/form-data" action="../scripts/submit.php" method="post">
<input type="text" name="name" /><p>Molecule Name</p>

<div class="fileinputs">
	<input type="file" class="file" name="file" id="file">
</div><p>Protein File</p>
<?php 
if (isLoggedIn($conn))
	echo '<input type="checkbox" name="private" /><p>Make this protein private</p>';
?>
<input type="submit" value="Submit" style="width: 100px; background-color:#CCC; color: black; border:#666 3px solid; padding: 0 0 0 0;" />
</form>

</div>

<?php
//include footer block into webpage
include("../includes/footer_a.php");
?>
