<?php

namespace CPANA\myFrontController\controller;

use CPANA\myFrontController\model\BlogModel;
use CPANA\myFrontController\view\Render;
use CPANA\myFrontController\login\LoginUser;

/**
* Blog class handles the behaviour of the "Blog" page
*
*
* @author   Cristian Pana <cristianpana86@yahoo.com>
* @version   0.4
* @access   public
*/



class Blog extends Page{
	
	
   	
	
	/**
    * displays the New Post entry form where user fills Post name, Author name and the actual post text
    *
    */
	public function new_post_entry(){
		//get the correct path to the new_post_entry.php template file
		$path=substr(__DIR__,0, (strlen(__DIR__)-strlen("controller"))) . 'templates\new_post_entry.php';
		
		//reads the entire content of the file login.php in order to have it rendered
		$text=file_get_contents($path);
		
		if (LoginUser::validateLoginAdmin()){ Render::$menu="templates\menu_admin.php"; }
		Render::$content=$text;
		Render::renderPage("user");
		//include 'C:\\Program Files (x86)\\EasyPHP-DevServer-14.1VC9\\data\\localweb\\myFrontController\\templates\ ew_post_entry.php';
		
	
	}
	
	/**
    * postOnBlog method connects to the Database and writes the a new entry on the BlogPosts table 
    *
	* @param void
	* @return void
    */
	public function postOnBlog(){
	
	   
	   $bm=new BlogModel();
	   $rows_affected=$bm->newPost($_POST['Author'],$_POST['Category'],$_POST['ActualPost'],$_POST['Title']);
	  
	   if($rows_affected==1){
			if (LoginUser::validateLoginAdmin()){ Render::$menu="templates\menu_admin.php"; }
			Render::$content="you have successfully posted a new blog post!";
			Render::renderPage("user");
	       
	   }else{
	   
			if (LoginUser::validateLoginAdmin()){ Render::$menu="templates\menu_admin.php"; }
			Render::$content= "bad luck, there was an error....";
			Render::renderPage("user");
	   
	       
	   }
	}
	
	/**
    * This method is used to render blogs when clicking Older link.
    *
    * @param    void
    * @return   void
    *
    */
	public function renderOlder(){
		
		$bm=new BlogModel();
		$bm->setPaginationOlder();
		
		$this->render();
	
	
	}
	
	/**
    * This method is used to render blogs when clicking Newer link.
    *
    * @param    void
    * @return   void
    *
    */
	public function renderNewer(){
		

		$bm=new BlogModel();
		$bm->setPaginationNewer();
		
		$this->render();
	
	
	}
	/**
    * This method is used to edit a blog post fr. The blog post slug is received as parameter
    *
    * @param   string  $post_slug
    * @return   void
    *
    */
	public function editPost($post_slug){
		
		//get the correct path to the new_post_entry.php template file
		$path=substr(__DIR__,0, (strlen(__DIR__)-strlen("controller"))) . 'templates\edit_post_entry.php';
		
		//reads the entire content of the file login.php in order to have it rendered
		$text=file_get_contents($path);
		
		if (LoginUser::validateLoginAdmin()){ Render::$menu="templates\menu_admin.php"; }
		Render::$content=$text;
		Render::renderPage("user");
	
	}
	/**
    * This method is used to create an BlogModel object and extract from database a specific blog post. The blog post slug is received as parameter
    *
    * @param   string  $post_slug
    * @return   void
    *
    */
	public function renderPost($post_slug){
		
		$bm=new BlogModel();
		$result_from_db=$bm->getPost($post_slug);
		//$this->renderSinglePost($result_from_db);
				
		$new_content="";
			
	    foreach($result_from_db as $row){
			 // print "<tr> ID  </tr> ";
			 // print "<tr>".$row['Id']."</tr></br>";
			  $new_content.= "<tr> Category  </tr> ";
			  $new_content.= "<tr>".$row['Category']."</tr></br>";
			  $new_content.= "<tr> Author </tr>";
			  $new_content.= "<tr>".$row['Author']."</tr></br>";
			  $new_content.= "<tr> Title </tr>";
			  $slug_from_title=  strtolower(str_replace(' ','-',$row['title']));
			  $new_content.= "<tr><a href=/myFrontController/blog/post/$slug_from_title>".$row['title']."</a></tr></br>";
			  $new_content.= "<tr> Post </tr> </br>";
			  $new_content.= "<tr>".$row['ActualPost']."</tr></br>";
			  $new_content.= "</br></br></br>";
		}
		$new_content.= "</table><br>";
		$new_content.="<a href=/myFrontController/blog>Back</a>";
		////////////////
		if (LoginUser::validateLoginAdmin()){ Render::$menu="templates\menu_admin.php"; }
		Render::$content =$new_content;
		Render::renderPage("user");
		
	
	}
	
