<?php
namespace CPANA\myFrontController\model;



class BlogModel
{

    private $page_number=0;
	private $page_older=0;
	private $page_newer=0;
    private $per_page=0;
    
    public function __construct()
    {
    
        $path_to_xml=__DIR__ . '\\pagination.xml';
        $xml=simplexml_load_file($path_to_xml) or die("Error: Cannot create object");
        //$this->page_number = (integer)$xml->page_number;
        $this->per_page =(integer) $xml->per_page;
		$this->page_number=1;
		$this->page_older=1;
		$this->page_newer=2;
    }
    
	/**
    * Set current page number from the requested URI, for ex /blog/4
    *
    * @param  integer setPageNumber
    * @return void
    */
	public function setPageNumber($current_page)
	{
	    $db=new DBCon;
		$totalPostsNo=$db->countBlogPosts();
	    if ($current_page<=1){
		
	        $this->page_number=1;
			
		}else if ($current_page>=($totalPostsNo/$this->per_page)){
		
		    $this->page_number=$current_page;
			$this->page_older=$current_page -1;
			$this->page_newer=$current_page;
		
		}else{
		
		    $this->page_number=$current_page;
			$this->page_older=$current_page -1;
			$this->page_newer=$current_page +1;
		}
		
	}
    /**
    * Get current page number from the requested URI, for ex /blog/4
    *
    * @param  void
    * @return integer page_number
    */
	public function getPageNumber()
	{
        return $this->page_number;
	} 
	/**
    * Get older page number
    *
    * @param  void
    * @return integer page_number
    */
	public function getPageOlder()
	{
        return $this->page_older;
	} 
	/**
    * Get newer page number number
    *
    * @param  void
    * @return integer page_number
    */
	public function getPageNewer()
	{
        return $this->page_newer;
	} 
	
    /**
    * Connects to database and fetches all  posts headers only (not entire content)
    *
    * @param  void
    * @return array
    */
    public function getBlogPostsHeaders()
    {
    
        $db=new DBCon();
        $result=$db->fetchBlogPosts(1, 1000);
        
        return $result;
    
    }
    /**
    * Connects to database and fetches specified posts
    *
    * @param  string $post_slug - is the name of the post extracted from the URI, ex URI: "/blog/posts/welcome-to-my-blog-people"
    *                              - the $post_slug will be "welcome-to-my-blog-people"
    * @return array
    */
    public function getPost($post_slug)
    {
    
        
        $post_slug_from_url=$post_slug; //I want to make clear that $post_slug represents the slug from the requested URL
        $db=new DBCon();
        //$transformed_post_slug=str_replace('-',' ',$post_slug);
        
        $result=$db->fetchPost($post_slug_from_url);
        
        return $result;
    }
    /**
    * Connects to database and fetches all  posts
    *
    * @param  void
    * @return array
    */
    
    public function getBlogPosts()
    {
    
        
        
        $db=new DBCon();
        $result=$db->fetchBlogPosts($this->page_number, $this->per_page);
        
        return $result;
    }
    
    /**
    * Connects to database and inserts a new blog post
    *
    * @param  string $Author, string $Category, string $Text
    * @return array
    */
    
    public function newPost($Author,$Category,$Text,$Title,$Slug)
    {
    
        $db=new DBCon();
        $result=$db->newPost($Author, $Category, $Text, $Title, $Slug);
        
        return $result;
    }
    
    /**
    * Connects to database and updates post
    *
    * @param  string $Author, string $Category, string $Text
    * @return array
    */
    
    public function updatePost($PostID,$Author,$Category,$Text,$Title)
    {
    
        $db=new DBCon();
        $result=$db->updatePost($PostID, $Author, $Category, $Text, $Title);
        
        return $result;
    }
    
    /**
    * Connects to database and updates post
    *
    * @param  string $Author, string $Category, string $Text
    * @return array
    */
    
    public function deletePost($PostID)
    {
    
        $id=$PostID;
        $db=new DBCon();
        $result=$db->deletePost($id);
        
        return $result;
    }

}

?>
