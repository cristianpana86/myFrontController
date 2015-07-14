<?php
namespace CPANA\myFrontController\model;
use PDO;
use CPANA\myFrontController\model\SlugGenerator;

class DBCon
{


    public $db="";
	
    /**
    * Create a DB connection
    * @copyright  2015 Cristian Pana 
    * @param    no input params
    * @return   PDO 
    */
    public function __construct()
    {

        $user='myblog';
        $pass='password';
        try{
            //include connection details 
            $db_conn = new PDO('mysql:host=localhost;dbname=myblog', $user, $pass);
            $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db=$db_conn;
         
        }
        catch(Exception $e){
         
            echo "Connection to Database failed".$e->getMessage();
         
        }

    }
    
    /**
    * Fetches the content of the static pages from the database
    * @copyright  2015 Cristian Pana 
    * @param    string $pagetype
    * @return   string
    */
    public function fetchStaticPagesInfo($pagetype)
    {
    
        $sth=$this->db->prepare("SELECT textcontent FROM static_pages WHERE pagetype=:value;");
        $sth->execute(array(':value'=>$pagetype));
        $this->db=null;
        return $sth->fetchColumn();
            
    }
    
    /**
    * Fetches the content of the blog posts from the database
    * @copyright  2015 Cristian Pana 
    * @param    string $transformed_post_slug
    * @return   string $result  - result returned by SQL query
    */
    public function fetchPost($post_slug_from_url)
    {
    
        $sth=$this->db->prepare("SELECT * FROM blogposts WHERE slug = :post_slug_from_url;");
        $sth->bindParam(':post_slug_from_url', $post_slug_from_url);
                        
        $sth->execute();
            
        $result=$sth->fetchAll();
        $this->db=null;
        return $result;
            
    }
    
    /**
    * Fetches BlogPost pages from the database
    * @copyright  2015 Cristian Pana 
    * @param    void
    * @return   integer $result  the total number of posts 
    */
    
    public function countBlogPosts()
	{
	    $sth=$this->db->prepare("SELECT count(*) FROM blogposts;");
		$sth->execute();
            
        $result=$sth->fetchColumn();
        $this->db=null;
        return $result;
	}
	
    /**
    * Fetches BlogPost pages from the database
    * @copyright  2015 Cristian Pana 
    * @param    integer $page_number
    * @param    integer $per_page
    * @return   array
    */
    
    public function fetchBlogPosts($page_number,$per_page)
    {
        
        
        if($page_number<=1) {
            
            $sth=$this->db->prepare("SELECT * FROM blogposts LIMIT :per_page OFFSET 0;");
            $sth->bindParam(':per_page', $per_page, PDO::PARAM_INT);
                        
            $sth->execute();
            
            $result=$sth->fetchAll();
            $this->db=null;
            return $result;
        
        }else{
            $page_numb=($page_number-1)*$per_page;
            //echo $page_numb;
            $sth=$this->db->prepare("SELECT * FROM blogposts LIMIT :per_page OFFSET :page_number ;");
            $sth->bindParam(':per_page', $per_page, PDO::PARAM_INT);
            $sth->bindParam(':page_number', $page_numb, PDO::PARAM_INT);
            
            $sth->execute();
            
            $result=$sth->fetchAll();
            $this->db=null;
            return $result;
        }
    }
    /**
    * add new Post to Database
    * @copyright  2015 Cristian Pana 
    * @param    string $Author, string $Category, string $Text
    * @return   integer
    */
    public function newPost($Author,$Category,$Text,$Title, $Slug)
    {
    
        $stmt = $this->db->prepare("INSERT INTO blogposts (Category, Author, ActualPost,title,slug) VALUES (:field1,:field2,:field3,:field4,:field5);");
        $stmt->execute(array(':field1' => $Category, ':field2' => $Author, ':field3' => $Text,':field4'=>$Title, ':field5' => $Slug));
        $affected_rows = $stmt->rowCount();
        return $affected_rows;
    }
    
    /**
    * Save the update post on database
    * @copyright  2015 Cristian Pana 
    * @param    integer $PostID, string $Author, string $Category, string $Text
    * @return   integer
    */
    
    public function updatePost($PostID,$Author,$Category,$Text,$Title)
    {
        
        $new_slug=SlugGenerator::slugify($Title);
        $stmt = $this->db->prepare("UPDATE blogposts SET Category=:field1, Author=:field2, ActualPost=:field3,title=:field4,slug=:field5 WHERE Id=:field_id;");
        $stmt->bindParam(':field_id', $PostID, PDO::PARAM_INT);
        $stmt->bindParam(':field1', $Category);
        $stmt->bindParam(':field2', $Author);
        $stmt->bindParam(':field3', $Text);
        $stmt->bindParam(':field4', $Title);
        $stmt->bindParam(':field5', $new_slug);
        

        $stmt->execute();
        $affected_rows = $stmt->rowCount();
        return $affected_rows;
    
    }
    
    /**
    * Delete post on database
    * @copyright  2015 Cristian Pana 
    * @param    integer $PostID
    * @return   integer
    */
    
    public function deletePost($PostID)
    {
    
        $stmt = $this->db->prepare("DELETE FROM blogposts  WHERE Id=:field_id;");
        $stmt->bindParam(':field_id', $PostID, PDO::PARAM_INT);
        
        $stmt->execute();
        $affected_rows = $stmt->rowCount();
        return $affected_rows;
    
    }

}
?>
