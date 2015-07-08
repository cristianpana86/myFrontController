<form action="http://127.0.0.1/myFrontController/admin/postOnBlog" method="POST">
	Categorie
	<select name="Category">
	<option value="Amuzante">Amuzante</option>
	<option value="Vacataion">Vacataion</option>
	<option value="Altele">Altele</option>
	<option value="PHP">PHP</option>
	</select></br>
	Author
	<input type="text" name="Author"></br>
	Title
	<input type="text" name="Title"></br>
	Write here your actual blog post:</br>
	<textarea name="ActualPost" rows="40" cols="90">write here...</textarea></br>
	<button type="submit" >Send</button></br>
	<input type="hidden" name="controller" value="Blog">
	<input type="hidden" name="action" value="postOnBlog">
</form>



