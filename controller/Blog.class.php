<?php

namespace CPANA\myFrontController\controller;

use CPANA\myFrontController\model\BlogModel;
use CPANA\myFrontController\view\Render;
use CPANA\myFrontController\login\LoginUser;

/**
* Home class handles the behaviour of the "Blog" page
*
*
* @author   Cristian Pana <cristianpana86@yahoo.com>
* @version   0.1
* @access   public
*/



class Blog extends Page{
	
	
    //private $page_number=;
	
	
	/**
    * displays the New Post entry form where user fills Post name, Author name and the actual post text
    *
    */
	public function new_post_entry(){
		//get the correct path to the new_post_entry.php template file
		$path=substr(__DIR__,0, (strlen(__DIR__)-strlen("controller"))) . 'templates\\new_post_entry.php';
		
		//reads the entire content of the file login.php in order to have it rendered
		$text=file_get_contents($path);
		
		if (LoginUser::validateLoginAdmin()){ Render::$menu="templates\menu_admin.php"; }
		Render::$content=$text;
		Render::renderPage("user");
		//include 'C:\\Program Files (x86)\\EasyPHP-DevServer-14.1VC9\\data\\localweb\\myFrontController\\templates\\new_post_entry.php';
		
	
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
	
	public function renderOlder(){
	
	
	}
	
	public function renderNewer(){
	
	}
	
	/**
    * render method connects to the Database and renders posts from BlogPosts table using getBlogPosts method from class BlogModel
    *
    * @param    void
    * @return   void
    *
    */
	public function render(){
	
			
	        
		    $bm=new BlogModel();
			$result = $bm->getBlogPosts();
			$new_content="";
			

			foreach($result as $row)
			{
			 // print "<tr> ID  </tr> ";
			 // print "<tr>".$row['Id']."</tr></br>";
			  $new_content.= "<tr> Category  </tr> ";
			  $new_content.= "<tr>".$row['Category']."</tr></br>";
			  $new_content.= "<tr> Author </tr>";
			  $new_content.= "<tr>".$row['Author']."</tr></br>";
			  $new_content.= "<tr> Title </tr>";
			  $new_content.= "<tr>".$row['title']."</tr></br>";
			  $new_content.= "<tr> Post </tr> </br>";
			  $new_content.= "<tr>".$row['ActualPost']."</tr></br>";
			  $new_content.= "</br></br></br>";
			}
			$new_content.= "</table><br>";
			$new_content.="<a href=/myFrontController/blog/older>Older posts</a>&nbsp;&nbsp;&nbsp;<a href=/myFrontController/blog/newer>Newer posts</a> ";
			////////////////
			if (LoginUser::validateLoginAdmin()){ Render::$menu="templates\menu_admin.php"; }
			Render::$content =$new_content;
			Render::renderPage("user");
			
			
			
	}
}

?>