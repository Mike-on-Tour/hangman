<?php
/*
*
* @package Hangman v0.2..0
* @author Mike-on-Tour
* @copyright (c) 2021 Mike-on-Tour
* @former author dmzx (www.dmzx-web.net)
* @copyright (c) 2015 by dmzx (www.dmzx-web.net)
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
	$lang = array();
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
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'PLURAL_RULE'					=> 1,
	// Tab menu
	'TAB_GAME'					=> 'Game',
	'TAB_WORD'					=> 'Search Term Input',
	'TAB_SCORE'					=> 'Highscore',
	// Back menu
	'TO_GAME'					=> 'Start Game',
	'TO_WORD_INPUT'				=> 'Submit a new search term',
	'TO_SCORE_TABLE'			=> 'View Highscore',
	// Game
	'HANGMAN'					=> 'Hangman',
	'HANGMAN_TITLE'				=> 'Hangman Game',
	'HANGMAN_DESC'				=> 'Welcome to the `Hangman` game area. By clicking the `Start Game` button a random term will be selected from the database
									and displayed in the term area. Each letter will be represented by an underscore.
									If you select a letter contained in the term it will be displayed instead of the underscore.<br>
									Selected letters will vanish from the selection area and will no longer be available. Letters already selected by you will
									be displayed either in the `Failed Tries` or the `Correct Tries` area.<br>
									According to the current settings you will gain %1$s points for every correctly selected letter and %2$s points for a turn
									you have won, losing will cost you %3$s points.<br>
									ATTENTION: Terms used in a game turn will be deleted from the database after that turn. Please enter a term after you
									concluded a game turn in order to enable others to play, too.',
	// List all letters of this language as uppercase letters seperated by comma. If this language contains lowercase letters without an uppercase equivalent list them here, too. If your language uses special characters and you have put them in
	//	the following variable please consider mentioning them in the 'HANGMAN_QUOTE_INPUT_EXPL' variable
	'HANGMAN_LETTERS'			=> 'A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z',
	'HANGMAN_LIVES'				=> 'You have %1$s lives to play with.',
	'HANGMAN_SCORE'				=> 'Score:',
	'HANGMAN_LIVES_USED'		=> 'Lives Used:',
	'HANGMAN_NEW_QUOTE'			=> 'Start Game',
	'HANGMAN_NEW_QUOTE_START'	=> 'Click the ´Start Game´ button to start Hangman',
	'HANGMAN_NO_QUOTE'			=> 'Currently there are no terms available. Please try again later.',
	'HANGMAN_FAILED_TRIES'		=> 'Failed Tries',
	'HANGMAN_CORRECT_TRIES'		=> 'Correct Tries',
	'HANGMAN_YOUWIN'			=> 'You Win! Points gained: ',
	'HANGMAN_NEW_QUOTE_TO'		=> 'Click ´Start Game´ to start Hangman Game!',
	'HANGMAN_YOU_LOSE'			=> 'You lose! Points gained: ',
	'HANGMAN_POINTS_SAVED'		=> 'Your game account was credited with the points gained in this game turn.',
	// Term definition
	'HANGMAN_QUOTE_INPUT_HEAD'	=> 'Enter a new term',
	'HANGMAN_QUOTE_INPUT_EXPL'	=> 'You can enter a new term in this form. This term may contain spaces but must not contain punctuation marks, special
									characters and digits. Therefore you are not limmited to single words and you can enter quotes as well.<br>
									Terms entered by yourself will not be displayed to you during game turns!<br>
									According to the current settings your game account will be credited with %1$s points for entering a term.',
	'HANGMAN_QUOTE_INPUT'		=> 'New term',
	'HANGMAN_WORD_SAVED'		=> 'The term you have entered was successfully stored in the database.<br>
									Your game account was credited with %1$s points.',
	'HANGMAN_WORD_EXISTS'		=> '<strong>The term you have entered already exists!</strong> Please try again with another term.',
	// Ranking table
	'HANGMAN_RANKING_TABLE'		=> 'Highscore',
	'TOTAL_POINTS'				=> 'Total points',
	'GAME_POINTS'				=> 'Game points',
	'WORD_POINTS'				=> 'Term input points',
	'NO_ENTRIES'				=> 'No entries',
));
