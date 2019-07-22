<?php
use Illuminate\Http\Request as Request; // NOT SURE IF STILL USED
class listingController extends Controller
{
	// Setup the view/filter/sort Listings section of the user interface
	public function setup()
	{
		
		$conditions = self::searchFormHandler();
		self::viewAll(new Conditions($conditions));
	}
	// Displays the listing section's header
	public function displayHeader($listingID)
	{
		$listing = Listing::find($listingID);
		
		$prodReviewCount = $listing->productReview->where('Account_Id', $_SESSION['accountID'])->count();
		self::view('listing/listingDetailsHeader', [
			'accountID' => $_SESSION['accountID'],
			'accountType' => $_SESSION['accountType'],
			'listingID'=> $listingID,
			'sellerAccountID' => $listing->Seller,
			'prodReviewCount' => $prodReviewCount]);
	}
	// Displays a filtered and sorted list of Listings based on the given Condition model
	public function viewAll($conditions)
	{
		$listings = new Listing();
		# **************************************************
		# **********SEARCH BY SELECTING A CATEGORY**********
		# **************************************************
		if(isset($conditions->category))
		{
			$listings = $listings->where('Category_Id', $conditions->category);
		}
		# *************************************************
		# **********SEARCH THROUGH THE SEARCH BAR**********
		# *************************************************
		if(isset($conditions->search))
		{
			$listings = $listings->where(
				function($query) use ($conditions) {
					$query->whereRaw('LOWER(Title) LIKE LOWER(?)', ["%$conditions->search%"])
						  ->orwhereRaw('LOWER(Description) LIKE LOWER(?)', ["%$conditions->search%"]);
				}
			);
		}
		# *****************************************
		# **********FILTER SEARCH RESULTS**********
		# *****************************************
		if(isset($conditions->seller))
		{
			$account = Account::whereRaw('LOWER(Username) = LOWER(?)', [$conditions->seller])->first();
			$accountID = is_null($account) ? 0 : $account->Account_Id;
			$listings = $listings->where('Seller', $accountID);
		}
		if(isset($conditions->priceLow))
		{
			$listings = $listings->where('Price', '>=', $conditions->priceLow);
		}
		if(isset($conditions->priceHigh))
		{
			$listings = $listings->where('Price', '<=', $conditions->priceHigh);
		}
		if(isset($conditions->stock))
		{
			$listings = $listings->where('Stock', '>=', $conditions->stock);
		}
		if(isset($conditions->rating))
		{
			$listings = $listings->where('Rating', '>=', $conditions->rating);
		}
		# *************************************************
		# **********SORT SEARCH RESULTS********************
		# *************************************************
		if(isset($conditions->sort))
		{
			$orderbycol = split(' ',$conditions->sort)[0];
			$order = split(' ', $conditions->sort)[1];
			$listings = $listings->orderby($orderbycol, $order);
		}
		else
		{
			$listings = $listings->orderby('Date', 'DESC');
		}
		self::view('listing/listingPreviews', ['listings' => $listings->get()]);
	}
	// Displays a listingPreview view for each listing in the given array
	public function viewPreviewHelper($listings)
	{
		for($index = 0; $index < $listings->count(); $index++)
		{
			$listing = $listings->get($index);
			$listingOptions = $listing->listingOptions; // Get the associated listingOptions
			if($listing->account->Banned == 0) // Only display listings of users who are not banned
			{
				$seller = $listing->Seller == $_SESSION['accountID'] ? "You" : $listing->account->Username;
				self::view('listing/listingPreview', [
					'listingID' => $listing->Listing_Id,
					'image' => $listingOptions->first()->Image, 
					'title' => $listing->Title, 
					'seller' => $seller, 
					'price' => $listing->Price,
					'rating' => $listing->Rating,
					'stock' => $listing->Stock,
					'sellerAccountID' => $listing->account->Account_Id]);
			}
		}
	}
	// Displays a listingDetails view for the listing with the given Listing_Id
	public function viewDetails($listingID, $optionID = null)
	{
		// For displaying a form error message to the user
		$errorMessage = isset($_SESSION['errorMessage']) ? $_SESSION['errorMessage'] : null;
		unset($_SESSION['errorMessage']);
		$listing = Listing::find($listingID);
		$listingOptions = $listing->listingOptions; // Get the associated listingOptions
		// Get the currently selected listingOption
		$optionID = is_null($optionID) ? $listingOptions->first()->Option_Id : $optionID;
		$optionID = isset($_POST['optionID']) ? $_POST['optionID'] : $optionID;
		// Check if the listing with the desired option is already in the user's wishlist
		$wish = Wishlist::where('Account_Id', $_SESSION['accountID'])
						->where('Option_Id', $optionID)->first();
		home::displayHeader();
		self::displayHeader($listingID);
		# *********************************************
		# **********VIEW LISTINGS INFORMATION**********
		# *********************************************
		$seller = $listing->Seller == $_SESSION['accountID'] ? "You" : $listing->account->Username;
		$wishID = is_null($wish) ? null : $wish->Wishlist_Id;
		self::view('listing/listingDetails', [
			'accountID' => $_SESSION['accountID'],
			'accountType' => $_SESSION['accountType'],
			'listingID' => $listingID, 
			'title' => $listing->Title, 
			'categoryID' => $listing->Category_Id,
			'description' => $listing->Description, 
			'sellerAccountID' => $listing->Seller, 
			'seller' => $seller, 
			'rating' => $listing->Rating, 
			'price' => $listing->Price, 
			'date' => $listing->Date, 
			'optionID' => $optionID,
			'image' => $listingOptions->find($optionID)->Image, 
			'color' => $listingOptions->find($optionID)->Color, 
			'size' => $listingOptions->find($optionID)->Size,
			'stock' => $listingOptions->find($optionID)->Stock,
			'wishID' => $wishID,
			'errorMessage' => $errorMessage]);
	}
	
