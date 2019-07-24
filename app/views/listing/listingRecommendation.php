<?php
	$listingID = $data['listingID'];
	$image = $data['image'];
	$title = $data['title'];
	$price = $data['price'];
?>

<html>
<head>
</head>

<body>
	<td>
		<center>
			<a href="/public/listingController/viewDetails/<?= $listingID ?>">
				<img height="100px" width="100px" src="data:image/jpeg;base64,<?= base64_encode($image) ?>" />
			</a>

			<div>
				<a href="/public/listingController/viewDetails/<?= $listingID ?>">
					<?= htmlentities($title) ?>
				</a>
			</div>

			<div>
				$<?= $price ?>
			</div>
		</center>
	</td>
</body>
</html>