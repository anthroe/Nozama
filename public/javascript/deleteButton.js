addEvent(window, "load", setup, false);

var deleteButton;
var deleteConfirmation;
var noButton;

// Get all the needed html elements and add events
function setup() {
	deleteButton = document.getElementById("deleteButton");
	deleteConfirmation = document.getElementById("deleteConfirmation");
	noConfirmation = document.getElementById("noButton");

	if(deleteButton == null)
		return;
	
	hideConfirmation();

	addEvent(deleteButton, "click", showConfirmation, false);
	addEvent(noConfirmation, "click", hideConfirmation, false);
}

// Show the yes/no confirmation and hide the delete button
function showConfirmation() {
	deleteButton.style.display = "none";
	deleteConfirmation.style.display = "";
}

// Hide the yes/no confirmation and show the delete button
function hideConfirmation() {
	deleteButton.style.display = "";
	deleteConfirmation.style.display = "none";
}