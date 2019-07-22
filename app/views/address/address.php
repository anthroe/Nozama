<?php
	$accountID = $data['accountID'];

	$addressID = $data['addressID'];
	$addressLine1 = $data['addressLine1'];
	$addressLine2 = $data['addressLine2'];
	$city = $data['city'];
	$stateProvince = $data['stateProvince'];
	$zipPostalCode = $data['zipPostalCode'];
	$country = $data['country'];

	$addressIndex = $data['addressIndex'];
?>

<html>
<head>
</head>

<body>
	<div class="well">
		<?php
			if($addressIndex == 0) {
		?>
				<div>
					<b>Default Address</b>
				</div>


				<br />
		<?php
			}
		?>

		<?php
			if($addressIndex == 1) {
		?>
				<div>
					<b>Additional Addresses</b>
				</div>

				<br />
		<?php
			}
		?>

		<table>
			<tr>
				<td>
					<div>
						<?= $addressLine1 ?>
					</div>

					<?php
						if(!is_null($addressLine2)) {
					?>
							<div>
								<?= $addressLine2 ?>
							</div>
					<?php
						}
					?>

					<div>
						<?= $city ?>, <?= $stateProvince ?> <?= $zipPostalCode ?>
					</div>

					<div>
						<?= $country ?> 
					</div>
				</td>
			</tr>


			<tr>
				<td>
					<form method="POST" action="/Nozama/public/addressController/editAddress/<?= $addressID ?>">
						<input class="btn btn-default" type="submit" value="Edit" />	

						<button class="btn btn-danger" data-toggle="modal" data-target="#deleteConfirmation" type="button" value="<?= $viewIndex ?>" id="deleteButton">Delete</button>

						<div id="deleteConfirmation" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
							    	<div class="modal-header">
							    		<button type="button" class="close" data-dismiss="modal">&times;</button>

							     		<h4 class="modal-title">Delete Address Confirmation</h4>
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
						if($addressIndex > 0) {
					?>
							<form method="POST" action="/Nozama/public/addressController/switchDefaultAddress/<?= $addressID ?>">
								<input class="btn btn-primary" type="submit" value="Make Default Address" />
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