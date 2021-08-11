<?php
/*
*
* @package Hangman v0.3.0
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
	// Tab menu
	'TAB_GAME'					=> 'Spiel',
	'TAB_WORD'					=> 'Eingabe Suchbegriff',
	'TAB_SCORE'					=> 'Rangliste',
	// Back menu
	'TO_GAME'					=> 'Neues Spiel',
	'TO_WORD_INPUT'				=> 'Einen neuen Suchbegriff eingeben',
	'TO_SCORE_TABLE'			=> 'Zur Rangliste',
	// Game
	'HANGMAN'					=> 'Hangman',
	'HANGMAN_TITLE'				=> 'Hangman Spiel',
	'HANGMAN_DESC'				=> 'Willkommen im Spielbereich von `Hangman`. Durch Anklicken des Knopfes `Spielstart` wird ein zufälliger Begriff aus der
									Datenbank ausgewählt und im Begriffsfenster dargestellt. Dabei wird jeder Buchstabe durch einen Unterstrich repräsentiert.
									Hast du einen Buchstaben ausgewählt, der im gesuchten Begriff vorkommt, wird er statt des Unterstriches angezeigt.<br>
									Einmal verwendete Buchstaben verschwinden aus der Auswahl und können nicht mehr ausgewählt werden. Bereits gewählte
									Buchstaben werden entweder im Fenster `Falsche Versuche` oder im Fenster `Richtige Versuche` aufgelistet.<br>
									Entsprechend der aktuellen Einstellungen erhälst du für jeden richtigen Buchstaben %1$d Punkte gutgeschrieben, ein
									gewonnenes Spiel zählt %2$d Punkte und ein verlorenes Spiel %3$d Punkte.',
	'HANGMAN_DESC_DEL_TERM'		=> '<br>ACHTUNG: Verwendete Suchbegriffe werden aus der Datenbank gelöscht. Gib also bitte nach jedem Spiel einen neuen Suchbegriff
									ein, damit andere ebenfalls spielen können.',
	// List all letters of this language as uppercase letters seperated by comma. If this language contains lowercase letters without an uppercase equivalent list them here, too. If your language uses special characters and you have put them in
	//	the following variable please consider mentioning them in the 'HANGMAN_QUOTE_INPUT_EXPL' variable
	'HANGMAN_LETTERS'			=> 'A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,Ä,Ö,Ü,ß',
	'HANGMAN_LIVES'				=> 'Du hast in diesem Spiel %1$d Leben.',
	'HANGMAN_SCORE'				=> 'Erreichte Punkte:',
	'HANGMAN_LIVES_USED'		=> 'Benutzte Leben:',
	'HANGMAN_NEW_QUOTE'			=> 'Spielstart',
	'HANGMAN_NEW_QUOTE_START'	=> 'Klicke auf ´Spielstart´, um das Hangman Spiel zu starten',
	'HANGMAN_NO_QUOTE'			=> 'Es sind keine Begriffe verfügbar. Versuche es bitte später noch einmal.',
	'HANGMAN_CATEGORY'			=> 'Kategorie',
	'HANGMAN_FAILED_TRIES'		=> 'Falsche Versuche',
	'HANGMAN_CORRECT_TRIES'		=> 'Richtige Versuche',
	'HANGMAN_YOU_WIN'			=> '<strong>Du hast gewonnen!</strong><br>Erreichte Punktzahl: ',
	'HANGMAN_NEW_QUOTE_TO'		=> 'Klicke erst auf ´Spielstart´ zum Start!',
	'HANGMAN_YOU_LOSE'			=> '<strong>Du hast leider verloren!</strong><br>Erreichte Punktzahl: ',
	'HANGMAN_POINTS_SAVED'		=> 'Deine im Spiel gewonnenen Punkte wurden deinem Konto gutgeschrieben.',
	// Term definition
	'HANGMAN_QUOTE_INPUT_HEAD'	=> 'Eingabe eines neuen Suchbegriffes',
	'HANGMAN_QUOTE_INPUT_EXPL'	=> 'Hier kannst du einen neuen Suchbegriff eingeben. Dieser Suchbegriff darf die Buchstaben %1$s (groß und klein) und Leerzeichen,
									aber keine Satz- und Sonderzeichen und Zahlen enthalten. So bist du nicht auf einzelne Wörter begrenzt, sondern kannst z.B.
									auch Zitate eingeben.<br>
									Von dir eingegebene Suchbegriffe werden dir beim Spielen nicht angezeigt!<br>
									Entsprechend den aktuellen Spieleinstellungen werden dir für jeden eingegebenen Begriff %2$d Punkte gutgeschrieben.',
	'HANGMAN_QUOTE_INPUT'		=> 'Neuer Suchbegriff',
	'HANGMAN_WORD_SAVED'		=> 'Der eingegebene Suchbegriff wurde erfolgreich in der Datenbank gespeichert.<br>
									Deinem Konto wurden %1$s Punkte gutgeschrieben.',
	'HANGMAN_UNAUTH_LETTERS'	=> 'Der Suchbegriff enthält folgende ungültige Zeichen: ',
	'HANGMAN_WORD_EXISTS'		=> '<strong>Der eingegebene Suchbegriff existiert bereits!</strong> Gib bitte einen anderen Begriff ein.',
	// Ranking table
	'HANGMAN_RANKING_TABLE'		=> 'Rangliste',
	'TOTAL_POINTS'				=> 'Gesamtpunktzahl',
	'GAME_POINTS'				=> 'Spielepunkte',
	'WORD_POINTS'				=> 'Begriffseingabepunkte',
	'NO_ENTRIES'				=> 'Keine Einträge',
));
