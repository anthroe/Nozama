<?php

#TO ADD LATER
#USERS CAN ONLY LEAVE REVIEWS IF THEY HAVE BOUGHT AN ITEM FROM THE SELLER

class userReviewController extends Controller
{
	# ************************************************
	# **********VIEW FEEDBACK OF OTHER USERS**********
	# ************************************************
	// Displays all the userReviews associated with the account with the given Profile_Id
	public function viewUserReview($profileID)
	{
		home::displayHeader();
		profileController::displayHeader($profileID);

		$userReviews = UserReview::where('To_Review', $profileID)
								 ->orderby('Date', 'DESC');

		self::view('userReview/userReviews', [
			'reviewedUsername' => Profile::find($profileID)->account->Username,
			'userReviews' => $userReviews->get()]);
	}

	// Displays a userReview view for each review in the given array
	public function viewReviewHelper($userReviews)
	{
		for($count = 0; $count < $userReviews->count(); $count++)
		{
			$userReview = $userReviews->get($count);

			$reviewer = $userReview->Account_Id == $_SESSION['accountID'] ? "You" : $userReview->account->Username;
			self::view('userReview/userReview', [
				'accountID' => $_SESSION['accountID'],
				'accountType' => $_SESSION['accountType'],
				'reviewedID' => $userReview->To_Review,
				'userReviewID' => $userReview->Review_Id,
				'reviewer' => $reviewer,
				'reviewerID' => $userReview->Account_Id,
				'title' => $userReview->Title,
				'message' => $userReview->Message,
				'rating' => $userReview->Rating,
				'date' => $userReview->Date,
				'viewIndex' => $count]);
		}
	}

	//  Displays the postReview form and handles inserting, updating and deleting userReviews
	public function postUserReview($reviewedID, $userReviewID = null)
	{
		// For keeping track of either an insert or an update
		$operation = 'edited';

		// Get the userReview for updating
		$userReview = UserReview::where('Account_Id', $_SESSION['accountID'])
								->where('To_Review', $reviewedID)->first();

		if(is_null($userReview)) // Create a new userReview instance for inserting
		{
			$userReview = new UserReview();
			$operation = 'submitted';
		}

		if(isset($_POST['post'])) // Insert or update a userReview
		{
			# *****************************************************************
			# **********EDIT REVIEW ON USER + LEAVE FEEDBACK ON USERS**********
			# *****************************************************************
			$userReview->To_Review = $reviewedID;
			$userReview->Account_Id = $_SESSION['accountID'];
			$userReview->Title = trim($_POST['title']);
			$userReview->Message = trim($_POST['message']);
			$userReview->Rating = $_POST['rating'];
			$userReview->Date = date("Y-m-d H:i:s");
			$userReview->save();

			// Update the profile's rating
			profileController::updateRating($reviewedID);

			// Generate a listing review notification for the owner of the listing
			if($operation == 'submitted')
			{
				notificationController::userFeedbackNotif($userReview->To_Review, $userReview->account->Username);
			}

			// Redirect to the confirmation
			header('Location: '. '/public/userReviewController/userReviewConfirmation/' . $reviewedID . '/' . $operation);
		}
		else if(isset($_POST['delete']) || isset($_POST['adminDelete'])) // Delete a userReview
		{
			if(!is_null($userReviewID))
			{
				$userReview = UserReview::find($userReviewID);
			}

			if(isset($_POST['adminDelete']))
			{
				notificationController::reviewDeleteNotif($userReview->Account_Id);
			}

			$userReview->delete();

			// Update the profile's rating
			profileController::updateRating($reviewedID);

			// Redirect to the confirmation
			header('Location: '. '/public/userReviewController/userReviewConfirmation/' . $reviewedID . '/deleted');
		}
		else // Display the userReview form
		{
			home::displayHeader();
			profileController::displayHeader($reviewedID);

			self::view('userReview/postReview', [
				'reviewedID' => $reviewedID,
				'reviewedUsername' => Account::find($reviewedID)->Username,
				'accountID' => $userReview->Account_Id,
				'rating' => $userReview->Rating,
				'title' => $userReview->Title,
				'message' => $userReview->Message]);
		}
	}

	// Displays the userReviewConfirmation view
	public function userReviewConfirmation($profileID, $operation)
	{
		home::displayHeader();
		profileController::displayHeader($profileID);

		self::view('userReview/userReviewConfirmation', ['operation' => $operation]);
	}
}

?>