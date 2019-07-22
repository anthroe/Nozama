<?php
	$profileID = $data['profileID'];
	$fullName = $data['fullName'];
	$bio = $data['bio'];
	$occupation = $data['occupation'];
	$location = $data['location'];
	$privacy = $data['privacy'];
?>

<html>
<head>
</head>

<body>
	<div>
		<div class="col-sm-offset-4 col-sm-10">
			<h3>Edit Your Profile</h3>
		</div>

		<form class="form-horizontal" method="POST">
			<div class="form-group">
				<label class="control-label col-sm-4">Full Name</label>

				<div class="col-xs-3"> 
					<input class="form-control" type="text" name="fullName" pattern="^(?!\s*$).+" title="whitespace only is invalid" value="<?= htmlentities($fullName) ?>" required />
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4">Bio</label>

				<div class="col-xs-3"> 
					<textarea class="form-control" name="bio"><?= htmlentities($bio) ?></textarea>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4">Occupation</label>

				<div class="col-xs-3"> 
					<input class="form-control" type="text" name="occupation" pattern="^(?!\s*$).+" title="whitespace only is invalid" value="<?= htmlentities($occupation) ?>" />
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4">Location</label>

				<div class="col-xs-3"> 
					<input class="form-control" type="text" name="location" pattern="^(?!\s*$).+" title="whitespace only is invalid" value="<?= htmlentities($location) ?>" />
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4">Privacy</label>

				<div class="col-xs-3"> 
					<select class="form-control" name="privacy" required>
						<option value="0" <?= $privacy == 0 ? 'selected' : '' ?>>Public</option>
						<option value="1" <?= $privacy == 1 ? 'selected' : '' ?>>Private</option>
					</select>
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