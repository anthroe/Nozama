<?php
	/* TO DO
	*/
	$accountID = $data['accountID'];
?>

<html>
<head>
	<title>Nozama | Submit a ticket</title>

	<h1>Submit a ticket</h1>
	
</head>
<body>
<div class="contain">

<div class="col-md-6">
	<form method="post" action="/public/ticketController">	
	<div class="row">

		<div class="col-md-6">
		<label for="subject">Subject:</label>
		<input id="subject" class="form-control" type="text" name="subject" required="true">
		</div>
		</div>
		<br>
		<div class="row"></div>
		<div class="row"></div>
		<div class="row"></div>
		<div class="row"></div>
		<br>
		<div class="row">
		<div class="col-md-6">
		<label for="message">Message:</label>
		<textarea class="form-control" rows="6" columns="10" id="message" name="message" required="true"></textarea>
		</div>
		<!-- <input type="textarea" name="message" required="true"> -->
		
		</div>
		<br>
		<div class="row"></div><div class="row"></div>

		<div class="row"></div><div class="row"></div>

		<div class="row"></div><div class="row"></div>

		<br>

		<input type="hidden" name="createdBy" value="<?= $accountID ?>">
		<input class="btn btn-success" type="submit" value="Submit" name="submittedTicket">

	</form>
	</div>
</body>
</html>