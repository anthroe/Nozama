<?php
	$reviewedID = $data['reviewedID'];
	$reviewedUsername = $data['reviewedUsername'];
	$accountID = $data['accountID'];
	$rating = $data['rating'];
	$title = $data['title'];
	$message = $data['message'];
?>

<html>
<head>
</head>

<body>
	<div>
		<div class="col-sm-offset-4 col-sm-10">
			<h3>Review <?= $reviewedUsername ?></h3>
		</div>

		<form class="form-horizontal" method="POST">
			<div class="form-group">
				<label class="control-label col-sm-4">Rating (/5)</label>

				<div class="col-xs-3"> 
					<input class="form-control" type="number" name="rating" min="0" max="5" value="<?= $rating ?>" required />
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4">Title</label>

				<div class="col-xs-3"> 
					<input class="form-control" type="text" name="title" pattern="^(?!\s*$).+" title="whitespace only is invalid" value="<?= htmlentities($title) ?>" required />
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4">Message</label>

				<div class="col-xs-3"> 
					<textarea class="form-control" name="message" rows="5" required><?= htmlentities($message) ?></textarea>
				</div>
			</div>

			<input type="number" name="reviewedID" value="<?= $reviewedID ?>" hidden required />

			<div class="col-sm-offset-4 col-sm-10">
				<input class="btn btn-default" type="submit" name="post" value="<?= is_null($rating) ? 'Submit' : 'Edit' ?>" />

				<?php
					if($accountID == $_SESSION['accountID']) {
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
			</div>
		</form>
	</div>
</body>
</html>