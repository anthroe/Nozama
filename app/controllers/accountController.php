<?php

class accountController extends Controller
{
	// Displays the account section's header
	public function displayHeader($accountID)
	{
		self::view('account/accountHeader', ['accountID' => $accountID]);
	}

	// Displays an editAccount view handling the form POST data from it to edit an account
	public function editAccount($accountID)
	{
		// For displaying a form error message to the user
		$errorMessage = isset($_SESSION['errorMessage']) ? $_SESSION['errorMessage'] : null;
		unset($_SESSION['errorMessage']);

		$account = Account::find($accountID);

		if(isset($_POST['edit'])) //  Handle the POST data and edit the account
		{
			$originalEmail = $account->Email;

			# ********************************
			# **********EDIT ACCOUNT**********
			# ********************************
			// Edit the account
			$account->Username = trim($_POST['username']);
			$account->Email = trim($_POST['email']);

			if(!self::validate($account))
			{
				// Redirect back to the edit account form
				header('Location: '. '/Nozama/public/accountController/editAccount/' . $accountID);
				return;
			}

			if($_POST['newPassword']) // If the user wanted to change their password
			{
				$account->PasswordHash = password_hash($_POST['newPassword'], PASSWORD_BCRYPT);
				notificationController::passwordChangeNotif($accountID); // Generate password change notification
			}

			// Generate email change notification
			if($originalEmail != $account->Email)
			{
				notificationController::emailChangeNotif($accountID);
			}

			$account->save();

			// Redirect back to the edit account form
			header('Location: '. '/Nozama/public/accountController/editAccount/' . $accountID);
		}
		else // Display the form
		{
			home::displayHeader();

			self::displayHeader($accountID);

			self::view('account/editAccount', [
				'accountID' => $accountID,
				'username' => $account->Username,
				'email' => $account->Email,
				'errorMessage' => $errorMessage]);
		}
	}

	// Validates the account form data
	protected function validate($account)
	{
		if(!$account->validate($account->Account_Id)) // Model validation
		{
			return false;
		} 
		if(!self::validatePassword($account)) // Invalid password
		{
			$_SESSION['errorMessage'] = 'Invalid Password';
			return false;
		}
		else if(!self::confirmPasswords()) // Passwords do not match
		{
			$_SESSION['errorMessage'] = 'Passwords Did Not Match';
			return false;
		}

		return true;
	}

	// Checks the password entered with the hash stored in the database
	protected function validatePassword($account)
	{
		$currentPasswordHash = $account->PasswordHash;
		$passwordInput = $_POST['password'];

		if(!password_verify($passwordInput, $currentPasswordHash))
		{
			return false;
		}

		return true;
	}

	// Checks if the user properly entered the new password
	protected function confirmPasswords()
	{
		if($_POST['newPassword'] != $_POST['confirmPassword'])
		{
			return false;
		}

		return true;
	}

	// Displays the accountConfirmation view
	public function accountConfirmation()
	{
		home::displayHeader();

		self::view('account/accountConfirmation', []);
	}

	# *****************************
	# **********BAN USERS**********
	# *****************************
	// Bans or unbans the account with the given Account_Id
	public function banAccount($accountID)
	{
		$account = Account::find($accountID);

		if($account->Banned == 0) // Not banned
		{
			$account->Banned = 1;
		}
		else // Banned
		{
			$account->Banned = 0;
		}

		$account->save();

		// Redirect back to the edit account form
		header('Location: '. '/Nozama/public/profileController/viewProfile/' . $accountID);
	}
}

?>