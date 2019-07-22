<?php
	
	use Illuminate\Database\Eloquent\Model as Eloquent;

	class TicketReply extends Eloquent
	{
		public $timestamps = false;

		protected $table = 'ticket_reply';
		protected $primaryKey = 'Reply_Id';

		protected $fillable = ['Reply_Id'];
		protected $guarded = ['Ticket_Id', 'Message', 'Account_Id'];

		public $_replyID;
		public $_ticketID;
		public $_message;
		public $_accountID;
		public $_date;

		// Sets its properties based on the given request object's values
		public function set($request)
		{
			if(isset($request['ticketID']))
				$this->_ticketID = $request['ticketID'];

			if(isset($request['message']))
				$this->_message = $request['message'];

			if(isset($request['accountID']))
				$this->_accountID = $request['accountID'];

			$this->_date = date("Y-m-d H:i:s");
		}
	}
?>