<?php
	$accountID = $data['accountID'];
	$accountType = $data['accountType'];

	$listingID = $data['listingID'];

	$prodReviewID = $data['prodReviewID'];
	$reviewer = $data['reviewer'];
	$reviewerID = $data['reviewerID'];
	$title = $data['title'];
	$message = $data['message'];
	$rating = $data['rating'];
	$date = $data['date'];

	$viewIndex = $data['viewIndex'];
?>

<html>
<head>
</head>

<body>
	<tr>
		<td>
			<div>
				<span>
					<b><?= htmlentities($title) ?></b>
				</span>

				<span>
					(<?= is_null($rating) ? 'Not Rated' : "Rating: $rating/5" ?>)
				</span>
			</div>

			<div>
				<span>
					by <a href="/public/profileController/viewProfile/<?= $reviewerID ?>"><?= htmlentities($reviewer) ?></a>
				</span>

				<span>
					<i>on <?= date('F j, Y', strtotime($date)) ?></i>
				</span>
			</div>

			<div>
				<span>
					<?= nl2br(htmlentities($message)) ?>
				</span>

				<?php
					if(!is_null($accountType) && ($accountType == 0 || $accountID == $reviewerID)) {
				?>
					<form method="POST" action="/public/productReviewController/postListingReview/<?= $listingID ?>/<?= $prodReviewID ?>">
						<button class="btn btn-danger" data-toggle="modal" data-target="#deleteConfirmation<?= $viewIndex ?>" type="button" value="<?= $viewIndex ?>" id="deleteButton">Delete</button>

						<div id="deleteConfirmation<?= $viewIndex ?>" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
							    	<div class="modal-header">
							    		<button type="button" class="close" data-dismiss="modal">&times;</button>

							     		<h4 class="modal-title">Delete Review Confirmation</h4>
							    	</div>

							    	<div class="modal-body">
							        	<p>Are You Sure?</p>
							      	</div>

							      	<div class="modal-footer">
							        	<button class="btn btn-default" type="submit" name="adminDelete" value="Yes" formnovalidate>Yes</button>

							        	<button class="btn btn-danger" data-dismiss="modal" type="button" value="<?= $viewIndex ?>" id="noButton">No</button>
							      	</div>
							    </div>
							</div>
						</div>
					</form>
				<?php
					}
				?>
			</div>
		</td>
	</tr>

	<br />
</body>
</html>