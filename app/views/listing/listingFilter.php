<?php
	$priceLow = $data['priceLow'];
	$priceHigh = $data['priceHigh'];
	$rating = $data['rating'];
	$stock = $data['stock'];
	$sort = $data['sort'];
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="/public/css/listingFilter.css?1" />

	<script type="text/javascript" src="/public/javascript/utility.js"></script>
	<script type="text/javascript" src="/public/javascript/listingFilter.js?12"></script>
</head>

<body>
	<div class="container">
		<div class="row">
			<form class="form-inline" id="filterForm" method="POST" action="/public/">
				<div class="form-group">
					<input class="form-control input-sm" id="priceLowInput" type="number" name="filterPriceLow" step="any" placeholder="Price Low" value="<?= $priceLow ?>" />

					<input class="form-control input-sm" id="priceHighInput" type="number" name="filterPriceHigh" step="any"  placeholder="Price High" value="<?= $priceHigh ?>" />

					<select class="form-control input-sm" id="minRatingSelect" type="number" name="filterRating" value="<?= $rating ?>">
						<option disabled selected>Rating</option>
						<option value="5" <?= $rating == 5 ? 'selected' : '' ?>>5</option>
						<option value="4" <?= $rating == 4 ? 'selected' : '' ?>>4 & Up</option>
						<option value="3" <?= $rating == 3 ? 'selected' : '' ?>>3 & Up</option>
						<option value="2" <?= $rating == 2 ? 'selected' : '' ?>>2 & Up</option>
						<option value="1" <?= $rating == 1 ? 'selected' : '' ?>>1 & Up</option>
					</select>
				</div>

				<div class="btn-group">
					<button class="btn btn-default input-sm <?= $stock == 0 ? 'buttonPressed' : '' ?>" id="noStock" name="filterStock" value="0">Include Out Of Stock</button>
					
					<button class="btn btn-default input-sm <?= $stock > 0 ? 'buttonPressed' : '' ?>" id="inStock" name="filterStock" value="1">In-Stock Only</button>
				</div>

				<div class="form-group">
					<select class="form-control input-sm" id="sortSelect" name="sort">
						<option disabled selected>Sort By</option>
						<option value="Title ASC" <?= $sort == 'Title ASC' ? 'selected' : '' ?>>Alphabetical</option>
						<option value="Title DESC" <?= $sort == 'Title DESC' ? 'selected' : '' ?>>Unalphabetical</option>
						<option value="Price ASC" <?= $sort == 'Price ASC' ? 'selected' : '' ?>>Cheapest</option>
						<option value="Price DESC" <?= $sort == 'Price DESC' ? 'selected' : '' ?>>Most Expensive</option>
						<option value="Date DESC" <?= $sort == 'Date DESC' ? 'selected' : '' ?>>Newest</option>
						<option value="Date ASC" <?= $sort == 'Date ASC' ? 'selected' : '' ?>>Oldest</option>
						<option value="Rating DESC" <?= $sort == 'Rating DESC' ? 'selected' : '' ?>>Best Rated</option>
						<option value="Rating ASC" <?= $sort == 'Rating ASC' ? 'selected' : '' ?>>Worst Rated</option>
					</select>
				</div>

				<?php
			    	if(!is_null($priceLow) || !is_null($priceHigh) || !is_null($rating) || !is_null($sort)) {
			    ?>
						<button class="btn btn-primary form-control input-sm" type="submit" name="clearFilters" value="Clear Filters">
					    	<i class="glyphicon glyphicon-remove-circle"></i>
					    </button>
			    <?php
			    	}
			    ?>
			</form>
		</div>
	</div>

	<br />
</body>
</html>