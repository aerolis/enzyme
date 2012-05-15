<?php

require_once('pclzip.lib.php');

function create_zip($files = array(),$destination = '',$overwrite = false,$uncompressed = true,$rezip = 0) {
  	//if the zip file already exists and overwrite is false, return false
  	if(file_exists($destination) && !$overwrite) { return false; }
	else if (file_exists($destination) && $overwrite) { unlink($destination); }
	
  	$valid_files = array();
  	//if files were passed in...
  	if(is_array($files)) {
    	//cycle through each file
    	foreach($files as $file) {
      	//make sure the file exists
      		if(file_exists($file)) {
        		$valid_files[] = $file;
      		}
    	}
  	}
  	//if we have good files...
  	if(count($valid_files)) {
    	//create the archive
    	$zip = new PclZip($destination);
		
    	//add the files
    	foreach($valid_files as $file) {
			if ($rezip == 0)
			{
				if ($uncompressed)
					$v_list = $zip->add($file,PCLZIP_OPT_NO_COMPRESSION);
				else
					$v_list = $zip->add($file);
			}
			else
			{
				if ($uncompressed)
					$v_list = $zip->add($file,PCLZIP_OPT_NO_COMPRESSION,PCLZIP_OPT_REMOVE_PATH,"output/".$rezip."/".$rezip."_uncompressed");	
				else
					$v_list = $zip->add($file,PCLZIP_OPT_REMOVE_PATH, "output/".$rezip."/".$rezip."_uncompressed");			
			}
			if ($v_list == 0) {
    			die("Error : ".$zip->errorInfo(true));
  			}
		}
		return true;
  	}
  	else
  	{
    	return false;
	}
}

function convert_zip_to_uncompressed($src,$dest,$id)
{
	$tmpdir	= "output/".$id."/".$id."_uncompressed";
	echo $tmpdir;
	if (!file_exists($tmpdir))
	{
		echo "file does not exist<br>";
		mkdir($tmpdir);
	}
		
	//unzip $src to a new temp directory
	$zip = new PclZip($src);
  	if ($zip->extract(PCLZIP_OPT_PATH, $tmpdir) == 0) {
    	die("Error : ".$zip->errorInfo(true));
  	}
	
	
	//rezip into $dest
	create_zip(array($tmpdir),$dest,true,true,$id);
	
	//delete temp dir
	//clear_dir($tmpdir.$i);
}

function clear_dir($src)
{
	$dir = opendir($src);
	echo $src . '<br>';
	while(false !== ($next = readdir($dir)))
	{
		$nextstr = $src.'/'.$next;
		echo $nextstr.'<br>';
		if (is_dir($nextstr) && !($next == '.' || $next == '..'))
			clear_dir($nextstr);
		else if (!is_dir($nextstr))
			unlink($nextstr);
	}
	closedir($dir);
	rmdir($src);
}

?>