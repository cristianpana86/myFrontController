<?php

namespace CPANA\myFrontController\login;

class LoginUser
{

    private static $secret_word='doooooo';
    /**
    * Validate user filled in form authentication
    * @copyright  2015 Cristian Pana 
    * @param   string $user - user filled in login form
    * @param    string $pass - password filled in login form
    * @return      boolean
    */
    static public function validateUserPass($user,$pass)
    {
        if(($user=='admin')&&($pass=='1234')) {
            return true;
        }else{
            return false;
        }
    }
    /**
    * set cookie 
    * @param   string $user - user filled in login form
    * @return      void
    */
    static public function setCookieUsername($user)
    {
        setcookie('PageLogin', md5($user.self::$secret_word), time()+3600, '/');
        setcookie('PageLoginUser', $user, time()+3600, '/');
    }
    
    static public function validateCookie($biscuit)
    {
        if($biscuit==md5('admin'.self::$secret_word)) {
            return true;
        }else{
            return false;
        }
    }
    
    static public function expireCookie()
    {
        setcookie('PageLogin', "", time()-3600, '/');
        setcookie('PageLoginUser', "", time()-3600, '/');
    
    }
    
    public static function login($user,$pass)
    {
    
        if(self::validateUserPass($user, $pass)) {
            self::setCookieUsername($_POST['username']);
            return true;
            
        }else{
            return false;
            
        }
    }
    public static function validateLoginAdmin()
    {
    

    
        if(isset($_COOKIE['PageLogin'])) {
        
            if(self::validateCookie($_COOKIE['PageLogin'])) {
                return true;
            }else{
                return false;
            }
    
        }else{
        
            return false;
        
        }
        
            
    }
    

}

?>
