<?php

// Defines a set of properties which are used to filter and sort Listings
class Conditions
{
	public $category = null;
	public $search = null;
	public $seller = null;
	public $priceLow = null;
	public $priceHigh = null;
	public $stock = null;
	public $rating = null;
	public $sort = null;

	// Sets its properties based on the given request object's values
	public function __construct($request)
	{
		if(isset($request['searchCategory']))
			$this->category = $request['searchCategory'];

		if(isset($request['searchKeyWord']))
		{
			if($request['searchKeyWord'] == '')
			{
				$this->search = null;
			}
			else
			{
				$this->search = $request['searchKeyWord'];
			}
		}

		if(isset($request['searchSeller']) && $request['searchSeller'] != '')
		{
			if($request['searchSeller'] == '')
			{
				$this->seller = null;
			}
			else
			{
				$this->seller = $request['searchSeller'];
			}
		}

		if(isset($request['filterPriceLow']) && $request['filterPriceLow'] > 0)
		{
			if($request['filterPriceLow'] == '')
			{
				$this->priceLow = null;
			}
			else
			{		
				$this->priceLow = $request['filterPriceLow'];
			}
		}

		if(isset($request['filterPriceHigh']) && $request['filterPriceHigh'] > 0)
		{
			if($request['filterPriceHigh'] == '')
			{
				$this->priceHigh = null;
			}
			else
			{
				$this->priceHigh = $request['filterPriceHigh'];
			}
		}

		if(isset($request['filterStock']))
			$this->stock = $request['filterStock'];

		if(isset($request['filterRating']))
			$this->rating = $request['filterRating'];

		if(isset($request['sort']))
			$this->sort = $request['sort'];

		$this->validatePriceConditions();
	}

	// Switches the values of priceLow and priceHigh if priceLow is larger than priceHigh
	public function validatePriceConditions()
	{
		if(!is_null($this->priceLow) && !is_null($this->priceHigh) && $this->priceLow  > $this->priceHigh)
		{
			$tempLow = $this->priceLow;
			$this->priceLow = $this->priceHigh;
			$this->priceHigh = $tempLow;
		}
	}
}

?>