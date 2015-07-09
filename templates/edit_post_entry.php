<form action="http://127.0.0.1/myFrontController/edit/saveEditPost" method="POST">
	Categorie
	<select name="Category">
	<option value="Amuzante">Amuzante</option>
	<option value="Vacataion">Vacataion</option>
	<option value="Altele">Altele</option>
	<option value="PHP">PHP</option>
	</select></br>
	Author
	<input type="text" name="Author" value=<?php echo '"'.$author.'"'; ?> ></br>
	Title
	<input type="text" name="Title" value=<?php echo '"'.$title.'"'; ?> ></br>
	Write here your actual blog post:</br>
	<textarea name="ActualPost" rows="40" cols="90"  ><?php echo $actual_content ; ?></textarea></br>
	<button type="submit" >Send</button></br>
	<input type="hidden" name="postID" value<?php echo '"'.$postID.'"'; ?>
</form>


