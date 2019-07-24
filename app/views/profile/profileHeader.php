<?php
	$accountID = $data['accountID'];
	$accountType = $data['accountType'];

	$profileID = $data['profileID'];
	$privacy = $data['privacy'];

	$userReviewCount = $data['userReviewCount'];
?>

<html>
<head>
</head>

<body>
	<ul class="nav nav-tabs nav-justified">
		<li>
			<a href="/public/profileController/viewProfile/<?= $profileID ?>">Profile</a>
		</li>

		<?php
			if($profileID == $accountID) {
		?>
				<li>
					<a href="/public/profileController/editProfile/<?= $profileID ?>">Edit Profile</a>
				</li>
		<?php
			}
		?>

		<li>
			<a href="/public/userReviewController/viewUserReview/<?= $profileID ?>">Reviews</a>
		</li>

		<?php
			if($profileID != $accountID) {
		?>
				<?php
					if(!is_null($accountType)) {
				?>
						<li>
							<a href="/public/userReviewController/postUserReview/<?= $profileID ?>"><?= $userReviewCount == 0 ? 'Write a' : 'Edit Your' ?> Review</a>
						</li>
				<?php
					}
				?>

				<?php
					if($privacy != 1) {
				?>
						<li>
							<a href="/public/profileController/profileWishlist/<?= $profileID ?>">Wishlist</a>
						</li>
				<?php
					}
				?>
		<?php
			}
		?>

		<!-- <?php
			if(!is_null($accountType) && $accountType == 0 && $accountID != $profileID) {
		?>
				<a href="/public/orderController/viewOrders/<?= $accountID ?>">Orders</a>
		<?php
			}
		?> -->
	</ul>

	<br />
</body>
</html>