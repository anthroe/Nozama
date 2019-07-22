<?php
	$optionCount = $data['optionCount'];
	$image = $data['image'];
	$color = $data['color'];
	$size = $data['size'];
	$stock = $data['stock'];
?>

<html>
<head>
</head>

<body>
	<tr>
		<td>
			<input class="imageUpload form-control" type="file" name="image[]" value="<?= $image ?>" accept=".jpg, .png, .gif, .tif, .jpeg" required />
		</td>

		<td>
			<input class="colorOption form-control" type="text" name="color[]" pattern="^(?!\s*$).+" title="whitespace only is invalid" value="<?= htmlentities($color) ?>" <?= $optionCount > 1 ? 'selected' : '' ?> />
		</td>

		<td>
			<input class="sizeOption form-control" type="text" name="size[]" pattern="^(?!\s*$).+" title="whitespace only is invalid" value="<?= htmlentities($size) ?>" <?= $optionCount > 1 ? 'selected' : '' ?> />
		</td>

		<td>
			<input class="form-control" type="number" name="stock[]" value="<?= htmlentities($stock) ?>" required />
		</td>
	</tr>
</body>
</html>