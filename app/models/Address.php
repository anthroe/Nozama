<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Address extends Eloquent
{
	public $timestamps = false;

	protected $table = 'address';
	protected $primaryKey = 'Address_Id';

	protected $fillable = ['Address_Id', 'Address_Line_2'];
	protected $guarded = ['Account_Id', 'Address_Line_1', 'City', 'State_Province', 'Zip_Postal_Code', 'Country'];

	// Copy mutator
	public function copy($address)
	{
		$this->Address_Line_1 = $address->Address_Line_1;
		$this->Address_Line_2 = $address->Address_Line_2;
		$this->City = $address->City;
		$this->State_Province = $address->State_Province;
		$this->Zip_Postal_Code = $address->Zip_Postal_Code;
		$this->Country = $address->Country;
	}

	// FOREIGN KEY RELATIONSHIPS

	public function account()
	{
		return $this->belongsTo('account', 'Account_Id', 'Account_Id');
	}
}

?>