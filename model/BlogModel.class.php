<?php
namespace CPANA\myFrontController\model;



class BlogModel{

	private $page_number=0;
	private $per_page=0;
	
	public function __construct(){
	
	    //require_once 'DBCon.class.php';
		$path_to_xml=__DIR__ . '\\pagination.xml';
		$xml=simplexml_load_file($path_to_xml) or die("Error: Cannot create object");
		$this->page_number = $xml->page_number;
		$this->per_page = $xml->per_page;
	}

	/**
    *
    * Connects to database and fetches all the blog posts
    *
    * @param    void
    * @return      array
    *
    */
	public function getBlogPosts(){
	
		
		
        $db=new DBCon();
		$result=$db->fetchBlogPosts($this->page_number,$this->per_page);
		
		return $result;
	}
	
	/**
    *
    * Connects to database and inserts a new blog post
    *
    * @param    string $Author, string $Category, string $Text
    * @return      array
    *
    */
	
	public function newPost($Author,$Category,$Text,$Title){
	
		$db=new DBCon();
		$result=$db->newPost($Author,$Category,$Text,$Title);
		
		return $result;
	}

}

?>