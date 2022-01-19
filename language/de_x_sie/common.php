<?php
/*
*
* @package Hangman v0.4.0
* @author Mike-on-Tour
* @copyright (c) 2021 - 2022 Mike-on-Tour
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
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	// Tab menu
	'MOT_HANGMAN_TAB_GAME'			=> 'Spiel',
	'MOT_HANGMAN_TAB_WORD'			=> 'Eingabe Suchbegriff',
	'MOT_HANGMAN_TAB_SCORE'			=> 'Rangliste',
	'MOT_HANGMAN_TAB_SUMMARY'		=> 'Übersicht',
	// Back menu
	'MOT_HANGMAN_TO_GAME'			=> 'Neues Spiel',
	'MOT_HANGMAN_TO_WORD_INPUT'		=> 'Einen neuen Suchbegriff eingeben',
	'MOT_HANGMAN_TO_SCORE_TABLE'	=> 'Zur Rangliste',
	'MOT_HANGMAN_TO_SUMMARY'		=> 'Zur Übersicht',
	// Game
	'MOT_HANGMAN'					=> 'Hangman',
	'MOT_HANGMAN_TITLE'				=> 'Hangman Spiel',
	'MOT_HANGMAN_DESC'				=> 'Willkommen im Spielbereich von `Hangman`. Durch Anklicken des Knopfes `Spielstart` wird ein zufälliger Begriff aus der
										Datenbank ausgewählt und im Begriffsfenster dargestellt. Dabei wird jeder Buchstabe durch einen Unterstrich repräsentiert.
										Haben Sie einen Buchstaben ausgewählt, der im gesuchten Begriff vorkommt, wird er statt des Unterstriches angezeigt.<br>
										Einmal verwendete Buchstaben verschwinden aus der Auswahl und können nicht mehr ausgewählt werden. Bereits gewählte
										Buchstaben werden entweder im Fenster `Falsche Versuche` oder im Fenster `Richtige Versuche` aufgelistet.<br>
										Entsprechend der aktuellen Einstellungen erhalten Sie für jeden richtigen Buchstaben %1$d Punkte gutgeschrieben, ein
										gewonnenes Spiel zählt %2$d Punkte und ein verlorenes Spiel %3$d Punkte.',
	'MOT_HANGMAN_DESC_DEL_TERM'		=> '<br>ACHTUNG: Verwendete Suchbegriffe werden aus der Datenbank gelöscht. Geben Sie also bitte nach jedem Spiel einen neuen Suchbegriff
										ein, damit andere ebenfalls spielen können.',
	// List all letters of this language as uppercase letters seperated by comma. If this language contains lowercase letters without an uppercase equivalent list them here, too.
	'MOT_HANGMAN_LETTERS'			=> 'A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,Ä,Ö,Ü,ß',
	'MOT_HANGMAN_LIVES'				=> 'Sie haben in diesem Spiel %1$d Leben.',
	'MOT_HANGMAN_SCORE'				=> 'Erreichte Punkte:',
	'MOT_HANGMAN_LIVES_USED'		=> 'Benutzte Leben:',
	'MOT_HANGMAN_NEW_QUOTE'			=> 'Spielstart',
	'MOT_HANGMAN_NEW_QUOTE_START'	=> 'Klicken Sie auf ´Spielstart´, um das Hangman Spiel zu starten',
	'MOT_HANGMAN_NO_QUOTE'			=> 'Es sind keine Begriffe verfügbar. Versuchen Sie es bitte später noch einmal.',
	'MOT_HANGMAN_CATEGORY'			=> 'Kategorie',
	'MOT_HANGMAN_FAILED_TRIES'		=> 'Falsche Versuche',
	'MOT_HANGMAN_CORRECT_TRIES'		=> 'Richtige Versuche',
	'MOT_HANGMAN_YOU_WIN'			=> '<strong>Sie haben gewonnen!</strong><br>Erreichte Punktzahl: ',
	'MOT_HANGMAN_NEW_QUOTE_TO'		=> 'Klicken Sie erst auf ´Spielstart´ zum Start!',
	'MOT_HANGMAN_YOU_LOSE'			=> '<strong>Sie haben leider verloren!</strong><br>Erreichte Punktzahl: ',
	'MOT_HANGMAN_POINTS_SAVED'		=> 'Ihre im Spiel gewonnenen Punkte wurden deinem Konto gutgeschrieben.',
	// Term definition
	'MOT_HANGMAN_QUOTE_INPUT_HEAD'	=> 'Eingabe eines neuen Suchbegriffes',
	'MOT_HANGMAN_QUOTE_INPUT_EXPL'	=> 'Hier können Sie einen neuen Suchbegriff eingeben. Dieser Suchbegriff darf die Buchstaben %1$s (groß und klein), Leerzeichen
										und die Satzzeichen %2$s enthalten. So sind Sie nicht auf einzelne Wörter begrenzt, sondern können z.B.
										auch Zitate eingeben.<br>
										Von Ihnen eingegebene Suchbegriffe werden Ihnen beim Spielen nicht angezeigt!',
	'MOT_HANGMAN_CATEGORY_EXPL'		=> 'Durch die Angabe einer Kategorie können Sie eine Hilfestellung geben, die auf den gesuchten Begriff hinweist.',
	'MOT_HANGMAN_INPUT_POINTS'		=> [
		1							=> 'Entsprechend den aktuellen Einstellungen wird Ihnen für jeden eingegebenen Begriff %1$d Punkt gutgeschrieben.',
		2							=> 'Entsprechend den aktuellen Einstellungen werden Ihnen für jeden eingegebenen Begriff %1$d Punkte gutgeschrieben.',
	],
	'MOT_HANGMAN_QUOTE_INPUT'		=> 'Neuer Suchbegriff',
	'MOT_HANGMAN_WORD_SAVED'		=> 'Der eingegebene Suchbegriff wurde erfolgreich in der Datenbank gespeichert.<br>
										Ihrem Konto wurden %1$s Punkte gutgeschrieben.',
	'MOT_HANGMAN_UNAUTH_LETTERS'	=> 'Der Suchbegriff enthält folgende ungültige Zeichen: ',
	'MOT_HANGMAN_TERM_TOO_SHORT'	=> 'Der Suchbegriff ist zu kurz! Erforderliche Anzahl an Buchstaben: ',
	'MOT_HANGMAN_CATEGORY_MISSING'	=> 'Kategorie muss ausgefüllt sein!',
	'MOT_HANGMAN_WORD_EXISTS'		=> '<strong>Der eingegebene Suchbegriff existiert bereits!</strong> Geben Sie bitte einen anderen Begriff ein.',
	// Ranking table
	'MOT_HANGMAN_RANKING_TABLE'		=> 'Rangliste',
	'MOT_HANGMAN_TOTAL_POINTS'		=> 'Gesamtpunktzahl',
	'MOT_HANGMAN_GAME_POINTS'		=> 'Spielepunkte',
	'MOT_HANGMAN_WORD_POINTS'		=> 'Begriffseingabepunkte',
	'MOT_HANGMAN_NO_ENTRIES'		=> 'Keine Einträge',
	// Summary
	'MOT_HANGMAN_SUMMARY'			=> 'Übersicht',
	'ACP_MOT_HANGMAN_TERMS'			=> 'Suchbegriffe',
	'MOT_HANGMAN_TERMS_AVAILABLE'	=> 'Anzahl der verfügbaren Suchbegriffe',
	'MOT_HANGMAN_USER_TERMS_AVAILABLE'	=> 'Davon von Ihnen eingegebene Suchbegriffe',
	'MOT_HANGMAN_USER_TERMS'		=> 'Von Ihnen eingegebene, verfügbare Suchbegriffe',
	'MOT_HANGMAN_TERM'				=> 'Suchbegriff',
	'MOT_HANGMAN_CATEGORY'			=> 'Kategorie',
]);
