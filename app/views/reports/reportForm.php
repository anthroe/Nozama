<?php
	/* TO DO
		Adding to database
		success message
		Validation
		Change list of values
	*/
	$accountID = $data['accountID'];
	$listingID = $data['listingID'];
?>

<html>
<head>
	<title>Nozama | Submit a report</title>
	<div class="container">
		<div class="row col-md-6">
			<h1>Submit a report</h1>
		</div>
	</div>
</head>
<body>
<div class="container">
	<div class="row">
	<form method="post" action="/Nozama/public/reportController">
		<div class="col-xs-4">
		<label for="category">Category:</label>
					<select class="form-control" name="category" id="category" required="true">
						<option value="User Misconduct">User Misconduct</option>
						<option value="Fraudulent Listing">Fraudulent Listing</option>
						<option value="Terms of Service Violation">Terms of Service Violation</option>
						<option value="Other">Other</option>
					</select>
		</div>
		</div>
		<div class="row"></div>
		<div class="row"></div>
		<div class="row"></div>
		<br>
		<br>
		<div class="row">
		<div class="col-xs-4">
			<label for="subject">Subject:</label>
			<input class="form-control" type="text" id="subject" name="subject" required="true">
		</div>
		</div>
		<div class="row"></div>
		<div class="row"></div>
		<div class="row"></div>
		<br>
		<br>
		<div class="row">
		<div class="col-xs-4">
		<label for="comment">Comment:</label>
			<textarea class="form-control" rows="6" name="comment" id="comment" required="true"></textarea>
		</div>
		</div>
		<!-- <input type="textarea" rows="5" cols="40" name="comment" required="true"> -->
		<br>
		<br>
		<input type="hidden" name="accountID" value="<?= $accountID ?>">
		<input type="hidden" name="listingID" value="<?= $listingID ?>">
		<input class="btn" type="submit" value="Submit" name="submittedReport">
	</form>
</div>
</body>
</html>