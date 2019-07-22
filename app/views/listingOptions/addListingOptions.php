<?php
	$optionCount = $data['optionCount'];
?>

<html>
<head>
	<script type="text/javascript" src="/Nozama/public/javascript/utility.js"></script>
	<script type="text/javascript" src="/Nozama/public/javascript/addListingOptions.js"></script>
</head>

<body>
	<div class="col-sm-offset-1 col-sm-10">
		<table class="table-condensed">
			<tr>
				<th colspan="4">
				<center>
					Options
				</center>
				</th>
			</tr>

			<tr>
				<th>
					Image
				</th>

				<th>
					Color
				</th>

				<th>
					Size
				</th>

				<th>
					Stock
				</th>
			</tr>

			<?php
				for($count = 0; $count < $optionCount; $count++) 
					listingOptionsController::addListingOption($optionCount, $count);
			?>

			<tr>
				<th colspan="4">
					<center>
						<button class="btn btn-default" name="optionCount" value="<?= $optionCount + 1 ?>" formnovalidate>+</button>
						
						<?php
							if($optionCount > 1)
							{
						?>
								<button class="btn btn-default" name="optionCount" value="<?= $optionCount - 1 ?>" formnovalidate>-</button>
						<?php
							}
						?>
					</center>
				</th>
			</tr>
		</table>
	</div>
</body>
</html>