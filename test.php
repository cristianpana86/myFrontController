<?php

echo "start search";

$dir_iterator = new RecursiveDirectoryIterator("C:\Program Files (x86)\EasyPHP-DevServer-14.1VC9\data\localweb\myFrontController");
$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST,RecursiveIteratorIterator::CATCH_GET_CHILD);
// could use CHILD_FIRST if you so wish

foreach ($iterator as $file) {
    if(preg_match("/.class.php/i",$file)) echo $file, "</br>";
}
/*
foreach (glob("*.php") as $filename) {
		echo $filename;
	}
	echo "end search";
*/
?>