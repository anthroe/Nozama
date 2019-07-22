<?php
$listing = $this->model('Listing');
$address = $this->model('Address');
$currentAddress = null;
$total=0;
	 for($index = 0; $index < count($data['itemOrders']); $index++)
	 	{
			
       		// $listing = $listing->find($data['cart']->get($index)->Option_Id);
      		
//$total = $total + (($data['itemOrders']->get($index)->Price) * ($data['cart']->get($index)->Quantity));

      	}
?>

<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src='https://js.stripe.com/v2/' type='text/javascript'></script>
</head>
<div class="jumbotron text-center">
	<body>
	<form method="POST" action="/nozama/public/checkoutController/placeOrder">

		
		<div>
			<h1>Review your order</h1>
		</div>
		<br />
		<div style="border:1.8px groove black;position:relative;">			
				</br>
				Select your shipping address:</br>	
				

				<select id="addressList" name="addressList" class="btn btn-primary dropdown-toggle">
					<?php
					//display the user's saved addresses
						for($index = 0; $index < $data['address']->count(); $index++){
							echo "<option value='".$data['address']->get($index)->Address_Id."'>". 
								$data['address']->get($index)->Address_Line_1. "/ " .
								$data['address']->get($index)->Address_Line_2. " - " .
								$data['address']->get($index)->Zip_Postal_Code. " " .
								$data['address']->get($index)->City . " " .
								$data['address']->get($index)->State_Province . ", " .
								$data['address']->get($index)->Country .
							"</option>";
							#$currentAddress =$data['address']->get($index)->City;
						}
						$currentAddress = $_POST['addressList'];
				?>	
				</select>
					</br></br>			
		</div>
		<br />
		<div style="border:1.8px groove black;position:relative;" align="center">
			<h2>Item Summary:</h2>
				
				<?php
				$listing = $this->model('Listing');
				$username = $this->model('Account');
				//$listing = $this->model('Listing');
				//display all items that user had in their cart
					for($index = 0; $index < count($data['itemOrders']); $index++)
					{
					//var_dump($data['itemOrders'][$index]);
						$listing = $listing->find(ListingOptions::find($data['itemOrders'][$index]->Option_Id)->Listing_Id);
					//	var_dump($listing);
			      		$sellerName = null;
			      		#$listing = $listing->find($data['itemOrders']->get($index)->Option_Id);
			            $sellerId = $listing->Seller;          
			           
			            $sellerName = $username->find($sellerId);
						
						
						echo "<div style='	padding: 10px;	margin: 20px;	background: #F0F8FF;	border: 5px solid #ccc;	width: 400px;	width: 370px;'>".  
			                "<b>$listing->Title </b></br> &nbsp;&nbsp;&nbsp; <i>from ".$sellerName->Username." </i></br>".		                   
							"$$listing->Price </br>Quantity: ".$data['itemOrders'][$index]->Quantity."</br>".
							"</div>"
			           		;		
						$total = $total + ($data['itemOrders'][$index]->Quantity * $listing->Price);			
			         }						
					 

				?>

				
		</div>

		<br />
	
		<div style="border:1.8px groove black;position:relative;">
		</br>Select a payment method from your saved payment methods: </br>
			<select id="paymentList" name="paymentList" class="btn btn-primary dropdown-toggle">
			<?php
			
			//display user's payment saved methods from the payment table
				for($index = 0; $index < $data['paymentMethod']->count(); $index++){
					echo "<option value='".$data['paymentMethod']->get($index)->Payment_Id."'>". 
						$data['paymentMethod']->get($index)->Card_Type. ": "; 
						echo substr_replace($data['paymentMethod']->get($index)->Card_Number,"*********",0,9) . 				
					"</option>";
					#$currentAddress =$data['address']->get($index)->City;
				}
						#$currentPayment = $_POST['paymentList'];
						
						?>
						</select>
				</br>
						
			</br></br>Select a shipping method:
			</br>
			<select id="shippingList" name="shippingList" class="btn btn-primary dropdown-toggle">
				<option value="1 Day Shipping" >1 Day Shipping - Receive your item in 1 working day of ordering </option>
				<option value="Priority Shipping" >Priority Shipping - Receive your item within a week of ordering </option>
				<option value="Free Shipping" >Free Shipping - Receive your item within 4 - 6 weeks of ordering </option>
			</select>
			
			<h2>Order total:
				$<?php 

				//calculated total from all items
				echo $total;		

				?>
			</h2>
				
	
		</div>
		<!--<form method="POST" action="/nozama/public/checkoutController/placeOrder" >-->
		<div class='form-row'>
              <div class='col-md-12 form-group'>
                </br><input type="submit" value="Place Order  »" class="btn btn-info"  name="orderPress" id="orderPress">
              </div>
            </div>
		
	</form>
	</div>
</body>
</html>
