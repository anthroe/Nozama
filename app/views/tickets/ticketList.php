
<html>
<head>
	<?php
		if(strcasecmp($_SESSION['accountType'], "admin") == 0) // If current user is an admin
		{
			echo "<title>Nozama | Ticket List</title>" .
				 "<div class='container'>" .
				 "<div class='row col-md-6'>" .
				 "<h1>Ticket List</h1>" .
				 "</div>" . 
				 "</div";
		}

		else
		{
			echo "<title>Nozama | My Tickets</title>" .
				 "<div class='container'>" .
				 "<div class='row col-md-6'>" .
				 "<h1>My Tickets</h1>" .
				 "</div>" . 
				 "</div";
		}
	?>
</head>
<body>
<div class="container">
	<div class="row">
		<table class="table table-striped col-md-6">
			<tr>
				<th>Ticket ID</th>
				<th>Subject</th>
				<th>Status</th>
				<th>Created On</th>
				<th>View Details</th>
			</tr>

			<?php

				for($index = 0; $index < $data['tickets']->count(); $index++)
				{
					$ticket = $data['tickets']->get($index);
					
					echo "<tr>" . 
						 "<td>$ticket->Ticket_Id</td>" .
						 "<td>$ticket->Subject</td>" .
						 "<td>$ticket->Status</td>" .
						 "<td>$ticket->Created_On</td>" .
						 "<td>" .
						 "<form method='post' action='/public/ticketController'>" . 
						 	"<input type='hidden' name='viewTicket' value='$ticket->Ticket_Id'>" .
						 	"<input class='btn btn-info' type='submit' value='View Ticket'>" .
						 "</form>" .
						 "</td>" .
						 "</tr>";
				}
			
			?>

		</table>
	</div>
</div>
</body>
</html>