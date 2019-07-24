<?php
	/* 
		ADD REPLIES  & VIEW
	*/

	$ticketID = $data['ticketID'];
	$subject = $data['subject'];
	$message = $data['message'];
	$status = $data['status'];
	$createdBy = $data['createdBy'];
	$createdOn = $data['createdOn'];
	$closedOn = $data['closedOn'];
	$accountID = $_SESSION['accountID'];
	$createdByID = $data['createdByID'];


?>

<html>
<head>
	<title>Nozama | Ticket #<?= $ticketID ?></title>
</head>
<body>
	<div>
		Ticket ID: <?= $ticketID ?> <br>
		Subject: <?= htmlentities($subject) ?> <br>
		Message: <?= htmlentities($message) ?> <br>
		Status: <?= $status ?> <br>
		Submitted By: <a href="/public/profileController/viewProfile/<?= $createdByID ?>" target="_blank"><?= $createdBy ?></a> <br>
		Submitted On: <?= $createdOn ?> <br>

	<?php

		for($index = 0; $index < $data['replies']->count(); $index++)
		{
			$reply = $data['replies']->get($index);

			$user = $this->model('Account');
			$user = $user->find($reply->Account_Id);

			echo 	"<br>" .
					"<div>" .
					"<a href='/public/profileController/viewProfile/$reply->Account_Id' target='_blank'>" . 
					$user->Username . "</a>" . "<br>" .
					$reply->Date . "<br>" .
					$reply->Message .
				 "</div>" . 
				 "<br>";
		}


		if(isset($closedOn)) // If Status of ticket is closed
		{
			echo "Closed On: $closedOn <br>";
		}

		else // Status of ticket is open
		{	
			// Display the reply text area
			echo "<form method='post' action='/public/ticketController'>" .
					"<textarea rows='5' name='message' required='true'></textarea>" . 
					"<br>" .
					"<input type='hidden' name='accountID' value='$accountID'>" .
					"<input type='hidden' name='ticketID' value='$ticketID'>" .
					"<input class='btn btn-primary' type='submit' name='ticketReply' value='Reply'>" .
				 "</form>";

			if($_SESSION['accountType'] == 1) // If current user is a customer
			{
				echo "<form method='post' action='/public/ticketController'>" .
				 	 	"<input type='hidden' name='closeTicket' value='$ticketID'>" .
					 	"<input class='btn btn-warning' type='submit' value='Close this ticket'>" .
				 	 "</form>";
			}		
		}
	?>	

	<a class="btn btn-default" href="/public/ticketController">Return to the list of tickets</a>
	</div>
</body>
</html>