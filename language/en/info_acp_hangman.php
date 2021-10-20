<?php
/**
*
* @package Hangman v0.3.0
* @copyright (c) 2021 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, [
	'ACP_MOT_HANGMAN'							=> 'Hangman',
	'ACP_MOT_HANGMAN_SETTINGS'					=> 'Settings',
	'ACP_MOT_HANGMAN_EXT_SETTINGS'				=> 'Extension settings',
	'ACP_MOT_HANGMAN_AUTODELETE'				=> 'Delete used terms?',
	'ACP_MOT_HANGMAN_AUTODELETE_EXP'			=> 'If you select ´Yes´ then a term used in a game will be deleted from the data base after this game is finished.',
	'ACP_MOT_HANGMAN_CATEGORY_ENABLE'			=> 'Enable categories?',
	'ACP_MOT_HANGMAN_CATEGORY_ENABLE_EXP'		=> 'If you select ´Yes´ an additional text field will be displayed while creating a search term. In this field you
													can enter a category name to which this term belongs.<br>
													This category wil be displayed above the search term field in the game tab and serves as a little hint.',
	'ACP_MOT_HANGMAN_CATEGORY_ENFORCE'			=> 'Enforce catgory input?',
	'ACP_MOT_HANGMAN_CATEGORY_ENFORCE_EXP'		=> 'If you select ´Yes´ then the input of a category will be enforced which means that the input form can not be submitted
													without an input in the category input field. This setting is only applicable if ´Enable categories´ is enabled.',
	'ACP_MOT_HANGMAN_EVADE_ENABLE'				=> 'Count a game as lost if game is left?',
	'ACP_MOT_HANGMAN_EVADE_ENABLE_EXP'			=> 'If you select ´Yes´ players leaving a running game (e.g. by klicking a link or refreshing the page) will be
													scored the ´Points if losing´.<br>
													If this option is enabled players will be asked via a popup window whether they really want to leave the game
													page. If they affirm this action they will be scored (punished by) the ´Points if losing´. According to the
													setting ´Delete used terms´ the search term used in this game may be deleted from the database.<br>
													If this option is disabled the player wil be relayed to the selected page without further action.',
	'ACP_MOT_HANGMAN_GAME_SETTINGS'				=> 'Game settings',
	'ACP_MOT_HANGMAN_GAME_SETTINGS_EXP'			=> 'Here you can configure the settings for the number of lives to play with (failed tries) and for points to gain.<br>
													All inputs are subject to getting checked according to the individual hints and changed if necessary.',
	'ACP_MOT_HANGMAN_LIVES'						=> 'Number of failed tries (lives)',
	'ACP_MOT_HANGMAN_LIVES_EXP'					=> 'Number of failed tries until the player dances on air and loses the game<br>
													(integer between 4 and 10)',
	'ACP_MOT_HANGMAN_POINTS_WIN'				=> 'Points if winning',
	'ACP_MOT_HANGMAN_POINTS_WIN_EXP'			=> 'Number of points to gain if the player solves the puzzle<br>
													(integer greater than zero)',
	'ACP_MOT_HANGMAN_POINTS_LOOSE'				=> 'Points if losing',
	'ACP_MOT_HANGMAN_POINTS_LOOSE_EXP'			=> 'Number of points debited if the player fails to solve the puzzle<br>
													(integer smaller than or equal to zero)',
	'ACP_MOT_HANGMAN_POINTS_LETTER'				=> 'Number of points to gain with correct letter',
	'ACP_MOT_HANGMAN_POINTS_LETTER_EXP'			=> 'Number of points to gain by selecting a letter belonging to the puzzle<br>
													(integer greater than or equal to zero)',
	'ACP_MOT_HANGMAN_POINTS_WORD'				=> 'Points for a new quote',
	'ACP_MOT_HANGMAN_POINTS_WORD_EXP'			=> 'Number of points to gain by entering a term or quote into the database<br>
													(integer greater than or equal to zero)',
	'ACP_MOT_HANGMAN_INPUT_SETTINGS'			=> 'Term input settings',
	'ACP_MOT_HANGMAN_INPUT_SETTINGS_EXP'		=> 'Here you can configure the settings for the input of search terms.',
	'ACP_MOT_HANGMAN_PUNCTUATION_MARKS'			=> 'Permitted puncuation marks',
	'ACP_MOT_HANGMAN_PUNCTUATION_MARKS_EXP'		=> 'Those puncuation marks permitted for input with a new term besides letters and spaces. They will be
													displayed in the game tab as part of the term.',
	'ACP_MOT_HANGMAN_SETTING_SAVED'				=> 'Settings for the Hangman Game successfully saved.',
	'ACP_MOT_HANGMAN_RESET_HIGHSCORE'			=> 'Reset Highscore',
	'ACP_MOT_HANGMAN_RESET_HIGHSCORE_CAUTION'	=> '<strong>CAUTION:</strong> This action is irreversible!',
	'ACP_MOT_HANGMAN_SCORE_TABLE_CLEARED'		=> 'Hangman Highscore table cleared',
	'ACP_MOT_HANGMAN_HIGHSCORE_TABLE_CLEARED'	=> 'Highscore table cleared',
	'ACP_MOT_HANGMAN_SUPPORT_HANGMAN'			=> 'If you want to support Hangman´s development please use this link to donate:<br>',
	'ACP_MOT_HANGMAN_VERSION'					=> '<img src="https://img.shields.io/badge/Version-%1$s-green.svg?style=plastic" /><br>&copy; 2020 - %2$d by Mike-on-Tour',
]);
