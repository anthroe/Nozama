<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class ListingOptions extends Eloquent
{
	public $timestamps = false;

	protected $table = 'listing_options';
	protected $primaryKey = 'Option_Id';

	protected $fillable = ['Option_Id'];
	protected $guarded = ['Listing_Id', 'Image', 'Color', 'Size', 'Stock'];

	public $_image;
	public $_color;
	public $_size;
	public $_stock;

	// Sets its properties based on the given request object's values stored in arrays and an index
	public function setFromArray($request, $index)
	 {
		if(isset($request['image']['tmp_name'][$index]))
			$this->_image = file_get_contents($request['image']['tmp_name'][$index]);

		if(isset($request['color'][$index]))
		{
			$color = trim($request['color'][$index]);
			$this->_color = $color === '' ? NULL : $color; // Turn empty string into null
		}

		if(isset($request['size'][$index]))
		{
			$size = trim($request['size'][$index]);
			$this->_size = $size === '' ? NULL : $size; // Turn empty string into null
		}

		if(isset($request['stock'][$index]))
			$this->_stock = trim($request['stock'][$index]);
	}

	// FOREIGN KEY RELATIONSHIPS

	public function listing()
	{
		return $this->belongsTo('Listing', 'Listing_Id', 'Listing_Id');
	}

	public function wishlist()
	{
		return $this->hasMany('Wishlist', 'Option_Id', 'Option_Id');
	}
}

?>