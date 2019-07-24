<?php
//$listingName      = $data['listingName'];
//$listingPrice     = $data['listingPrice'];
//$listingQuantity  = $data['listingQuantity'];
?>
<html>
<head>
<meta charset="UTF-8">
<title>Your Shopping Cart</title>
<!-- Latest compiled and minified CSS -->
<!-- <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->

</head>
<body> 
<div class="panel-title">
                        <div class="row">
                            <div class="col-xs-6">
                                <h2 align="center"><span class="glyphicon glyphicon-shopping-cart"></span> Your Shopping Cart</h2>
                            </div>
                            
                        </div>
                    </div>


<div class="container" method="Post" style="width:70%;">

       
    
    
  <?php

	$listingOption = $this->model('ListingOptions');
    $username = $this->model('Account');

	$total=0;
	
    
     	for($index = 0; $index < $data['cart']->count(); $index++)
		{
			$sellerName = null;
      		$listingOption = $listingOption->find($data['cart']->get($index)->Option_Id);
            $listing = $listingOption->listing;
            $sellerId = $listing->Seller;          
           
            $sellerName = $username->where('Account_Id', $sellerId)->first();
          
	
			$total = $total + (($listing->Price) * ($data['cart']->get($index)->Quantity));
            
echo "<div class=\"row\">\n"; 
echo "                        <div class=\"col-xs-2\"><img height='100px' width='100px' src='data:image/jpeg;base64," . base64_encode($listingOption->Image) . "' />\n"; 
echo "                        </div>\n"; 
echo "                        <div class=\"col-xs-4\">\n"; 
echo "                            <h4 class=\"product-name\">
<a href='/public/listingController/viewDetails/$listing->Listing_Id/$listingOption->Option_Id'>" . htmlentities($listing->Title) . "</a> </br> &nbsp;&nbsp;&nbsp; <i>from <a href='/public/profileController/viewProfile/$sellerId'>". htmlentities($sellerName->Username) . "</a> </i>";
echo "                       \n"; 
?>
 <?= isset($listingOption->Size) || isset($listingOption->Color) ? '<br />' : '' ?>
                                    <?= isset($listingOption->Size) ? "<br />Size: " . htmlentities($listingOption->Size) : '' ?>
                                    <?= isset($listingOption->Color) ? "<br />Color: " . htmlentities($listingOption->Color) : '' ?>
<?php                                    
echo "                     </div>  <div class=\"col-xs-6\">\n"; 
echo "                            <div class=\"col-xs-6 text-left\">\n"; 
echo "                                <h6><strong>$listing->Price  <span class=\"text-muted\">x</span></strong></h6>\n"; 


echo "                               <form method='POST' style='height:2px;' action='/public/cartController/updateItem/".$data['cart']->get($index)->Cart_Id."'>".
                     "<input type='number' min='1' name='updateQty' value=".$data['cart']->get($index)->Quantity." style='width: 40px;'>".
                    "<input type='submit' name='update' value='update'></form>"; 
echo "                            </div>\n"; 
echo "                            <div class=\"col-xs-2\">\n 
<form method='POST' style='height:5px;' action='/public/cartController/removeItem/" . $data['cart']->get($index)->Cart_Id."'>";
                 
echo "                                </br><input type=\"submit\" name=\"remove\" value=\" \" class=\"btn btn-link btn-xs\">\n</form></br>"; 
echo "                                    <span class=\"glyphicon glyphicon-trash\"> </span>\n"; 
echo "                                </button>\n
 <form method='POST' style='height:5px;' action='/public/shoppingCartController/transferCartToWishlist/" . $data['cart']->get($index)->Cart_Id .
                           # $data['cart']->get($index)->Cart_Id, $data['cart']->get($index)->Listing_Id
                     "'></br><input type='submit' name='send' value='save for later'></form></br></td>" ;

echo "                            </div>\n"; 
echo "                        </div>\n"; 
echo "                    </div>   \n";

         }
    ?>
	
      
	
        <div class="panel-footer">
                    <div class="row text-center">
                        <div class="col-xs-9">
                            <h4 class="text-right">Total:  <strong>$<?php echo $total ?> </strong></h4>
                        </div>
                        <div class="col-xs-3">
                        <form method='POST' style='height:5px;'>
                            <input type="submit" name="checkout" value="checkout" class="btn btn-success btn-block">
                               
                            </form>
                        </div>
                    </div>
                </div>
    
       

    </div>
    </div>
 </body>
</html>