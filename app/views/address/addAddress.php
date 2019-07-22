<?php
	$addressID = $data['addressID'];
	$addressLine1 = $data['addressLine1'];
	$addressLine2 = $data['addressLine2'];
	$city = $data['city'];
	$stateProvince = $data['stateProvince'];
	$zipPostalCode = $data['zipPostalCode'];
	$country = $data['country'];
?>

<html>
<head>
</head>

<body>
	<div>
		<div class="col-sm-offset-4 col-sm-10">
			<h3><?= is_null($addressID) ? "Add" : "Edit" ?> Address</h3>
		</div>

		<form class="form-horizontal" method="POST">
			<div class="form-group">
				<label class="control-label col-sm-4">Address Line 1</label>

				<div class="col-xs-3"> 
					<input class="form-control" type="text" name="addressLine1" pattern="^(?!\s*$).+" title="whitespace only is invalid" value="<?= $addressLine1 ?>" required />
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4">Address Line 2</label>

				<div class="col-xs-3"> 
					<input class="form-control" type="text" name="addressLine2" pattern="^(?!\s*$).+" title="whitespace only is invalid" value="<?= $addressLine2 ?>" />
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4">City</label>

				<div class="col-xs-3"> 
					<input class="form-control" type="text" name="city" pattern="^(?!\s*$).+" title="whitespace only is invalid" value="<?= $city ?>" required />
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4">State/Province</label>

				<div class="col-xs-3"> 
					<input class="form-control" type="text" name="stateProvince" pattern="^(?!\s*$).+" title="whitespace only is invalid" value="<?= $stateProvince ?>" required />
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4">Zip/Postal Code</label>

				<div class="col-xs-3"> 
					<input class="form-control" type="text" name="zipPostalCode" pattern="(^\d{5}(-\d{4})?$)|(^[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} *\d{1}[A-Z]{1}\d{1}$)" title="Invalid postal/zip code" value="<?= $zipPostalCode ?>" required />
				</div>
			</div>


			<div class="form-group">
				<label class="control-label col-sm-4">Country</label>

				<div class="col-xs-3"> 
					<input class="form-control" type="text" name="country" pattern="^(?!\s*$).+" title="whitespace only is invalid" value="<?= $country ?>" required />
				</div>
			</div>


			<div class="col-sm-offset-4 col-sm-10">
					<?php
						if(is_null($addressID)) {
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
					if(!is_null($addressID)) {
				?>
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
				<?php
					}
				?>
			</div>
		</form>
	</div>
</body>
</html>