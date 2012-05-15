<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="<?php echo $main_stylesheet; ?>" />
<title>GRAPE | <?php echo $pg_title; ?></title>
<script type="text/javascript" src="../scripts/jquery-1.6.2.min.js" language="javascript"></script>
<script type="text/javascript" src="../scripts/javascript_library.js" language="javascript"></script>
<script type="text/javascript" language="javascript"><?php echo $page_extra_script; ?></script>

</head>

<body onload="initFileUploads();">
<div class="header">
	<h2>GRaphical Abstracted Protein Explorer (GRAPE)</h2>
	<h2>UW Bacter Institute and UW Graphics Group</h2>
	<div class="navbar">
    	<ul>
   		<a href="/enzyme"><li class="link">GRAPE Home</li></a>
        <li class="navbar_spacer">&nbsp;</li>
   		<a href="/enzyme/view"><li class="link">Viewer</li></a>
        <li class="navbar_spacer">&nbsp;</li>
   		<a href="/enzyme/manual" onclick="return false" ><li class="link">Manual</li></a>
        <li class="navbar_spacer">&nbsp;</li>
    	<a href="/enzyme/submit"><li class="link">Submit Job</li></a>
        <li class="navbar_spacer">&nbsp;</li>
    	<a href="/enzyme/status"><li class="link">Job Status</li></a>
        <li class="navbar_spacer">&nbsp;</li>
    	<a href="/enzyme/about"><li class="link">About This Tool</li></a>
        <li class="navbar_spacer">&nbsp;</li>
        |
        <?php
		if (!isLoggedIn($conn))
		{
			echo '<li class="navbar_spacer">&nbsp;</li>
    				<a href="/enzyme/login"><li class="link">Login</li></a>
        			<li class="navbar_spacer">&nbsp;</li>
    				<a href="/enzyme/register"><li class="link">Register</li></a>';
		}
		else
		{
			echo '<li class="navbar_spacer">&nbsp;</li>
    				<a href="/enzyme/repo"><li class="link">My Protein Repository</li></a>
        			<li class="navbar_spacer">&nbsp;</li>
    				<a href="/enzyme/logout"><li class="link">Logout</li></a>';			
		}
		
		?>
        </ul>
    </div>
</div>

<div class="body">