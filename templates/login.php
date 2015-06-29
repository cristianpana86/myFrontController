<form action="http://127.0.0.1/myFrontController/admin/" method="POST" >
	Username <br>
	<input type="text" name="username">
	<br>Password <br>
	<input type="text" name="password">
	<input type="submit" value="Login"> 
	<input type="hidden" name="controller" value="Admin">
	<input type="hidden" name="action" value="validateLogin">
</form>