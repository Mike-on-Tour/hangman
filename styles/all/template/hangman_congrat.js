/**
*
* package Hangman v0.8.0
* copyright (c) 2021 - 2023 Mike-on-Tour
* license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

(function($) {  // Avoid conflicts with other libraries

'use strict';

// Define keyPressed values
var ENTER = 13;
var ESC = 27;

// Variable to indicate waiting for keyboard or mouse input to close modal window
motHangman.waitForOk = true;

/*
* Open a modal window and display message
*
* @params	string	htmlText	Message to be displayed
*/
motHangman.congratWindow = function(htmlText) {
	$("#modal_text").html(htmlText);
	$("#mot_hangman_modal").attr("style", "display: block;");
}

/*
* Wait for the user to either press the 'Esc' or 'Enter' button or mouse click on the modal window's 'Ok' button to close the modal window and carry on with the script
*
* @params	boolean	backToPhp	if true we not only close the modal window but go back to the PHP script as well
*/
motHangman.waitToClose = function() {
	if(this.waitForOk) {//we want it to match
		setTimeout(function() { motHangman.waitToClose();}, 50);//wait 50 millisecnds then recheck
		return;
	}
	$("#mot_hangman_modal").attr("style", "display: none;");

	// Reset the button
	this.waitForOk = true;

	$("#submit").click();
}

/* --------------------------------------------- Event handlers --------------------------------------------- */

/*
* Event handler for mouse click on the modal window's Ok button
*/
$("#mot_ok_button").click(function() {
	motHangman.waitForOk = false;
});

/*
* Keyboard event handler to get 'Esc' or 'Enter' keys to trigger modal window closure
*
* @params	e
*/
$(document).keydown(function(e) {
	if ((e.which == ENTER) || (e.which == ESC)) {
		motHangman.waitForOk = false;
	}
});

})(jQuery); // Avoid conflicts with other libraries
