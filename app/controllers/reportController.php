<?php

# TO DO: Account_Id --> Username ?
# Check user priviledges?
/* TO DO
		Adding to database
		success message
		Validation
*/

class reportController extends Controller
{
	
	public function index()
	{
		if($_SESSION['accountType'] != 0)
		{
			header("Location: ". "/public");
		}		

		// $_SESSION['accountID'] = 2;
		// $_POST['reportUserID'] = 1;
		// $_POST['reportListingID'] = null;
		// $_POST['fillOutReport'] = '';

		if(!empty($_POST))
		{
			if(isset($_POST['reportDetails'])) // Admin wants to view a specific report
			{
				self::getReport($_POST['reportDetails']); // Get a specific report if the user clicked the "View Details" button
			}

			if(isset($_POST['fillOutReport']))// User wants to submit a report
			{
				self::fillOutReport($_POST['reportUserID'], $_POST['reportListingID']); // Display form to submit a report
			}

			if(isset($_POST['submittedReport'])) // User submitted a report
			{
				self::submitReport($_POST); // Add ticket to database


			}

			if(isset($_POST['deleteReport'])) // Admin is deleting a report
			{
				self::deleteReport($_POST['deleteReport']);
			}
		}

		else // Display list of reports
		{
			self::getAllReports(); // Get all the records in Report table
		}
	}

	// Display all the reports (default on page load)
	// public function getAllReports()
	// {
	// 	$allReports = self::model('Report'); // Retrieves all reports in an array

	// 	//foreach($data[report] as $report)
	// 	for($index = 0; $index < $allReports->count(); $index++)
	// 	{
	// 		$reports = $allReports->get($index); // Retrieve each report record from the array

	// 		self::view('reports/reportList', [
	// 			'reportID' => $reports->Report_Id, 
	// 			'category' => $reports->Category, 
	// 			'subject' => $reports->Subject ]);
	// 	}
	// }

	// Display a specific report (clicked "View Details" button) with a given Report_Id 
	public function getReport($reportID)
	{
		home::displayHeader();

		$report = self::model('Report');
		$report = $report->find($reportID); // Get the specified report

		$account = self::model('Account');
		$account = $account->find($report->Account_Id); // Get the account of the user who submitted the report

		self::view('reports/viewReport', [
			'reportID' => $report->Report_Id,
			'category' => $report->Category, 
			'subject' => $report->Subject, 
			'comment' => $report->Comment, 
			'username' => $account->Username,
			'listingID' => $report->Listing_Id,
			'submittedOn' => $report->Submitted_On,
			'accountID' => $report->Account_Id ]);
	}

	// Display all the reports (default on page load)
	public function getAllReports()
	{
		home::displayHeader();

		$allReports = self::model('Report')->orderBy('Report_Id', 'desc')->get(); 
		//->orderBy('listingID', 'desc'); // Retrieves all reports in an array
		self::view('reports/reportList', ['reports' => $allReports]);
	}

	public function fillOutReport($accountID, $listingID = null) // Display the report form
	{
		home::displayHeader();

		if(!is_null($listingID))
		{
			listingController::displayHeader($listingID);
		}
		else
		{
			profileController::displayHeader($accountID);
		}

		self::view('reports/reportForm', ['accountID' => $accountID, 'listingID' => $listingID]);
	}

	public function submitReport($request) // Add a submitted report to database
	{	
		$report = self::model('Report');
		$report->set(array_map('trim', $request));

		$report->Category = $report->_category;
		$report->Subject = $report->_subject;
		$report->Comment = $report->_comment;
		$report->Account_Id = $report->_accountID;
		$report->Listing_Id = $report->_listingID;
		$report->Submitted_On = $report->_submittedOn;
		$report->save();

		// require_once '../app/controllers/notificationController.php';
		// $notificationController = new notificationController();
		notificationController::reportNotif($_SESSION['accountID']);
		
		// self::getAllReports();
		if(!is_null($report->Listing_Id))
		{
			// Redirect to back the listing's details
			header('Location: '. '/public/listingController/viewDetails/' . $report->Listing_Id);
		}
		else
		{
			// Redirect to back the user's profile
			header('Location: '. '/public/profileController/viewProfile/' . $report->Account_Id);
		}
	}

	// Delete a specific report with its given Report_Id
	public function deleteReport($reportID)
	{
		$report = self::model('Report');
		$report = $report->find($reportID);
		$report->delete();

		self::getAllReports();
	}
}

?>
