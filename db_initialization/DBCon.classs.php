<?php


class DBCon
{

    /**
    * Create a DB connection
    * @copyright  2015 Cristian Pana 
    * @param    no input params
    * @return      void
    */
    public function __construct()
    {

        $user='myblog';
        $pass='password';
        try{
            
            $db_conn = new PDO('mysql:host=localhost;dbname=myblog', $user, $pass);
            $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         
        }
        catch(Exception $e){
         
            
            echo "Connection to Database failed";
         
        }

    }

}

$x=new DBCon();
?>
