<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Profile extends Eloquent
{
	public $timestamps = false;

	protected $table = 'profile';
	protected $primaryKey = 'Profile_Id';

	protected $fillable = ['Profile_Id', 'User_Rating', 'Privacy'];
	protected $guarded = ['Bio', 'Full_Name', 'Occupation', 'Location'];

	// FOREIGN KEY RELATIONSHIPS

	public function account()
	{
		return $this->belongsTo('Account', 'Profile_Id', 'Account_Id');
	}
}

?>