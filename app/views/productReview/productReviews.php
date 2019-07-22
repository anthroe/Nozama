<?php
	$prodReviews = $data['prodReviews'];
?>

<html>
<head>
</head>

<body>
	<div class="col-sm-offset-4 col-sm-10">
		<?php
			if($prodReviews->count() == 0) {
		?>
				<div>
					This listing has not yet been reviewed
				</div>
		<?php
			}
		?>
		<div>
			<?= productReviewController::viewReviewHelper($prodReviews) ?>
		</div>
	</div>
</body>
</html>