<?php

namespace CPANA\myFrontController\validation;


/**
* Validation  contains methods to validate user input
*
* @author  Cristian Pana <cristianpana86@yahoo.com>
* @version 0.1
* 
*/

class Validation
{
    
	/**
	* Regular expression to be used against input data
	*
	* source of inspiration for regex  http://webcheatsheet.com/php/regular_expressions.php
	*
	*/
    const REGEX_USER   = '/^[a-zA-Z0-9_-]{3,16}$/i';
    const REGEX_PASS   = '/^[a-zA-Z0-9_-]{3,20}$/i';
	  
	/**
    * Validate user 
    *
    * @copyright 2015 Cristian Pana 
    * @param     string $user
    * @return    boolean flag
    */
    public static function userValidation($user)
	{
	    $flag=false;
		
		if (preg_match(self::REGEX_USER,$user)===1) {
		    $flag=true;
		}
		
	    return $flag;
	}
	
	/**
    * Validate password 
    *
    * @copyright 2015 Cristian Pana 
    * @param     string $pass
    * @return    boolean flag
    */
    public static function passwordValidation($pass)
	{
	    $flag=false;
		
		if (preg_match(self::REGEX_PASS,$pass)===1) {
		    $flag=true;
		}
				
	    return $flag;
	}
	
    /**
    * Validate user and pass inputs 
    *
    * @copyright 2015 Cristian Pana 
    * @param     string $user, string $param
    * @return    boolean $flag
    */
	public static function userAndPass($user,$pass)
	{
	    $flag=false;
		if (self::userValidation($user) and (self::passwordValidation($pass))) {
		    $flag=true;
		}
		return $flag;
	
	}
	/**
    * Validate blog post content
    *
    * @copyright 2015 Cristian Pana 
    * @param     string $blogPost
    * @return    boolean flag
    */
    public static function titleValidation($title)
	{
	    $flag=false;
		
		if (isset($title)){
		    if ((strlen($title)>3)and (strlen($title)<255)){
		        $flag=true;
		   }
		}
		
	    return $flag;
	}



}



