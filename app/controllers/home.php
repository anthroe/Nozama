<?php

#DON'T FORGET
#USERS DON'T HAVE TO BE LOGGED IN SO THE WEBSITE SHOULD STILL WORK ANYWAYS

class home extends Controller
{
	public function index()
	{
		# TEMPORARY HARDCODE
		// $account = Account::where('Username', 'Admin')->first();
		// $_SESSION['accountID'] = $account->Account_Id;
		// $_SESSION['accountType'] = $account->Type;

		self::displayHeader();
		listingController::setup();
	}

	// Displays the website's header
	public function displayHeader()
	{
		self::setSessionNulls();

		$cart = ShoppingCart::where('Account_Id', $_SESSION['accountID'])->get();

		$account = Account::find($_SESSION['accountID']);
		$username = is_null($account) ? null : $account->Username;
		self::view('home/header', [
			'accountID' => $_SESSION['accountID'],
			'accountType' => $_SESSION['accountType'],
			'username' => $username,
			'cartItems' => $cart->count()]);
	}

	// Sets the session variables to null if they are not set
	public function setSessionNulls()
	{
		if(!isset($_SESSION['accountID'], $_SESSION['accountType']))
		{
			$_SESSION['accountID'] = null;
			$_SESSION['accountType'] = null;
		}
		else
		{
			self::checkBannedUser($_SESSION['accountID']);
		}
	}

	// Checks if the account with the given accountID is banned
	public function checkBannedUser($accountID)
	{
		$account = Account::find($accountID);

		if($account->Banned == 1)
		{
			// Redirect the banned user
			header('Location: '. '/Nozama/public/home/bannedUser');
		}
	}

	// The page seen when banned user's login
	public function bannedUser()
	{
		// Log the user out
		$_SESSION['accountID'] = null;
		$_SESSION['accountType'] = null;


		self::view('home/banned', []);
	}
}

?>