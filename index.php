<?php
namespace CPANA\myFrontController;
use CPANA\myFrontController\controller\FrontController;

/**
* Starting page of this website
*
*
* @author   Cristian Pana <cristianpana86@yahoo.com>
* @version   0.3
* @access   public
*/

/**
*@param string $class 
*/


spl_autoload_register(function ($class) {
	
	//echo "autoloaderul cauta clasa  " . $class . "<br>";
    // project-specific namespace prefix
    $prefix = 'CPANA\\myFrontController\\';

    // base directory for the namespace prefix
    $base_dir = __DIR__ .'\\';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
		return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .class.php
    $file = $base_dir . $relative_class . '.class.php';
	//echo "<br>" . "file path is " . $file . "<br>";
    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});




$fconontroller=new FrontController();
$fconontroller->set_controller();

//FrontController::set_controller();







?>