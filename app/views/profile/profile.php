<?php
	$accountID = $data['accountID'];
	$accountType = $data['accountType'];

	$profileID = $data['profileID'];
	$bio = $data['bio'];
	$rating = $data['rating'];
	$fullName = $data['fullName'];
	$occupation = $data['occupation'];
	$location = $data['location'];
	$privacy = $data['privacy'];

	$username = $data['username'];
	$banned = $data['banned'];
?>

<html>
<head>
</head>

<body>
	<div>
		<h3><?= $profileID == $accountID ? 'Your' : $username . "'s" ?> Profile</h3>
	</div>

	<br />

	<table>
		<tr>
			<td>
				<?php
					if($privacy == 0 || $profileID == $accountID) {
				?>
						<div>
							<?= htmlentities($username) ?> is <?= htmlentities($fullName) ?>	
						</div>
				<?php
					}
					else {
				?>
						<div>
							<?= htmlentities($username) ?>'s Profile is private
						</div>
				<?php
					}
				?>

				<div>
					<?= is_null($rating) ? 'Not Rated' : "Rating: $rating/5" ?>
				</div>
			</td>
		</tr>

		<?php
			if(!is_null($bio)) {
		?>
				<tr>
					<td>
						<br />

						Bio<br />
						<?= nl2br(htmlentities($bio)) ?>
					</td>
				</tr>
		<?php
			}
		?>

		<?php
			if($privacy == 0 || $profileID == $accountID) {
		?>

				<?php
					if(!is_null($occupation)) {
				?>
						<tr>
							<td>
								<br />

								Occupation<br />
								<?= nl2br(htmlentities($occupation)) ?>
							</td>
						</tr>
				<?php
					}
				?>

				<?php
					if(!is_null($location)) {
				?>
						<tr>
							<td>
								<br />

								Location<br />
								<?= nl2br(htmlentities($location)) ?>
							</td>
						</tr>
				<?php
					}
				?>
		<?php
			}
		?>

	</table>

	<?php
		if(!is_null($accountType) && $profileID != $accountID) {
	?>
			<br />

			<form method="POST" action="/public/reportController/fillOutReport/<?= $accountID ?>">
				<input class="btn btn-danger" type="submit" value="Report" />
			</form>
	<?php
		}
	?>

	<?php
		if(!is_null($accountType) && $accountType == 0 && $profileID != $accountID) {
	?>
			<form method="POST" action="/public/accountController/banAccount/<?= $profileID ?>">
				<input class="btn btn-danger" type="submit" value="<?= $banned == 0 ? 'Ban' : 'Unban' ?>" />
			</form>
	<?php
		}
	?>
</body>
</html>