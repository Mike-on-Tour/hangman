/**
*
* package Hangman v0.3.0
* copyright (c) 2021 Mike-on-Tour
* license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

(function($) {  // Avoid conflicts with other libraries

'use strict';

$("#hangman_quote_text").focus();

$("#hangman_quote_input").submit(function() {
	var elementValue = '';

	elementValue = $("#hangman_quote_text").val();
	// delete all digits
	elementValue = elementValue.replace(/\d/g, '');
	// delete multiple spaces
	elementValue = elementValue.replace(/ {2,}/g, ' ');

	// check whether only authorized letters are used
	var strLenght = elementValue.length;
	var onlyAuthLetters = true;
	var checkLetter;
	var unauthLetters = new Array();
	for (var i = 0; i < strLenght; i++) {
		checkLetter = elementValue[i];
		if (!motHangman.jsLcLetters.includes(checkLetter.toLowerCase()) && !motHangman.jsAllowedPunctMarks.includes(checkLetter) && checkLetter != ' ') {
			unauthLetters.push(checkLetter);
			onlyAuthLetters = false;
		}
	}
	$("#hangman_quote_text").val(elementValue);
	if (!onlyAuthLetters) {
		alert (motHangman.jsUnauthLetters + unauthLetters);
		$("#hangman_quote_text").focus();
	}
	if (elementValue == '' || elementValue == ' ') {
		$("#hangman_quote_text").focus();
		onlyAuthLetters = false;
	}

	if (motHangman.jsShowCategory) {
		elementValue = $("#hangman_quote_category").val();
		// delete all special characters
		elementValue = elementValue.replace(/[,;\:\._\-\<\>\#'\+\*^°\!\"§\$%&\/()\=\?\|\{\}\[\]~]/g, '');
		// delete multiple spaces
		elementValue = elementValue.replace(/ {2,}/g, ' ');

		if (motHangman.jsEnforceCategory && elementValue == '') {
			alert('Kategorie muss ausgefüllt sein');
			$("#hangman_quote_category").focus();
			onlyAuthLetters = false;
		}
	}

	return (onlyAuthLetters);
});

})(jQuery); // Avoid conflicts with other libraries
