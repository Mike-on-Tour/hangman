/**
*
* package Hangman v0.7.0
* copyright (c) 2021 - 2023 Mike-on-Tour
* license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

(function($) {  // Avoid conflicts with other libraries

'use strict';

/*
* Check the 'Category' setting and hide or show the 'Enforce Catgory Input' setting accordingly
*/
$("input[name='mot_hangman_category_enable']").click(function() {
	// Check radio buttons
	if ($(this).attr('type') == 'radio') {
		if ($(this).val() == 1) {
			$("#mot_hangman_category_enforce_field").show();
		} else {
			$("#mot_hangman_category_enforce_field").hide();
		}
	}
	// Check checkbox
	if ($(this).attr('type') == 'checkbox') {
		if ($(this).is(":checked")) {
			$("#mot_hangman_category_enforce_field").show();
		} else {
			$("#mot_hangman_category_enforce_field").hide();
		}
	}
});

if ($("input[name='mot_hangman_category_enable']:checked").val() == 1) {
	$("#mot_hangman_category_enforce_field").show();
}

/*
* Check the 'Enforce term' setting and hide or show the 'Enforce Term Ratio' setting accordingly
*/
$("input[name='mot_hangman_enforce_term']").click(function() {
	// Check radio buttons
	if ($(this).attr('type') == 'radio') {
		if ($(this).val() == 1) {
			$("#mot_hangman_enforce_term_ratio_field").show();
		} else {
			$("#mot_hangman_enforce_term_ratio_field").hide();
		}
	}
	// Check checkbox
	if ($(this).attr('type') == 'checkbox') {
		if ($(this).is(":checked")) {
			$("#mot_hangman_enforce_term_ratio_field").show();
		} else {
			$("#mot_hangman_enforce_term_ratio_field").hide();
		}
	}
});

if ($("input[name='mot_hangman_enforce_term']:checked").val() == 1) {
	$("#mot_hangman_enforce_term_ratio_field").show();
}

/*
* Check the 'Enable extra points' setting and hide or show the 'Extra points' setting accordingly
*/
$("input[name='mot_hangman_extra_points_enable']").click(function() {
	// Check radio buttons
	if ($(this).attr('type') == 'radio') {
		if ($(this).val() == 1) {
			$("#mot_hangman_extra_points_field").show();
		} else {
			$("#mot_hangman_extra_points_field").hide();
		}
	}
	// Check checkbox
	if ($(this).attr('type') == 'checkbox') {
		if ($(this).is(":checked")) {
			$("#mot_hangman_extra_points_field").show();
		} else {
			$("#mot_hangman_extra_points_field").hide();
		}
	}
});

if ($("input[name='mot_hangman_extra_points_enable']:checked").val() == 1) {
	$("#mot_hangman_extra_points_field").show();
}

/*
* Define the search patterns
*/
var twoDigits = /\d{1,2}/;
var negativeNumber = /-?\d{1,2}/;

/*
* Checks the value of an input element with a regular expression to make certain we get the value we want
*
* @params:	domElement:	object,  DOM element we want to check
*		matchString:	string, contains the pre-defined search pattern
*		defaultValue:	value to use in case the provided value isn't valid
*		minValue:		lowest value allowed
*		maxValue:		highest value allowed
*
* @return:	writes either the default value or - if it matches the pattern and is within the boundaries - the given value into the DOM element's value
*/
function motHmChkInput(domElement, matchString, defaultValue, minValue, maxValue) {
	var elementValue = domElement.val();
	var result = elementValue.match(matchString);
	if (result == null) {
		domElement.val(defaultValue);		// input doesn't match the pattern, we use the default value
	} else {
		if ((result[0] < minValue) || (result[0] > maxValue)) {
			domElement.val(defaultValue);	// input matches the search pattern but is outside the given boundaries, we use the default value
		} else {
			domElement.val(result[0]);		// input matches the search pattern und is within the boundaries, we use it
		}
	}
}

$("#acp_hangman_lives").blur(function() {
	motHmChkInput($(this), twoDigits, 10, 4, 10);
});

$("#acp_hangman_points_win").blur(function() {
	motHmChkInput($(this), twoDigits, 15, 1, 99);
});

$("#acp_hangman_points_loose").blur(function() {
	motHmChkInput($(this), negativeNumber, -5, -99, 0);
});

$("#acp_hangman_points_letter").blur(function() {
	motHmChkInput($(this), twoDigits, 1, 0, 99);
});

$("#acp_hangman_points_word").blur(function() {
	motHmChkInput($(this), twoDigits, 8, 0, 99);
});
/*
$("#acp_mot_hangman_file").change(function(evt) {
	var files = evt.target.files;
});
*/
$("#acp_mot_hangman_file_upload").on('submit', (function(evt) {
	var fd = new FormData();
	var files = $('#acp_mot_hangman_file')[0].files;
	if (files.length > 0 ) {
		fd.append('file',files[0]);
		$.post(motHangman.acpAction,
			{filedata: fd,},
		);
	} else {
		evt.preventDefault();
		phpbb.alert(motHangman.acpError, motHangman.acpSelectFile);
	}
}));

})(jQuery); // Avoid conflicts with other libraries
