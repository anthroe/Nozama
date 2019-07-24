<?php
	$owner = $data['owner'];
	$wishlist = $data['wishlist'];

	$viewingUser = $data['viewingUser'];
?>

<html>
<head>
</head>

<body>
	<div>
		<?= is_null($viewingUser) ? 'Your' : $owner . "'s" ?> Wishlist
	</div>

	<br />

	<div>
		<?php
			if($wishlist->count() != 0 && is_null($viewingUser)) {
		?>
				<form method="POST" action="/public/wishlistController/transferWishlistToCart">
					<input class="btn btn-info" type="submit" value="Transfer All To Cart" />
				</form>
		<?php
			}
			else if($wishlist->count() == 0) {
		?>
				<div>
					There are no items in this wishlist
				</div>
		<?php
			}
		?>
	</div>

	<br />

	<div>
		<?= wishlistController::viewWishHelper($wishlist, $viewingUser) ?>
	</div>
</body>
</html>