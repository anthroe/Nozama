<?php
	
	
	$reportID = $data['reportID'];
	$category = $data['category'];
	$subject = $data['subject'];
	$comment = $data['comment'];
	$username = $data['username'];
	$listingID = $data['listingID'];
	$submittedOn = $data['submittedOn']; 
	$accountID = $data['accountID']; 
?>

<html>
<head>
	<title>Nozama | Report #<?= $reportID ?></title>
</head>
<body>
	Report ID: <?= $reportID ?> <br>
	Category: <?= htmlentities($category) ?> <br>
	Submitted On: <?= $submittedOn ?> <br>
	Subject: <?= htmlentities($subject) ?> <br>
	Comment: <?= htmlentities($comment) ?> <br>
	Username: <a href="/public/profileController/viewProfile/<?= $accountID ?>" target="_blank"><?= $username ?></a> <br>
	

	<?php

		if(isset($listingID))
		{
			echo "Listing ID: <a href='/public/listingController/viewDetails/$listingID' target='_blank'>$listingID</a> <br>";
		}
	?>

	

	<br>
	<br>

	<form method="post" action="/public/reportController">
		<input type="hidden" name="deleteReport" value="<?=$reportID?>">
		<input class="btn btn-danger" type="submit" value="Delete Report">
	</form>

	<a class="btn btn-default" href="/public/reportController"> Return to the list of reports</a>
</body>
</html>