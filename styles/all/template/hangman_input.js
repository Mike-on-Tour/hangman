/**
*
* package Hangman v0.10.0
* copyright (c) 2021 - 2024 Mike-on-Tour
* license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

(function($) {  // Avoid conflicts with other libraries

'use strict';

$("#hangman_quote_text").focus();

$("#hangman_quote_input").submit(function(e) {
	let elementValue = '';

	elementValue = $("#hangman_quote_text").val();
	// delete all digits
	elementValue = elementValue.replace(/\d/g, '');
	// delete multiple spaces
	elementValue = elementValue.replace(/ {2,}/g, ' ');

	// check whether only authorized letters are used and count the authorized letters
	let strLenght = elementValue.length;
	let onlyAuthLetters = true;
	let checkLetter;
	let countLetters = 0;
	let unauthLetters = new Array();
	for (let i = 0; i < strLenght; i++) {
		// check one character after another
		checkLetter = elementValue[i];
		// check for unauthorized characters
		if (!motHangman.jsLcLetters.includes(checkLetter.toLowerCase()) && !motHangman.jsAllowedPunctMarks.includes(checkLetter) && checkLetter != ' ') {
			unauthLetters.push(checkLetter);
			onlyAuthLetters = false;
		}
		//count authorized letters
		if (motHangman.jsLcLetters.includes(checkLetter.toLowerCase())) {
			countLetters++;
		}
	}

	$("#hangman_quote_text").val(elementValue);

	if (elementValue == '' || elementValue == ' ') {
		$("#hangman_quote_text").focus();
		onlyAuthLetters = false;
		return (onlyAuthLetters);
	}

	if (countLetters < motHangman.jsMinTermLen) {
		phpbb.alert (motHangman.jsErrorTitle, motHangman.jsTermTooShort + motHangman.jsMinTermLen);
		$("#hangman_quote_text").focus();
		onlyAuthLetters = false;
		return (onlyAuthLetters);
	}

	if (!onlyAuthLetters) {
		phpbb.alert (motHangman.jsErrorTitle, motHangman.jsUnauthLetters + unauthLetters);
		$("#hangman_quote_text").focus();
		return (onlyAuthLetters);
	}

	if (motHangman.jsShowCategory) {
		elementValue = $("#hangman_quote_category").val();
		// delete all special characters
		elementValue = elementValue.replace(/[,;\:\._\-\<\>\#'\+\*^°\!\"§\$%&\/()\=\?\|\{\}\[\]~]/g, '');
		// delete multiple spaces
		elementValue = elementValue.replace(/ {2,}/g, ' ');

		$("#hangman_quote_category").val(elementValue);
alert(motHangman.jsEnforceCategory);
		if (motHangman.jsEnforceCategory && elementValue == '') {
			phpbb.alert(motHangman.jsErrorTitle, motHangman.jsCategoryMissing);
			$("#hangman_quote_category").focus();
			onlyAuthLetters = false;
			return (onlyAuthLetters);
		}
	}

	return (onlyAuthLetters);
});

})(jQuery); // Avoid conflicts with other libraries
