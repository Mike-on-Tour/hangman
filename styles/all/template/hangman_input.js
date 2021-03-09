'use strict';

function cleanQuoteInput(elementId) {
	var domElement = document.getElementById(elementId);
	var elementValue = domElement.value;
	// delete all special characters
	elementValue = elementValue.replace(/[,;\:\._\-\<\>\#'\+\*^°\!\"§\$%&\/()\=\?\|\{\}\[\]~]/g, '');
	// delete all digits
	elementValue = elementValue.replace(/\d/g, '');
	// delete multipla spaces
	elementValue = elementValue.replace(/ {2,}/g, ' ');

	// check whether only authorized letters are used
	var strLenght = elementValue.length;
	var onlyAuthLetters = true;
	var checkLetter;
	var unauthLetters = new Array();
	for (var i = 0; i < strLenght; i++) {
		checkLetter = elementValue[i];
		if (!jsLcLetters.includes(checkLetter.toLowerCase()) && checkLetter != ' ') {
			unauthLetters.push(checkLetter);
			onlyAuthLetters = false;
		}
	}
	domElement.value = elementValue;
	if (!onlyAuthLetters) {
		alert (jsUnauthLetters + unauthLetters);
		domElement.focus();
	}
	return (onlyAuthLetters);
}
