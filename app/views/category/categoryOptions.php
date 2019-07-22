<?php
	$categoryID = $data['categoryID'];
	$categoryName = $data['categoryName'];
	$category = $data['category'];
	$selectedCategory = $data['selectedCategory'];
?>

<html>
<head>
</head>

<body>
	<option value=<?= $categoryID ?> <?= $selectedCategory == $categoryID ? 'selected' : '' ?>>
		<?= htmlentities($categoryName) ?>
	</option>
</body>
</html>