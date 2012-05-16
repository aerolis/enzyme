<?php

ob_start();

$main_stylesheet = "/enzyme2/includes/master.css";

$now_at_dir = getcwd();
chdir(realpath("/home/content/10/8826310/html/enzyme"));
include("scripts/php_library.php");

chdir($now_at_dir);

ob_end_clean();

?>