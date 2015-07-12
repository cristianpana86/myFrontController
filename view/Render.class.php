<?php 
namespace CPANA\myFrontController\view;


class Render
{

    public static $content="";
    public static $menu="templates\menu.php";
    public static $menu_up="templates\menu_up.php";
    
    
    public static function renderContent()
    {
       
       

    }
    
    public static function renderPage($pagetype)
    {
       
        $path=substr(__DIR__, 0, (strlen(__DIR__)-strlen("\view")));
       
        switch ($pagetype){
        case "user":
              include_once  $path . "templates\main_template.php";
            break;
        case "admin":
            include_once  $path . "templates\main_template.php";
            break;
        }

    }
}
