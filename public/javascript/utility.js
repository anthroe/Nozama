// Add events
function addEvent(object, evName, fnName, cap) {
	if(object.attachEvent) {
		object.attachEvent("on" + evName, fnName);
	}
	else if(object.addEventListener) {
		object.addEventListener(evName, fnName, cap);
	}
}

// Remove events
function removeEvent(object, evName, fnName, cap) {
	if(object.detachEvent) {
		object.detachEvent("on" + evName, fnName);
	}
	else if(object.removeEventListener) {
		object.removeEventListener(evName, fnName, cap);
	}
}

// Get the style values
function getStyle(object, styleName) {
   if(window.getComputedStyle) {
      return document.defaultView.getComputedStyle(object).getPropertyValue(styleName);
   } 
   else if(object.currentStyle) {
      return object.currentStyle[styleName];
   }
}

// Set the opacity
function setOpacity(object, value) {
   // Apply the opacity value for IE and non-IE browsers
   object.style.filter = "alpha(opacity = " + value + ")";
   object.style.opacity = value/100;
}

// Removes some of the default webpage events
function removeDefaults() {
	// Removes the default highlight text event
	window.onmousedown = function() {
		return false;
	}
}

// Removes some of the default webpage key events
function removeDefKeys(e) {
	var evt = e || window.event;

	// Backspace
	if(evt.keyCode == 8)
		evt.preventDefault();

	// F5
	// if(evt.keyCode == 116)
	// 	evt.preventDefault();

	// Tab
	if(evt.keyCode == 9)
		evt.preventDefault();
}

// Generate a random number within the specified range
function randNumbGen(low, high) {
	var rand = Math.floor(Math.random() * 100000) % (high - low) + low;

	return rand;
}

// FadeIn the given object to the given high limit
function fadeIn(obj, high, current, delay, interval) {
	if(current >= high)
		return;
	
	current++;

	setTimeout(function() {
		setOpacity(obj, current);
	}, delay);

	delay += interval;

	fadeIn(obj, high, current, delay, interval);
}

// FadeOut the given object to the given high limit
function fadeOut(obj, current, delay, interval) {
	if(current <= 0) {
		setTimeout(function() {
			document.body.removeChild(obj);
		}, delay);
		
		return;
	}
	
	current--;

	setTimeout(function() {
		setOpacity(obj, current);
	}, delay);

	delay += interval;

	fadeOut(obj, current, delay, interval);
}

/** The recursive function that will grow the given object
  * @param obj  The object to grow
  * @param highX  The max width to grow the object to
  * @param highY  The max height to grow the object to
  * @param currentX  The object's current width
  * @param currentY  The object's current height
  * @param delay  The initial delay to grow the object
  * @param interval  The overall delay to grow the object
  */
function grow(obj, highX, highY, currentX, currentY, delay, interval) {
	if(currentX >= highX && currentY >= highY)
		return;


	if(currentX < highX)
		currentX += highX/highY;
	
	if(currentY < highY)
		currentY++;

	setTimeout(function() {
		obj.style.width = (currentX) + "px";
		obj.style.height = (currentY) + "px"; 
	}, delay);

	delay += interval;

	grow(obj, highX, highY, currentX, currentY, delay, interval);
}

/** The recursive function that will shrink the given object
  * @param obj  The object to shrink
  * @param currentX  The object's current width
  * @param currentY  The object's current height
  * @param delay  The initial delay to shrink the object
  * @param interval  The overall delay to shrink the object
  */
function shrink(obj, currentX, currentY, delay, interval) {
	if(currentX <= 0 && currentY <= 0) {
		setTimeout(function() {
			document.body.removeChild(obj);
		}, delay);

		return;
	}

	if(currentX > 0)
		currentX -= currentX/currentY;
	
	if(currentY > 0)
		currentY--;

	setTimeout(function() {
		obj.style.width = (currentX) + "px";
		obj.style.height = (currentY) + "px";
	}, delay);

	delay += interval;

	shrink(obj, currentX, currentY, delay, interval);
}