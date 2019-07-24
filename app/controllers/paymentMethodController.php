<?php

class paymentMethodController extends Controller
{
	// Displays all the paymentMethods associated with the account with the given Account_Id
	public function viewPaymentMethods($accountID)
	{
		home::displayHeader();
		accountController::displayHeader($accountID);

		$paymentMethods = PaymentMethod::where('Account_Id', $accountID)
									   ->orderby('Payment_Id', 'ASC');

		self::view('paymentMethod/paymentMethods', ['paymentMethods' => $paymentMethods->get()]);
	}

	// Displays a paymentMethod view for each paymentMethod in the given array
	public function viewPaymentMethodHelper($paymentMethods)
	{
		for($count = 0; $count < $paymentMethods->count(); $count++)
		{
			$paymentMethod = $paymentMethods->get($count);

			self::view('paymentMethod/paymentMethod', [
				'paymentID' => $paymentMethod->Payment_Id,
				'cardType' => $paymentMethod->Card_Type,
				'cardNumber' => $paymentMethod->Card_Number,
				'paymentIndex' => $count]);
		}
	}

	//  Displays the paymentMethod form and handles inserting, updating and deleting payment methods
	public function editPaymentMethod($paymentID = null)
	{
		// For displaying a form error message to the user
		$errorMessage = isset($_SESSION['errorMessage']) ? $_SESSION['errorMessage'] : null;
		unset($_SESSION['errorMessage']);

		$paymentMethod = PaymentMethod::find($paymentID);

		if(is_null($paymentMethod))
		{
			$paymentMethod = new PaymentMethod();
		}

		if(isset($_POST['add']) || isset($_POST['edit']))
		{
			$paymentMethod->Account_Id = $_SESSION['accountID'];
			$paymentMethod->Card_Type = trim($_POST['cardType']);
			$paymentMethod->Card_Number = trim($_POST['cardNumber']);
			
			if(!$paymentMethod->validate())
			{
				header('Location: '. '/public/paymentMethodController/editPaymentMethod/' . $paymentID);
				return;
			}

			$paymentMethod->save();

			//  Generate add payment method notification
			if(isset($_POST['add']))
			{
				notificationController::addPaymentNotif($paymentMethod->Account_Id);
			}
			else // Generate edit payment method notification
			{
				notificationController::editPaymentNotif($paymentMethod->Account_Id);
			}	
			
			// Redirect to the list of payment methods
			header('Location: '. '/public/paymentMethodController/viewPaymentMethods/' . $_SESSION['accountID']);
		}
		else if(isset($_POST['delete']))
		{
			$paymentMethod->delete();
			
			// Redirect to the plist of payment methods
			header('Location: '. '/public/paymentMethodController/viewPaymentMethods/' . $_SESSION['accountID']);
		}
		else
		{	
			home::displayHeader();
			accountController::displayHeader($_SESSION['accountID']);

			self::view('paymentMethod/addPaymentMethod', [
				'paymentID' => $paymentMethod->Payment_Id,
				'cardType' => $paymentMethod->Card_Type,
				'cardNumber' => $paymentMethod->Card_Number,
				'errorMessage' => $errorMessage]);
		}
	}

	// Switches the first payment method's values with the desired payment method
	public function switchDefaultPaymentMethod($paymentID)
	{
		$defaultPaymentMethod = PaymentMethod::where('Account_Id', $_SESSION['accountID'])->first();
		$newDefaultPaymentMethod = PaymentMethod::find($paymentID);
		$tempPaymentMethod = new PaymentMethod();

		$tempPaymentMethod->copy($defaultPaymentMethod);
		$defaultPaymentMethod->copy($newDefaultPaymentMethod);
		$newDefaultPaymentMethod->copy($tempPaymentMethod);

		$defaultPaymentMethod->save();
		$newDefaultPaymentMethod->save();

		// Redirect to the list of addresses
		header('Location: '. '/public/paymentMethodController/viewPaymentMethods/' . $_SESSION['accountID']);
	}
}

?>