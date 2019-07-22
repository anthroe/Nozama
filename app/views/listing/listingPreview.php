<?php 
	$listingID = $data['listingID'];
	$image = $data['image'];
	$title = $data['title'];
	$seller = $data['seller'];
	$price = $data['price'];
	$rating = $data['rating'];
	$stock = $data['stock'];

	$sellerAccountID = $data['sellerAccountID'];
?>

<html>
<head>
	
</head>

<body>
	<button class="btn btn-default btn-lg" style="margin-left: 15px; margin-bottom: 17px;">
		<a href="/Nozama/public/listingController/viewDetails/<?= $listingID ?>" style="text-decoration: none;">
			<center>
				<table class="table-condensed">
					<tr>
						<td align="center">
							<a href="/Nozama/public/listingController/viewDetails/<?= $listingID ?>">
								<img class="img-rounded" height="150px" width="150px" src="data:image/jpeg;base64,<?= base64_encode($image) ?>" />
							</a>
						</td>
					</tr>

					<tr>
						<td>
							<div>
								<a href="/Nozama/public/listingController/viewDetails/<?= $listingID ?>">
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

							<br />

							<div align="right">
								<?= is_null($rating) ? 'Not Rated' : "Rated $rating/5" ?>
							</div>
						</td>
					</tr>
				</table>
			</center>
		</a>
	</button>
</body>
</html>