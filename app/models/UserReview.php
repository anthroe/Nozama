<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserReview extends Eloquent
{
	public $timestamps = false;

	protected $table = 'user_review';
	protected $primaryKey = 'Review_Id';

	protected $fillable = ['Review_Id', 'Date'];
	protected $guarded = ['To_Review', 'Account_Id', 'Title', 'Message', 'Rating'];

	// FOREIGN KEY RELATIONSHIPS

	public function account()
	{
		return $this->belongsTo('Account', 'Account_Id', 'Account_Id');
	}

	public function reviewedAccount()
	{
		return $this->belongsTo('Account', 'To_Review', 'Account_Id');
	}
}

?>