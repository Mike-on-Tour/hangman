/**
*
* package Hangman v0.10.0
* copyright (c) 2021 - 2024 Mike-on-Tour
* license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

(function($) {  // Avoid conflicts with other libraries

'use strict';

// Define keyPressed values
let ENTER = 13;
let ESC = 27;

// Variable to indicate waiting for keyboard or mouse input to close modal window
motHangman.waitForButton = true;

// Variables to hold the original Quote and the Text with the underscores to show letter positions
motHangman.quoteText = '';
motHangman.showText = '';

// The used qoute's id from the database (needed to give it back to php after playing this quote in order to delete it from the database)
motHangman.quoteId = 0;

// Variable to define the game status
motHangman.running = false;

// Variables to enable the display of hangman images
motHangman.imageExt = '.svg" width="75" height="125">';
motHangman.imageNumber = 10 - motHangman.jsNumberOfLives;

// Variable to count points
motHangman.points = 0;

// Variable to count used lives
motHangman.livesUsed = 0;

// Variable to hold used lettters in order to prevent them from being used more than once through keyboard input
motHangman.usedLetters = new Array();

/*
* Open a modal window and display message
*
* @params	string	htmlText	Message to be displayed
*/
motHangman.modalWindow = function(htmlText) {
	$("#modal_text").html(htmlText);
	$("#mot_hangman_modal").attr("style", "display:block");
}

/*
* Wait for the user to either press the 'Esc' or 'Enter' button or mouse click on the modal window's 'Ok' button to close the modal window and carry on with the script
*
* @params	boolean	backToPhp	if true we not only close the modal window but go back to the PHP script as well
*/
motHangman.waitToClose = function(backToPhp) {
	if(this.waitForButton) {//we want it to match
		setTimeout(function() { motHangman.waitToClose(backToPhp);}, 50);//wait 50 millisecnds then recheck
		return;
	}
	$("#mot_hangman_modal").attr("style", "display:none");

	// Reset the button
	this.waitForButton = true;
	if (backToPhp) {
		$("#submit").click();
	}
}

/*
* Fills the table rows for the letters retrieved from a language variable to ensure compatibility with national alphabets
*
* @params	array		letters		contains the letters from the language file
*
*/
motHangman.fillLetterTable = function(letters) {
	let letterTableWidth = $(".letter_table").width();
	let letterCount = letters.length;
	let rowCount = letterTableWidth > 451 ? 2 : 3;

	let letterRow = ((letterCount % rowCount) > 0) ? (Math.floor(letterCount / rowCount) + 1) : (letterCount / rowCount);

	for (let i = 1; i <= rowCount; i++) {
		let startLetter = letterRow * (i - 1);
		let stopLetter = letterRow * i < letterCount ? letterRow : letterCount - (letterRow * (i - 1));
		for (let j = 0; j < stopLetter; j++) {
			$("#row" + i).html($("#row" + i).html() + '<input type="button" class="button letter-button" id="' + letters[j + startLetter] + '" value=" ' + letters[j + startLetter] + ' "	onclick="motHangman.seek(\'' + letters[j + startLetter] + '\');">');
		}
	}
}

/*
* Starts the game if the 'Start Game' button was hit by getting the given quote (or displays an error message if there is none).
* Replaces all letters with underscores and displays this in the search quote text area
*
*/
$("#start_button").click(function() {
	function replaceChars(myString) {
		let len = myString.length;
		let tempString = ''
		for (let i = 0; i < len; i++) {
			if (!motHangman.jsAllowedPunctMarks.includes(myString[i]) && myString[i] != ' ') {
				tempString += '_';
			} else {
				tempString += myString[i];
			}
		}
		return tempString;
	}

	if (!motHangman.running) {					// prevent another game start while game is running
		if (motHangman.jsQuote.length == 0) {
			motHangman.modalWindow(motHangman.jsNoQuote);
			motHangman.waitToClose(false);
		} else {
			motHangman.quoteId = motHangman.jsQuote['word_id'];
			$("#word_id").val(motHangman.quoteId);

			motHangman.quoteText = motHangman.decrypt(motHangman.jsQuote['hangman_word'], motHangman.jsQuote['word_len']);
			motHangman.showText = replaceChars(motHangman.quoteText);			// replace all characters with underscores for display
			$("#hangman_word").val(motHangman.showText);
			$("#hangman_word").css("letter-spacing", "5px");

			// set hangman picture to start
			$("#hm_picture").html('<img src="' + motHangman.jsImagePath + motHangman.imageNumber + motHangman.imageExt);

			// show the category if enabled
			if (motHangman.jsShowCategory) {
				$("#hangman_category").html(motHangman.jsQuote['hangman_category']);
			}

			// show the creator
			$("#mot_hangman_creator").html(motHangman.jsQuote['username']);

			// and hide the start button
			$("#start_button").hide();
			motHangman.running = true;	// indicate that game has started
		}
	}
});

