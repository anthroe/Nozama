<?php

class addressController extends Controller
{
	// Displays all the addresses associated with the account with the given Account_Id
	public function viewAddresses($accountID)
	{
		home::displayHeader();
		accountController::displayHeader($accountID);

		$addresses = Address::where('Account_Id', $accountID)
							->orderby('Address_Id', 'ASC');;

		self::view('address/addresses', ['addresses' => $addresses->get()]);
	}

	// Displays an address view for each address in the given array
	public function viewAddressHelper($addresses)
	{	
		for($count = 0; $count < $addresses->count(); $count++)
		{
			$address = $addresses->get($count);

			self::view('address/address', [
				'accountID' => $_SESSION['accountID'],
				'addressID' => $address->Address_Id,
				'addressLine1' => $address->Address_Line_1,
				'addressLine2' => $address->Address_Line_2,
				'city' => $address->City,
				'stateProvince' => $address->State_Province,
				'zipPostalCode' => $address->Zip_Postal_Code,
				'country' => $address->Country,
				'addressIndex' => $count]);
		}
	}

	//  Displays the editAddress form and handles inserting, updating and deleting addresses
	public function editAddress($addressID = null)
	{
		$address = Address::find($addressID); // Get the addresses associated with the account for an edit

		if(is_null($address))
		{
			$address = new Address(); // Create a new address instance for adding
		}

		if(isset($_POST['add']) || isset($_POST['edit']))  // Add or edit an address
		{
			# ****************************************************************************
			# **********EDIT SHIPPING ADDRESS + ADD ALTERNATIVE SHIPPING ADDRESS**********
			# ****************************************************************************
			$address->Account_Id = $_SESSION['accountID'];
			$address->Address_Line_1 = trim($_POST['addressLine1']);
			$address->Address_Line_2 = trim($_POST['addressLine2']);
			$address->City = trim($_POST['city']);
			$address->State_Province = trim($_POST['stateProvince']);
			$address->Zip_Postal_Code = trim($_POST['zipPostalCode']);
			$address->Country = trim($_POST['country']);
			$address->save();

			//  Generate add address notification
			if(isset($_POST['add']))
			{
				notificationController::addAddressNotif($address->Account_Id);
			}
			else // Generate edit address notification
			{
				notificationController::editAddressNotif($address->Account_Id);
			}	
			
			// Redirect to the list of addresses
			header('Location: '. '/public/addressController/viewAddresses/' . $_SESSION['accountID']);
		}
		else if(isset($_POST['delete'])) // Delete an address
		{
			$address->delete();
			
			// Redirect to the list of addresses
			header('Location: '. '/public/addressController/viewAddresses/' . $_SESSION['accountID']);
		}
		else // Display the address form
		{	
			home::displayHeader();
			accountController::displayHeader($_SESSION['accountID']);

			self::view('address/addAddress', [
					'addressID' => $addressID,
					'addressLine1' => $address->Address_Line_1,
					'addressLine2' => $address->Address_Line_2,
					'city' => $address->City,
					'stateProvince' => $address->State_Province,
					'zipPostalCode' => $address->Zip_Postal_Code,
					'country' => $address->Country]);
		}
	}

	// Switches the first address's values with the desired address
	public function switchDefaultAddress($addressID)
	{
		$defaultAddress = Address::where('Account_Id', $_SESSION['accountID'])->first();
		$newDefaultAddress = Address::find($addressID);
		$tempAddress = new Address();

		$tempAddress->copy($defaultAddress);
		$defaultAddress->copy($newDefaultAddress);
		$newDefaultAddress->copy($tempAddress);

		$defaultAddress->save();
		$newDefaultAddress->save();

		// Redirect to the list of addresses
		header('Location: '. '/public/addressController/viewAddresses/' . $_SESSION['accountID']);
	}
}

?>