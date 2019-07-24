<?php
	$optionID = $data['optionID'];
	$quantity = $data['quantity'];
	
	$image = $data['image'];
	$color = $data['color'];
	$size = $data['size'];

	$listingID = $data['listingID'];
	$title = $data['title'];
	$price = $data['price'];

	$sellerProfileID = $data['sellerProfileID'];
	$seller = $data['seller'];

	$index = $data['index'];
	$errorMessage = $data['errorMessage'];
?>

<html>
<head>
</head>

<body>
	<tr>
		<td>
			<a href="/public/listingController/viewDetails/<?= $listingID ?>/<?= $optionID ?>">
				<img height="100px" width="100px" src="data:image/jpeg;base64,<?= base64_encode($image) ?>" />
			</a>
		</td>

		<td style="padding-right: 50px;">
			<div>
				<a href="/public/listingController/viewDetails/<?= $listingID ?>/<?= $optionID ?>"><?= htmlentities($title) ?></a>
			</div>

			<div>
				by <a href="/public/profileController/viewProfile/<?= $sellerProfileID ?>"><?= htmlentities($seller) ?></a>
			</div>


			<?php
				if(!is_null($color)) {
			?>
					<div>
						Color: <?= htmlentities($color) ?>
					</div>
			<?php
				}
			?>

			<?php
				if(!is_null($size)) {
			?>
					<div>
						Size: <?= htmlentities($size) ?>
					</div>
			<?php
				}
			?>

			<br />

			<a href="/public/anonymousCartController/deleteFromCart/<?= $optionID ?>">Delete</a>
		</td>

		<td align="left" style="padding-right: 50px;">
			$<?= number_format($price * $quantity, 2) ?>
		</td>

		<td align="right">
			<form method="POST" action="/public/anonymousCartController/editCartItem/<?= $optionID ?>/<?= $index ?>">
				<?= $errorMessage ?>

				<br />

				<input type="number" name="quantity" min="1" value="<?= $quantity ?>" required style="width: 50px;" />

				<br />

				<input type="submit" value="update" />
			</form>
		</td>
	</tr>
</body>
</html>