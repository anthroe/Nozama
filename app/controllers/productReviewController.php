<?php

#TO ADD LATER
#USERS CAN ONLY LEAVE REVIEWS IF THEY HAVE BOUGHT THE ITEM

class productReviewController extends Controller
{
	# ****************************************
	# **********VIEW LISTING REVIEWS**********
	# ****************************************
	// Displays all the productReviews associated with the listing with the given Listing_Id
	public function viewListingReview($listingID)
	{
		home::displayHeader();
		listingController::displayHeader($listingID);

		$prodReviews = ProductReview::where('Listing_Id', $listingID)
									 ->orderby('Date', 'DESC');

		self::productPreview($listingID);
		self::view('productReview/productReviews', ['prodReviews' => $prodReviews->get()]);
	}

	// Displays a productReview view for each review in the given array
	public function viewReviewHelper($prodReviews)
	{
		for($count = 0; $count < $prodReviews->count(); $count++)
		{
			$prodReview = $prodReviews->get($count);

			$reviewer = $prodReview->Account_Id == $_SESSION['accountID'] ? "You" : $prodReview->account->Username;
			self::view('productReview/productReview', [
				'accountID' => $_SESSION['accountID'],
				'accountType' => $_SESSION['accountType'],
				'listingID' => $prodReview->Listing_Id,
				'prodReviewID' => $prodReview->Review_Id,
				'reviewer' => $reviewer,
				'reviewerID' => $prodReview->Account_Id,
				'title' => $prodReview->Title,
				'message' => $prodReview->Message,
				'rating' => $prodReview->Rating,
				'date' => $prodReview->Date,
				'viewIndex' => $count]);
		}
	}

	//  Displays the postReview form and handles inserting, updating and deleting productReviews
	public function postListingReview($listingID, $prodReviewID = null)
	{
		// For keeping track of either an insert or an update
		$operation = 'edited';

		// Get the productReview for updating
		$prodReview = ProductReview::where('Account_Id', $_SESSION['accountID'])
								   ->where('Listing_Id', $listingID)->first();

		if(is_null($prodReview)) // Create a new productReview instance for inserting
		{
			$prodReview = new ProductReview();
			$operation = 'submitted';
		}

		if(isset($_POST['post'])) // Insert or update a productReview
		{

			# ************************************************
			# **********LEAVE REVIEWS + EDIT REVIEWS**********
			# ************************************************
			$prodReview->Listing_Id = $listingID;
			$prodReview->Account_Id = $_SESSION['accountID'];
			$prodReview->Title = trim($_POST['title']);
			$prodReview->Message = trim($_POST['message']);
			$prodReview->Rating = $_POST['rating'];
			$prodReview->Date = date("Y-m-d H:i:s");
			$prodReview->save();

			// Update the listing's rating
			listingController::updateRating($listingID);

			// Generate a listing review notification for the owner of the listing
			if($operation == 'submitted')
			{
				notificationController::listingReviewNotif($prodReview->listing->Seller, $prodReview->Listing_Id, $prodReview->listing->Title, $prodReview->account->Username);
			}

			// Redirect to the confirmation view
			header('Location: '. '/public/productReviewController/productReviewConfirmation/' . $listingID . '/' . $operation);
		}
		# *********************************
		# **********DELETE REVIEW**********
		# *********************************
		else if(isset($_POST['delete']) || isset($_POST['adminDelete'])) // Delete a productReview
		{
			if(!is_null($prodReviewID))
			{
				$prodReview = ProductReview::find($prodReviewID);
			}

			if(isset($_POST['adminDelete']))
			{
				notificationController::reviewDeleteNotif($prodReview->Account_Id);
			}

			$prodReview->delete();

			// Update the listing's rating
			listingController::updateRating($listingID);

			// Redirect to the confirmation view
			header('Location: '. '/public/productReviewController/productReviewConfirmation/' . $listingID . '/deleted');
		}
		else // Display the postReview form
		{
			home::displayHeader();
			listingController::displayHeader($listingID);

			self::productPreview($listingID);

			self::view('productReview/postReview', [
				'listingID' => $listingID,
				'accountID' => $prodReview->Account_Id,
				'rating' => $prodReview->Rating,
				'title' => $prodReview->Title,
				'message' => $prodReview->Message]);
		}
	}

	// Displays productPreview view of the listing being reviewed
	protected function productPreview($listingID)
	{
		$listing = Listing::find($listingID);

		$listingSeller = $listing->Seller == $_SESSION['accountID'] ? "You" : $listing->account->Username;
		self::view('productReview/productPreview', [
			'listingTitle' => $listing->Title,
			'listingImage' => $listing->listingOptions->first()->Image,
			'listingSellerAccountID' => $listing->Seller,
			'listingSeller' => $listingSeller,
			'listingPrice' => $listing->Price,
			'listingRating' => $listing->Rating]);
	}

	// Displays the productReviewConfirmation view
	public function productReviewConfirmation($listingID, $operation)
	{
		home::displayHeader();
		listingController::displayHeader($listingID);

		self::view('productReview/productReviewConfirmation', ['operation' => $operation]);
	}
}

?>