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
	'ACP_HANGMAN'						=> 'Hangman',
	'ACP_HANGMAN_SETTINGS'				=> 'Einstellungen',
	'ACP_HANGMAN_EXT_SETTINGS'			=> 'Programmeinstellungen',
	'ACP_HANGMAN_AUTODELETE'			=> 'Benutzte Begriffe löschen?',
	'ACP_HANGMAN_AUTODELETE_EXP'		=> 'Wenn Sie hier ´Ja´ auswählen, werden beim Spiel verwendete Suchbegriffe bei Beendigung des Spiels aus der Datenbank gelöscht.',
	'ACP_HANGMAN_CATEGORY_ENABLE'		=> 'Kategorien einschalten?',
	'ACP_HANGMAN_CATEGORY_ENABLE_EXP'	=> 'Wenn Sie hier ´Ja´ auswählen, wird bei der Eingabe eines Suchbegriffes ein weiteres Eingabefeld angezeigt, in dem für
											den eingegebenen Suchbegriff eine Kategorie angegeben werden kann.<br>
											Diese Kategorie wird im Spiel über dem Feld mit dem zu suchenden Begriff angezeigt und dient so als kleine Hilfestellung.',
	'ACP_HANGMAN_CATEGORY_ENFORCE'		=> 'Ausfüllen der Kategorie erzwingen?',
	'ACP_HANGMAN_CATEGORY_ENFORCE_EXP'	=> 'Wenn Sie hier ´Ja´ auswählen, wird bei eingeschalteter ´Kategorie´ das Eingeben einer Kategorie erzwungen, das
											Eingabeformular kann dann ohne eine Eintragung im Feld ´Kategorie´ nicht verlassen werden.',
	'ACP_HANGMAN_GAME_SETTINGS'			=> 'Spieleinstellungen',
	'ACP_HANGMAN_GAME_SETTINGS_EXP'		=> 'Hier können Sie alle Einstellungen zu Anzahl der Leben (Fehlversuche) und der zu zählenden Punkte eingeben.<br>
											Die Eingaben werden entsprechend den Hinweisen zu den einzelnen Werten überprüft und ggf. abgeändert.',
	'ACP_HANGMAN_LIVES'					=> 'Anzahl Versuche (Leben)',
	'ACP_HANGMAN_LIVES_EXP'				=> 'Anzahl der Fehlversuche, bis der Spieler am Galgen baumelt und das Spiel verliert<br>
											(möglich ist eine ganze Zahl zwischen 4 und 10)',
	'ACP_HANGMAN_POINTS_WIN'			=> 'Punktzahl bei Auflösung',
	'ACP_HANGMAN_POINTS_WIN_EXP'		=> 'Anzahl der Punkte, die dem Spieler beim Auflösen des Rätsels auf seinem Spielekonto gutgeschrieben werden<br>
											(ganze Zahl größer als Null)',
	'ACP_HANGMAN_POINTS_LOOSE'			=> 'Punktzahl bei Verlieren',
	'ACP_HANGMAN_POINTS_LOOSE_EXP'		=> 'Anzahl der Punkte, mit denen das Spielekonto des Spielers beim Verlieren belastet wird<br>
											(ganze Zahl kleiner oder gleich Null)',
	'ACP_HANGMAN_POINTS_LETTER'			=> 'Punktzahl für richtigen Buchstaben',
	'ACP_HANGMAN_POINTS_LETTER_EXP'		=> 'Anzahl der Punkte, die dem Spieler bei Auswahl eines richtigen Buchstabens auf seinem Spielekonto gutgeschrieben werden<br>
											(ganze Zahl größer oder gleich Null)',
	'ACP_HANGMAN_POINTS_WORD'			=> 'Punkte für eingestellten Suchbegriff',
	'ACP_HANGMAN_POINTS_WORD_EXP'		=> 'Anzahl der Punkte, die einem Spieler für das Erstellen eines Suchbegriffes auf seinem Spielekonto gutgeschrieben werden<br>
											(ganze Zahl größer oder gleich Null)',
	'ACP_HANGMAN_SETTING_SAVED'			=> 'Die Einstellungen für das Hangman Spiel wurden erfolgreich gesichert.',
	'RESET_HIGHSCORE'					=> 'Rangliste löschen',
	'RESET_HIGHSCORE_CAUTION'			=> '<strong>ACHTUNG:</strong> Dieser Vorgang kann nicht rückgängig gemacht werden!',
	'HANGMAN_SCORE_TABLE_CLEARED'		=> 'Hangman Rangliste gelöscht',
	'HIGHSCORE_TABLE_CLEARED'			=> 'Rangliste wurde gelöscht',
	'SUPPORT_HANGMAN'					=> 'Wenn Sie die Entwicklung des Hangman Spiels unterstützen möchtest, können Sie das hier tun:<br>',
]);
