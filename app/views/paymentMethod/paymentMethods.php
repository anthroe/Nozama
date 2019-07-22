<?php
	$paymentMethods = $data['paymentMethods'];
?>

<html>
<head>
</head>

<body>
	<div>
		<h3>Your Payment Methods</h3>
	</div>

	<br />

	<div>
		<?= $paymentMethods->count() == 0 ? "There are no registered payment methods." : paymentMethodController::viewPaymentMethodHelper($paymentMethods) ?>
	</div>

	<div>
		<form method="POST" action="/Nozama/public/paymentMethodController/editPaymentMethod">
			<input class="btn btn-primary" type="submit" value="Enter a new Payment Method" />
		</form>
	</div>
</body>
</html>