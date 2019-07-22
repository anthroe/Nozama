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
	<div>
		<div class="col-sm-offset-4 col-sm-10">
			<h3>Post a Listing</h3>
		</div>

		<form class="form-horizontal" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<label class="control-label col-sm-4">Title</label>

				<div class="col-xs-3">
					<input class="form-control" type="text" name="title" pattern="^(?!\s*$).+" title="whitespace only is invalid" value="<?= htmlentities($title) ?>" required />
				</div>
			</div>

			<div class="form-group">
			<label class="control-label col-sm-4">Category</label>

				<div class="col-xs-3">
					<select class="form-control" name="category" required>
						<option value="" disabled selected>Select a Category</option>

						<?= categoryController::fillOptions() ?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4">Description</label>

				<div class="col-xs-3">
					<textarea class="form-control" name="description" rows="5" required><?= htmlentities($description) ?></textarea>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4">Price</label>

				<div class="col-xs-3">
					<input class="form-control" type="number" name="price" value="<?= $price ?>" step="any" min="0" required />
				</div>
			</div>

			<br />

			<?= listingOptionsController::addListingOptions($optionCount) ?>

			<br />

			<input type="number" name="finalOptionCount" value="<?= $optionCount ?>" hidden />

			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-10">
					<button class="btn btn-default" type="submit" name="post" value="Post">Post</button>
				</div>
			</div>
		</form>
	</div>
</body>
</html>