<?php

include("../includes/pg_details.php");

$name	= $_POST["name"];
$priv	= $_POST["private"];
$file	= $_FILES["file"];
$user	= getUserId($conn);
$filename	= basename($file["name"]);

//convert the private input to bool
if ($priv == 'on')
	$priv = 1;
else
	$priv = 0;

//deal with uploaded pdb file

//set to require < 3MB files
if ((($_FILES["file"]["type"] == "application/octet-stream")) && ($_FILES["file"]["size"] < 3000000))
{
	if ($_FILES["file"]["error"] > 0)
	{
    	echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
	}
  	else
	{
    	//echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    	//echo "Type: " . $_FILES["file"]["type"] . "<br />";
    	//echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    	//echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
		
		$code_len	= 10;
		$code	= generateCode($code_len);
		
		$s	= "SELECT * FROM gr_jobs WHERE job_file='$code'";
		while (mysql_num_rows(mysql_query($s,$conn)) > 0)
		{
			$code = generateCode($code_len);
			$code_len++;
		}
		//echo "<br>Grabbed code: " . $code . "<br>";
		
		//add the file to the job queue
		$s	= "INSERT INTO gr_jobs (job_name, job_file, job_private, job_status, job_user) VALUES ('$name', '$code', '$priv', '1', '$user')";
		$r	= mysql_query($s,$conn);
			
		$dest_dir	= "../output/" . $code;
		$dest_file	= $dest_dir . "/" . $code . ".pdb";
		
	    if (file_exists($dest_file))
    	{
    		//echo $dest_file . " already exists. ";
    	}
    	else
    	{
			if (!is_dir("../output"))
				mkdir("../output");
			if (!is_dir($dest_dir))
				mkdir($dest_dir);
    		move_uploaded_file($_FILES["file"]["tmp_name"], $dest_file);
    	  	//echo "<br>Stored in: " . $dest_file;
			
			/*******************************************************************
					TODO: Link to the protein analysis software
					Currently the pdb file is moved to a directory
					in /output/$code based on a generated unique $code.
					$code is saved in the database under the field job_file.
			
					In addition, each job is added to the database with
					a job_status = 1 to represent that it has been added
					to the queue but has not been processed.
					
					When a job is selected for processing (tbd how this
					is done) its job_status should be updated to = 2 to
					show that it is in the works. 
					
					When completed, job_status should be set = 3 to show 
					that it is complete and can be viewed. The output zip
					file should be placed in /output/$code for the given
					job and the method convert_zip_to_uncompressed($src,$dest)
					(found in /zip/zip_library.php) should be run with the
					original compressed zip, with an output file of
					/output/$code/$code_uncompressed.zip. This will create
					an uncompressed zip in the correct directory for the
					viewer to find.
			*******************************************************************/
			
			header("Location: " . $webroot . "/submitted/index.php?code=" . $code);
    	}
  	}
}
else
{
	echo "Invalid file";
}


?>
