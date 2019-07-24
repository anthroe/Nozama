<?php
	
	class ticketController extends Controller
	{
		public function index()
		{
			// $_SESSION['accountID'] = 3;
			// $_SESSION['accountType'] = "admin";
			//$_POST['fillOutTicket'] = '';
			

			if(isset($_POST['viewTicket'])) // User wants to view a specific ticket
			{
				self::getTicket($_POST['viewTicket']); // Get a specific ticket
			}

			elseif(isset($_POST['ticketReply'])) // User submitted a reply to a ticket
			{
				self::replyToTicket($_POST);
			}

			// elseif(isset($_POST['assignTicket'])) // Admin wants to assign a ticket to an admin
			// {
			// 	self::assignTicket($_POST);
			// }

			elseif(isset($_POST['fillOutTicket'])) // User wants to submit a ticket
			{
				self::fillOutTicket($_SESSION['accountID']); // Display form for submitting a ticket
			}

			elseif(isset($_POST['submittedTicket'])) // User submitted a ticket
			{
				self::submitTicket($_POST); // Add ticket to database
			}

			elseif(isset($_POST['closeTicket'])) // User wants to close a ticket
			{
				self::closeTicket($_POST['closeTicket']);
			}

			else
			{
				self::showTickets($_SESSION['accountID'], $_SESSION['accountType']); // Get all relevant tickets associated to the user
			}
		}

		// Display a sepecifc ticket for a given Ticket_Id
		public function getTicket($ticketID)
		{
			home::displayHeader();

			$ticket = self::model('Ticket');
			$ticket = $ticket->find($ticketID); // Get the specified ticket

			$user = self::model('Account');
			$user = $user->find($ticket->Created_By); // Get the account of the user who submitted the ticket

			$replies = self::model('TicketReply');
			$replies = $replies->where('Ticket_Id', $ticketID)->get();

			self::view('tickets/viewTicket', [
			'ticketID' => $ticket->Ticket_Id,
			'subject' => $ticket->Subject,
			'message' => $ticket->Message,
			'status' => $ticket->Status,
			'createdBy' => $user->Username,
			'createdOn' => $ticket->Created_On,
			'closedOn' => $ticket->Closed_On,
			'replies' => $replies, 
			'createdByID' => $ticket->Created_By]);	
		}

		// Show the the relevant tickets associated with the current user
		public function showTickets($accountID, $accountType)
		{
			home::displayHeader();
			
			$tickets = self::model('Ticket');

			if($accountType == 0) // If user is an admin
			{
				$tickets = $tickets->where('Status', 'Open')->get();
			}

			else // regular user
			{
				$tickets = $tickets->where('Created_By', $accountID)->get();
			}

			self::view('tickets/ticketList', ['tickets' => $tickets]);
		}

		// // Assign a ticket to an admin
		// public function assignTicket($request)
		// {
		// 	$accountID = $request['accountID'];
		// 	$ticketID = $request['ticketID'];

		// 	$ticket = $ticket->find('Ticket_Id' $ticketID);
		// 	$ticket->Assigned_To = $accountID;
		// 	$ticket->save();
		// }

		// User submitted a reply to a ticket
		public function replyToTicket($request)
		{
			$ticketReply = self::model('TicketReply');
			$ticketReply->set(array_map('trim', $request));

			$ticketReply->Ticket_Id = $ticketReply->_ticketID;
			$ticketReply->Message = $ticketReply->_message;
			$ticketReply->Account_Id = $ticketReply->_accountID;
			$ticketReply->Date = $ticketReply->_date;
			$ticketReply->save();

			$createdBy = self::model('Ticket')->find($ticketReply->_ticketID)->Created_By;

			if($createdBy != $ticketReply->_accountID)
			{	
				// require_once '../app/controllers/notificationController.php';
				// $notificationController = new notificationController();
				notificationController::ticketReplyNotif($createdBy, $ticketReply->_accountID, $ticketReply->_ticketID);
			}

			self::getTicket($ticketReply->Ticket_Id);
		}

		// Display the ticket form 
		public function fillOutTicket($accountID)
		{
			home::displayHeader();

			self::view('tickets/ticketForm', ['accountID' => $accountID]);
		}

		// Add a submitted ticket to the database
		public function submitTicket($request)
		{
			$ticket = self::model('Ticket');
			$ticket->set(array_map('trim', $request));

			//if(isset($_POST['submittedTicket']))
			//{
				// Add the new ticket to the Ticket table
				$ticket->Subject = $ticket->_subject;
				$ticket->Message = $ticket->_message;
				$ticket->Status = $ticket->_status;
				$ticket->Created_By = $ticket->_createdBy;
				$ticket->Created_On = $ticket->_createdOn;
				$ticket->save();

				// require_once '../app/controllers/notificationController.php';
				// $notificationController = new notificationController();
				notificationController::submitTicketNotif($ticket->_createdBy, $ticket->Ticket_Id);

				// self::model('Notification')->submitTicketNotif($ticket->_createdBy, $ticket->Ticket_Id);

				// Redirect to the home page
				header('Location: '. '/public');
			//}
		}

		// Close a specific ticket with a given Ticket_Id
		public function closeTicket($ticketID)
		{
			$ticket = self::model('Ticket');
			$ticket = $ticket->find($ticketID);
			$ticket->Status = "Closed";
			$ticket->Closed_On = date("Y-m-d H:i:s");
			$ticket->save();

			// require_once '../app/controllers/notificationController.php';
			// $notificationController = new notificationController();
			notificationController::closeTicketNotif($_SESSION['accountID'], $ticketID);

			
			self::showTickets($_SESSION['accountID'], $_SESSION['accountType']);
		}	
	} 
?>