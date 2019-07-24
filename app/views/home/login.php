<html>
<head>

</head>

<body>
	<div>
		Login
	</div>

	<br />

	<form method="post" >
 		<div>
			Username
			<input type="text" name="username" required>
		</div>

		<div>
			Password
			<input type="password" name="passwordHash" required>
		</div>
		
		<br />

		<input type="submit" name="login" value="Login">	
	</form>

	<a href="/public/registrationController">Don't already have an account?</a>
</body>
</html>