motHangman.seek = function(letter) {
	let i = 0;
	let len = 0;
	let tempText = '';
	let quoteLength = this.quoteText.length;
	let showLength = this.showText.length;
	let correctLetter = false;

	if(!this.running) {
//		phpbb.alert('', this.jsClickStart);
		this.modalWindow(this.jsClickStart);
		this.waitToClose(false);
	} else {
		// If this letter has already been used leave this  (necessary to avoid redundant count when using keyboard)
		if (this.usedLetters.includes(letter)) {
			return;
		}
		// Add this letter to Used Letters Array
		this.usedLetters.push(letter)
		//and hide it so it can't be used again (with mouse)
		$("#" + letter).attr("style", "visibility:hidden");

		// Check if this letter is contained in quote
		for(i = 0; i < quoteLength; i++) {
			if (letter.toLowerCase() == this.quoteText[i].toLowerCase()) {
				// letter is correct
				correctLetter = true;
				tempText = '';
				if (i != 0) {
					tempText = this.showText.substr(0, i);
				}
				len = showLength - (i + 1);
				tempText = tempText + this.quoteText[i];
				if (i < quoteLength - 1) {
					tempText += this.showText.substr(i+1, len);
				}
				this.showText = tempText;
			}
		}

		if (correctLetter) {
			// Show the quote with letter found
			$("#hangman_word").val(this.showText);
			// List the used letter in the list with correct letters
			$("#correct").val($("#correct").val() + letter + " ");

			// Inkrement score and display it
			this.points += this.jsLetterPoints;
			$("#score").val(this.points);

			// Check if all letters have been found
			const matches = this.showText.match(/[_]/g);
			if (matches === null) {
				this.points += this.jsWinPoints;
				if (this.jsEnableExtraPoints && this.livesUsed == 0) {
					this.jsWinString += this.jsExtraPointsMsg + this.jsWinStringPts;
					this.points += this.jsExtraPoints;
				} else {
					this.jsWinString += this.jsWinStringPts;
				}
				$("#score").val(this.points);
				this.running = false;		// to prevent the action while unloading
				this.modalWindow(this.jsWinString + this.points);
				this.waitToClose(true);
			}
		} else {
			this.imageNumber++;
			$("#hm_picture").html('<img src="' + this.jsImagePath + this.imageNumber + this.imageExt);
			$("#tried").val($("#tried").val() + letter + " ");

			// Inkrement used lives and display it
			this.livesUsed++;
			$("#lives").val(this.livesUsed);

			// Check if end of life is reached
			if (this.livesUsed == this.jsNumberOfLives) {
				this.points += this.jsLoosePoints;
				$("#score").val(this.points);
				this.running = false;		// to prevent the action while unloading
				this.messageText = this.jsLooseString + this.points;
				if (this.jsShowTerm) {
					this.messageText += this.jsShowTermMsg + this.quoteText + '</i>';
				}
				this.modalWindow(this.messageText);
				this.waitToClose(true);
			}
		}
	}
}

motHangman.encrypt = function(str, key) {
	let result = "";
	for (let i = 0; i < str.length; i++) {
		let charCode = (str.charCodeAt(i) + key) % 256;
		result += String.fromCharCode(charCode);
  }
  return result;
}

motHangman.decrypt = function(str, key) {
	let result = "";
	for (let i = 0; i < str.length; i++) {
		let charCode = (str.charCodeAt(i) - key + 256) % 256;
		result += String.fromCharCode(charCode);
	}
	return result;
}

/* --------------------------------------------- Event handlers --------------------------------------------- */

/*
* Event handlers to get keyboard input
*
* @params	event
*/
$(document).keypress(function(event) {
	let key = event.key;

	key = key.toLocaleUpperCase();
	if (key == 'SS') {
		key = 'ß';
	}
	// Call the seek function only if this key is contained in the letters array to avoid counting e.g. digits
	if(motHangman.jsHangmanLetters.includes(key)) {
		motHangman.seek(key);
	}
});

/*
* Event handler for mouse click on the modal window's Ok button
*/
$("#mot_ok_button").click(function() {
	motHangman.waitForButton = false;
});

/*
* Keyboard event handler to get 'Esc' or 'Enter' keys to trigger modal window closure
*
* @params	e
*/
$(document).keydown(function(e) {
	if ((e.which == ENTER) || (e.which == ESC)) {
		motHangman.waitForButton = false;
	}
});

/*
* Event handlers to handle people trying to evade a loosing game
*
* @params	evt
*/
if (motHangman.jsPunishEvaders) {
	$(window).on('beforeunload', function(evt) {
		if (motHangman.running) {
			evt.preventDefault();	// For Firefox, Safari, IE and Firefox for Android
			evt.returnValue = '';	// For Chrome and Edge and Android: WebView, Chrome, Opera, Samsung Internet
			return '';				// For Opera
		}
	});

	$(window).on('visibilitychange', function(evt) {
		if (motHangman.running) {
			motHangman.points = motHangman.jsLoosePoints;
			$("#score").val(motHangman.points);
			let formData = new FormData();
			formData.append('score', motHangman.points);
			formData.append('word_id', motHangman.quoteId);
			navigator.sendBeacon(motHangman.jsAjaxCall, formData);
		}
	});
}

// Start immediately with displaying the letter table
motHangman.fillLetterTable(motHangman.jsHangmanLetters);

})(jQuery); // Avoid conflicts with other libraries
