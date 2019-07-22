<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class ProductReview extends Eloquent
{
	public $timestamps = false;

	protected $table = 'product_review';
	protected $primaryKey = 'Review_Id';

	protected $fillable = ['Review_Id', 'Date'];
	protected $guarded = ['Listing_Id', 'Account_Id', 'Title', 'Message', 'Rating'];

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