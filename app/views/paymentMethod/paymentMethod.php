<?php
	$paymentID = $data['paymentID'];
	$cardType = $data['cardType'];
	$cardNumber = $data['cardNumber'];

	$cnLength = strlen($cardNumber);

	$paymentIndex = $data['paymentIndex'];

	$mask = '';
	for($count = 4; $count < $cnLength; $count++)
	{
		$mask = $mask . '*';
	}
?>

<html>
<head>
</head>

<body>
	<div class="well">
		<?php
			if($paymentIndex == 0) {
		?>
				<div>
					<b>Default Payment Method</b>
				</div>

				<br />
		<?php
			}
		?>

		<?php
			if($paymentIndex == 1) {
		?>
				<div>
					<b>Additional Payment Methods</b>
				</div>

				<br />
		<?php
			}
		?>

		<table>
			<tr>
				<td>
					<table>
						<tr>
							<td align="right">
								Type:
							</td>

							<td>
								<?= $cardType ?>
							</td>
						</tr>

						<tr>
							<td align="right">
								Number:
							</td>

							<td>
								<?= $mask . substr($cardNumber,$cnLength - 4, $cnLength - 1) ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<td>
					<form method="POST" action="/Nozama/public/paymentMethodController/editPaymentMethod/<?= $paymentID
					 ?>">
						<input class="btn btn-default" type="submit" value="Edit" />
						
						<button class="btn btn-danger" data-toggle="modal" data-target="#deleteConfirmation" type="button" value="<?= $viewIndex ?>" id="deleteButton">Delete</button>

						<div id="deleteConfirmation" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
							    	<div class="modal-header">
							    		<button type="button" class="close" data-dismiss="modal">&times;</button>

							     		<h4 class="modal-title">Delete Payment Method Confirmation</h4>
							    	</div>

							    	<div class="modal-body">
							        	<p>Are You Sure?</p>
							      	</div>

							      	<div class="modal-footer">
							        	<button class="btn btn-default" type="submit" name="delete" value="Yes" formnovalidate>Yes</button>

							        	<button class="btn btn-danger" data-dismiss="modal" type="button" value="<?= $viewIndex ?>" id="noButton">No</button>
							      	</div>
							    </div>
							</div>
						</div>
					</form>

					<?php
						if($paymentIndex > 0) {
					?>
							<form method="POST" action="/Nozama/public/paymentMethodController/switchDefaultPaymentMethod/<?= $paymentID ?>">
								<input class="btn btn-primary" type="submit" value="Make Default Payment Method" />
							</form>
					<?php
						}
					?>
				</td>
			</tr>
		</table>
	</div>

	<br />
</body>
</html>