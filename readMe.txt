-------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------
----------------------  Changes in version 0.4  -------------------------------------
-------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------
Start using GitHub!
1. create account
2. install GitHub for Windows
3. make Git work behind firewall at work. In the .gitconfig file found probably at %USERPROFILE% I added this line:
		[http]
	          proxy = http://<your-proxy>:<port>

Here details on how to find your proxy settings:  http://superuser.com/questions/346372/how-do-i-know-what-proxy-server-im-using

------------------------------------------------------------------------------------------
-----new branch for new method on how to list blog posts when clicking the "Blog" link----
-I will display a certain number of posts per page (now is hardcoded to 2), and a Older posts and Newer Posts buttons 
- I am using MySQL "LIMIT" clause to specify the number of records to be returned: http://www.w3schools.com/php/php_mysql_select_limit.asp
		The SQL query below says "return only 10 records, start on record 16 (OFFSET 15)":
		$sql = "SELECT * FROM Orders LIMIT 10 OFFSET 15";

- it seems that the default type for bindParam is string so you will get an error if you do not specify the PDO:PARAM_INT:
	http://stackoverflow.com/questions/4544051/sqlstate42000-syntax-error-or-access-violation-1064-you-have-an-error-in-you
		
		$sth=$this->db->prepare("SELECT * FROM blogposts LIMIT :per_page OFFSET :page_number ;");
		$sth->bindParam(':per_page', $per_page, PDO::PARAM_INT);
		$sth->bindParam(':page_number', $page_numb, PDO::PARAM_INT);
		$sth->execute();


-added pagination.xml file in \model to store current page number and number of posts per page
-added routes for /blog/older and /blog/newer 
-------------------------------------------------------------------------------------------
------------------ display individual blog posts ----------------------------
--------------------------------------------------------------------------------------------------------

-for this I need to modify a little bit the routing to recognize paths like /blog/post/post-name-without-spaces
-I need a regular expression to match this kind of routes. I do not have too much experience with regexp and it turns out to be
difficult to understand in the beginning. Some important aspects about regexp in PHP:

		- PHP uses another pair of delimiters inside '': "You must specify a delimiter for your expression. A delimiter is a special 
		character used at the start and end of your expression to denote which part is the expression. This allows you to use modifiers 
		and the interpreter to know which is an expression and which are modifiers."

		 http://stackoverflow.com/questions/7660545/delimiter-must-not-be-alphanumeric-or-backslash-and-preg-match

		-http://www.phpliveregex.com/ this is a website where you can test your regexp with different php functions (preg_match, preg_grep etc)

		- the php manual for regexp is found here: http://www.php.net/manual/en/reference.pcre.pattern.syntax.php

		-  regexp from "/blog/post/blog-title-here" :  preg_match("/\/blog\/post\/[\w\-]+/i",  $path);

- In order to have generic routes I added a new field in the route.xml called <path_regexp>, example below

	<route name="individual blog post">
		<path>/blog/posts/{slug}</path>
	    <path_regexp>/\/blog\/post\/[\w\-]+/i</path_regexp>
	    <controllerClass>Blog</controllerClass>
	    <action>renderPost</action>
	</route>

- I am doing a verification using preg_match and the <path_regexp>	to see if it is matching the requested URI from HTTP request.
-if there is a match than a new object of class "controllerClass" is created, and it is called the <action> method with parameter {slug},
basically the value after "/blog/post/"

-this triggers a search in the database for a blog post where title is like slug. what if there are two identical titles?at this moment all of them are listed.
- links are added dynamically on the list of all blogs (when clicking Blog button) based on the Title from database in which I replace spaces with hyphen, and 
make all letters lower-case.

			$slug_from_title=  strtolower(str_replace(' ','-',$row['title']));
			$new_content.= "<tr><a href=/myFrontController/blog/post/$slug_from_title>".$row['title']."</a></tr></br>";
!!! further improvement should be done in for a proper slug generator (treat all signs and also transform language specific signs to the closest ASCII charachter)
!!! other improvement on having unique slugs from blog posts with same title (maybe adding a timestamp or at least day and month). when viewing it's ok
!!!I can list all the identic slugs, the issue appears when I want to edit.

