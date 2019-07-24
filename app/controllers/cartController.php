<?php

use Illuminate\Support\Facades\Auth;
require_once 'home.php';

class cartController extends Controller {
	
	public function index() {
		
		if(isset($_POST["checkout"]))
		{	 
			echo '<script>alert("Proceeding to checkout")</script>';
			echo '<script type="text/javascript">
				window.location = "/public/checkoutController"
				</script>';					
		} 
		else
		{
			$this->viewCart();
		}	
	}
	
	public function viewCart()
	{
		home::displayHeader();
		// $_SESSION['accountID'] = 3;
		
		$cart = $this->model('Shopping_Cart');
		
		$accountTable = $this->model('Account');
		
		
		
		//get user's cart

		$cart = $cart->where('Account_Id',$_SESSION['accountID'])->get();
		//get listing id from cart
		//$listing = $listing->find($cart->Listing_Id);
		
		$this->view('shoppingCart/shopping_cart',[
			'cart' => $cart	
		]);

	}

	# ************************************
	# **********DELETE FROM CART**********
	# ************************************
	public function removeItem($Cart_Id){
		$cart = $this->model('Shopping_Cart');
		$cart = $cart->find($Cart_Id);
		$cart = $cart->delete();
		echo '<script>alert("Product has been removed")</script>';	
		echo '<script type="text/javascript">
			window.location = "/public/cartController"
			</script>';	
		
	}


	public function updateItem($Cart_Id){
		$cart = $this->model('Shopping_Cart');
	
		$cart = $cart->find($Cart_Id);
		$listingOption = $this->model('ListingOptions')->find($cart->Option_Id);

		$listingStock = $listingOption->Stock;

		# ****************************************
		# **********MODIFY ITEM QUANTITY**********
		# ****************************************
		$cart->Quantity = $_POST['updateQty'];
		
		if(($_POST['updateQty'] > $listingStock)){
			echo '<script>alert("Your item cannot exceed the amount of stock left.")</script>';	
		}else{
			$cart->save();
			echo '<script>alert("Cart has been updated")</script>';
		}
		
		echo '<script type="text/javascript">
			window.location = "/public/cartController"
			</script>';	
		
	}		 

	public function sendToWishlist($Cart_Id, $Listing_Id){
		/*$cart = $this->model('Shopping_Cart');
	
		$cart = $cart->find($Cart_Id);
		$listing = $this->model('Listing')->find($cart->Listing_Id);

		$listingStock = $listing->Stock;

		$cart->Quantity = $_POST['updateQty'];
		
			$cart = $this->model('Shopping_Cart');
			$cart = $cart->find($Cart_Id);
			$cart = $cart->delete(); */
		echo '<script>alert("Item has been sent to your wishlist")</script>';
		
		
		echo '<script type="text/javascript">
			window.location = "/public/cartController"
			</script>';	
		
	}	
	
}
?>