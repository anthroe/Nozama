<?php

#LET USER SELECT LISTING OPTION: ADD LISTING OPTION ID IN WISHLIST DB

class wishlistController extends Controller
{
	// Display the wishlist items associate with the given user's Account_Id
	public function viewUserWishlist($accountID)
	{
		home::displayHeader();
		
		// Get the wishes associated with the given Account_Id, ordred by newest first
		$wishlist = Wishlist::where('Account_Id', $accountID)
						    ->orderby('Date', 'DESC');

		self::view('wishlist/wishlist', [
			'owner' => Account::find($accountID)->Username,
			'wishlist' => $wishlist->get(),
			'viewingUser' => null]);
	}

	# *********************************
	# **********VIEW WISHLIST**********
	# *********************************
	// Displays a wish view for each wishlist item in the given array
	public function viewWishHelper($wishlist, $viewingUser = null)
	{
		for($count = 0; $count < $wishlist->count(); $count++)
		{
			$wish = $wishlist->get($count);
			$cartItem = ShoppingCart::where('Option_Id', $wish->Option_Id)->first();

			self::view('wishlist/wish', [
				'accountType' => $_SESSION['accountType'],
				'wishID' => $wish->Wishlist_Id,
				'listingID' => $wish->listingOptions->Listing_Id,
				'optionID' => $wish->Option_Id,
				'image' => $wish->listingOptions->Image, 
				'color' => $wish->listingOptions->Color,
				'size' => $wish->listingOptions->Size,
				'title' => $wish->listingOptions->listing->Title, 
				'seller' => $wish->listingOptions->listing->account->Username, 
				'sellerAccountID' => $wish->listingOptions->listing->Seller,
				'price' => $wish->listingOptions->listing->Price,
				'stock' => $wish->listingOptions->Stock,
				'cartQuantity' => is_null($cartItem) ? 0 : $cartItem->Quantity,
				'viewingUser' => $viewingUser]);
		}
	}

	// Adds the listing to the user's wishlist and redirects back to listing details of that listing
	public function addWish($listingID, $optionID)
	{
		# *****************************************
		# **********ADD ITEMS TO WISHLIST**********
		# *****************************************
		$wish = new Wishlist();
		$wish->Option_Id = $optionID;
		$wish->Account_Id = $_SESSION['accountID'];
		$wish->save();

		// Redirect back to the listing details
		header('Location: '. '/Nozama/public/listingController/viewDetails/' . $listingID . '/' . $optionID);
	}

	// Removes the listing from the user's wishlist an redirects back to the user's wishlist 
	public function removethroughWishlist($wishID)
	{
		# **********************************************
		# **********DELETE ITEMS FROM WISHLIST**********
		# **********************************************
		$wish = Wishlist::find($wishID);
		$wish->delete();

		// Redirect back to the listing details
		header('Location: '. '/Nozama/public/wishlistController/viewUserWishlist/' . $_SESSION['accountID']);
	}

	// Removes the listing from the user's wishlist an redirects back to the listing details of that listing 
	public function removeThroughListingDetails($listingID, $optionID, $wishID)
	{
		$wish = Wishlist::find($wishID);
		$wish->delete();

		// Redirect back to the listing details
		header('Location: '. '/Nozama/public/listingController/viewDetails/' . $listingID . '/' . $optionID);
	}

	// Transfers the wish with the given Wishlist_Id to the user's shopping cart
	public function transferWishToCart($wishID)
	{
		$wish = Wishlist::where('Wishlist_Id', $wishID);
		self::transferToCartHelper($wish->get());
	}

	// 
	public function transferWishlistToCart()
	{
		$wishlist = Wishlist::where('Account_Id', $_SESSION['accountID']);
		self::transferToCartHelper($wishlist->get());
	}

	# ***************************************************
	# **********TRANSFER WISHLIST ITEMS TO CART**********
	# ***************************************************
	// Deletes every item in the given wishlist and adds a shopping cart item for every deleted item
	protected function transferToCartHelper($wishlist)
	{
		for($count = 0; $count < $wishlist->count(); $count++)
		{
			$wish = $wishlist->get($count);
			$cartItem = ShoppingCart::where('Option_Id', $wish->Option_Id)->first();

			// Avoid transferring out of stock items
			if($wish->listingOptions->Stock < 1 + $cartItem->Quantity)
			{
				continue;
			}

			// Remove the item from the user's wishlist
			$wish->delete();

			// Add the item to the user's shopping cart or increment its quantity
			$cartItem = ShoppingCart::where('Option_Id', $wish->Option_Id)
									->where('Account_Id', $_SESSION['accountID'])->first();
			if(is_null($cartItem))
			{
				$cartItem = new ShoppingCart();
			}

			$cartItem->Option_Id = $wish->Option_Id;
			$cartItem->Account_Id = $_SESSION['accountID'];
			$cartItem->Quantity++;
			$cartItem->save();
		}

		// Redirect back to the wishlist
		header('Location: '. '/Nozama/public/wishlistController/viewUserWishlist/' . $_SESSION['accountID']);
	}
}

?>