	/**
    * This method is used to render blog posts when clicking Blog link.
    *
    * @param    void
    * @return   void
    *
    */
	public function renderBlogsInit(){
		
		$bm=new BlogModel();
		$bm->setPaginationInit();
		
		$this->render();
	
	}
	
	/**
    * render method connects to the Database and renders posts from BlogPosts table using getBlogPosts method from class BlogModel
    *
    * @param    void
    * @return   void
    *
    */
	public function render(){
	
			
	        
		    
			// if the user Admin is logged, than menu_admin should be rendered. Also Edit buttons should appear next to each blog post
			if (LoginUser::validateLoginAdmin()){
				
				$bm=new BlogModel();
				$result = $bm->getBlogPostsHeaders();// this function returns first 1000 posts found in the table
				$new_content='<table  style="width:100%"><tr><th> Category  </th> <th> Author </th><td> Title </td><th></th></tr>';
				Render::$menu="templates\menu_admin.php";
				
				foreach($result as $row){
					$slug_from_title=  strtolower(str_replace(' ','-',$row['title']));
					$new_content.= "<tr> ";
					$new_content.= "<td>".$row['Category']."</td>  ";
					$new_content.= "<td>".$row['Author']."</td>  ";
					$new_content.= "<td><a href=/myFrontController/blog/post/$slug_from_title>".$row['title']."</a></td> ";
					$new_content.='<td><a href="/myFrontController/edit/blog/post/' . $slug_from_title . '">Edit</a></td>';
					$new_content.= "</tr>";

				}
				$new_content.= "<tr></table>";
				$new_content.= "</br></br></br>";
				$new_content.="<a href=/myFrontController/blog/older>Older posts</a>&nbsp;&nbsp;&nbsp;<a href=/myFrontController/blog/newer>Newer posts</a> ";

				
			}else{
				
				$bm=new BlogModel();
				$result = $bm->getBlogPosts();
				$new_content="";
				foreach($result as $row){
					 
					 $slug_from_title=  strtolower(str_replace(' ','-',$row['title']));
					 
					 
					  $new_content.= "<tr> Category  </tr> ";
					  $new_content.= "<tr>".$row['Category']."</tr></br>";
					  $new_content.= "<tr> Author </tr>";
					  $new_content.= "<tr>".$row['Author']."</tr></br>";
					  $new_content.= "<tr> Title </tr>";
					  
					  $new_content.= "<tr><a href=/myFrontController/blog/post/$slug_from_title>".$row['title']."</a></tr></br>";
					  $new_content.= "<tr> Post </tr> </br>";
					  $new_content.= "<tr>".$row['ActualPost']."</tr></br>";
					  $new_content.= "</br></br></br>";
				}
				$new_content.= "</table><br>";
				$new_content.="<a href=/myFrontController/blog/older>Older posts</a>&nbsp;&nbsp;&nbsp;<a href=/myFrontController/blog/newer>Newer posts</a> ";
			}
			 ////////////////
			Render::$content =$new_content;
			Render::renderPage("user");//it doesn't matter the parameter at this point, maybe in a further implementation
			
			
			
	}
	
	
}

?>