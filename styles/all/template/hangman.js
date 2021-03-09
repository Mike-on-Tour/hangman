'use strict';

/*
* Select the tab as active and the corresponding content box after a tab was selected
*
* @params	integer	index		the numerical descriptor of the selected tab
*
* @return	none
*/
function selectTab(index) {
	var element = document.getElementsByTagName('div');
	var elementId = "";
	var object;

	for (var i = 0; i < element.length; i++) {
		elementId = element[i].id;
		if (elementId.substr(0,12) == 'hangman_box_') {
			object = document.getElementById(elementId);
			object.hidden = true;
		}
	}

	var tab = document.getElementById('hangman_tab_' + index);
	tab.setAttribute('class','tab activetab');
	var box = document.getElementById('hangman_box_' + index);
	box.hidden = false;
}
