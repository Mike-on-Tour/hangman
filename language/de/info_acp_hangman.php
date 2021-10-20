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
	'ACP_MOT_HANGMAN_SETTINGS'					=> 'Einstellungen',
	'ACP_MOT_HANGMAN_EXT_SETTINGS'				=> 'Programmeinstellungen',
	'ACP_MOT_HANGMAN_AUTODELETE'				=> 'Benutzte Begriffe löschen?',
	'ACP_MOT_HANGMAN_AUTODELETE_EXP'			=> 'Wenn du hier ´Ja´ auswählst, werden beim Spiel verwendete Suchbegriffe bei Beendigung des Spiels aus der Datenbank gelöscht.',
	'ACP_MOT_HANGMAN_CATEGORY_ENABLE'			=> 'Kategorien einschalten?',
	'ACP_MOT_HANGMAN_CATEGORY_ENABLE_EXP'		=> 'Wenn du hier ´Ja´ auswählst, wird bei der Eingabe eines Suchbegriffes ein weiteres Eingabefeld angezeigt, in dem für
													den eingegebenen Suchbegriff eine Kategorie angegeben werden kann.<br>
													Diese Kategorie wird im Spiel über dem Feld mit dem zu suchenden Begriff angezeigt und dient so als kleine Hilfestellung.',
	'ACP_MOT_HANGMAN_CATEGORY_ENFORCE'			=> 'Ausfüllen der Kategorie erzwingen?',
	'ACP_MOT_HANGMAN_CATEGORY_ENFORCE_EXP'		=> 'Wenn du hier ´Ja´ auswählst, wird bei eingeschalteter ´Kategorie´ das Eingeben einer Kategorie erzwungen, das
													Eingabeformular kann dann ohne eine Eintragung im Feld ´Kategorie´ nicht verlassen werden.',
	'ACP_MOT_HANGMAN_EVADE_ENABLE'				=> 'Verlassen eines Spieles als Verloren werten?',
	'ACP_MOT_HANGMAN_EVADE_ENABLE_EXP'			=> 'Wenn du hier ´Ja´ auswählst, erhalten Spieler, die ein laufendes Spiel verlassen (z.B. durch Anklicken eines
													Links oder Neuladen der Seite) die ´Punktezahl bei Verlieren´ angerechnet.<br>
													Ist diese Option eingeschaltet, werden Spieler über ein Popup-Fenster gefragt, ob sie das Spiel wirklich
													verlassen wollen und erst bei Bejahen dieser Frage mit der ´Punktezahl bei Verlieren´ bestraft. Abhängig von
													der Einstellung ´Benutzte Begriffe löschen´ wird der in diesem Spiel verwendete Suchbegriff ggf. gelöscht.<br>
													Ist diese Option ausgeschaltet, wird die verlangte Seite ohne weitere Maßnahmen geladen.',
	'ACP_MOT_HANGMAN_GAME_SETTINGS'				=> 'Spieleinstellungen',
	'ACP_MOT_HANGMAN_GAME_SETTINGS_EXP'			=> 'Hier kannst du alle Einstellungen zu Anzahl der Leben (Fehlversuche) und der zu zählenden Punkte eingeben.<br>
													Die Eingaben werden entsprechend den Hinweisen zu den einzelnen Werten überprüft und ggf. abgeändert.',
	'ACP_MOT_HANGMAN_LIVES'						=> 'Anzahl Versuche (Leben)',
	'ACP_MOT_HANGMAN_LIVES_EXP'					=> 'Anzahl der Fehlversuche, bis der Spieler am Galgen baumelt und das Spiel verliert<br>
													(möglich ist eine ganze Zahl zwischen 4 und 10)',
	'ACP_MOT_HANGMAN_POINTS_WIN'				=> 'Punktzahl bei Auflösung',
	'ACP_MOT_HANGMAN_POINTS_WIN_EXP'			=> 'Anzahl der Punkte, die dem Spieler beim Auflösen des Rätsels auf seinem Spielekonto gutgeschrieben werden<br>
													(ganze Zahl größer als Null)',
	'ACP_MOT_HANGMAN_POINTS_LOOSE'				=> 'Punktzahl bei Verlieren',
	'ACP_MOT_HANGMAN_POINTS_LOOSE_EXP'			=> 'Anzahl der Punkte, mit denen das Spielekonto des Spielers beim Verlieren belastet wird<br>
													(ganze Zahl kleiner oder gleich Null)',
	'ACP_MOT_HANGMAN_POINTS_LETTER'				=> 'Punktzahl für richtigen Buchstaben',
	'ACP_MOT_HANGMAN_POINTS_LETTER_EXP'			=> 'Anzahl der Punkte, die dem Spieler bei Auswahl eines richtigen Buchstabens auf seinem Spielekonto gutgeschrieben werden<br>
													(ganze Zahl größer oder gleich Null)',
	'ACP_MOT_HANGMAN_POINTS_WORD'				=> 'Punkte für eingestellten Suchbegriff',
	'ACP_MOT_HANGMAN_POINTS_WORD_EXP'			=> 'Anzahl der Punkte, die einem Spieler für das Erstellen eines Suchbegriffes auf seinem Spielekonto gutgeschrieben werden<br>
													(ganze Zahl größer oder gleich Null)',
	'ACP_MOT_HANGMAN_INPUT_SETTINGS'			=> 'Einstellungen für Suchbegriff',
	'ACP_MOT_HANGMAN_INPUT_SETTINGS_EXP'		=> 'Hier kannst du Einstellungen für die Eingabe der Suchbegriffe vornehmen.',
	'ACP_MOT_HANGMAN_PUNCTUATION_MARKS'			=> 'Erlaubte Satzzeichen',
	'ACP_MOT_HANGMAN_PUNCTUATION_MARKS_EXP'		=> 'Die Satzzeichen, die bei der Eingabe eines Suchbegriffes neben den Buchstaben und dem Leerzeichen erlaubt
													sind. Sie werden im Spiel im Suchbegriff angezeigt.',
	'ACP_MOT_HANGMAN_SETTING_SAVED'				=> 'Die Einstellungen für das Hangman Spiel wurden erfolgreich gesichert.',
	'ACP_MOT_HANGMAN_RESET_HIGHSCORE'			=> 'Rangliste löschen',
	'ACP_MOT_HANGMAN_RESET_HIGHSCORE_CAUTION'	=> '<strong>ACHTUNG:</strong> Dieser Vorgang kann nicht rückgängig gemacht werden!',
	'ACP_MOT_HANGMAN_SCORE_TABLE_CLEARED'		=> 'Hangman Rangliste gelöscht',
	'ACP_MOT_HANGMAN_HIGHSCORE_TABLE_CLEARED'	=> 'Rangliste wurde gelöscht',
	'ACP_MOT_HANGMAN_SUPPORT_HANGMAN'			=> 'Wenn du die Entwicklung des Hangman Spiels unterstützen möchtest, kannst du das hier tun:<br>',
	'ACP_MOT_HANGMAN_VERSION'					=> '<img src="https://img.shields.io/badge/Version-%1$s-green.svg?style=plastic" /><br>&copy; 2020 - %2$d by Mike-on-Tour',
]);
