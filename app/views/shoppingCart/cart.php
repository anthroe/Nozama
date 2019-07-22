<?php
	$cart = $data['cart'];

	$items = $data['items'];
	$subtotal = $data['subtotal'];
?>

<html>
<head>
</head>

<body>
	<?php
		if($items == 0) {
	?>
			<div>
				There are no items in the cart
			</div>
	<?php
		}
		else {
	?>		
			<table>
				<tr>
					<th colspan="4">
						Shopping Cart
					</th>

					<td align="center" rowspan="3" style="padding-left: 50px;">
						<div>
							<b>
								Subtotal (<?= $items ?> item<?= $items > 1 ? 's' : ''?>): $<?= number_format($subtotal, 2) ?>
							</b>
						</div>

						<form method="POST" action="/Nozama/public/loginController">
							<input class="btn btn-success" type="submit" value="Proceed to Checkout" />
						</form>
					</td>
				</tr>

				<tr>
					<td colspan="2" align="center">
						Item
					</td>

					<td>
						Price
					</td>

					<td align="right" colspan="1">
						Quantity
					</td>
				</tr>

				<?= anonymousCartController::viewCartItemHelper($cart) ?>
			</table>
	<?php
		}
	?>
</body>
</html>