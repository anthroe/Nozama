<?php
	
use Illuminate\Support\Facades\Auth;

class loginController extends Controller {
	
	public function index() {

		if(isset($_POST['login'])){
			$this->login();
		}
		else {
			home::displayHeader();

			$this->form();
		}
	}

	public function form() {
		$this->view('home/login', []); 
	}

	// Validates the form data and sets the session variables
	public function login() {

		$accountTable = $this->model('Account');
		$userCheck = $accountTable->where('Username',$_POST['username'])->first();
		

		$decrypt =password_verify($_POST['passwordHash'], $userCheck->PasswordHash);
	
		if(isset($userCheck->Username) && $decrypt == true) {
			
			# *************************
			# **********LOGIN**********
			# *************************
			$_SESSION['accountID'] = $userCheck->Account_Id;
			$_SESSION['accountType'] =	$userCheck->Type;

			// Convert anonymous cart to user cart
			anonymousCartController::convertCart();

			// Redirect to the home page
			 header('Location: '. '/Nozama/public');
		} else {
			
			// Alert and redirect back to the login page
			echo "<script type='text/javascript'>" . 
					"alert('Invalid credentials');" .
					"window.location.replace(\"/Nozama/public/loginController\");".
				 "</script>";
		}
	}

	// Sets the session variables to null
	public function logout() {
		
		# **************************
		# **********LOGOUT**********
		# **************************
		$_SESSION['accountID'] = null;
		$_SESSION['accountType'] =	null;

		// Redirect to the home page
		header('Location: '. '/Nozama/public');
	}
}

?>