addEvent(window, "load", setup, false);

var searchForm;
var filterForm;

var priceLowInput;
var priceHighInput;
var minRatingSelect;
var sortSelect;

function setup() {
	searchForm = document.getElementById("searchForm");
	filterForm = document.getElementById("filterForm");

	priceLowInput = document.getElementById("priceLowInput");
	priceHighInput = document.getElementById("priceHighInput");
	minRatingSelect = document.getElementById("minRatingSelect");
	sortSelect = document.getElementById("sortSelect");

	addEvent(priceLowInput, "change", submitFilterForm, false);
	addEvent(priceHighInput, "change", submitFilterForm, false);
	addEvent(minRatingSelect, "change", submitFilterForm, false);
	addEvent(sortSelect, "change", submitFilterForm, false);
}

function submitFilterForm() {
	searchForm.submit();
	filterForm.submit();
}