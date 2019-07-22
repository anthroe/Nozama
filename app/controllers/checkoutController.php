<?php

class checkoutController extends Controller {
	
	public function index() {
		
		
		#if(isset($_SESSION['username'])){
			self::viewOrder();
		#}
	if(isset($_POST['orderPress'])){
		
		placeOrder();
		
	}
	}
	
public function viewOrder(){
	
		$itemOrders = array();

		$carts = self::model('Shopping_Cart');
		$listing = self::model('Listing');
		$paymentMethod = self::model('PaymentMethod');
		$address = self::model('Address');
		$listingOption = self::model('ListingOptions');
		$listingOptionCounter = self::model('ListingOptions');

		$address = $address->where('Account_Id',$_SESSION['accountID'])->get();

		$paymentMethod = $paymentMethod->where('Account_Id',$_SESSION['accountID'])->get();
		
		//get user's cart
		$carts = $carts->where('Account_Id',$_SESSION['accountID'])->get();

		//get each option in the cart
		foreach($carts as $cart)
		{	
			$listingOption = $cart->where('Option_Id', $cart->Option_Id)->get();
			
			foreach($listingOption as $options)
			{
				array_push($itemOrders, $options);
			}
		}
		

		self::view('shoppingCart/checkout',[

			'cart' => $cart,
			'listing' => $listing,
			'address' => $address,
			'paymentMethod' => $paymentMethod,
			'itemOrders' => $itemOrders,
		]);

	}


	public function placeOrder(){
		
		$accountTable = self::model('Account');
		$cartTable = self::model('Shopping_Cart');
		$paymentTable = self::model('PaymentMethod');
		$listingTable = self::model('Listing')->find($cartTable->Listing_Id);
		$listing = self::model('Listing');
		$listingOptionItem = self::model('ListingOptions');
		$cart = $cartTable->where('Account_Id',$_SESSION['accountID'])->get();


		$itemOrders = array();
		$listingArray =array();
		foreach($cart as $cartItem)
		{	
			$listingOption = $cartItem->where('Option_Id', $cartItem->Option_Id)
									  ->where('Account_Id', $_SESSION['accountID'])->get();
			
			foreach($listingOption as $options)
			{
				array_push($itemOrders, $options);
			}
		}


		if(isset($_POST['addressList']) && isset($_POST['paymentList']) && isset($_POST['orderPress']) && count($itemOrders) != 0) {
			
			//place every cart item as an order
			for($index = 0; $index < count($itemOrders); $index++)
			{	

				$listingOptionItem = $listingOptionItem->find($itemOrders[$index]->Option_Id);
				 var_dump($itemOrders[$index]->Option_Id); echo $index;
				$listing= $listing->find($listingOptionItem->Listing_Id);
				array_push($listingArray, $listing);
				$sellerName = null;	      		
	            $sellerId = $listing->Seller;  
	            $listingStock = $listing->Stock;
			    $sellerName = $accountTable->find($sellerId);
			    
			    # *******************************
				# **********BUY AN ITEM**********
				# *******************************
				$orderTable = $this->model('Order');
				$orderTable->Account_Id = $cart->get($index)->Account_Id;
				$orderTable->Option_Id = $itemOrders[$index]->Option_Id;
				$orderTable->Quantity = $cart->get($index)->Quantity;
				$orderTable->Total = (($itemOrders[$index]->Quantity) * ($listing->Price));
				$orderTable->Address_Id = $_POST['addressList'];
				$orderTable->Shipping_Method = $_POST['shippingList'];
				$orderTable->Payment_Id = $_POST['paymentList'];
				$orderTable->Status = 'Open';
				$orderTable -> save();

				
				/*
				//notify buyer about their purchase
				$orderSearch = $orderTable->find($itemOrders[$index]->Option_Id);
				$orderId = $orderTable->find($orderSearch->OrderId);
				$order = $orderTable->find($OrderId);
				$buyerId = $order->Account_Id;
				$buyerAccount = self::model('Account');
				$buyerAccount = $buyerAccount->find($buyerId);
				$buyerUsername =$buyerAccount->Username;

				//notify seller that an item has been sold
			
				notificationController::soldNotif(
					$sellerName,
					$listing->Title,
					$cart->get($index)->Listing_Id,
					$buyerUsername);
			
				*/


				//recalculate listing stock
				$listing->Stock = ($listing->Stock) - ($cart->get($index)->Quantity); 
				$listing->save();
				//recalculate listing options stock
				$listingOptionItem->Stock = ($listingOptionItem->Stock) - ($cart->get($index)->Quantity); 
				$listingOptionItem->save();

				//remove items from cart after making the order
				$cartTable = $cart->find($cart->get($index)->Cart_Id);
				$cartTable = $cartTable->delete();

/*
				notificationController::purchaseNotif(
					$cart->get($index)->Account_Id,
					$orderTable->get($index)->Order_Id,
					$listingArray);
			*/
				
				/*
				
				//notifies user if stock has depleted
				if($listing->Stock <= 0){
					notificationController::sellStockNotif(
					$sellerId,
					$listing->Title,
					$cart->get($index)->Listing_Id);
					}
				*/	
				
}

				
				
			
		
			echo '<script>alert("You have successfully placed your order")</script>';	

			// Redirect to the home page
			header('Location: '. '/Nozama/public/orderController/orderController/getSales/' .  $_SESSION['accountID']);
		}else{
			
		header('Location: '. '/Nozama/public/cartController/');

	}

		
	}
}

?>