<?php
// mySql db and login information here

require_once("domain_details.php");


$conn = mysql_connect('grapeenzyme.db.8826310.hostedresource.com', 'grapeenzyme', 'CSGraphics2');
if (!$conn) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db('grapeenzyme', $conn) or die(mysql_error());

?>