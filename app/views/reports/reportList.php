<?php
	//include'header.php';
?>
	<html>
	<head>
		<title>Nozama | Report List</title>
		<div class="container">
			<div class="row col-md-6">
				<h1 class="">Report List</h1>
			</div> 
		</div>
	</head>
	<body>
	<div class='container'>
		<div class="row">
			<table class="table table-striped col-md-6">
				<tr>
					<th>Report ID</th>
					<th>Category</th>
					<th>Subject</th>
					<th>Submitted On</th>
					<th>View Details</th>
					<th>Delete</th>
				</tr>

				<?php

					for($index = 0; $index < $data['reports']->count(); $index++)
					{
						$report = $data['reports']->get($index);
						
						echo "<tr>" . 
							 "<td>$report->Report_Id</td>" .
							 "<td>$report->Category</td>" .
							 "<td>$report->Subject</td>" .
							 "<td>$report->Submitted_On</td>" .
							 "<td>" .
							 "<form method='post' action='/nozama/public/reportController'>" . 
							 	"<input type='hidden' name='reportDetails' value='$report->Report_Id'>" .
							 	"<input type='submit' value='View Report' class='btn btn-info'>" .
							 "</form>" .
							 "</td>" .
							 "<td>" .
								 "<form method='post' action='/Nozama/public/reportController'>" . 
								 	"<input type='hidden' name='deleteReport' value='$report->Report_Id'>" .
								 	"<input type='submit' value='Delete' class='btn btn-danger'>" .
								 	"</form>" .
								 "</td>" .
							 "</tr>"; 
					}
				?>

			</table>
		</div>
	</div>
	</body>
	</html>