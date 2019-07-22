<?php
   $accountID = $data['accountID'];
   $accountType = $data['accountType'];
   $username = $data['username'];
   
   $cartItems = $data['cartItems'];
   ?>
<html>
   <head>
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <!-- jQuery library -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
      <!-- Latest compiled JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   </head>
   <body>
   
      <div>
         <nav class="navbar navbar-default">
		 
            <div class="container-fluid">
               <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  </button>
			   </div>
			  
			   
               <div class="collapse navbar-collapse" id="myNavbar"style="margin-right:10%">
			  
                  <ul class="nav navbar-nav">
				  <li class="dropdown"><a href="./index.html"><img src="./media/logo/header.png" width="100px" height="80px" style="margin: -20px -10px -20px -20px;"></a></li>
				  <?php
                        if(!is_null($accountType)) {
                        ?>
                     <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href=""><?= $username ?><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                           <li>
                              <a href="/Nozama/public/accountController/editAccount/<?= $accountID ?>">Account</a>
                           </li>
                           <li>
                              <a href="/Nozama/public/profileController/viewProfile/<?= $accountID ?>">Profile</a>
                           </li>
                           <li>
                              <a href="/Nozama/public/orderController">Orders</a>
                           </li>
                           <li>
                              <a href="/Nozama/public/wishlistController/viewUserWishlist/<?= $accountID ?>">Wishlist</a>
                           </li>
                        </ul>
                     </li>
                     <?php
                        }
                        ?>
                     <?php
                        if(!is_null($accountType)) {
                        ?>
                     <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="">Listings<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                           <li>
                              <a href="/Nozama/public">View</a>
                           </li>
                           <li>	
                              <a href="/Nozama/public/listingController/postListing">Post</a>
                           </li>
                           <li>
                              <a href="/Nozama/public/orderController/getSales/<?= $accountID ?>">All Sales</a>
                           </li>
                        </ul>
                     </li>
                     <?php
                        }
                        ?>
                     <?php
                        if(!is_null($accountType)) {
                        ?>
                     <?php
                        if($accountType == 0) {
                        ?>
                     <li>
                        <a href="/Nozama/public/reportController">Reports</a>
                     </li>
                     <?php
                        }
                        ?>
                     <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href=""><?= $accountType == 0 ? 'Tickets' : 'Support' ?><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                           <li>
                              <a href="/Nozama/public/ticketController">View <?= $accountType == 1 ? 'Tickets' : '' ?></a>
                           </li>
                           <li>
                              <a href="/Nozama/public/ticketController/fillOutTicket/<?= $accountID ?>">Submit <?= $accountType == 1 ? 'Ticket' : '' ?></a>
                           </li>
                           <?php
                              if($accountType == 0) {
                              ?>
                           <li>
                              <a href="/Nozama/public/orderController/searchForOrder">Order Search</a>
                           </li>
                           <?php
                              }
                              ?>
                        </ul>
                     </li>
                     <?php
                        }
                        ?>
                  </ul>
                  <?= listingController::displaySearch() ?>
                  <ul class="nav navbar-nav navbar-right">
                     <?php
                        if(!is_null($accountType)) {
                        ?>
                     <li>
                        <?= notificationController::showNotifications($accountID) ?>
                     </li>
                     <?php
                        }
                        ?>
                     <!-- <li>
                        <a href="/Nozama/public/shoppingCartController/viewCart/<?= $accountID ?>">Shopping Cart</a>
                        </li> -->
                     <li style="margin-left: 5px;">
                        <button class="btn btn-default navbar-btn form-control" value="Shopping Cart">
                        <a href="/Nozama/public/shoppingCartController/viewCart/<?= $accountID ?>"><i class="glyphicon glyphicon-shopping-cart"></i> Cart <?php if(!is_null($accountType)) { ?><span class="badge" style="background-color: #337ab7;"><?= $cartItems ?></span><?php } ?></a>
                        </button>
                     </li>
                     <?php
                        if(is_null($accountType)) {
                        ?>
                     <li>
                        <button class="btn btn-link navbar-btn form-control" value="Login">
                        <a href="/Nozama/public/loginController">Login</a>
                        </button>
                     </li>
                     <?php
                        }
                        else {
                        ?>
                     <li>
                        <button class="btn btn-link navbar-btn form-control" value="Logout">
                        <a href="/Nozama/public/loginController/logout">Logout</a>
                        </button>
                     </li>
                     <?php
                        }
                        ?>
               </div>
               </ul>
            </div>
      </div>
      </nav> 

   </body>
</html>