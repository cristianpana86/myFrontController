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

--------------------------------------------------------------------------------------------------
---------- new brach for new mothod on how to list blog posts when clicking the "Blog" link------
-I will display a certain number of posts per page, and a Older posts and Newer Posts buttons 
- I am using MySQL "LIMIT" clause to specify the number of records to be returned: http://www.w3schools.com/php/php_mysql_select_limit.asp
		The SQL query below says "return only 10 records, start on record 16 (OFFSET 15)":
		$sql = "SELECT * FROM Orders LIMIT 10 OFFSET 15";

- it seems that the default type for bindParam is string so you will get an error if you do not specify the PDO:PARAM_INT:	http://stackoverflow.com/questions/4544051/sqlstate42000-syntax-error-or-access-violation-1064-you-have-an-error-in-you
		
		$sth=$this->db->prepare("SELECT * FROM blogposts LIMIT :per_page OFFSET :page_number ;");
		$sth->bindParam(':per_page', $per_page, PDO::PARAM_INT);
		$sth->bindParam(':page_number', $page_numb, PDO::PARAM_INT);
		$sth->execute();


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
	