I solved the problems saving in the "blogposts" table the slug in the newly added column "slug". I also added in \model the class SlugGenerator
with a static function slugify($title) which treats all the problems with characters whcih may be included in the title of a post

--------------------------------------------------------------------------------------------------------
--------- admin dashboard , edit posts,delete posts, publish? ------------------------------------------
------------------------------------------------------------------------------------------------------------


For an Admin would be more relevant to see just the titles (not entire content as in normal view) and have an edit / delete/ publish button 
1. Admin dashboard for editing posts
- in the "render()" method of the class Blog, if the admin is logged Edit button is displayed otherwise normal listing of posts
- new path /edit/{slug} should be added to route.xml as a result of the above
2. Edit posts and save them to database
- the edit post page should look exactly like the new post entry just that it should be populated with the values from DB. So I added
the file "edit_post_entry.php" under templates, inside I added value=<?php echo '"'.$author.'"'; ?> (same for the title and category).
- the problem is that now I do not want to take the file edit_post_entry.php end include it directly into the main template, 
I want first to process it (interpret ) with the local variables in order to replace the actual "value=" in the HTML form.
The post "Read echo'ed output from another PHP file" http://stackoverflow.com/questions/631388/read-echoed-output-from-another-php-file showed me the way:

		ob_start(); // begin collecting output
		include 'myfile.php';
		$result = ob_get_clean(); // retrieve output from myfile.php, stop buffering
		//$result will then contain the text.
- as you could see the slug is used to identify uniquely the post. If the admin wants to change the title of the blog this unique identifier is lost.
I will put in the form (edit_post_entry.php) a hidden field to store the post Id taken from database which will be used in the SQL update statement:

		$new_slug=SlugGenerator::slugify($Title);
		$stmt = $this->db->prepare("UPDATE blogposts SET Category=:field1, Author=:field2, ActualPost=:field3,title=:field4,slug=:field5 WHERE Id=:field_id;");
        $stmt->bindParam(':field_id',$PostID, PDO::PARAM_INT);
	    $stmt->bindParam(':field1', $Category);
		$stmt->bindParam(':field2', $Author);
		$stmt->bindParam(':field3', $Text);
		$stmt->bindParam(':field4', $Title);
		$stmt->bindParam(':field5', $new_slug);
	

	$stmt->execute();

3. Delete posts	

//I discovered a bug. Because I always replace spaces with hyphen, if a title is using hyphen it will be replaced with space
when transforming it and cannot be found./////

---------------------------------------------------------------------------------------------------------------
to do also: - admin dashboard, edit posts, delete posts, publish 
-tinyMCE
-uploading and storing photos
-modify database, add more fields
--- real slug generator!!!!!! the titles may contain forbidden characters possible solution:  http://code.google.com/p/php-slugs/
------ Controller too fat!! some stuff should be moved to View
------ Model should contain functions like selectPost, selectAllPosts, UpdatePost, DeletePost

-------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------
----------------------  Changes in version 0.3  -------------------------------------
-------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------

Started using namespaces and implemented a new autoloading function which almost respects the PSR-4 standard.
http://www.php-fig.org/psr/psr-4/examples/  - my autoload function is inspired from this one, just that I do not have the /src/ directory.

my vendor\package combination of namespaces is :  CPANA\myFrontController
under this I have added :
CPANA\myFrontController\controller
CPANA\myFrontController\model
-----------

I had to change some code in my FrontController class as it seems there is a known bug (weird behaviour ) :
	http://stackoverflow.com/questions/6150703/php-dynamic-instance-with-not-fully-qualified-namespaces
	https://bugs.php.net/bug.php?id=51126

	When I try to dinamically create the name of the class  "new $_GET['controller']()" I get message that the class cannot be found.
	
				$class_name=__NAMESPACE__ . '\\'. $_GET['controller'];
				$obj= new $class_name();
				$obj->$_GET['action']();

----------------------------------------------------------------------------------------------------------------------------------
--------------- routing ----------------------------------------------------------------

