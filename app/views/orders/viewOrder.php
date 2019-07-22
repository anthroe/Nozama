<?php 
	
	$orderID = $data['orderID'];
	$accountID = $data['accountID'];
	$optionID = $data['optionID'];
	$quantity = $data['quantity'];
	$total = $data['total'];
	$date = $data['date'];
	$addressID = $data['addressID'];
	$shippingMethod = $data['shippingMethod'];
	$paymentID = $data['paymentID'];
	$status = $data['status'];
	$username = $data['username'];
	$name = $data['name'];
	$addressLine1 = $data['addressLine1'];
	$addressLine2 = $data['addressLine2'];
	$city = $data['city'];
	$stateProvince = $data['stateProvince'];
	$zipPostalCode = $data['zipPostalCode'];
	$country = $data['country'];
	$cardNumber = "****" . substr($data['cardNumber'], -4);
	$cardType = $data['cardType'];
	$listingID = $data['listingID'];
	$image = $data['image'];
	$color = $data['color'];
	$size = $data['size'];
	$title = $data['title'];
	$description = $data['description'];
	$price = $data['price'];
	$sellerID = $data['sellerID'];
	$seller = $data['seller'];

?>

<html>
<head>
	<title>Nozama | Order #<?= $orderID ?></title>
	<h1>Order Details</h1>
</head>
<body>
	<div>
		Order ID: <?=$orderID?> <br>
		Ordered On: <?=$date?> <br>
		Total: <?=$total?> <br>
		Status: <?=$status?> <br>

		<?php
			if($_SESSION['accountID'] != $accountID)
			{
				echo "Purchased By: <a href='/nozama/public/profileController/viewProfile/$accountID' target='_blank'>$username</a> <br>";
			}  
		?>

		<br>
	</div>
	<div>
		<br>
		<?php
			if(isset($image))
			{
				echo '<img height="300" width="300" src="data:image/jpeg;base64,' . base64_encode($image) . '"/>' . "<br>";
			} 
		?>

		Item: <a href="/nozama/public/listingController/viewDetails/<?=$listingID?>" target="_blank"><?=$title?></a> <br>

		<?php
			if(isset($color))
			{
				echo "Color: " . $color . "<br>";
			}

			if(isset($size)) 
			{
				echo "Size: " . $size . "<br>";
			}
		?>

		Price: <?=$price?> <br>
		Quantity: <?=$quantity?> <br>
		Seller: <a href="/nozama/public/profileController/viewProfile/<?=$sellerID?>" target="_blank"><?=$seller?></a> <br>
		<br>
	</div>
	<div>
		<br>
		Shipping Method: <?=$shippingMethod?> <br> <br>
		Shipping Address: <br>

		<?php
			$street = $addressLine1 . "<br>";

			if(!empty($addressLine2))
			{
				$street = $street . $addressLine2 . "<br>";
			}

			echo $name . "<br>" .
				$street .
				$city . ", " . $stateProvince . " " . $zipPostalCode . "<br>" . 
				$country;  
		?>

		<br>
	</div>
	<div>
		<br>
		Payment Method: <br>
		<?=$cardType?> &nbsp; <?=$cardNumber?>
	</div>

	<br>

		<?php
			if((strcasecmp($status, "Cancelled") != 0 && strcasecmp($status, "Shipped") != 0 && strcasecmp($status, "Delivered") != 0) && ($_SESSION['accountType'] == 0 || $_SESSION['accountID'] == $sellerID)) 
			{
				echo "<form method='post' action='/nozama/public/orderController'>" .
				 	 	"<input type='hidden' name='cancelOrder' value='$orderID'>" .
					 	"<input class='btn btn-danger' type='submit' value='Cancel Order'>" .
				 	 "</form>";
			}

			//if(strcasecmp($_SESSION['accountType'], "admin") != 0 && $_SESSION['accountID'] != $accountID && $_SESSION['accountID'] != $sellerID )
			//{	

				else if($_SESSION['accountID'] == $accountID)
				{
					echo "<br> <a class='btn btn-default' href='/nozama/public/orderController/getAllOrders/$accountID'> Return to your list of orders</a>";
				}

				else if($_SESSION['accountID'] == $sellerID)
				{
					echo "<br> <a class'btn btn-default' href='/nozama/public/orderController/getSales/$sellerID'> Return to your list of sales</a>";
				}

			//}
		?>

</body>
</html>