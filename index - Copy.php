<?php

/**
* Starting page of this website
*
*
* @author   Cristian Pana <cristianpana86@yahoo.com>
* @version   0.2
* @access   public
*/

/**
*@param string $class 
*/



$fh=fopen("path.txt","w");
fwrite($fh,__DIR__);
fclose($fh);



function my_autoloader($class) {
	
	$fh=fopen("path.txt","r") or die ('No global path is set');
    $dir=fread($fh,filesize("path.txt"));
    fclose($fh);
	
	$folders=array('\\controller\\','\\model\\','\\login\\','\\view\\');
	
	foreach($folders as $folder){
		
		//echo "path to class $class is " . $dir . $folder . $class . 'class.php';
	    if(file_exists($dir . $folder . $class . '.class.php')){
		    require_once $dir . $folder . $class . '.class.php';
		}
	}
				
}

spl_autoload_register('my_autoloader');


include("templates/header.php");


FrontController::set_controller();



include("templates/footer.php");



?>