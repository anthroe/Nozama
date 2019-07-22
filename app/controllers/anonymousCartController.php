<?php

use \Illuminate\Database\Eloquent\Collection as Collection;

class anonymousCartController extends Controller
{
	// Displays all items in the anonymous user's cart
	public function viewCart()
	{
		home::displayHeader();

		$cart = null;
		if(isset($_COOKIE['cart']))
		{
			$cart = unserialize($_COOKIE['cart']);
		}

		$items = 0;
		$subtotal = 0;
		if(!is_null($cart))
		{
			foreach($cart as $cartItem)
			{
				$listingOption = ListingOptions::find($cartItem->Option_Id);

				if(is_null($listingOption))
				{
					continue;
				}

				$listing = $listingOption->listing;

				$items += $cartItem->Quantity;
				$subtotal += $cartItem->Quantity * $listing->Price;
			}
		}

		self::view('shoppingCart/cart', [
			'cart' => $cart,
			'items' => $items,
			'subtotal' => $subtotal]);
	}

	// Adds an item to the anonymous user's cart
	public function viewCartItemHelper($cart)
	{
		$errorIndex;
		if(isset($_SESSION['errorMessage'], $_SESSION['errorIndex']))
		{
			$errorIndex = $_SESSION['errorIndex'];
		}

		$index = 0;
		foreach($cart as $cartItem)
		{
			$errorMessage = null;
			if(isset($_SESSION['errorIndex']) && $errorIndex == $index)
			{
				$errorMessage = $_SESSION['errorMessage'];
				unset($_SESSION['errorMessage']);
				unset($_SESSION['errorIndex']);
			}

			$listingOption = ListingOptions::find($cartItem->Option_Id);

			if(is_null($listingOption))
			{
				continue;
			}
				
			$listing = $listingOption->listing;

			self::view('shoppingCart/cartItem', [
				'optionID' => $cartItem->Option_Id,
				'quantity' => $cartItem->Quantity,
				'image' => $listingOption->Image,
				'color' => $listingOption->Color,
				'size' => $listingOption->Size,
				'listingID' => $listingOption->Listing_Id,
				'title' => $listing->Title,
				'price' => $listing->Price,
				'sellerProfileID' => $listing->Seller,
				'seller' => $listing->account->Username,
				'index' => $index,
				'errorMessage' => $errorMessage]);

			$index++;
		}
	}

	// Adds or updates a cart item in the anonymous cart stored in cookies
	public function addToCart($listingID, $optionID)
	{
		$listing = Listing::find($listingID);

		// Create a new cart and cart item or get them if the anonymous user already has
		$cart = new Collection();
		$cartItem = null;
		if(isset($_COOKIE['cart']))
		{
			$cart = unserialize($_COOKIE['cart']);
			$cartItem = $cart->where('Option_Id', $optionID)->first(); // Get the cart item if it's already in cart
		}

		// Create a new cart item if it is not already in cart
		if(is_null($cartItem))
		{
			$cartItem = new AnonymousCart();
		}

		// Set or update the cart item's fields
		$cartItem->Option_Id = $optionID;
		$cartItem->Quantity += $_POST['quantity'];

		if(!$cartItem->validate())
		{
			$cartItem->Quantity -= $_POST['quantity'];
		}

		$cart = $cart->push($cartItem); // Add the updated cart item to the cart
		$cart = $cart->keyBy('Option_Id'); // Deletes the old cart item (Throws off collection indexing)

		// Set the updated cart to the cookie
		setcookie('cart', serialize($cart), time() + (86400 * 30), '/');	

		// Redirect to the listing details
		header('Location: '. '/Nozama/public/listingController/viewDetails/' . $listingID . '/' . $optionID);
	}

	// Edits the quantity of a item in the user's anonymous cart
	public function editCartItem($optionID, $index)
	{
		$cart = unserialize($_COOKIE['cart']);
		$cartItem = $cart->where('Option_Id', $optionID)->first();

		$originalQuantity = $cartItem->Quantity; // Fallback in case quantity selected is invalid

		// Update the cart item's fields
		$cartItem->Option_Id = $optionID;
		$cartItem->Quantity = $_POST['quantity'];

		// Validate the selected quantity
		if(!$cartItem->validate())
		{
			$_SESSION['errorIndex'] = $index;
			$cartItem->Quantity = $originalQuantity;
		}

		$cart = $cart->push($cartItem); // Add the updated cart item to the cart
		$cart = $cart->keyBy('Option_Id'); // Deletes the old cart item (Throws off collection indexing)

		// Set the updated cart to the cookie
		setcookie('cart', serialize($cart), time() + (86400 * 30), "/");

		// Redirect to the anonymous cart
		header('Location: '. '/Nozama/public/anonymousCartController/viewCart');
	}

	// Deltes the given item from the anonymous user's cart
	public function deleteFromCart($optionID)
	{
		$cart = unserialize($_COOKIE['cart']);

		$cart = $cart->keyBy('Option_Id');
		$cart = $cart->forget($optionID);

		// Set the updated cart to the cookie
		setcookie('cart', serialize($cart), time() + (86400 * 30), "/");

		// Redirect to the anonymous cart
		header('Location: '. '/Nozama/public/anonymousCartController/viewCart');
	}

	// Converts an anonymous cart to a user shopping cart
	public function convertCart()
	{
		$cart = null;
		if(isset($_COOKIE['cart']))
		{
			$cart = unserialize($_COOKIE['cart']);
			setcookie('cart', serialize($cart), 1, '/');
		}

		// No anonymous cart to convert
		if(is_null($cart))
		{
			// Redirect to the home page
			header('Location: '. '/Nozama/public');
			return;
		}

		foreach($cart as $cartItem)
		{
			$listingOption = ListingOptions::find($cartItem->Option_Id);
			$listing = $listingOption->listing;

			shoppingCartController::addToCart($listing->Listing_Id, $cartItem->Option_Id, $cartItem->Quantity, true);
		}

		unset($_SESSION['errorMessage']);
		unset($_SESSION['errorIndex']);

		// Redirect to the user's cart
		header('Location: '. '/Nozama/public/cartController');
	}
}

?>