addEvent(window, "load", setup, false);

var deleteButton;
var deleteConfirmation;
var noButton;

// Get all the needed html elements and add events
function setup() {
	deleteButton = document.getElementsByClassName("deleteButton");
	deleteConfirmation = document.getElementsByClassName("deleteConfirmation");
	noConfirmation = document.getElementsByClassName("noButton");

	// Hide every yes/no confirmation
	for(var index = 0; index < deleteConfirmation.length; index++)
		deleteConfirmation[index].style.display = "none";

	// Add events to every deleteButton and noConfirmation 
	for(var index = 0; index < deleteButton.length; index++) {
		addEvent(deleteButton[index], "click", function() { showConfirmation(this, deleteConfirmation[this.value]); }, false);
		addEvent(noConfirmation[index], "click", function() { hideConfirmation(deleteButton[this.value], deleteConfirmation[this.value]); }, false);
	}
}

// Show the yes/no confirmation and hide the delete button
function showConfirmation(button, confirmation) {
	button.style.display = "none";
	confirmation.style.display = "";
}

// Hide the yes/no confirmation and show the delete button
function hideConfirmation(button, confirmation) {
	button.style.display = "";
	confirmation.style.display = "none";
}