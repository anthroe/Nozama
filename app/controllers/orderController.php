<?php
	
	class orderController extends Controller
	{
		public function index()
		{
			//$_SESSION['accountID'] = 3;
			//$_SESSION['accountType'] = 'admin';
			//$_POST['viewSales'] = '';

			if(isset($_POST['viewOrder']))
			{
				self::getOrder($_POST['viewOrder']);
			}

			elseif(isset($_POST['cancelOrder'])) 
			{
				self::cancelOrder($_POST['cancelOrder']);

				if(strcasecmp($_SESSION['accountType'], "admin") == 0)
				{
					self::searchForOrder();
				}

				else
				{
					self::getSales($_SESSION['accountID']);
				}
			}

			elseif(isset($_POST['searchForOrder'])) 
			{
				self::searchForOrder();
				self::getOrder($_POST['searchForOrder'], true);
			}

			elseif(isset($_POST['viewSales'])) 
			{
				self::getSales($_SESSION['accountID']);
			}

			else
			{
				self::getAllOrders($_SESSION['accountID']);
			}
		}

		// Retrieves all the orders associated to a given user with their specified Account_Id
		public function getAllOrders($accountID)
		{
			home::displayHeader();

			$orders = self::model('Order');
			$orders = $orders->where('Account_Id', $accountID)->orderBy('Date', 'desc')->get();

			self::view('orders/orderList', ['orders' => $orders]);
		}

		// Retrieves a specific order for a given Order_Id
		public function getOrder($orderID, $parentCall = null)
		{
			if(is_null($parentCall))
			{
				home::displayHeader();
			}

			$order = self::model('Order');
			$order = $order->find($orderID);

			if(empty($order))
			{
				echo "Order #$orderID does not exist.";
			}

			else
			{
				$listingOptions = self::model('ListingOptions');
				$listingOptions = $listingOptions->find($order->Option_Id);

				$listing = self::model('Listing');
				$listing = $listing->find($listingOptions->Listing_Id);

				$account = self::model('Account');
				$account = $account->find($order->Account_Id);

				$profile = self::model('Profile');
				$profile = $profile->find($order->Account_Id);

				$address = self::model('Address');
				$address = $address->find($order->Address_Id);

				$payment = self::model('PaymentMethod');
				$payment = $payment->find($order->Payment_Id);

				$seller = self::model('Account')->find($listing->Seller);

				self::view('orders/viewOrder', [
					'orderID' => $order->Order_Id,
					'accountID' => $order->Account_Id,
					'optionID' => $order->Option_Id,
					'quantity' => $order->Quantity,
					'total' => $order->Total,
					'date' => $order->Date,
					'addressID' => $order->Address_Id,
					'shippingMethod' => $order->Shipping_Method,
					'paymentID' => $order->Payment_Id,
					'status' => $order->Status,
					'username' => $account->Username,
					'name' => $profile->Full_Name,
					'addressLine1' => $address->Address_Line_1,
					'addressLine2' => $address->Address_Line_2,
					'city' => $address->City,
					'stateProvince' => $address->State_Province,
					'zipPostalCode' => $address->Zip_Postal_Code,
					'country' => $address->Country,
					'cardNumber' => $payment->Card_Number,
					'cardType' => $payment->Card_Type,
					'listingID' => $listingOptions->Listing_Id,
					'image' => $listingOptions->Image,
					'color' => $listingOptions->Color,
					'size' => $listingOptions->Size,
					'title' => $listing->Title,
					'description' => $listing->Description,
					'price' => $listing->Price,
					'sellerID' => $listing->Seller,
					'seller' => $seller->Username ]);
			}
		}

		// Retrieve all orders on the listings of a given seller
		public function getSales($accountID)
		{	
			$sales = array();

			$listings = self::model('Listing');
			$listings = $listings->where('Seller', $accountID)->get();
			
			// For each listing of the user
			foreach($listings as $listing)
			{
				$listingOptions = $listing->listingOptions;

				// For each listingOption of the user's listing
				foreach($listingOptions as $listingOption)
				{	
					$orders = self::model('Order')->where('Option_Id', $listingOption->Option_Id)->get();

					// For each order on that listingOption
					foreach($orders as $order)
					{	
						array_push($sales, $order);
					}	
				}
			}

			home::displayHeader();
			
			//echo $sales->count();
			self::view('orders/viewSales', ['sales' => $sales]);
		}

		// // Retrieve all orders on a specific listing 
		// public function getSalesOnListing($listingID)
		// {	
		// 	$sales = array();

		// 	$listing = self::model('Listing')->find($listingID);
		// 	$listingOptions = $listing->listingOptions;

		// 	// For each listingOption of the user's listing
		// 	foreach($listingOptions as $listingOption)
		// 	{	
		// 		$orders = self::model('Order')->where('Option_Id', $listingOption->Option_Id)->get();

		// 		// For each order on that listingOption
		// 		foreach($orders as $order)
		// 		{	
		// 			array_push($sales, $order);
		// 		}	
		// 	}

		// 	home::displayHeader();
		// 	listingController::displayHeader($listingID);

		// 	//echo $sales->count();
		// 	self::view('orders/viewSales', ['sales' => $sales]);
		// }

		// Cancels a specific order for a given Order_Id
		public function cancelOrder($orderID)
		{
			$order = self::model('Order')->find($orderID);
			$order->Status = 'Cancelled';
			$order->save();

			$listingOptions = self::model('ListingOptions');
			$listingOptions = $listingOptions->find($order->Option_Id);

			$listing = self::model('Listing');
			$listing = $listing->find($listingOptions->Listing_Id);

			// require_once '../app/controllers/notificationController.php';
			// $notificationController = new notificationController();
			notificationController::cancelOrderNotif($order->Account_Id, $orderID, $listing->Listing_Id, $listing->Title);
		}

		// Cancels all orders associated to a specific listing for a given Listing_Id
		public function cancelAllOrders($listingID)
		{
			$listing = self::model('Listing')->find($listingID);

			if(!is_null($listing))
			{
				$listingOptions = $listing->listingOptions;

				// For each listingOption of the selected listing
				foreach($listingOptions as $listingOption)
				{
					$orders = self::model('Order')->where('Option_Id', $listingOption->Option_Id)->get();

					// For each order on that listingOption
					foreach($orders as $order)
					{
						self::cancelOrder($order->Order_Id);
					}
				}
			}

			// Redirect back to the listing's details
			//header('Location: '. '/public/listingController/viewDetails/' . $listingID);
		}

		// Display the page for admins to search for a specific order
		public function searchForOrder()
		{
			home::displayHeader();

			self::view('orders/searchForOrder', []);
		}		
	} 
?>