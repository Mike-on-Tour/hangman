'use strict';

/*
* Define the search patterns for lat(itude) as a 2-digit floating point value with a possible leading minus (-)dd.d and for lon(gitude) as a 3-digit value (-)ddd.d
*/
var twoDigits = /\d{1,2}/;
var negativeNumber = /-?\d{1,2}/;

/*
* Checks the value of an input element with a regular expression to make certain we get the value we want
*
* @params:	inputName:	string, name of the DOM element we want to check
*		matchString: string, contains the pre-defined search pattern
*		defaultValue: value to use in case the provided value isn't valid
*		minValue: lowest value allowed
*		maxValue: highest value allowed
*
* @return:	writes either the default value or - if it matches the pattern and is within the boundaries - the given value into the DOM element's value
*/
function chkInput(inputName, matchString, defaultValue, minValue, maxValue)
{
	var domElement = document.getElementById(inputName);
	var elementValue = domElement.value;
	var result = elementValue.match(matchString);
	if (result == null) {
		domElement.value = defaultValue;		// input doesn't match the pattern, we use the default value
	} else {
		if ((result[0] < minValue) || (result[0] > maxValue)) {
			domElement.value = defaultValue;	// input matches the search pattern but is outside the given boundaries, we use the default value
		} else {
			domElement.value = result[0];		// input matches th search pattern und is within the boundaries, we use it
		}
	}
}

/*
* First replaces some characters with a comma in case somebody hit the wrong key, then erases all characters which are not a digit or a comma, erases all multible, trailing or leading commas
* and checks whether the expression is of 'dd,dd' to make sure we get only two numbers seperated by a comma
*
* @params:	inputName:	string, name of the DOM element we want to check
*		defaultValue: string, the value which gets set if we encounter an invalid input
*
* @return:	a pair of integer numbers seperated by a comma
*/
function cleanInput(inputName, defaultValue)
{
	var pairMatch = /\d{1,2}\,\d{1,2}/;
	var domElement = document.getElementById(inputName);
	var elementValue = domElement.value;
	if (elementValue != '') {
		elementValue = elementValue.replace(/[;:\._-]/g, ",");		// replace some characters with a comma (in case someone fooled while typing)
		elementValue = elementValue.replace(/[^,\d]/g, "");			// erase all characters which are not a digit or a comma
		elementValue = elementValue.replace(/,{2,10}/g, ",");		// erase multiple commas
		elementValue = elementValue.replace(/^,*/, "");				// erase all leading commas
		elementValue = elementValue.replace(/,*$/, "");				// erase all trailing commas
	}
	var result = elementValue.match(pairMatch);
	if (result == null) {
		domElement.value = defaultValue;		// input doesn't match the pattern, we use the default value
	} else {
		domElement.value = result[0];			// input matches th search pattern, we use it
	}
}
