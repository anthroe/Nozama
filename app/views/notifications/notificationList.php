<html>
<head>
	<title>Nozama | My Notifications</title>
	<div class="container">
		<div class="row col-md-6">
			<h1>My Notifications</h1>
		</div>
	</div>
</head>
<body>
<div class="container">
	<div class="row">
		<table class="table table-striped col-md-6">
			<tr>
				<th>Subject</th>
				<th>Date</th>
				<th>Status</th>
				<th>View Details</th>
				<th>Delete</th>
			</tr>
			<tr>
				<?php
					for($index = 0; $index < $data['notifications']->count(); $index++)
					{
						$notifications = $data['notifications']->get($index);
						
						if($notifications->Read == 0)
						{
							$status = "Unread";
						}

						else
						{
							$status = "Read";
						}

						echo "<tr>" . 
							 "<td>$notifications->Subject</td>" .
							 "<td>$notifications->Date</td>" .
							 "<td>$status</td>" .
							 "<td>" .
							 "<form method='post' action='/public/notificationController'>" . 
							 	"<input type='hidden' name='viewNotification' value='$notifications->Notification_Id'>" .
							 	"<input type='submit' value='View Notification' class='btn btn-info'>" .
							 "</form>" .
							 "</td>" .
							 "<td>" .
							 "<form method='post' action='/public/notificationController'>" . 
							 	"<input type='hidden' name='deleteNotification' value='$notifications->Notification_Id'>" .
							 	"<input type='submit' value='Delete' class='btn btn-danger'>" .
							 	"</form>" .
							 "</td>" .
							 "</tr>"; 
					}
				?>
			</tr>
		</table>
	</div>
</div>
</body>
</html>