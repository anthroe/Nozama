<?php
	$listingTitle = $data['listingTitle'];
	$listingImage = $data['listingImage'];
	$listingSellerAccountID = $data['listingSellerAccountID'];
	$listingSeller = $data['listingSeller'];
	$listingPrice = $data['listingPrice'];
	$listingRating = $data['listingRating'];
?>

<html>
<head>
</head>

<body>
	<div class="col-sm-offset-4 col-sm-10">
		<table>
			<tr>
				<td>
					<img class="img-rounded" height="100px" width="100px" src="data:image/jpeg;base64,<?= base64_encode($listingImage) ?>" />
				</td>

				<td>
					<div>
						<?= htmlentities($listingTitle) ?>
					</div>

					<div>
						by
						<a href="/Nozama/public/profileController/viewProfile/<?= $listingSellerAccountID ?>">
							<?= htmlentities($listingSeller) ?>
						</a>
					</div>

					<div>
						$<?= $listingPrice ?>
					</div>

					<br />

					<div align="right">
						<?= is_null($listingRating) ? 'Not Rated' : "Rated $listingRating/5" ?>
					</div>
				</td>
			</tr>
		</table>
	</div>

	<br />
</body>
</html>