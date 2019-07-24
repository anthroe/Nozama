<html>
<head>
	<title>Nozama | Sales List</title>
	<div class="container">
		<div class="row col-md-6">
	<h1>My Sales</h1>
	</div>
</div>
</head>
<body>
<div class="container">
	<div class="row">
		<table class="table table-striped col-md-6">
			<tr>
				<th>Order ID</th>
				<th>Buyer</th>
				<th>Item</th>
				<th>Quantity</th>
				<th>Order Total</th>
				<th>Purchased On</th>
				<th>Order Status</th>
				<th>View Details</th>
			</tr>

			<?php
				foreach($data['sales'] as $order)
				{	
					$listingOptions = $this->model('ListingOptions')->find($order->Option_Id);

					$listing = $this->model('Listing')->find($listingOptions->Listing_Id);

					$account = $this->model('Account')->find($order->Account_Id);

					echo "<tr>" . 
						 "<td>$order->Order_Id</td>" .
						 "<td>$account->Username</td>" .
						 "<td>$listing->Title</td>" .
						 "<td>$order->Quantity</td>" .
						 "<td>$order->Total</td>" .
						 "<td>$order->Date</td>" .
						 "<td>$order->Status</td>" .
						 "<td>" .
						 "<form method='post' action='/public/orderController'>" . 
						 	"<input type='hidden' name='viewOrder' value='$order->Order_Id'>" .
						 	"<input type='submit' value='View Order' class='btn btn-info'>" .
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