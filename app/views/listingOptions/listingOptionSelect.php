<?php
	$listingOptions = $data['listingOptions'];
?>

<html>
<head>
</head>

<body>
	<form id="optionsForm" method="POST">
		<select id="options" name="optionID">
			<option disabled selected>Options</option>

			<?= listingOptionsController::fillOptions($listingOptions) ?>
		</select>
	</form>
</body>
</html>