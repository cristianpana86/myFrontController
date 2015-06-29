<?php
namespace CPANA\myFrontController\model;
use PDO;

class DBCon{


	public $db="";
    /**
    *
    * Create a DB connection
    * @copyright  2015 Cristian Pana 
    * @param    no input params
    * @return   PDO 
    *
    */
	public function  __construct(){

        $user='myblog';
	    $pass='password';
        try{
			//include connection details 
            $db_conn = new PDO('mysql:host=localhost;dbname=myblog', $user,$pass);
		    $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db=$db_conn;
		 
	    }
	    catch(Exception $e){
	     
		     echo "Connection to Database failed".$e->getMessage();
		 
	   }

    }
	
	 /**
    *
    * Fetches the content of the static pages from the database
    * @copyright  2015 Cristian Pana 
    * @param    string $pagetype
    * @return   string
    *
    */
	public function fetchStaticPagesInfo($pagetype){
	
        $sth=$this->db->prepare("SELECT textcontent FROM static_pages WHERE pagetype=:value;");
		$sth->execute(array(':value'=>$pagetype));
		$this->db=null;
		return $sth->fetchColumn();
			
	}
	
	/**
    *
    * Fetches the content of the static pages from the database
    * @copyright  2015 Cristian Pana 
    * @param    void
    * @return   array
    *
    */
	
	public function fetchBlogPosts(){
	
	    $sth=$this->db->prepare("SELECT * FROM blogposts;");
		$sth->execute();
		$result=$sth->fetchAll();
		$this->db=null;
		return $result;
	}
	/**
    *
    * Fetches the content of the static pages from the database
    * @copyright  2015 Cristian Pana 
    * @param    string $Author, string $Category, $Text
    * @return   interger
    *
    */
	public function newPost($Author,$Category,$Text,$Title){
	
	    $stmt = $this->db->prepare("INSERT INTO blogposts (Category, Author, ActualPost,title) VALUES (:field1,:field2,:field3,:field4);");
        $stmt->execute(array(':field1' => $Category, ':field2' => $Author, ':field3' => $Text,':field4'=>$Title));
        $affected_rows = $stmt->rowCount();
		return $affected_rows;
	}
	

}
?>