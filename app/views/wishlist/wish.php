<?php 
	$accountType = $data['accountType'];

	$wishID = $data['wishID'];
	$listingID = $data['listingID'];
	$optionID = $data['optionID'];

	$image = $data['image'];
	$color = $data['color'];
	$size = $data['size'];
	$title = $data['title'];
	$seller = $data['seller'];
	$sellerAccountID = $data['sellerAccountID'];
	$price = $data['price'];
	$stock = $data['stock'];

	$cartQuantity = $data['cartQuantity'];

	$viewingUser = $data['viewingUser'];
?>

<html>
<head>
	
</head>

<body>
	<table>
		<tr>
			<td>
				<a href="/Nozama/public/listingController/viewDetails/<?= $listingID ?>/<?= $optionID ?>">
					<img height="100px" width="100px" src="data:image/jpeg;base64,<?= base64_encode($image) ?>" />
				</a>
			</td>

			<td>
				<div>
					<a href="/Nozama/public/listingController/viewDetails/<?= $listingID ?>/<?= $optionID ?>">
						<?= htmlentities($title) ?>
					</a>
				</div>

				<div>
					by
					<a href="/Nozama/public/profileController/viewProfile/<?= $sellerAccountID ?>">
						<?= htmlentities($seller) ?>
					</a>
				</div>

				<div>
					$<?= $price ?>
				</div>

				<?php
					if(!is_null($color)) {
				?>
						<div>
							Color: <?= $color ?>
						</div>
				<?php
					}
				?>

				<?php
					if(!is_null($size)) {
				?>
						<div>
							Size: <?= $size ?>
						</div>
				<?php
					}
				?>
			</td>

			<td><center>
				<?php
					if(is_null($viewingUser)) {
				?>
						<?php
							if($stock > 0 + $cartQuantity) {
						?>
								<form method="POST" action="/Nozama/public/wishlistController/transferWishToCart/<?= $wishID ?>">
									<input class="btn btn-default" type="submit" value="Transfer To Cart" />
								</form>
						<?php
							}
						?>

						<form method="POST" action="/Nozama/public/wishlistController/removeThroughWishlist/<?= $wishID ?>">
							<input class="btn btn-danger" type="submit" value="Remove From Wishlist" />
						</form>
				<?php
					}
					else if(!is_null($accountType)) {
				?>
						<form method="POST" action="/Nozama/public/orderController/sendGift/<?= $optionID ?>">
							<input class="btn btn-primary" type="submit" value="Send As Gift" />
						</form>
				<?php
					}
				?></center>
			</td>
		</tr>
	</table>
</body>
</html>