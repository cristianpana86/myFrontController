<?php
namespace CPANA\myFrontController\controller;

use CPANA\myFrontController\model\StaticPages;
use CPANA\myFrontController\view\Render;
use CPANA\myFrontController\login\LoginUser;

/**
* Home class handles the behaviour of the "Home" page
 *
* @author  Cristian Pana <cristianpana86@yahoo.com>
* @version 0.1
* @access  public
*/
class Home extends Page
{

    /**
    * This variable stores the text to be displayed on the Home page
    * @var string
    */
    private $mesaj='';   
    public function __construct()
    {
    
        //require_once "{$_SERVER["DOCUMENT_ROOT"]}".'/myFrontController/model/StaticPages.class.php';
        $sp=new StaticPages();
        $this->mesaj=$sp->getHome();
    }
    
    public function render()
    {
    
        //modify the values of the static properties $content and $menu of the Render class and then display the main_template.php
        
        if (LoginUser::validateLoginAdmin()) { Render::$menu="templates\menu_admin.php"; 
        }
        Render::$content=$this->mesaj;
        Render::renderPage("user");
    }
}

?>
