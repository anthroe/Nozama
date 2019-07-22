<?php
	
	$notificationID = $data['notificationID'];
	$subject = $data['subject'];
	$message = $data['message'];
	$recipient = $data['recipient'];
	$date = $data['date'];
	$read = $data['read'];
?>

<html>
<head>
	<title>Nozama | My Notifications </title>
</head>
<body>
	<div class="container">
		<div class="">
			<div class="row">
			<div class="col-md-4"><?= htmlentities($subject) ?> <br> </div>
			<div class="col-md-3"><?= $date ?> <br> </div>
			</div>
		<div class="row col-md-6"> <?= htmlentities($message) ?> <br> </div>
			
			<div class="row"></div>
			<div class="row"></div>
			<div class="row"></div>
			<div class="row">
			<br>
			<!--<div class="col-md-4"></div>-->
			<form method="post" action="/Nozama/public/notificationController">
				<input type="hidden" name="deleteNotification" value="<?=$notificationID?>">
				<input class="btn btn-danger col-md-2" type="submit" value="Delete Notification">
			</form>
			</div>

		</div>

		
		<br>
		<div class="row"></div>
		<div class="row"></div>
		<div class="row"></div>
		<div class="row">
		<a class="btn btn-default" href="/Nozama/public/notificationController/getAllNotifications/<?=$_SESSION['accountID']?>">Return to my notifications</a>
		</div>
	</div>
</body>
</html>