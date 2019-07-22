<?php


class registrationController extends Controller {
	
	public function index() {
		$this->addUser();
	}

	public function addUser() {
		
		$accountTable = $this->model('Account');
		$profileTable = $this->model('Profile');
		$addressTable = $this->model('Address');
		
		if(isset($_POST['username']) && isset($_POST['passwordHash']) && isset($_POST['email'])
		&& isset($_POST['address1']) && isset($_POST['city']) && isset($_POST['state'])
		&& isset($_POST['zip']) && isset($_POST['country'])) {
			

			# ******************************************
			# **********REGISTER A NEW ACCOUNT**********
			# ******************************************
			$accountTable->Username = $_POST['username'];
			$accountTable->PasswordHash = password_hash($_POST["passwordHash"], PASSWORD_BCRYPT, array('salt' => uniqid(mt_rand(), true)));
			$accountTable->Email = $_POST['email'];
			
			$accountTable -> save();
			
			$addressTable->Account_Id = $accountTable->Account_Id;
			$profileTable->Profile_Id = $accountTable->Account_Id;
			$profileTable->Full_Name = $_POST['fullName'];
			
			$addressTable->Address_Line_1 = $_POST['address1'];
			$addressTable->Address_Line_2 = $_POST['address2'];
			$addressTable->City = $_POST['city'];
			$addressTable->State_Province = $_POST['state'];
			$addressTable->Zip_Postal_Code = $_POST['zip'];
			$addressTable->Country = $_POST['country'];
			
			$addressTable -> save();
			$profileTable -> save();

			// Geenrate registration notification
			notificationController::registerNotif($accountTable->Account_Id);
			
			echo "<script type='text/javascript'>'" .
				 	"alert('You have successfully registered!');" .
				 "</script>";
			
			echo '<script type="text/javascript">' .
           			'window.location = "loginController/index"' .
      			 '</script>';
		}
		else {
			home::displayHeader();

			$this->view('home/register', []);
		}
	}
}

?>