<?php
	$paymentID = $data['paymentID'];
	$cardType = $data['cardType'];
	$cardNumber = $data['cardNumber'];

	$errorMessage = $data['errorMessage'];
?>

<html>
<head>
</head>

<body>
	<div>
		<div class="col-sm-offset-4 col-sm-10">
			<h3>Edit Payment Method</h3>
		</div>


		<form class="form-horizontal" method="POST">
			<?php
				if(!is_null($errorMessage)) {
			?>

					<div class="form-group">
						<div class="col-sm-offset-4 col-xs-3 alert alert-danger">
							<strong><?= $errorMessage ?></strong>
						</div>
					</div>
			<?php
				}
			?>

			<div class="form-group">
				<label class="control-label col-sm-4">Card Type</label>

				<div class="col-xs-3"> 
					<select class="form-control" name="cardType" required>
						<option value="" selected disabled>Type</option>
						<option <?= $cardType == 'Visa' ? 'selected' : '' ?>>Visa</option>
						<option <?= $cardType == 'Master Card' ? 'selected' : '' ?>>Master Card</option>
						<option <?= $cardType == 'American Express' ? 'selected' : '' ?>>American Express</option>
						<option <?= $cardType == 'Visa Electron' ? 'selected' : '' ?>>Visa Electron</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4">Card Number</label>

				<div class="col-xs-3"> 
					<input  class="form-control" type="text" name="cardNumber" pattern="^(?!\s*$).+" title="whitespace only is invalid" value="<?= $cardNumber ?>" required />
				</div>
			</div>

			<div class="col-sm-offset-4 col-sm-10">
				<?php
					if(is_null($paymentID)) {
				?>
						<button class="btn btn-default" type="submit" name="add" value="Add">Add</button>
				<?php
					}
					else {
				?>
						<button class="btn btn-default" type="submit" name="edit" value="Edit">Edit</button>
				<?php
					}
				?>

				<?php
					if(!is_null($paymentID)) {
				?>
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
				<?php
					}
				?>
		</form>
	</div>
</body>
</html>