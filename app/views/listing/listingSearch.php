<?php
	$category = $data['category'];
	$search = $data['search'];
	$seller = $data['seller'];
?>

<html>
<head>
</head>

<body>
	<form class="navbar-form navbar-left form-inline" id="searchForm" method="POST" action="/Nozama/public/">
		<div class="form-group">
			<select class="form-control" name="searchCategory">
				<option disabled selected>Category</option>

				<?= categoryController::fillSearchOptions($category) ?>
			</select>

			<input class="form-control" type="text" name="searchKeyWord" placeholder="Search By Keyword" value="<?= htmlentities($search) ?>" />

			<input class="form-control" type="text" name="searchSeller" placeholder="Search By Seller" value="<?= htmlentities($seller) ?>" />

			<button class="btn btn-default form-control" type="submit" value="Search">
		    	<i class="glyphicon glyphicon-search"></i>
		    </button>

		    <?php
		    	if(!is_null($category) || !is_null($search) || !is_null($seller)) {
		    ?>
				    <button class="btn btn-primary form-control" type="submit" name="clearSearch" value="Clear Search">
				    	<i class="glyphicon glyphicon-remove-circle"></i>
				    </button>
		    <?php
		    	}
		    ?>
		</div>
	</form>
</body>
</html>