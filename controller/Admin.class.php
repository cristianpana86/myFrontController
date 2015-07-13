<?php

namespace CPANA\myFrontController\controller;

use CPANA\myFrontController\login\LoginUser;
use CPANA\myFrontController\view\Render;

class Admin
{
    
    /**
    * If cookie already set and match correct cookie than redirects to /admin/home
    * else if $_POST['username'] and $_POST['password'] exist try to login
    *     if credentials are OK than set cookie 
    * @param   void
    * @return      void
    */
    public function renderLogin()
    {
    
	
        //if already logged in (the cookie is  set and cookie value is correct) than redirect automatically to /admin/home
        if(isset($_COOKIE['PageLogin'])) {
		
        
            if(LoginUser::validateCookie($_COOKIE['PageLogin'])) {
			echo "redirect to /admin/home";
                header("Location: /admin/home");
                die();
            }else{
                //echo "ajunge pe aici";
                header("Location: /");
                die();
            }
    
        }else{
        
        
            //if $_POST['username'] and $_POST['password'] exist try to login
            if(isset($_POST['username'])&isset($_POST['password'])) {
                               
                if(LoginUser::login($_POST['username'], $_POST['password'])) {
                    
                    
                    header("Location: /admin/home");
                    die();
                }else{
                    Render::$content="Wrong user or password";
                    Render::renderPage("user");
                    die();
                }
                
                
            }else{
                //get the correct path to the login.php template file
                $path=substr(__DIR__, 0, (strlen(__DIR__)-strlen("controller"))) . "templates\login.php";
        
                //reads the entire content of the file login.php in order to have it rendered
                $text=file_get_contents($path);
        
                Render::$content=$text;
                Render::renderPage("user");
       
            }
            
        }
        
        

    }
    
    /**
    * If cookie already set and match correct cookie than redirects to index_admin.php
    * otherwise show the login form
    * set cookie 
    * @param   void
    * @return      void
    */
    public function renderAdminHome()
    {
        
                
        //if already logged in (the cookie is  set) than redirect automatically to /admin/home
        if(isset($_COOKIE['PageLogin'])) {
        
            if(LoginUser::validateCookie($_COOKIE['PageLogin'])) {
				
                Render::$menu="templates\menu_admin.php";
                Render::$content="Bun venit Admin";
                Render::renderPage("admin");
                
            }else{
                echo "ajunge pe aici";
                header('Location: /');
                die();
            }
    
        }else{
            header('Location: /');
            die();
        }
        

    }
    
       
    
    public function logOut()
    {
        LoginUser::expireCookie();
        header('Location: /');
        die();
    
    }
}


?>
