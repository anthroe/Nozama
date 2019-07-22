<?php

class listingOptionsController extends Controller
{
	// Fills a select tag with options from the listingOptions database table that associate with the given Listing_Id
	public function optionSelect($listingID, $selectedOption)
	{
		// Get the listingOptions that are associated with the given Listing_Id and that have color or size options
		$listingOptions = new listingOptions();
		$listingOptions = $listingOptions->where('Listing_Id', $listingID)
										 ->where(
										 		function($query) {
													$query->wherenotnull('Color')
														  ->orwherenotnull('Size');
												}
											)
										 ->orderby('Size', 'ASC')
										 ->orderby('Color', 'ASC')
										 ->get();

		if($listingOptions->count() > 1)
		{
			self::view('listingOptions/listingOptionSelect', ['listingOptions' => $listingOptions]);
		}
	}

	// Displays a listingOptions view for each listingOption
	public function fillOptions($listingOptions)
	{
		for($index = 0; $index < $listingOptions->count(); $index++) 
		{
			$listingOption = $listingOptions->get($index);

			self::view('listingOptions/listingOptions', [
				'optionID' => $listingOption->Option_Id, 
				'size' => $listingOption->Size, 
				'color' => $listingOption->Color,
				'selectedOption' => $selectedOption]);
		}
	}

	// Displays the listingOptions view with the given amount of listingOptions
	public function addListingOptions($optionCount)
	{
		self::view('listingOptions/addListingOptions', ['optionCount' => $optionCount]);
	}

	// Displays a listingOption view based on an array of options and an index
	public function addListingOption($optionCount, $index)
	{
		$listingOptions = new ListingOptions();
		$listingOptions->setFromArray($_POST, $index);

		self::view('listingOptions/addListingOption', [
			'optionCount' => $optionCount, 
			'image' => $listingOptions->_image, 
			'color' => $listingOptions->_color, 
			'size' => $listingOptions->_size,
			'stock' => $listingOptions->_stock]);
	}
}

?>