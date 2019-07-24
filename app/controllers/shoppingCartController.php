<?php

class shoppingCartController extends Controller
{
	// Displays the apppropriate cart based on whether the user is logged in or not
	public function viewCart()
	{
		// User is not logged in, anonymous cart
		if(is_null($_SESSION['accountID']))
		{
			anonymousCartController::viewCart();
			return;
		}
		else
		{
			// Redirect to the listing details
			header('Location: '. '/public/cartController');
		}
	}

	# *******************************
	# **********ADD TO CART**********
	# *******************************
	// Adds an item to the user's cart
	public function addToCart($listingID, $optionID, $quantity = null, $convert = null)
	{
		// User is not logged in, anonymous cart
		if(is_null($_SESSION['accountID']))
		{
			anonymousCartController::addToCart($listingID, $optionID);
			return;
		}

		// Get the cart item associated with the user and the given listing for an edit
		$cartItem = ShoppingCart::where('Account_Id', $_SESSION['accountID'])
								->where('Option_Id', $optionID)->first();

		if(is_null($cartItem))
		{
			$cartItem = new ShoppingCart(); // Create a new instance for adding
		}

		$cartItem->Option_Id = $optionID;
		$cartItem->Account_Id = $_SESSION['accountID'];
		$cartItem->Quantity += isset($_POST['quantity']) ? $_POST['quantity'] : $quantity;
		$cartItem->Date = date("Y-m-d H:i:s");

		if($cartItem->validate())
		{
			$cartItem->save();
		}
		else if(!is_null($convert))
		{
			notificationController::couldNotTransferNotif($_SESSION['accountID'], $optionID);
		}

		// Redirect to the listing details
		header('Location: '. '/public/listingController/viewDetails/' . $listingID . '/' . $optionID);
	}

	# ************************************
	# **********Cart To Wishlist**********
	# ************************************
	// Transfers cart items to the wishlist
	public function transferCartToWishlist($carItemID)
	{
		$cartItem = ShoppingCart::find($carItemID);
		$listingOption = $cartItem->listingOptions;

		$wish = $listingOption->wishlist->where('Account_Id', $cartItem->Account_Id)->first();

		if(is_null($wish))
		{
			// Add to wishlist
			$wish = new Wishlist();
			$wish->Option_Id = $cartItem->Option_Id;
			$wish->Account_Id = $cartItem->Account_Id;
			$wish->save();

			// Remove from shopping cart
			$cartItem->delete();
		}
		
		// Redirect to the user's cart
		header('Location: '. '/public/cartController');
			return;
	}
}

?>