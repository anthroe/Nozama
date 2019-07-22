<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Wishlist extends Eloquent
{
	public $timestamps = false;

	protected $table = 'wishlist';
	protected $primaryKey = 'Wishlist_Id';

	protected $fillable = ['Wishlist_Id', 'Date'];
	protected $guarded = ['Option_Id', 'Account_Id'];

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