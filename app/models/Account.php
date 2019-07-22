<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Account extends Eloquent
{
	public $timestamps = false;

	protected $table = 'account';
	protected $primaryKey = 'Account_Id';

	protected $fillable = ['Account_Id', 'Type', 'Banned'];
	protected $guarded = ['Username', 'Email', 'PasswordHash'];
	
	// Defines this model's data valiation
	public function validate($accountID = null)
	{
		// Validate duplicate usernames
		$accounts = Account::where('Username', $this->Username)->get();
		if($accounts->count() > 0 && $accounts->first()->Account_Id != $accountID)
		{
			$_SESSION['errorMessage'] = 'Username Already Exists'; 
			return false;
		}

		return true;
	}

	// FOREIGN KEY RELATIONSHIPS

	public function address()
	{
		return $this->hasMany('Address', 'Account_Id', 'Account_Id');
	}

	public function listing()
	{
		return $this->hasMany('Listing', 'Seller', 'Account_Id');
	}

	public function paymentMethod()
	{
		return $this->hasMany('PaymentMethod', 'Account_Id', 'Account_Id');
	}

	public function productReview()
	{
		return $this->hasMany('ProductReview', 'Account_Id', 'Account_Id');
	}

	public function profile()
	{
		return $this->hasOne('Profile', 'Profile_Id', 'Account_Id');
	}

	public function shoppingCart()
	{
		return $this->hasMany('ShoppingCart', 'Account_Id', 'Account_Id');
	}

	// STILL NEED TO TEST
	public function userReview()
	{
		return $this->hasMany('UserReview', 'Account_Id', 'Account_Id');
	}

	// STILL NEED TO TEST
	public function userReviewed()
	{
		return $this->hasMany('UserReview', 'Account_Id', 'Account_Id');
	}

	public function wishlist()
	{
		return $this->hasMany('Wishlist', 'Account_Id', 'Account_Id');
	}
}

?>