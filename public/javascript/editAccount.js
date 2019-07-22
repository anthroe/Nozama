addEvent(window, "load", setup, false);

var newPasswordInput;
var confirmPasswordInput;

// Get all the needed html elements and add events
function setup() {
	newPasswordInput = document.getElementById("newPassword");
	confirmPasswordInput = document.getElementById("confirmPassword");

	addEvent(newPasswordInput, "change", requirePasswordConfirmation);
}

// Changes the required attribute of the passwordConfirmation input
function requirePasswordConfirmation() {
	if(newPasswordInput.value == "")
		confirmPassword.required = false;
	else
		confirmPassword.required = true;
}