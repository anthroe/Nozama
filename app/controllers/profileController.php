<?php

#HOW:
#DISPLAY USER REVIEWS (VIEW/ADD/EDIT) SEPARATE FROM THE USER'S OWN REVIEWS (LISTINGS/OTHER USERS)

#INTEGRATE LISTINGS (REDIRECT TO HOME BUT WITH SELLER CONDITION PRESET)
#INTEGRATE PRODUCT REVIEWS

class profileController extends Controller
{
	// Displays the profile of the user with which the given Profile_Id is associated
	public function viewProfile($profileID)
	{
		home::displayHeader();

		$profile = Profile::find($profileID);

		self::displayHeader($profileID);

		# ********************************
		# **********VIEW PROFILE**********
		# ********************************
		self::view('profile/profile', [
			'accountID' => $_SESSION['accountID'],
			'accountType' => $_SESSION['accountType'],
			'profileID' => $profileID,
			'bio' => $profile->Bio,
			'rating' => $profile->User_Rating,
			'fullName' => $profile->Full_Name,
			'occupation' => $profile->Occupation,
			'location' => $profile->Location,
			'privacy'=> $profile->Privacy,
			'username' => $profile->account->Username,
			'banned' => $profile->account->Banned]);
	}

	// Displays the profile section's header
	public function displayHeader($profileID)
	{
		$profile = Profile::find($profileID);
		$userReviewCount = UserReview::where('Account_Id', $_SESSION['accountID'])->get()->count();
		self::view('profile/profileHeader', [
				'accountID' => $_SESSION['accountID'],
				'accountType' => $_SESSION['accountType'],
				'profileID' => $profileID,
				'privacy' => $profile->Privacy,
				'userReviewCount' => $userReviewCount]);
	}

	// NOT DONE: HAVENT EVEN STARTED
	public function profileReviews($profileID)
	{
		home::displayHeader();
		self::displayHeader($profileID);
	}

	// Displays the wishlist of the user with which the given Profile_Id is associated
	public function profileWishlist($profileID)
	{
		home::displayHeader();
		self::displayHeader($profileID);

		// Get the wishes associated with the given Account_Id, ordred by newest first
		$wishlist = Wishlist::where('Account_Id', $profileID)
						    ->orderby('Date', 'DESC');

		self::view('wishlist/wishlist', [
			'owner' => Account::find($profileID)->Username,
			'wishlist' => $wishlist->get(),
			'viewingUser' => $profileID]);
	}

	// Displays an editProfile view handling the form POST data from it to edit a profile
	public function editProfile($profileID)
	{
		$profile = Profile::find($profileID); // Get the profile associated with the given Profile_Id

		if(isset($_POST['edit'])) // Handle the form POST data and edit the profile
		{
			// Manipulate the form POST data to convert empty or whitespace strings into null
			$_POST = array_map('trim', $_POST);
			$_POST = array_map(
				function($value){
		        	return ($value == '') ? null : $value;
		    	}
		   	, $_POST);

			# ********************************
			# **********EDIT PROFILE**********
			# ********************************
			// Edit the profile
			$profile->Full_Name = trim($_POST['fullName']);
			$profile->Bio = trim($_POST['bio']) == '' ? NULL :  trim($_POST['bio']);
			$profile->Occupation = trim($_POST['occupation']) == '' ? NULL :  trim($_POST['occupation']);
			$profile->Location = trim($_POST['location']) == '' ? null :  trim($_POST['location']);

			# **********************************
			# **********CHANGE PRIVACY**********
			# **********************************
			$profile->Privacy = $_POST['privacy'];
			$profile->save();

			// Generate edit profile notification
			notificationController::editProfileNotif($profileID);

			// Redirect to the user's profile
			header('Location: '. '/public/profileController/viewProfile/' . $profileID);
		}
		else // Display the form
		{
			home::displayHeader();
			self::displayHeader($profileID);

			self::view('profile/editProfile', [
				'profileID' => $profile->Profile_Id,
				'fullName' => $profile->Full_Name,
				'bio' => $profile->Bio,
				'occupation' => $profile->Occupation,
				'location' => $profile->Location,
				'privacy' => $profile->Privacy]);
		}
	}

	// Updates the rating of the profile with the given Profile_Id
	public function updateRating($profileID)
	{
		// Get the profile and the associated userReviews
		$profile = Profile::find($profileID);
		$userReviews = UserReview::where('To_Review', $profileID)->get();

		$profile->User_Rating = $userReviews->avg('Rating');
		$profile->save();
	}
}