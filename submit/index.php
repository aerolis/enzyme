<?php

include("../includes/pg_details.php");
$pg_title = "Submit job";

//include header block to page
include("../includes/header_a.php");



?>
<div class="main_body">
<div class="login_form">
<h1>Submit Protein</h1>
<p id="form_warning">&nbsp;</p>
<form enctype="multipart/form-data" action="../scripts/submit.php" method="post" id="submit_protein">
<input type="text" name="name" /><p>Molecule Name</p>

<div class="fileinputs">
	<input type="file" class="file" name="file" id="file">
</div><p>Protein File</p>
<p class="checkbox"><img id="private_checkbox" src="../images/icons/no_120_30.png" 
	onclick="toggleyesno('private_checkbox'); toggleCheckbox('private');">
	<input type="checkbox" name="private" class="checkbox_input"/>Make this protein private</p>
    
<img class="submit" src="../images/submit.png" onclick="submitForm('submit_protein',true,'');"/>
</form>

</div>

<?php
//include footer block into webpage
include("../includes/footer_a.php");
?>
