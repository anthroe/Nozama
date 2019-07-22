<?php
	$listings = $data['listings'];	
?>

<html>
<head>
</head>

<body>
	<?php
		if($listings->count() > 0) {
	?>
			<table>
				<tr>
					<th colspan="5">
						Recommendations
					</th>
				</tr>
				<tr>
					<?= listingController::displayRecommendationHelper($listings) ?>
				</tr>
			</table>
	<?php
		}
	?>
</body>
</html>