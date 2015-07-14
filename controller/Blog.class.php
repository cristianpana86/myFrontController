<?php

namespace CPANA\myFrontController\controller;

use CPANA\myFrontController\model\BlogModel;
use CPANA\myFrontController\view\Render;
use CPANA\myFrontController\login\LoginUser;
use CPANA\myFrontController\model\SlugGenerator;

/**
* Blog class handles the behaviour of the "Blog" page
 *
* @author  Cristian Pana <cristianpana86@yahoo.com>
* @version 0.4
* @access  public
*/



class Blog
{
    
    
       
    
    /**
    * displays the New Post entry form where user fills Post name, Author name and the actual post text
    */
    public function new_post_entry()
    {
        //get the correct path to the new_post_entry.php template file
        $path=substr(__DIR__, 0, (strlen(__DIR__)-strlen("controller"))) . 'templates\new_post_entry.php';
        
        //reads the entire content of the file login.php in order to have it rendered
        $text=file_get_contents($path);
        
        if (LoginUser::validateLoginAdmin()) { Render::$menu="templates\menu_admin.php"; 
        }
        Render::$content=$text;
        Render::renderPage("user");
        
        
    
    }
    
    /**
    * postOnBlog method connects to the Database and writes the a new entry on the BlogPosts table 
    *
    * @param  void
    * @return void
    */
    public function saveEditPost()
    {
    
       
        $bm=new BlogModel();
        $rows_affected=$bm->updatePost((integer)$_POST['postID'], $_POST['Author'], $_POST['Category'], $_POST['ActualPost'], $_POST['Title']);
        
      
        if($rows_affected==1) {
            if (LoginUser::validateLoginAdmin()) { Render::$menu="templates\menu_admin.php"; 
            }
            Render::$content="you have successfully updated the blog post!";
            Render::renderPage("user");
           
        }else{
       
            if (LoginUser::validateLoginAdmin()) { Render::$menu="templates\menu_admin.php"; 
            }
            Render::$content= "bad luck, there was an error....";
            Render::renderPage("user");
       
           
        }
    }
    
    /**
    * postOnBlog method connects to the Database and writes the a new entry on the BlogPosts table 
    *
    * @param  void
    * @return void
    */
    public function postOnBlog()
    {
    
       
        $bm=new BlogModel();
        $rows_affected=$bm->newPost($_POST['Author'], $_POST['Category'], $_POST['ActualPost'], $_POST['Title'], SlugGenerator::slugify($_POST['Title']));
      
        if($rows_affected==1) {
            if (LoginUser::validateLoginAdmin()) { Render::$menu="templates\menu_admin.php"; 
            }
            Render::$content="you have successfully posted a new blog post!";
            Render::renderPage("user");
           
        }else{
       
            if (LoginUser::validateLoginAdmin()) { Render::$menu="templates\menu_admin.php"; 
            }
            Render::$content= "bad luck, there was an error....";
            Render::renderPage("user");
       
           
        }
    }
    
	/**
    * This method is called when click the Blog link.
    *
    * @param  void
    * @return void
    */
	public function renderBlogsInit()
	{
	    $this->renderPagination(1);
	}
    /**
    * This method is used to render blogs when clicking Older link.
    *
    * @param  void
    * @return void
    */
    public function renderPagination($current_page)
    {
        
        $bm=new BlogModel();
		$bm->setPageNumber($current_page);
         
        $this->render($bm);
    
    
    }
    
    
    /**
    * This method is used to edit a blog post fr. The blog post slug is received as parameter
    *
    * @param  string $post_slug
    * @return void
    */
    public function editPost($post_slug)
    {
                
        //get the correct path to the new_post_entry.php template file
        $path=substr(__DIR__, 0, (strlen(__DIR__)-strlen("controller"))) . 'templates\edit_post_entry.php';
            
        $bm=new BlogModel();
        $result_from_db=$bm->getPost($post_slug);
            
        if(count($result_from_db)<1) { 
            
            self::renderPageNotFound();
        }else{
            
            
            $author=$result_from_db[0]['Author'];
            $title=$result_from_db[0]['title'];
            $actual_content=$result_from_db[0]['ActualPost'];
            $postID=$result_from_db[0]['Id'];
        
            //do not display now the content from the included file. the processed result is saved to be rendered inside the main template.
            ob_start();
            include $path;
            $text = ob_get_clean(); 
                
            
            //reads the entire content of the file edit_post_entry.php in order to have it rendered
            //$text=file_get_contents($path);
            
            if (LoginUser::validateLoginAdmin()) { Render::$menu="templates\menu_admin.php"; 
            }
            Render::$content=$text;
            Render::renderPage("user");
        }
    }
    
    
    /**
    * This method is used to delete a blog post. The blog post slug is received as parameter
    *
    * @param  string $post_slug
    * @return void
    */
    public function deletePost($post_slug)
    {
                
        
        $bm=new BlogModel();
        $result_from_db=$bm->getPost($post_slug);
            
            
        if(count($result_from_db)<1) { 
            
            self::renderPageNotFound();
        }else{
                        
            $postID=$result_from_db[0]['Id'];
            $result=$bm->deletePost($postID);
            if(count($result)>0) {
                $text = "The post was successfully deleted";
            }else{ $text="error";
            }
            
            if (LoginUser::validateLoginAdmin()) { Render::$menu="templates\menu_admin.php"; 
            }
            Render::$content=$text;
            Render::renderPage("user");
        }
    }
    
