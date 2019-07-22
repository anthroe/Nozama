<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Listing extends Eloquent
{
	public $timestamps = false;

	protected $table = 'listing';
	protected $primaryKey = 'Listing_Id';

	protected $fillable = ['Listing_Id', 'Date', 'Rating'];
	protected $guarded = ['Title', 'Description', 'Category', 'Price', 'Stock', 'Seller'];

	public $_title;
	public $_description;
	public $_categoryID;
	public $_price;
	public $_seller;

	// Sets its properties based on the given request object's values
	public function set($request)
	{
		if(isset($request['title']))
			$this->_title = trim($request['title']);

		if(isset($request['description']))
			$this->_description = trim($request['description']);

		if(isset($request['category']))
			$this->_categoryID = trim($request['category']);

		if(isset($request['price']))
			$this->_price = trim($request['price']);

		$this->_seller = $_SESSION['accountID'];
	}

	// FOREIGN KEY RELATIONSHIPS

	public function account()
	{
		return $this->belongsTo('Account', 'Seller', 'Account_Id');
	}
	
	public function category()
	{
		return $this->belongsTo('Category', 'Category_Id', 'Category_Id');
	}

	public function listingOptions()
	{
		return $this->hasMany('ListingOptions', 'Listing_Id', 'Listing_Id');
	}

	public function productReview()
	{
		return $this->hasMany('ProductReview', 'Listing_Id', 'Listing_Id');
	}
}

?>