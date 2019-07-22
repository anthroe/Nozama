<?php
	use Illuminate\Database\Eloquent\Model as Eloquent;

	class Ticket extends Eloquent
	{
		public $timestamps = false;

		protected $table = 'ticket';
		protected $primaryKey = 'Ticket_Id';

		protected $fillable = ['Ticket_Id'];
		protected $guarded = ['Subject', 'Message', 'Status', 'Created_By', 'Created_On', 'Closed_On'];

		public $_ticketID;
		public $_subject;
		public $_message;
		public $_status;
		public $_createdBy;
		public $_createdOn;
		public $_closedOn;

		// Sets its properties based on the given request object's values
		public function set($request)
		{
			if(isset($request['subject']))
				$this->_subject = $request['subject'];

			if(isset($request['message']))
				$this->_message = $request['message'];

			if(isset($request['createdBy']))
				$this->_createdBy = $request['createdBy'];

			$this->_createdOn = date("Y-m-d H:i:s");

			$this->_status = "Open";
		}
	}
?>