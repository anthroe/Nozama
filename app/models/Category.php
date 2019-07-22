<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Category extends Eloquent
{
	public $timestamps = false;

	protected $table = 'category';
	protected $primaryKey = 'Category_Id';

	protected $fillable = ['Category_Id'];
	protected $guarded = ['Category_Name'];

	// FOREIGN KEY RELATIONSHIPS

	public function listing()
	{
		return $this->hasMany('Listing', 'Category_Id', 'Category_Id');
	}
}

?>