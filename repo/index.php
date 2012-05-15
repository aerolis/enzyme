<?php

include("../includes/pg_details.php");
$pg_title = "My Repository";

//include header block to page
include("../includes/header_a.php");

?>
<div class="main_body">
<div class="repo">
<?php

$user	= getUserId($conn);
$pgnum	= $_GET['pg'];
$pgsize	= 15;
$pgstart = $pgnum*$pgsize;

$s	= "SELECT * FROM gr_jobs WHERE job_user='$user' ORDER BY job_date DESC LIMIT $pgstart,$pgsize";
$s_all	= "SELECT * FROM gr_jobs WHERE job_user='$user' ORDER BY job_date";
$r	= mysql_query($s,$conn);
$r_all	= mysql_query($s_all,$conn);

echo "<h2>My submitted proteins</h2>";

//print header
echo	"<div class=\"repo_header\">
			<span>Protein Name</span>
			<span>Status</span>
			<span>Viewer Code</span>
			<span>Submitted</span>
			<span>Submitted by</span>
			<span>Organization</span>
			<span>Files</span>
			</div>";

//print proteins
while ($line = mysql_fetch_array($r))
{
	echo "<div class='repo_main'>
	<span>" . $line['job_name'] . "</span>
	<span>" . printJobStatus($line['job_status']) . "</span>
	<span>" . printJobCode($line['job_status'],$line['job_file']) . "</span>
	<span>" . date("g:ia n/j/y",strtotime($line['job_date'])) . "</span>
	<span>" . printUserName($line['job_user'],$conn) . "</span>
	<span>" . printUserGroup($line['job_user'],$conn) . "</span>
	<span>";
	//deal with extra links
	echo "<a class='imagelink' href='../output/" . $line['job_file'] . "/" . $line['job_file'] . ".pdb' title='Download original .pdb'><img src='../images/icons/folder.png'></a>";
		
	if (fileExists("../output/" . $line['job_file'] . "/" . $line['job_file'] . ".zip"))
	{
		echo "<a class='imagelink' href='../output/" . $line['job_file'] . "/" . $line['job_file'] . ".zip'><img src='../images/icons/cd.png' title='Download abstracted protein'></a>";
		echo "<a class='imagelink' href='../view/index.php?id=" . $line['job_file'] . "'><img src='../images/icons/monitor.png' title='View protein'></a>";
	}
	else
	{
		echo "<img src='../images/icons/cd_banned.png' class=\"imagelink\" title='Not ready for download'>";
		echo "<img src='../images/icons/monitor_banned.png' class=\"imagelink\" title='Not ready for view'>";
	}
	
	
	if ($line['job_user'] == getUserId($conn))
		echo "<a class='imagelink' href='../delete/index.php?j=" . $line['job_id'] . "'><img src='../images/icons/cancel.png' title='Delete protein'></a>";
	echo "</span></div>";}

echo '</div>';


if (mysql_num_rows($r_all) > $pgsize)
{
	if ($pgnum > 0)
	{
		$pg = $pgnum-1;
		echo "<a href='index.php?pg=0'><img src='../images/icons/up.png' alt='Top page'></a>";
		echo "<a href='index.php?pg=" . $pg . "'><img src='../images/icons/left.png' alt='Back one page'></a>";
	}
	else
	{
		echo "<img src='../images/icons/spacer.png'>";
		echo "<img src='../images/icons/spacer.png'>";
	}
	if ($pgnum*$pgsize+$pgsize <= mysql_num_rows($r_all))
	{
		$pg = $pgnum+1;
		echo "<a href='index.php?pg=" . $pg . "'><img src='../images/icons/right.png' alt='Forward one page'></a>";
		echo "<a href='index.php?pg=".floor(mysql_num_rows($r_all)/$pgsize)."'><img src='../images/icons/down.png' alt='Bottom page'></a>";
	}
	else
	{
		echo "<img src='../images/icons/spacer.png'>";
		echo "<img src='../images/icons/spacer.png'>";
	}
}


?>

</div>

<?php
//include footer block into webpage
include("../includes/footer_a.php");
?>
