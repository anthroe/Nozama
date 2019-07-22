<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Shopping_Cart extends Eloquent {
	public $cart_Id;
	public $listing_Id;
	public $account_Id;
	public $quantity;
	public $date;
	

	public $timestamps = false;

	protected $table = 'shopping_cart';
	protected $primaryKey = 'Cart_Id';

	protected $fillable = ['Cart_Id', 'Date'];
	protected $guarded = ['Listing_Id', 'Account_Id', 'Quantity'];

	// FOREIGN KEY RELATIONSHIPS

	public function account()
	{
		return $this->belongsTo('Account', 'Account_Id', 'Account_Id');
	}

	public function listing()
	{
		return $this->belongsTo('Listing', 'Listing_Id', 'Listing_Id');
	}

}

?>