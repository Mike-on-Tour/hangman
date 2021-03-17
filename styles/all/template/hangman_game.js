'use strict';

// Define keyPressed values
var ENTER = 13;
var ESC = 27;

// Variable to indicate waiting for keyboard input
var waitForButton = true;

// Variable to hold the modal window
var modal;

// Variables to hold the original Quote and the Text with the underscores to show letter positions
var quoteText = '';
var showText = '';

// The used qoute's id from the database (needed to give it back to php after playing this quote in order to delete it from the database)
var quoteId = 0;

// Variable to define the game status
var running = false;

// Variables to enable the display of hangman images
var imageElement = document.getElementById('hm_picture');
var imagePath = '<img src="' + jsRootPath + 'ext/mot/hangman/styles/all/theme/images/hm';
var imageExt = '.svg" width="75" height="125">';
var imageNumber = 10 - jsNumberOfLives;

// Variable to count points
var points = 0;

// Variable to count used lives
var livesUsed = 0;

// Variable to hold used lettters in order to prevent them from being used more than once through keyboard input
var usedLetters = new Array();

/*
* Ajax function to call the php script (not working as of today)
*/
function jumpToPhp() {
	$.ajax({
		url: jsAction,
		type: 'post',
		data: {
			'word_id': quoteId,
			'points': points
		}
	});
}

/*
* Open a modal window and display message
*
* @params	string	htmlText	Message to be displayed
*/
function modalWindow(htmlText) {
	modal = document.getElementById("mot_hangman_modal");

	var modalDiv = document.getElementById('modal_text');
	modalDiv.innerHTML = htmlText;

	modal.style.display = "block";
}

/*
* Event handlers to get keyboard input
*
* @params	event
*/
function keyPressed(event) {
	var key = event.key;

	key = key.toLocaleUpperCase();
	if (key == 'SS') {
		key = 'ß';
	}
	seek(key);
}

/*
* Keyboard event handler to get 'Esc' or 'Enter' keys to trigger modal window closure
*/
function keyDown(event) {
	var code = event.keyCode;
	if (code == ENTER || code == ESC) {
		waitForButton = false;
	}
}

/*
* Event handler for mouse click on the modal window's Ok button
*/
function clickOk() {
	waitForButton = false;
}

/*
* Wait for the user to either press the the 'Esc' or 'Enter' button or mouse click on the modal window's 'Ok' button to close the modal window and carry on with the script
*/
function waitToClose(backToPhp) {
	if(waitForButton) {//we want it to match
		setTimeout(function() { waitToClose(backToPhp)}, 50);//wait 50 millisecnds then recheck
		return;
	}
	modal.style.display = "none";
	// Reset the button
	waitForButton = true;
	if (backToPhp) {
		document.getElementById('submit').click();
//		jumpToPhp();
	}
}

/*
* Fills the two table rows for the letters retrieved from a language variable to ensure compatibility with national alphabets
*
* @params	array		letters		contains the letters from the language file
*		integer	letterCount		total number of letters
*		integer	letterRow		number of letters for first row
*
*/
function fillLetterTable(letters, letterCount, letterRow) {
	var row1 = document.getElementById('row1');
	var row2 = document.getElementById('row2');
	var i = 0;

	for (i = 0; i < letterRow; i++) {
		row1.innerHTML = row1.innerHTML + '<input type="button" class="button letter-button" id="' + letters[i] + '" value=" ' + letters[i] + ' "	onclick="seek(\'' + letters[i] + '\');" class="alpha-butt">';
	}

	for (i = letterRow; i < letterCount; i++) {
		row2.innerHTML = row2.innerHTML + '<input type="button" class="button letter-button" id="' + letters[i] + '" value=" ' + letters[i] + ' "	onclick="seek(\'' + letters[i] + '\');" class="alpha-butt">';
	}
}

/*
* Calculates a random integer between 0 and max-1
*
* @params		integer	max	maximum number which the return value must not reach
*
* @return		integer	integer between 0 and max-1
*/
function getRandomInt(max) {
  return Math.floor(Math.random() * Math.floor(max));
}

/*
* Starts the game if the 'Start Game' button was hit by selecting a random quote from the given pool (or displays an error message if there is none).
* Replaces all letters with underscores and displays this in the search quote text area
*
*/
function hangman_start() {
	var quoteCount = jsQuotes.length;

	if (!running) {					// prevent another game start while game is running
		if (quoteCount == 0) {
			waitForButton = true;
			modalWindow(jsNoQuote);
			waitToClose(false);
		} else {
			var quoteIndex = getRandomInt(quoteCount);
			quoteId = jsQuotes[quoteIndex]['word_id'];
			document.getElementById('word_id').value = quoteId;

			quoteText = jsQuotes[quoteIndex]['hangman_word'];
			showText = quoteText.replace(/[ ]/g, '  ');			// if the quote contains spaces double them to get an even number of characters
			showText = showText.replace(/[^ ]/g, '_ ');			// replace all characters with underscores for display
			document.frm.word.value = showText;

			// set hangman picture to start
			imageElement.innerHTML =  imagePath + imageNumber + imageExt;

			// and hide the start button
			document.getElementById('start_button').style.visibility = 'hidden';
			running = true;	// indicate that game has started
		}
	}
}

function seek(letter)
{
	var i = 0;
	var len = 0;
	var tempText = '';
	var quoteLength = quoteText.length;
	var showLength = showText.length;
	var correctLetter = false;

	if(!running) {
		modalWindow(jsClickStart);
		waitToClose(false);
	} else {

		// If this letter has already been used leave this  (necessary to avoid redundant count when using keyboard)
		if (usedLetters.includes(letter)) {
			return;
		}
		// Add this letter to Used Letters Array
		usedLetters.push(letter)
		//and hide it so it can't be used again (with mouse)
		document.getElementById(letter).style.visibility = 'hidden';

		// Check if this letter is contained in quote
		for(i = 0; i < quoteLength; i++) {
			if (letter.toLowerCase() == quoteText[i].toLowerCase()) {
				// letter is correct
				correctLetter = true;
				tempText = '';
				if (i != 0) {
					tempText = showText.substr(0, 2*i);
				}
				len = showLength - (2 * (i + 1));
				tempText = tempText + quoteText[i] + ' ';
				if (i < quoteLength - 1) {
					tempText += showText.substr(2*(i+1), len);
				}
				showText = tempText;
			}
		}

		if (correctLetter) {
			// Show the quote with letter found
			document.frm.word.value = showText;
			// List the used letter in the list with correct letters
			document.frm.correct.value += letter + " ";

			// Inkrement score and display it
			points += jsLetterPoints;
			document.frm.score.value = points;

			// Check if all letters have been found
			const matches = showText.match(/[_]/g);
			if (matches === null) {
				points += jsWinPoints;
				document.frm.score.value = points;
				modalWindow(jsWinString + points);
				waitToClose(true);
			}
		} else {
			imageNumber++;
			imageElement.innerHTML =  imagePath + imageNumber + imageExt;
			document.frm.tried.value += letter + " ";

			// Inkrement used lives and display it
			livesUsed++;
			document.frm.lives.value = livesUsed;

			// Check if end of life is reached
			if (livesUsed == jsNumberOfLives) {
				points += jsLoosePoints;
				document.frm.score.value = points;
				modalWindow(jsLooseString + points);
				waitToClose(true);
			}
		}
	}
}

// Start immediately with displaying the letter table
fillLetterTable(jsHangmanLetters, jsHangmanTotalLetters, jsLetterRow);
// and inserting an event handler for keyboard input
document.addEventListener('keypress', keyPressed );
document.addEventListener('keydown', keyDown );
