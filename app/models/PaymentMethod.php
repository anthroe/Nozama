<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class PaymentMethod extends Eloquent
{
	public $timestamps = false;

	protected $table = 'payment_method';
	protected $primaryKey = 'Payment_Id';

	protected $fillable = ['Payment_Id'];
	protected $guarded = ['Card_Number', 'Card_Type'];

	// Defines this model's data valiation
	public function validate()
	{
		$card = CreditCard::validCreditCard($this->Card_Number, $this->Card_Type);

		if(!$card['valid'])
		{
			$_SESSION['errorMessage'] = 'Invalid Card Credentials';
			return false;
		}

		return true;
	}

	// Copy mutator
	public function copy($paymentMethod)
	{
		$this->Card_Number = $paymentMethod->Card_Number;
		$this->Card_Type = $paymentMethod->Card_Type;
	}

	// FOREIGN KEY RELATIONSHIPS

	public function account()
	{
		return $this->belongsTo('account', 'Account_Id', 'Account_Id');
	}
}

?>