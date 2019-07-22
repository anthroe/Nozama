<?php
	use Illuminate\Database\Eloquent\Model as Eloquent;

	class Notification extends Eloquent
	{
		public $timestamps = false;

		protected $table = 'notification';
		protected $primaryKey = 'Notification_Id';

		protected $fillable = ['Notification_Id'];
		protected $guarded = ['Subject', 'Message', 'Recipient', 'Date', 'Read'];

		public $_notificationID;
		public $_subject;
		public $_message;
		public $_recipient;
		public $_date;
		public $_read;

		// Sets its properties based on the given request object's values
		public function set($subject, $message, $recipient)
		{
			$this->_subject = $subject;

			$this->_message = $message;

			$this->_recipient = $recipient;

			$this->_date = date("Y-m-d H:i:s");

			$this->_read = 0;
		}
	}
?>