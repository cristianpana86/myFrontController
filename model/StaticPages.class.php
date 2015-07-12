<?php
namespace CPANA\myFrontController\model;

class StaticPages
{

    public function __construct()
    {
    
        // require_once 'DBCon.class.php';
    }

    /**
    * Connects to database and fetches the text for static page 'Home'
    *
    * @param  void
    * @return string
    */
    public function getHome()
    {

        $db=new DBCon();
        $result=$db->fetchStaticPagesInfo('Home');
        
        return $result;
    }

    public function getAbout()
    {


    }

    public function getContact()
    {

    }

}

?>
