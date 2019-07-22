<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class ShoppingCart extends Eloquent
{
	public $timestamps = false;

	protected $table = 'shopping_cart';
	protected $primaryKey = 'Cart_Id';

	protected $fillable = ['Cart_Id', 'Date'];
	protected $guarded = ['Account_Id', 'Option_Id', 'Quantity'];

	// Defines this model's data valiation
	public function validate()
	{	
		$listingOption = $this->listingOptions;
		if($this->Quantity > $listingOption->Stock)
		{
			$_SESSION['errorMessage'] = 'Could not add: Understocked';
			return false;
		}

		return true;
	}

	// FOREIGN KEY RELATIONSHIPS

	public function account()
	{
		return $this->belongsTo('Account', 'Account_Id', 'Account_Id');
	}

	public function listingOptions()
	{
		return $this->belongsTo('ListingOptions', 'Option_Id', 'Option_Id');
	}
}

?>