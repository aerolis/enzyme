<?php

	$keyphrase 	= "fdSioVEdmb3290An30-csxzTFsoaIOzzmqw";
	$c_key 		= hash("ripemd128",$keyphase);
	$c_alg 		= "rijndael-192";
	$c_meth 	= 'cbc';    
	//$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_192, MCRYPT_MODE_ECB);
    //$c_iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	//echo $c_iv;
	$c_iv		= '[f%Á^”—™D®d„$‰z—[“x ?/—';
?>