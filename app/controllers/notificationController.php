<?php
	
	class notificationController extends Controller
	{
		public function index()
		{	
			//var_dump($_POST);
			//$_POST['viewAllNotifications'] = '';
			//$_SESSION['accountID'] = 2;
			if(isset($_POST['viewAllNotifications']))
			{
				self::getAllNotifications($_SESSION['accountID']); // Display all notifications of a given users
			}

			if(isset($_POST['viewNotification']))
			{
				self::getNotification($_POST['viewNotification']); // Display a specific notification
			}

			if(isset($_POST['deleteNotification']))
			{	
				self::deleteNotification($_POST['deleteNotification']);
			}
		}

		// Retrieves a specific notification for a given Notification_Id
		public function getNotification($notificationID)
		{
			$notification = self::model('Notification');
			$notification = $notification->find($notificationID);

			if($notification->Read == 0) 
			{
				$notification->Read = 1;
				$notification->save();
			}
			
			home::displayHeader();

			self::view('notifications/viewNotification', [
				'notificationID' => $notification->Notification_Id,
				'subject' => $notification->Subject,
				'message' => $notification->Message,
				'recipient' => $notification->Recipient,
				'date' => $notification->Date,
				'read' => $notification->Read ]);
		}

		// Retrieves all notifications of a given user
		public function getAllNotifications($accountID)
		{
			$notifications = self::model('Notification');
			$notifications = $notifications->where('Recipient', $accountID)->orderBy('Date', 'desc')->get();

			home::displayHeader();

			self::view('notifications/notificationList', ['notifications' => $notifications]);
		}

		// Retrieves all unread notifications of a given user in the menu list
		public function showNotifications($accountID)
		{
			$notifications = self::model('Notification');
			$notifications = $notifications->where('Recipient', $accountID)->where('Read', 0)->orderBy('Date', 'desc')->get();

			self::view('notifications/notificationDropDown', ['notifications' => $notifications]);
		}

		// Adds a new notification to the databse
		public function addNotification($subject, $message, $accountID)
		{
			$notification = self::model('Notification');
			$notification->set($subject, $message, $accountID);

			$notification->Subject = $notification->_subject;
			$notification->Message = $notification->_message;
			$notification->Recipient = $notification->_recipient;
			$notification->Date = $notification->_date;
			$notification->Read = $notification->_read;
			$notification->save();
		}

		public function deleteNotification($notificationID)
		{	
			$notification = self::model('Notification');
			$notification = $notification->find($notificationID);
			$notification->delete();

			self::getAllNotifications($_SESSION['accountID']);
		}

		// Retrieves the username of a given account with a specic Account_Id
		public function getUsername($accountID)
		{
			$account = self::model('Account');
			$account = $account->find($accountID);

			return $account->Username;
		}

		// Sends a notification to a newly registered user
		public function registerNotif($accountID)
		{
			$username = self::getUsername($accountID);

			$subject = "Welcome to Nozama!";
			$message = "Hello $username,\n" .
					   "Congratulations, you have successfully registered to Nozama!";

			self::addNotification($subject, $message, $accountID);
		}

		// Sends a notification when user changes their email
		public function emailChangeNotif($accountID)
		{
			$username = self::getUsername($accountID);

			$subject = "Email Change Confirmation";
			$message = "Hello $username,\n" .
					   "You have updated your email address.";

			self::addNotification($subject, $message, $accountID);
		}

		// Sends a notification when user changes their password
		public function passwordChangeNotif($accountID)
		{
			$username = self::getUsername($accountID);

			$subject = "Password Change Confirmation";
			$message = "Hello $username,\n" .
					   "You have changed your password.";

			self::addNotification($subject, $message, $accountID);
		}

		// Sends a notification when user updates their profile
		public function editProfileNotif($accountID)
		{
			$username = self::getUsername($accountID);

			$subject = "Profile Information Updated";
			$message = "Hello $username,\n" .
					   "You have successfully updated you profile information.";

			self::addNotification($subject, $message, $accountID);
		}

		// Sends a notification when user updates their address
		public function editAddressNotif($accountID)
		{
			$username = self::getUsername($accountID);

			$subject = "Shipping Address Updated";
			$message = "Hello $username,\n" .
					   "You have updated your shipping address.";

			self::addNotification($subject, $message, $accountID);
		}

		// Sends a notification when user adds an address
		public function addAddressNotif($accountID)
		{
			$username = self::getUsername($accountID);

			$subject = "Added New Shipping Address";
			$message = "Hello $username,\n" .
					   "You have added a new shipping address.";

			self::addNotification($subject, $message, $accountID);
		}
 		
 		// Sends a notification when user edits their payment method
 		public function editPaymentNotif($accountID)
 		{
 			$username = self::getUsername($accountID);

 			$subject = "Payment Method Updated";
			$message = "Hello $username,\n" .
					   "You have updated a payment method.";

			self::addNotification($subject, $message, $accountID);
 		}

 		// Sends a notification when user adds a payment method
 		public function addPaymentNotif($accountID)
 		{
 			$username = self::getUsername($accountID);

 			$subject = "Added New Payment Method";
			$message = "Hello $username,\n" .
					   "You have added a new payment method.";

			self::addNotification($subject, $message, $accountID);
 		}

 		// Sends a notification when a user's listing runs out of stock.
 		public function sellStockNotif($accountID, $listingName, $listingID)
 		{
 			$username = self::getUsername($accountID);

 			$subject = "Your listing $listingID has sold out.";
			$message = "Hello $username,\n" .
					   "$listingName is out of stock.";

			self::addNotification($subject, $message, $accountID);
 		}

 		// Sends a notification  when an item in user's wishlist or cart runs out of stock
 		public function buyStockNotif($accountID, $listingName, $listingID)
 		{
 			$username = self::getUsername($accountID);

 			$subject = "$listingID is no longer available.";
			$message = "Hello $username,\n" .
					   "$listingName is out of stock.";

			self::addNotification($subject, $message, $accountID);
 		}

 		// Sends a notification when user makes an order
 		public function purchaseNotif($accountID, $orderNumber, $listings)
 		{
 			$username = self::getUsername($accountID);

 			$subject = "Order $orderNumber Confirmation";
			$message = "Hello $username,\n" .
					   "Congratulations, you have purchased: ";
					   for ($index = 0; $index < $listings->count() ; $index++) 
					   { 
					   		$message = $message + $listings[index]->Title + "\n"; 
					   }

			self::addNotification($subject, $message, $accountID);
 		}

 		// Sends a notification when user posts a listing
 		public function addListingNotif($accountID, $listingID, $listingName)
 		{
 			$username = self::getUsername($accountID);

 			$subject = "Listing $listingID Post Confirmation";
			$message = "Hello $username,\n" .
					   "You have successfully posted your listing: $listingName.";

			self::addNotification($subject, $message, $accountID);
 		}

 		// Sends a notification when user's listing has been sold
 		public function soldNotif($accountID, $listingName, $listingID, $buyerUsername)
 		{
 			$username = self::getUsername($accountID);

 			$subject = "Listing: $listingID has been sold";
			$message = "Hello $username,\n" .
					   "$buyerUsername has purchased $listingName.";

			self::addNotification($subject, $message, $accountID);
 		}

 		// Sends a notification when user updates their listing
 		public function listingEditNotif($accountID, $listingID, $listingName)
 		{
 			$username = self::getUsername($accountID);

 			$subject = "Listing:$listingID Updated";
			$message = "Hello $username,\n" .
					   "$listingName has been updated.";

			self::addNotification($subject, $message, $accountID);
 		}

 		// Sends a notification when user receives a review for their listing
 		public function listingReviewNotif($accountID, $listingID, $listingName, $reviewer)
 		{
 			$username = self::getUsername($accountID);

 			$subject = "You have receive a review for listing $listingID";
			$message = "Hello $username,\n" .
					   "$reviewer has left a review for $listingName.";

			self::addNotification($subject, $message, $accountID);
 		}

 		// Sends a notification when user receives feedback
 		public function userFeedbackNotif($accountID, $reviewer)
 		{
 			$username = self::getUsername($accountID);

 			$subject = "Someone has left you feedback";
			$message = "Hello $username,\n" .
					   "$reviewer has left you feedback";

			self::addNotification($subject, $message, $accountID);
 		}

 		// Sends a notifcation when user submits a report
 		public function reportNotif($accountID)
 		{
 			$username = self::getUsername($accountID);

 			$subject = "You have submitted a report";
			$message = "Hello $username,\n" .
					   "Thank you for reporting, our administrators will take the necessary steps to address the issue.";

			self::addNotification($subject, $message, $accountID);
 		}

 		// Sends a notification when user submits a ticket
 		public function submitTicketNotif($accountID, $ticketID)
 		{
 			$username = self::getUsername($accountID);

 			$subject = "You opened a ticket";
			$message = "Hello $username,\n" .
					   "You have opened ticket #$ticketID. Our administrators will assist you as soon as possible.";

			self::addNotification($subject, $message, $accountID);
 		}

 		// Sends a notification when a user's ticket has been replied
 		public function ticketReplyNotif($accountID, $admin, $ticketID)
 		{
 			$username = self::getUsername($accountID);
 			$replier = self::getUsername($admin);

 			$subject = "Ticket #$ticketID Reply";
			$message = "Hello $username,\n" .
					   "$replier has replied to your ticket.";

			self::addNotification($subject, $message, $accountID);
		}

		// Sends a notification when a user closes their ticket
		public function closeTicketNotif($accountID, $ticketID)
 		{
 			$username = self::getUsername($accountID);

 			$subject = "You have closed ticket #$ticketID";
			$message = "Hello $username,\n" .
					   "your ticket #$ticketID has been closed.";

			self::addNotification($subject, $message, $accountID);
		}

		// Sends a notification when a user's order has been cancelled
		public function cancelOrderNotif($accountID, $orderNumber, $listingID, $listingName)
 		{
 			$username = self::getUsername($accountID);

 			$subject = "Your order #$orderNumber has been cancelled";
			$message = "Hello $username,\n" .
					   "Unfortunately, we had to cancel your order of $listingName. We deeply apoligize for the inconvience and a refund will be made to the card you've used to checkout.";

			self::addNotification($subject, $message, $accountID);
		}

		// Sends a notification when a user's listing has been deleted
		public function listingDeleteNotif($accountID, $listingID, $listingName)
 		{
 			$username = self::getUsername($accountID);

 			$subject = "Your listing #$listingID has been taken down";
			$message = "Hello $username,\n" .
					   "We would like to inform you that your listing $listingName has been taken down for violating out terms of service. If you have any questions, please submit a ticket and we will assist you to the best of our ability.";

			self::addNotification($subject, $message, $accountID);
		}

		// Sends a notification when a user's review has been deleted
		public function reviewDeleteNotif($accountID)
 		{
 			$username = self::getUsername($accountID);

 			$subject = "Your review of has been taken down";
			$message = "Hello $username,\n" .
					   "Your review has been deemed inappropriate, thus being taken down.";

			self::addNotification($subject, $message, $accountID);
		}

		// Sends a notification when a user's anonymous cart item could not be transferred due to understock
		public function couldNotTransferNotif($accountID, $optionID)
 		{
 			$username = self::getUsername($accountID);
 			
 			$listingOption = ListingOptions::find($optionID);
 			$listing = $listingOption->listing;

 			$subject = "Could not transfer cart item $listing->Title";
			$message = "Hello $username,\n" .
					   "The cart item $listing->Title could not be transferred to your shopping cart due to understock.";

			self::addNotification($subject, $message, $accountID);
		}
	}

?>