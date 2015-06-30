<?php
namespace CPANA\myFrontController\model;

class BlogModel{

	private $per_page=2;
	
	public function __construct(){
	
	    require_once 'DBCon.class.php';
	}

	/**
    *
    * Connects to database and fetches all the blog posts
    *
    * @param    void
    * @return      array
    *
    */
	public function getBlogPosts($page_number){

        $db=new DBCon();
		$result=$db->fetchBlogPosts($page_number,$this->per_page);
		
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