I started reading the Symfony Book and I am thinking to implement a routing system inspired from the one used in Symfony.
The logic to call the correct function will be :
	1. read the requested URL ($_SERVER['REQUEST_URI']), and exclude the /myFrontController
	2. verify in the \config\route.xml if there is any route matching -> if yes than read from \config\route.xml the function and call it.
																	  -> if no redirect to 404 page - created new controller class called "PageNotFound.class.php"

So I did the following:

1. created \config\route.xml file to store routes and matching class and method to be called
2. modified FrontControll class
3. added .htaccess from Symfony and replaced to redirect to "index"	instead of "app"																 

-----------------------------------------------------------------------------------------
-----------give up admin/index----------------------------
-in order to use just one front controller (not one for normal user and one for admin user) some changes should be made (also taking in account the new routing system)
-this will involve changing the way the pages are rendered (templating?) maybe request and response objects
---->>>
-new class \view\Render.class.php 
	-it contains a static property $content  which is echoed in content.php  and also $menu which depends on being an admin or normal user
	-and a method which renders the main_template.php  (which imports content.php and menu.php or menu_admin.php)
	-each time we want to change the output, I change the value of the $content and call the Render::renderPage()
	
-----------------------------------------------------------------------------------------
I modified the LoginUser.class.php and also the Admin.class.php

-in Admin.class.php the function "renderLogin" it is called both when clicking "Admin" buton and also when clicking on the Submit button
-in Login.class.php I added the static function validateLoginAdmin() which is used to check which menu (admin or normal user one) 
should be displayed. at the moment I call it on each specific class (Home, Blog) but it should be moved in to Render


-------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------
----------------------  Changes in version 0.2  -------------------------------------
-------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------

added DBCon.class.php

added StaticPages.classes.php
added BlogModel.classes.php

replaced & with &amp; in the links

----------- database --------------------------------
shift from SQLite to MySQL
create database "myblog"
create table  static_pages
alter table blogposts add column title varchar(255)


----------------------------------------------------------------------------------------------------------------------------------------
added basic login module (based on cookies) to  have an Admin view from where you can add new posts 
added:
/admin/index_admin.php
/controller/Admin.class.php
/login/LoginUser.class.php

--------------------------------------------------
login module explained:
	first I hardcoded the username and passord inside the static function validateUserPass of the class LoginUser
	---
	static public function validateUserPass($user,$pass){
			if(($user=='admin')&&($pass=='1234')){
				return true;
	---

	from a form username and password as send via POST method using hidden fields (login.php):

			<form action="index.php" method="POST" >
				Username <br>
				<input type="text" name="username">
				<br>Password <br>
				<input type="text" name="password">
				<input type="submit" value="Login"> 
				<input type="hidden" name="controller" value="Admin">
				<input type="hidden" name="action" value="validateLogin">
			</form>
	---
	the hidden values indicated controller name "Admin" and action "validateLogin"

	if the user and password match the ones hardcoded than we set a cookie containing an md5 hash of the user name + a secret word.

	 setcookie('PageLogin', md5($user.self::$secret_word));
	 setcookie('PageLoginUser', $user);
	 
--------------------------------------------------------------------------------------------------------------------------------------

improved the autoload function  ??!!!! - this should be further improved
 
 first save the path to the root of the website on disk
 
$fh=fopen("path.txt","w");
fwrite($fh,__DIR__);
fclose($fh);
-----------


//read the path to root of website
    $fh=fopen("path.txt","r") or die ('No global path is set');
    $dir=fread($fh,filesize("path.txt"));
    fclose($fh);
//declare the list of folders contianing classes

	$folders=array('\\controller\\','\\model\\','\\login\\','\\view\\');
	
	foreach($folders as $folder){
		
		//echo "path to class $class is " . $dir . $folder . $class . 'class.php';
	    if(file_exists($dir . $folder . $class . '.class.php')){
		    require_once $dir . $folder . $class . '.class.php';
		}
	}
				

-----------------------------------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------
----------------------  Version 0.1  -------------------------------------
-------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------
	I was reading about MVC and HMVC patterns and I found out about the Front Controller pattern and decided to try a small implementation.
	From this I started building a very very basic CMS/ blogging platform.
	
