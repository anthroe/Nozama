<?php

class AnonymousCart
{
	public $Option_Id;
	public $Quantity;

	// Defines this model's data valiation
	public function validate()
	{	
		$listingOption = ListingOptions::find($this->Option_Id);

		if($this->Quantity > $listingOption->Stock)
		{
			$_SESSION['errorMessage'] = 'Could not add: Understocked';
			return false;
		}

		return true;
	}
}

?>