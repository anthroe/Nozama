<?php
	
	use Illuminate\Database\Eloquent\Model as Eloquent;

	class Report extends Eloquent
	{

		public $timestamps = false;

		protected $table = 'report';
		protected $primaryKey = 'Report_Id';

		protected $fillable = ['Report_Id'];
		protected $guarded = ['Category', 'Subject', 'Comment', 'Account_Id', 'Listing_Id', 'Submitted_On'];

		public $_reportID;
		public $_category;
		public $_subject;
		public $_comment;
		public $_accountID;
		public $_listingID;
		public $_submittedOn;

		// Sets its properties based on the given request object's values
		public function set($request)
		{
			// if(isset($request['reportID']))
			// 	$this->_reportID = $request['reportID'];

			if(isset($request['category']))
				$this->_category = $request['category'];

			if(isset($request['subject']))
				$this->_subject = $request['subject'];

			if(isset($request['comment']))
				$this->_comment = $request['comment'];

			if(isset($request['accountID']))
				$this->_accountID = $request['accountID'];

			if(empty($request['listingID']))
			 	$this->_listingID = null;

			else
				$this->_listingID = $request['listingID'];

			$this->_submittedOn = date("Y-m-d H:i:s");
		}
	}
?>