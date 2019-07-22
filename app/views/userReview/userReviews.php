<?php
	$reviewedUsername = $data['reviewedUsername'];

	$userReviews = $data['userReviews'];
?>

<html>
<head>
</head>

<body>
	<?php
		if($userReviews->count() == 0) {
	?>
			<div>
				<?= $reviewedUsername ?> has not yet been reviewed
			</div>
	<?php
		}
		else {
	?>
			<div>
				Reviews for <?= $reviewedUsername ?>
			</div>
	<?php
		}
	?>

	<br />

	<div>
		<?= userReviewController::viewReviewHelper($userReviews) ?>
	</div>
</body>
</html>