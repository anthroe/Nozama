<?php
	$optionID = $data['optionID'];
	$size = $data['size'];
	$color = $data['color'];
	$selectedOption = $data['selectedOption'];
?>

<html>
<head>
</head>

<body>
	<option name="optionID" value=<?= $optionID ?> <?= $optionID == $selectedOption ? 'selected' : '' ?>>
		<?=  htmlentities($size) . ' ' .  htmlentities($color) ?>
	</option>
</body>
</html>