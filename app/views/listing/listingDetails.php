<?php
	$accountID = $data['accountID'];
	$accountType = $data['accountType'];

	$listingID = $data['listingID'];
	$title = $data['title'];
	$categoryID = $data['categoryID'];
	$description = $data['description'];
	$sellerAccountID = $data['sellerAccountID'];
	$seller = $data['seller'];
	$rating = $data['rating'];
	$price = $data['price'];
	$date = $data['date'];

	$optionID = $data['optionID'];
	$image = $data['image'];
	$color = $data['color'];
	$size = $data['size'];
	$stock = $data['stock'];

	$wishID = $data['wishID'];

	$errorMessage = $data['errorMessage'];
?>

<html>
<head>
	<script type="text/javascript" src="/Nozama/public/javascript/utility.js"></script>
	<script type="text/javascript" src="/Nozama/public/javascript/listingDetails.js?"></script>
</head>

<body>
	<table>
		<tr>
			<td>
				<img class="img-rounded" height="300px" width="300px" src="data:image/jpeg;base64,<?= base64_encode($image) ?>" />
			</td>

			<td>
				<div>
					<?= htmlentities($title) ?>
				</div>

				<div>
					by <a href="/Nozama/public/profileController/viewProfile/<?= $sellerAccountID ?>"><?= htmlentities($seller) ?></a>
				</div>

				<div>
					<?= is_null($rating) ? 'Not Rated' : "Rating: $rating/5" ?>
				</div>

				<br />

				<div>
					Price: $<?= $price ?>
				</div>

				<div>
					<?= $stock == 0 ? 'Out Of Stock' : 'In Stock' ?>
				</div>

				<br />

				<div>
					<?= is_null($size) ? '' : 'Size: ' . htmlentities($size) ?>
				</div>

				<div>
					<?= is_null($color) ? '' : 'Color: '. htmlentities($color) ?>
				</div>

				<br />

				<?= listingOptionsController::optionSelect($listingID, $optionID) ?>
			</td>

			<td>
				<center>
					<?php
						if($stock > 0 && $sellerAccountID != $accountID) {
					?>
							<form class="form-horizontal" method="POST" action="/Nozama/public/shoppingCartController/addToCart/<?= $listingID ?>/<?= $optionID ?>">
								<?php
									if(!is_null($errorMessage)) {
								?>
										<div class="alert alert-danger">
											<strong><?= $errorMessage ?></strong>
										</div>
								<?php
									}
								?>

								<div class="form-group">
									<label class="control-label">Quantity</label>

									<input type="number" name="quantity" min="1" style="width:50px;" required />
								</div>

								<input class="btn btn-info" type="submit" value="Add To Cart" />
							</form>
					<?php
						}
					?>

					<?php
						if(!is_null($accountType) && $sellerAccountID != $accountID) {
					?>
							<?php
								if(is_null($wishID)) {
							?>			
								<form method="POST" action="/Nozama/public/wishlistController/addWish/<?= $listingID ?>/<?= $optionID ?>">
									<input class="btn btn-default" type="submit" value="Add To Wishlist" />
								</form>
							<?php
								}
								else {
							?>
								<form method="POST" action="/Nozama/public/wishlistController/removeThroughListingDetails/<?= $listingID ?>/<?= $optionID ?>/<?= $wishID ?>">
									<input class="btn btn-default" type="submit" value="Remove From Wishlist" />
								</form>
							<?php
								}
							?>
					<?php
						}
					?>
				</center>
			</td>
		</tr>

		<tr>
			<td colspan="2">
				<div>
					Description<br/>
					<?= nl2br(htmlentities($description)) ?>
				</div>

				<br />

				<div>
					Date Listed: <?= date('F j, Y', strtotime($date)) ?>
				</div>
			</td>
		</tr>
	</table>

	<br />

	<?php
		if(!is_null($accountType) && $sellerAccountID != $accountID) {
	?>
			<form method="POST" action="/Nozama/public/reportController/fillOutReport/<?= $accountID ?>/<?= $listingID ?>">
				<input class="btn btn-default" type="submit" value="Report" />
			</form>

			<br />
	<?php
		}
	?>

	<?php
		if(!is_null(Listing::where('Category_Id', $categoryID)->where('Listing_Id', '!=', $listingID)->first())) {
	?>
			<?= listingController::displayRecommendation($listingID, $categoryID) ?>
	<?php
		}
	?>

	<br />

	<?php
		if(!is_null($accountType) && $accountType == 0) {
	?>
			<form method="POST" action="/Nozama/public/orderController/cancelAllOrders/<?= $listingID ?>">
				<button class="btn btn-danger" data-toggle="modal" data-target="#cancelConfirmation" type="button" value="<?= $viewIndex ?>" id="deleteButton">Cancel Orders</button>

						<div id="cancelConfirmation" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
							    	<div class="modal-header">
							    		<button type="button" class="close" data-dismiss="modal">&times;</button>

							     		<h4 class="modal-title">Cancel All Orders Confirmation</h4>
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
			</form>

			<?php
				if($accountID != $sellerAccountID) {
			?>

					<form method="POST" action="/Nozama/public/listingController/editListing/<?= $listingID ?>">
						<button class="btn btn-danger" data-toggle="modal" data-target="#deleteConfirmation" type="button" value="<?= $viewIndex ?>" id="deleteButton">Delete</button>

						<div id="deleteConfirmation" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
							    	<div class="modal-header">
							    		<button type="button" class="close" data-dismiss="modal">&times;</button>

							     		<h4 class="modal-title">Delete Listing Confirmation</h4>
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
	<?php
		}
	?>
</body>
</html>