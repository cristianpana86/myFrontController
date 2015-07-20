<!DOCTYPE html>
<html>
<head>
<style>
#header {
    background-color:black;
    color:white;
    text-align:center;
    padding:5px;
}

#menu  {
	background-color: #98bf21;
    color:white;
    text-align:center;
    padding:5px;
	    			
}

a:hover, a:active {
    background-color: #7A991A;
}
#nav {
    line-height:30px;
    background-color:#eeeeee;
    height:300px;
    width:100px;
    float:left;
    padding:5px;	      
}
#section {
    width:950px;
    float:left;
    padding:10px;	 	 
}
#footer {
    background-color:black;
    color:white;
    clear:both;
    text-align:center;
   padding:5px;	 	 
}
</style>
<script type="text/javascript" src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
<script type="text/javascript">
   tinymce.init({
   
       selector: "textarea",
   plugins: [
       "advlist autolink lists link image charmap print preview anchor",
       "searchreplace visualblocks code fullscreen",
      "insertdatetime media table contextmenu paste "
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter      alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>
</head>
<body>

<div id="header">
	<div><h1>My Blog CMS by CPana<h1></div>
</div>

<div id="menu">
    <?php require $path . self::$menu_up; ?>
	  
	  </br></br>
</div>


<div id="nav">
    <?php require $path . self::$menu; ?>
</div>

<div id="section">

    <?php require 'content.php'; ?>

</div>

<div id="footer">
Copyright  CPana
</div>

</body>
</html>
