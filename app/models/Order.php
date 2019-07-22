<?php
	use Illuminate\Database\Eloquent\Model as Eloquent;

	class Order extends Eloquent
	{
		public $timestamps = false;

		protected $table = 'order';
		protected $primaryKey = 'Order_Id';

		protected $fillable = ['Order_Id'];
		protected $guarded = ['Account_Id', 'Option_Id', 'Quantity', 'Total', 'Date', 'Address_Id', 'Shipping_Method', 'Payment_Id', 'Status'];

	}
?>