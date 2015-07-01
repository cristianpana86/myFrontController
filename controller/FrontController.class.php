<?php
namespace CPANA\myFrontController\controller;


/**
* FrontController  has one static function which calls specific object and method depending on the input from GET or POST
*
*
* @author   Cristian Pana <cristianpana86@yahoo.com>
* @version   0.3
* @access   public
*/

class FrontController{

		
	private $relative_url='';
	private $controllerClass='';
	private $action='';
	
	public function __construct(){
		
		$request_uri=$_SERVER['REQUEST_URI'];
		
		$this->relative_url=substr($request_uri, strpos($request_uri,'/',1));
		
		
	}
	
	/**
    *
    * search for path in \config\route.xml, if the path exist this function saves the values in the properties of the class
	*
    * @copyright  2015 Cristian Pana 
	* @param    string $path  is the value of the $relative_url determined in the __contruct()
    * @return   boolean
    *
    */
	
	public function findPath($path){
		
		
		$path_to_routexml=substr(__DIR__,0,(strlen(__DIR__)-strlen('\controller'))) . '\\config\\route.xml';
		$xml=simplexml_load_file($path_to_routexml) or die("Error: Cannot open \\config\route.xml");
		
		foreach($xml->children() as $route){
		
			if($route->path==$path){
				$this->controllerClass = $route->controllerClass;
				$this->action = $route->action;
				return true;
			}
			
		}
		return false;
	
	}
	
	/**
    *
    * Calls the needed object and method based on path in the HTTP Request
	* it uses the findPath function to determine if the path requested is configured and if yes calls the class and method 
	* specified in \config\route.xml
	*
    * @copyright  2015 Cristian Pana 
	* @param    void
    * @return   void
    *
    */
	public  function  set_controller(){
	    
		
		/**
	    *  call controller class with the name name as the 'controller' and method with the same name as 'action'
	    */ 
		if($this->findPath($this->relative_url)){	
			
			$class_name=__NAMESPACE__ . '\\'. $this->controllerClass;
			$func=(string)$this->action;
			//var_dump($func);	
			$obj= new $class_name();
			$obj->$func();
		}else{
			//call specific class to handle 404 messages
			$class_name=__NAMESPACE__ . '\\'. "PageNotFound";
				
			$obj= new $class_name();
			$obj->render();
		
		}
			
		   
				
	}
}

?>