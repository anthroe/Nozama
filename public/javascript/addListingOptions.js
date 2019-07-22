addEvent(window, "load", setup, false);

var validExtension = ["jpg", "png", "gif", "tif", "jpeg"];
var maxFileSize = 8388608;

var imageUploadInput;
var colorOptionInput;
var sizeOptionInput;

// Get all the needed html elements and add events
function setup() {
	imageUploadInput = document.getElementsByClassName("imageUpload");
	colorOptionInput = document.getElementsByClassName("colorOption");
	sizeOptionInput = document.getElementsByClassName("sizeOption");

	// Required only if there are more than one set of options
	if(colorOptionInput.length > 1 && sizeOptionInput.length > 1)
		changeRequired();

	for(var index = 0; index < colorOptionInput.length; index++) {
		addEvent(imageUploadInput[index], "change", validateImage, false);
	
		if(colorOptionInput.length > 1 && sizeOptionInput.length > 1) {
			addEvent(colorOptionInput[index], "change", changeRequired, false);
			addEvent(sizeOptionInput[index], "change", changeRequired, false);
		}
	}
}

// Validates the file's extension and size
function validateImage() {
	var fileName = this.files[0].name;
	var fileExtension = fileName.split(".")[1];
	var fileSize = this.files[0].size;

	// if(validExtension.indexOf(fileExtension) == -1 || fileSize < maxFileSize)
	// 	this.value = null;
}

// Changes the input's required attribute dynamically making at least one of two inputs required in a set
function changeRequired() {
	for(var index = 0; index < colorOptionInput.length; index++) {
		changeRequiredHelper(colorOptionInput[index], sizeOptionInput[index]);
		changeRequiredHelper(sizeOptionInput[index], colorOptionInput[index]);
	}
}

// Changes the target input's required attrbute based on the value of the input being changed
function changeRequiredHelper(beingChanged, target) {
	if(beingChanged.value)
		target.required = false;
	else
		target.required = true;	
}