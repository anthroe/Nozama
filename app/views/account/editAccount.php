<?php
	$accountID = $data['accountID'];
	$username = $data['username'];
	$email = $data['email'];

	$errorMessage = $data['errorMessage'];
?>

<html>
<head>
	<script type="text/javascript" src="/Nozama/public/javascript/utility.js"></script>
	<script type="text/javascript" src="/Nozama/public/javascript/editAccount.js"></script>
</head>

<body>
	<div>
		<div class="col-sm-offset-4 col-sm-10">
			<h3>Edit Your Account</h3>
		</div>


		<form class="form-horizontal" method="POST" action="/Nozama/public/accountController/editAccount/<?= $accountID ?>">
			<?php
				if(!is_null($errorMessage)) {
			?>
					<div class="form-group">
						<div class="col-sm-offset-4 col-xs-3 alert alert-danger">
							<strong><?= $errorMessage ?></strong>
						</div>
					</div>
			<?php
				}
			?>

			<div class="form-group">
				<label class="control-label col-sm-4">Username</label>

				<div class="col-xs-3"> 
					<input class="form-control" type="text" name="username" pattern="^(?!\s*$).+" title="whitespace only is invalid" value="<?= htmlentities($username) ?>" required />
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4">Email</label>

				<div class="col-xs-3"> 
					<input class="form-control" type="email" pattern="^(?!\s*$).+" title="whitespace only is invalid" name="email" value="<?= htmlentities($email) ?>" required />
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4">Current Password</label>
				
				<div class="col-xs-3"> 
					<input class="form-control" type="password" name="password" required />
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4">New Password</label>

				<div class="col-xs-3"> 
					<input class="form-control" type="password" name="newPassword" />
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4">Confirm Password</label>

				<div class="col-xs-3"> 
					<input class="form-control" type="password" name="confirmPassword" />
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-10">
					<button class="btn btn-default" type="submit" name="edit" value="Edit">Edit</button>
				</div>
			</div>
		</form>
	</div>
</body>
</html>