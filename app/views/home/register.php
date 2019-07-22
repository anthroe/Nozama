<html>
<head>

</head>

<body>
	<div>
		Registration
	</div>

	<br />

<form method="post">
		Username*
		<input type="text" name="username" pattern=".{5,}" 
		title="Username must have 5 characters minimum" required="true"></br>

		Password*  				<input type="password" name="passwordHash" pattern=".{6,}" 
		 title="Password must have 6 characters minimum" required="true"></br></br>

		Full Name* <input type="text" name="fullName" required /><br />
		Email* 					<input type="email" name="email" required="true"></br></br>
				
		Address Line 1*				<input type="text" name="address1" required="true"></br>
		Address Line 2			<input type="text" name="address2" ></br>
		City*					<input type="text" name="city" required="true"></br>
		State/Province*			<input type="text" name="state" required="true"></br>
		Zip/Postal Code*			<input type="text" name="zip" 
		pattern="(^\d{5}(-\d{4})?$)|(^[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} *\d{1}[A-Z]{1}\d{1}$)" 
		title="Please enter a valid zip (#####) or postal(L#L #L#))" required="true"></br>
		
		Country*					<input type="text" name="country" required="true"></br></br>
		
		<input type="submit" name="register" value="Submit">
	</form>
</body>
</html>