    /**
    * This method is used to create an BlogModel object and extract from database a specific blog post. The blog post slug is received as parameter
    *
    * @param  string $post_slug
    * @return void
    */
    public function renderPost($post_slug)
    {
        
        $bm=new BlogModel();
        $result_from_db=$bm->getPost($post_slug);
        
        if(count($result_from_db)<1) { 
            
            self::renderPageNotFound();
        }    
        $new_content="";
            
        foreach($result_from_db as $row){
            // print "<tr> ID  </tr> ";
            // print "<tr>".$row['Id']."</tr></br>";
            $new_content.= "<tr> Category  </tr> ";
            $new_content.= "<tr>".$row['Category']."</tr></br>";
            $new_content.= "<tr> Author </tr>";
            $new_content.= "<tr>".$row['Author']."</tr></br>";
            $new_content.= "<tr> Title </tr>";
            $slug_from_title=  SlugGenerator::slugify($row['title']);
            $new_content.= "<tr><a href=/blog/post/$slug_from_title>".$row['title']."</a></tr></br>";
            $new_content.= "<tr> Post </tr> </br>";
            $new_content.= "<tr>".$row['ActualPost']."</tr></br>";
            $new_content.= "</br></br></br>";
        }
        $new_content.= "</table><br>";
        $new_content.="<a href=/blog>Back</a>";
        ////////////////
        if (LoginUser::validateLoginAdmin()) { Render::$menu="templates\menu_admin.php"; 
        }
        Render::$content =$new_content;
        Render::renderPage("user");
        
    
    }
    

    
    /**
    * render method connects to the Database and renders posts from BlogPosts table using getBlogPosts method from class BlogModel
    *
    * @param  void
    * @return void
    */
    public function render(BlogModel $bm)
    {
    
            
            
            
        // if the user Admin is logged, than menu_admin should be rendered. Also Edit buttons should appear next to each blog post
        if (LoginUser::validateLoginAdmin()) {
                
           
            $result = $bm->getBlogPostsHeaders();// this function returns first 1000 posts found in the table
            $new_content='<table  style="width:100%"><tr><th> Category  </th> <th> Author </th><td> Title </td><th></th><th></th></tr>';
            Render::$menu="templates\menu_admin.php";
                
            foreach($result as $row){
                $slug_from_title=  SlugGenerator::slugify($row['title']);
                $new_content.= "<tr> ";
                $new_content.= "<td>".$row['Category']."</td>  ";
                $new_content.= "<td>".$row['Author']."</td>  ";
                $new_content.= "<td><a href=/blog/post/$slug_from_title>".$row['title']."</a></td> ";
                $new_content.='<td><a href="/edit/post/' . $slug_from_title . '">Edit</a></td>';
                $new_content.='<td><a href="/delete/post/' . $slug_from_title . '">Delete</a></td>';
                $new_content.= "</tr>";

            }
            $new_content.= "<tr></table>";
            $new_content.= "</br></br></br>";
			
			$older=$bm->getPageOlder();
		    $newer=$bm->getPageNewer();
			
            $new_content.="<a href=/blog/{$older}>Older posts</a>&nbsp;&nbsp;&nbsp;<a href=/blog/{$newer}>Newer posts</a> ";

                
        }else{
            //if a normal user is seeing the page (not Admin)   
            
			$result = $bm->getBlogPosts();
            $new_content="";
            foreach($result as $row){
                     
                $slug_from_title=  SlugGenerator::slugify($row['title']);
                     
                     
                $new_content.= "<tr> Category  </tr> ";
                $new_content.= "<tr>".$row['Category']."</tr></br>";
                $new_content.= "<tr> Author </tr>";
                $new_content.= "<tr>".$row['Author']."</tr></br>";
                $new_content.= "<tr> Title </tr>";
                      
                $new_content.= "<tr><a href=/blog/post/$slug_from_title>".$row['title']."</a></tr></br>";
                $new_content.= "<tr> Post </tr> </br>";
                $new_content.= "<tr>".$row['ActualPost']."</tr></br>";
                $new_content.= "</br></br></br>";
            }
            $new_content.= "</table><br>";
			
			$older=$bm->getPageOlder();
		    $newer=$bm->getPageNewer();
		
			
            $new_content.="<a href=/blog/{$older}>Older posts</a>&nbsp;&nbsp;&nbsp;<a href=/blog/{$newer}>Newer posts</a> ";
        }
        ////////////////
        Render::$content =$new_content;
        Render::renderPage("user");//it doesn't matter the parameter at this point, maybe in a further implementation
            
            
            
    }
    
    
    public function renderPageNotFound()
    {
    
        Render::$content ="Page not found!";
        Render::renderPage("user");
    
    }
    
    
}

?>
