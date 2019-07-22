<?php
	$accountID = $data['accountID'];
	$accountType = $data['accountType'];

	$listingID = $data['listingID'];
	$sellerAccountID = $data['sellerAccountID'];
	$prodReviewCount = $data['prodReviewCount'];
?>

<html>
<head>
</head>

<body>
	<ul class="nav nav-tabs nav-justified">
		<li>
			<a href="/Nozama/public/listingController/viewDetails/<?= $listingID ?>">Details</a>
		</li>

		<?php 
			if(!is_null($accountType) && $sellerAccountID == $accountID) {
		?>
				<li>
					<a href="/Nozama/public/listingController/editListing/<?= $listingID ?>">Edit</a>
				</li>
		<?php
			}
		?>

		<li>
			<a href="/Nozama/public/productReviewController/viewListingReview/<?= $listingID ?>">Reviews</a>
		</li>

		<?php 
			if(!is_null($accountType) && $sellerAccountID != $accountID) {
		?>
				<li>
					<a href="/Nozama/public/productReviewController/postListingReview/<?= $listingID ?>"><?= $prodReviewCount == 0 ? 'Write a' : 'Edit Your' ?> Review</a>
				</li>
		<?php
			}
		?>

<!-- 		<?php
			if($sellerAccountID == $accountID) {
		?>
				<a href="/Nozama/public/orderController/getSalesOnListing/<?= $listingID ?>">Sales</a>
		<?php
			}
		?> -->
	</ul>

	<br />
</body>
</html>