<?php
	$addresses = $data['addresses'];
?>

<html>
<head>
</head>

<body>
	<div>
		<h3>Your Addresses</h3>
	</div>

	<br />

	<div>
		<?= $addresses->count() == 0 ? "There are no registered adresses." : addressController::viewAddressHelper($addresses) ?>
	</div>

	<div>
		<form method="POST" action="/public/addressController/editAddress">
			<input class="btn btn-primary" type="submit" value="Enter a new Address" />
		</form>
	</div>
</body>
</html>