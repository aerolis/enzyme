<?php

require_once('zip/zip_library.php');
require_once('scripts/mysql_login.php');

if (false)
{
	$zip_a = 'output/2553/decal-2553.zip';
	$zip_b = 'output/2553/2553_uncompressed.zip';
		
	$files = array('2553');
	//create_zip($files,$zip_a,true,true,0);
	convert_zip_to_uncompressed($zip_a,$zip_b,2553);
}

if (false)
{
	$i = 0;
	while ($i < 30)
	{
		$s	= "INSERT INTO gr_jobs (job_name, job_user) VALUES ('$i', 11)";
		echo $s;
		$r	= mysql_query($s,$conn);
		$i++;
	}
}

if (true)
{
	$str	= "output/jV9OpoG8Uc/jV9OpoG8Uc.zip";
	if (file_exists($str))
		echo "true 1";
	if (fileExists($str))
		echo "true 2";
}

function fileExists($path){
    return (@fopen($path,"r")==true);
}
?>