	# ************************************************
	# **********VIEW LISTING RECOMMENDATIONS**********
	# ************************************************
	// Gets other listings of the same category to display as recommendations 
	public function displayRecommendation($listingID, $categoryID)
	{
		// Get other listings of the same category in a random order
		$listings = Listing::inRandomOrder()->where('Category_Id', $categoryID)
											->where('Listing_Id', '!=', $listingID)
											->where('Seller', '!=', $_SESSION['accountID'])->get();
		self::view('listing/listingRecommendations', ['listings' => $listings]);
	}
	// Displays five other random listings under the same category as listingRecommendation views 
	public function displayRecommendationHelper($listings)
	{
		// Get the first five random listings
		for($count = 0; $count < 5 && $count < $listings->count(); $count++)
		{
			$listing = $listings->get($count);
			$listingOptions = ListingOptions::where('Listing_Id', $listing->Listing_Id)->get(); // Get the associated listingOptions
				
			self::view('listing/listingRecommendation', ['listingID' => $listing->Listing_Id,
				'image' => $listingOptions->first()->Image, 
				'title' => $listing->Title, 
				'seller' => $listing->account->Username, 
				'price' => $listing->Price,
				'sellerAccountID' => $listing->account->Account_Id]);
		}
	}
	// Handles form data from the listingSearch view
	protected function searchFormHandler()
	{
		// Retrieve the conditions already set and merge them with the new conditions
		$savedRequest = (isset($_SESSION['conditions']) ? $_SESSION['conditions'] : []);
		// $conditions = array_merge($savedRequest, array_filter($_POST, 
		// 	function($value) { 
		// 		return $value !== ''; // Prevent array_filter from filtering 0's
		// 	}
		// ));
		$conditions = array_merge($savedRequest, $_POST);
		unset($conditions['image'], $conditions['color'], $conditions['size'], $conditions['stock']); // To prevent array_map('trim', $conditions) from failing by trying to trim an array element
		$conditions = array_map('trim', $conditions); // Trim leading and trailing whitespaces from each element of the array
		if(isset($_POST['reset']))
		{
			$_POST = array();
			$conditions = null;
		}
		if(isset($_POST['clearSearch']))
		{
			unset($conditions['searchCategory']);
			unset($conditions['searchKeyWord']);
			unset($conditions['searchSeller']);
		}
		if(isset($_POST['clearFilters']))
		{
			unset($conditions['filterPriceLow']);
			unset($conditions['filterPriceHigh']);
			unset($conditions['filterRating']);
			unset($conditions['filterStock']);
			unset($conditions['sort']);
		}
		$_SESSION['conditions'] = $conditions;
		return $conditions;
	}
	// Displays the listingSearch view after handling the form data
	public function displaySearch()
	{
		$conditions = new Conditions(self::searchFormHandler());
		self::view('listing/listingSearch', [
			'category' => $conditions->category,
			'search' => $conditions->search,
			'seller' => $conditions->seller]);
	}
	// Displays the listingFilter view after handling the form data
	public function displayFilter()
	{
		$conditions = new Conditions(self::searchFormHandler());
		self::view('listing/listingFilter', [
			'priceLow' => $conditions->priceLow,
			'priceHigh' => $conditions->priceHigh,
			'rating' => $conditions->rating,
			'stock' => $conditions->stock,
			'sort' => $conditions->sort]);
	}
	// Displays a postListing view with the appropriate number of listingOptions and a postListingConfirmation when the form is submitted with valid values
	public function postListing()
	{
		$listing = new Listing();
		$listing->set($_POST);
		if(isset($_POST['post'])) // Post listing
		{
			$optionCount = $_POST['finalOptionCount'];
			# *********************************
			# **********ADD A LISTING**********
			# *********************************
			// Add a listing to the Listing table
			$listing->Title = $listing->_title;
			$listing->Description = $listing->_description;
			$listing->Category_Id = $listing->_categoryID;
			$listing->Price = $listing->_price;
			$listing->Stock = 0;
			$listing->Seller = $listing->_seller;
			$listing->save();
			$stock = 0; // For keeping track of the total stock of all listingOptions
			// Add a listingOption to the ListingOptions table for each option filled
			for($count = 0; $count < $optionCount; $count++) 
			{
				// Get a listingOption
				$listingOptions = new ListingOptions();
				$listingOptions->setFromArray(array_merge($_POST, $_FILES), $count);
				$stock += $listingOptions->_stock; // Add the current listingOption's stock
				// Add the listingOption to the ListingOption table
				$listingOptions->Listing_Id = $listing->Listing_Id;
				$listingOptions->Image = $listingOptions->_image;
				$listingOptions->Color = $listingOptions->_color;
				$listingOptions->Size = $listingOptions->_size;
				$listingOptions->Stock = $listingOptions->_stock;
				$listingOptions->save();
			}
			$listing->Stock = $stock;
			$listing->save();
			// Generate a post listing notification
			notificationController::addListingNotif($listing->Seller, $listing->Listing_Id, $listing->Title);
			// Redirect to the confirmation
			header('Location: '. '/public/listingController/viewDetails/' . $listing->Listing_Id);
		}
		else // Display the postListing form
		{
			home::displayHeader();
			// Get the amount of listingOptions currently requested
			$optionCount = 1;
			if(isset($_POST['optionCount']))
				$optionCount = $_POST['optionCount'];
			self::view('listing/postListing', [
				'optionCount' => $optionCount, 
				'title' => $listing->_title, 
				'categoryID' => $listing->_categoryID, 
				'description' => $listing->_description, 
				'price' => $listing->_price, 
				'stock' => $listing->_stock]);
		}
	}
	// Displays a editListing view with the appropriate number of listingOptions and an appropriate confirmation when the form is submitted
	public function editListing($listingID)
	{
		$listing = Listing::find($listingID);
		$category = $listing->category;
		$listingOptions = $listing->listingOptions;
		
		if(isset($_POST['edit'])) // Edit listing
		{		
			$listing->set($_POST);
			$finalOptionCount = $_POST['finalOptionCount'];
			$optionCount = $finalOptionCount > $listingOptions->count() ? $finalOptionCount : $listingOptions->count();
			// Edit the listing from the Listing table
			$listing->Title = $listing->_title;
			$listing->Description = $listing->_description;
			$listing->Category_Id = $listing->_categoryID;
			$listing->Price = $listing->_price;
			$listing->Seller = $listing->_seller;
			$listing->save();
			// Edit the listingOption from the ListingOptions table for each option filled
			for($count = 0; $count < $optionCount; $count++) 
			{
				// // If the listingOption's index is within the listingOptions to add
				if($count < $finalOptionCount)
				{
					// Get the listingOption for an update
					$listingOption = $listingOptions->get($count);
					if(is_null($listingOption)) // Create a new listingOption instance for inserting
						$listingOption = new ListingOptions();
					$listingOption->setFromArray(array_merge($_POST, $_FILES), $count);
					// Edit the listingOption from the ListingOption table
					$listingOption->Listing_Id = $listing->Listing_Id;
					$listingOption->Image = $listingOption->_image;
					$listingOption->Color = $listingOption->_color;
					$listingOption->Size = $listingOption->_size;
					$listingOption->Stock = $listingOption->_stock;
					$listingOption->save();
				}
				else // If the listingOption's index is over the listingOptions to add
				{
					// Delete the listingOption
					$listingOption = $listingOptions->get($count);
					$listingOption->delete();
				}
			}
			self::updateStock($listingID);
			// Generate an edit listing notification
			notificationController::listingEditNotif($listing->Seller, $listing->Listing_Id, $listing->Title);
			// Redirect to the confirmation
			header('Location: '. '/public/listingController/viewDetails/' . $listingID);
		}
		# **********************************
		# **********DELETE LISTING**********
		# **********************************
		else if(isset($_POST['delete']) || isset($_POST['adminDelete'])) // Delete listing
		{
			// Delete the listing automatically deleting all records associated to the listing
			$listing->delete();
			// Generate admin delete listing notification
			if(isset($_POST['adminDelete']))
			{
				notificationController::listingDeleteNotif($listing->Seller, $listingID, $listing->Title);
			}
			// Redirect to the confirmation
			header('Location: '. '/public/listingController/listingConfirmation/' . $listingID . '/deleted');
		}
		else // Display editListing form
		{
			home::displayHeader();
			self::displayHeader($listingID);
	
			$optionCount = $listingOptions->count();
			if(isset($_POST['optionCount']))
				$optionCount = $_POST['optionCount'];
			self::editListingHelper($category, $listingOptions, $optionCount);
			self::view('listing/editListing', [
				'optionCount' => $optionCount,
				'listingID' => $listing->Listing_Id,
				'title' => $listing->Title,
				'category' => $listing->Category_Id,
				'description' => $listing->Description,
				'price' => $listing->Price]);
		}
	}
	// Sets POST data for default listing values if not already set
	protected function editListingHelper($category, $listingOptions, $optionCount)
	{
		if(!isset($_POST['category']))
		{
			$_POST['category'] = $category->Category_Id;
		}
		for($count = 0; $count < $optionCount; $count++)
		{
			if(!isset($_POST['color'][$count]) && !is_null($listingOptions->get($count)))
				$_POST['color'][$count] = $listingOptions->get($count)->Color;
			if(!isset($_POST['size'][$count]) && !is_null($listingOptions->get($count)))
				$_POST['size'][$count] = $listingOptions->get($count)->Size;
			if(!isset($_POST['stock'][$count]) && !is_null($listingOptions->get($count)))
				$_POST['stock'][$count] = $listingOptions->get($count)->Stock;
		}
	}
	// Display a listing operation confirmation
	public function listingConfirmation($listingID, $operation)
	{
		home::displayHeader();
		if($operation == 'edited')
		{
			self::displayHeader($listingID);
		}	
		// Reset the search conditions
		$_SESSION['reset'] = 'reset';
		self::view('listing/listingConfirmation', [
				'operation' => $operation]);
	}
	// Updates the rating of the listing with the given Listing_Id
	public function updateRating($listingID)
	{
		// Get the listing and the associated productReviews
		$listing = Listing::find($listingID);
		$prodReviews = $listing->productReview;
		// Update the listing in the database
		$listing->Rating = $prodReviews->avg('Rating');
		$listing->save();
	}
	// Updates the stock of the listing with the given Listing_Id
	public function updateStock($listingID)
	{
		$listing = Listing::find($listingID);
		$listingOptions = $listing->listingOptions;
		$listing->Stock = $listingOptions->sum('Stock');
		$listing->save();
	}
}
?>