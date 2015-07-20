<?php
namespace CPANA\myFrontController\controller;


/**
* This class handles the behaviour for the pages not found
 *
* @author  Cristian Pana <cristianpana86@yahoo.com>
* @version 0.1
* @access  public
*/

class AccessDenied extends Page
{

    public function render()
    {
    
        echo "</br></br></br>";
        echo 'Access Denied! Please login <a href="/admin"> here</a>!';
        echo "</br></br></br>";
    }

}
