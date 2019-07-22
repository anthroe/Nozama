addEvent(window, "load", setup, false);

var optionsForm;
var options;

// Get all the needed html elements and add events
function setup() {
	optionsForm = document.getElementById("optionsForm");
	options = document.getElementById("options");

	addEvent(options, "change", submitForm, false);
}

function submitForm() {
	optionsForm.submit();
}