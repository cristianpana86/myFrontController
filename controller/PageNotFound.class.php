<?php
namespace CPANA\myFrontController\controller;


/**
* This class handles the behaviour for the pages not found
 *
* @author  Cristian Pana <cristianpana86@yahoo.com>
* @version 0.1
* @access  public
*/

class PageNotFound extends Page
{

    public function render()
    {
    
        echo "</br></br></br>";
        echo "Page not found!";
        echo "</br></br></br>";
    }

}
