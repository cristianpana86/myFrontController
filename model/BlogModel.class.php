<?php
namespace CPANA\myFrontController\model;



class BlogModel{

	private $page_number=0;
	private $per_page=0;
	
	public function __construct(){
	
	    $path_to_xml=__DIR__ . '\\pagination.xml';
		$xml=simplexml_load_file($path_to_xml) or die("Error: Cannot create object");
		$this->page_number = (integer)$xml->page_number;
		$this->per_page =(integer) $xml->per_page;
	}
	
	
	public function setPaginationInit(){
	
		$path_to_xml=__DIR__ . '\\pagination.xml';
		$xml=simplexml_load_file($path_to_xml) or die("Error: Cannot create object");
		$xml->page_number=1;
		$xml->asXML($path_to_xml);
	
	}
	public function setPaginationOlder(){
	
		
		if($this->page_number <= 1){
			//nothing happens, the same page will be displayed
		}else{
			$path_to_xml=__DIR__ . '\\pagination.xml';
			$xml=simplexml_load_file($path_to_xml) or die("Error: Cannot create object");
			$xml->page_number=$this->page_number-1;
			$xml->asXML($path_to_xml);
		
		}
		
	
	}
	public function setPaginationNewer(){
	
		if($this->page_number >= 10){
			//nothing happens, the same page will be displayed
		}else{
			$path_to_xml=__DIR__ . '\\pagination.xml';
			$xml=simplexml_load_file($path_to_xml) or die("Error: Cannot create object");
			$xml->page_number=$this->page_number+1;
			$xml->asXML($path_to_xml);
			//echo "ar trebui sa fi scris valoarea asta " . ($this->page_number+1);
		}
	
	}
	
	/**
    *
    * Connects to database and fetches all  posts headers only (not entire content)
    *
    * @param    void
    * @return      array
    *
    */
	public function getBlogPostsHeaders(){
	
		$db=new DBCon();
		$result=$db->fetchBlogPosts(1,1000);
		
		return $result;
	
	}
	/**
    *
    * Connects to database and fetches specified posts
    *
    * @param    string $post_slug - is the name of the post extracted from the URI, ex URI: "/blog/posts/welcome-to-my-blog-people"
    *                              - the $post_slug will be "welcome-to-my-blog-people"
	* @return      array
    *
    */
	public function getPost($post_slug){
	
		
		$post_slug_from_url=$post_slug; //I want to make clear that $post_slug represents the slug from the requested URL
        $db=new DBCon();
		//$transformed_post_slug=str_replace('-',' ',$post_slug);
		
		$result=$db->fetchPost($post_slug_from_url);
		
		return $result;
	}
	/**
    *
    * Connects to database and fetches all  posts
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
	
	public function newPost($Author,$Category,$Text,$Title,$Slug){
	
		$db=new DBCon();
		$result=$db->newPost($Author,$Category,$Text,$Title,$Slug);
		
		return $result;
	}
	
	/**
    *
    * Connects to database and updates post
    *
    * @param    string $Author, string $Category, string $Text
    * @return      array
    *
    */
	
	public function updatePost($PostID,$Author,$Category,$Text,$Title){
	
		$db=new DBCon();
		$result=$db->updatePost($PostID,$Author,$Category,$Text,$Title);
		
		return $result;
	}
	
	/**
    *
    * Connects to database and updates post
    *
    * @param    string $Author, string $Category, string $Text
    * @return      array
    *
    */
	
	public function deletePost($PostID){
	
		$id=$PostID;
		$db=new DBCon();
		$result=$db->deletePost($id);
		
		return $result;
	}

}

?>