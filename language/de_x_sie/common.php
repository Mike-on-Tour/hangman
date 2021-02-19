<?php
/*
*
* @package Hangman game
* @author Mike-on-Tour
* @copyright (c) 2021 by Mike-on-Tour (www.mike-on-tour.com)
* @former author dmzx (www.dmzx-web.net)
* @copyright (c) 2015 by dmzx (www.dmzx-web.net)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
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
	'HANGMAN'					=> 'Hangman',
	'HANGMAN_TITLE'				=> 'Hangman Spiel',
	'HANGMAN_TENLIVES'			=> 'Sie haben in diesem Spiel zehn Leben.',
	'HANGMAN_SCORE'				=> 'Spielstand',
	'HANGMAN_LIVES_USED'		=> 'Benutzte Leben',
	'HANGMAN_NEW_QUOTE'			=> 'Neues Zitat',
	'HANGMAN_RESTART'			=> 'Restart',
	'HANGMAN_NEW_QUOTE_START'	=> 'Klicken Sie auf ´Neues Zitat´, um das Hangman Spiel zu starten',
	'HANGMAN_FAILED_TRIES'		=> 'Falsche Versuche',
	'HANGMAN_CORRECT_TRIES'		=> 'Richtige Versuche',
	'HANGMAN_YOUWIN'			=> 'Sie haben gewonnen!',
	'HANGMAN_QUOTE_ALREADY'		=> 'Zitat wird bereits genutzt!',
	'HANGMAN_NEW_QUOTE_TO'		=> 'Klicken Sie auf ´Neues Zitat´ zum Start!',
	'HANGMAN_YOU_LOSE'			=> 'Sie haben verloren - Neuer Versuch!',
	'HANGMAN_LETTER'			=> 'Buchstabe',
	'HANGMAN_ALREADY_USED'		=> 'wird schon benutzt!',
));
