<?php
	$optionCount = $data['optionCount'];
	$title = $data['title'];
	$description = $data['description'];
	$price = $data['price'];
?>

<html>
<head>
</head>

<body>
	<form class="form-horizontal" method="POST" enctype="multipart/form-data">
		<div class="form-group">
			<label class="control-label col-sm-4">Title</label>

			<div class="col-xs-3">
				<input class="form-control" type="text" name="title" pattern="^(?!\s*$).+" title="whitespace only is invalid" value="<?= htmlentities($title) ?>" required  />
			</div>
		</div>

		<br />

		<div class="form-group">
			<label class="control-label col-sm-4">Category</label>

			<div class="col-xs-3">
				<select class="form-control" name="category" required>
					<option value="" disabled selected>Select a Category</option>

					<?= categoryController::fillOptions() ?>
				</select>
			</div>
		</div>

		<br />

		<div class="form-group">
			<label class="control-label col-sm-4">Description</label>

			<div class="col-xs-3">
				<textarea class="form-control" name="description" rows="5" required><?= htmlentities($description) ?></textarea>
			</div>
		</div>

		<br />

		<div class="form-group">
			<label class="control-label col-sm-4">Price</label>

			<div class="col-xs-3">
				<input class="form-control" type="number" name="price" value="<?= $price ?>" step="any" required />
			</div>
		</div>

		<br />

		<?= listingOptionsController::addListingOptions($optionCount) ?>

		<br />

		<input type="number" name="finalOptionCount" value="<?= $optionCount ?>" hidden />

		<div class="col-sm-offset-4 col-sm-10">
			<input class="btn btn-default" type="submit" name="edit" value="Edit" />

			<button class="btn btn-danger" data-toggle="modal" data-target="#deleteConfirmation" type="button" value="<?= $viewIndex ?>" id="deleteButton">Delete</button>

			<div id="deleteConfirmation" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
				    	<div class="modal-header">
				    		<button type="button" class="close" data-dismiss="modal">&times;</button>

				     		<h4 class="modal-title">Delete Listing Confirmation</h4>
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
		</div>
	</form>
</body>
</html>