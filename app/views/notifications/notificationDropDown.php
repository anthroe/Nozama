<!-- *** PLEASE ADD THIS TO THE HEAD OF THE VIEW ***
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
-->

<!-- Might have to change button class to nav depending on BS theme-->

<?php
	$numberOfNotifications = $data['notifications']->count();
?>

<button type="button" class="danger btn btn-primary navbar-btn form-control" data-toggle="popover" data-placement="bottom" title="Your Notifications" >
      <span class="glyphicon glyphicon-envelope"></span>
      <span class="badge"><?=$numberOfNotifications?></span>
</button>
<div id="notifications" style="display: none">
	<ul class="list-group">
	<?php

		if($numberOfNotifications > 5)
		{
			$numberOfNotificationsToDisplay = 5;
		}

		else
		{
			$numberOfNotificationsToDisplay = $numberOfNotifications;
		}

		for ($index = 0; $index < $numberOfNotificationsToDisplay; $index++)
			{ 
				$notification = $data['notifications']->get($index);

				if($notification->Read != 0)
				{
					echo "<li class='list-group-item disabled'>" .
        			 "<a href='/Nozama/public/notificationController/getNotification/$notification->Notification_Id'>$notification->Subject</a>" .
        			 "</li>";
				}

				else
				{
					echo "<li class='list-group-item'>" .
	    			 "<a href='/Nozama/public/notificationController/getNotification/$notification->Notification_Id'>$notification->Subject</a>" .
	    			 "</li>";
        		}
			}
 	?>
 	</ul>



 		
 		<form method="post" action='/Nozama/public/notificationController'>
 			<input type="submit" name="viewAllNotifications" class="btn btn-default form-control" value="See All Notifications">
 		</form>
 

 	<script>
		$(document).ready(function(){
		  $('.danger').popover({ 
		    html : true,
		    content: function() {
		      return $('#notifications').html();
		    }
		  });
		});
	</script>

</div>