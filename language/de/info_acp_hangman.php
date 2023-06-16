<?php
/**
*
* @package Hangman v0.7.0
* @copyright (c) 2021 - 2023 Mike-on-Tour
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
	'ACP_HANGMAN'								=> 'Hangman',
	'ACP_MOT_HANGMAN'							=> 'Hangman',
	'ACP_HANGMAN_SETTINGS'						=> 'Einstellungen',
	'ACP_MOT_HANGMAN_SETTINGS'					=> 'Einstellungen',
	// General settings
	'ACP_MOT_HANGMAN_EXT_SETTINGS'				=> 'Programmeinstellungen',
	'ACP_MOT_HANGMAN_AUTODELETE'				=> 'Benutzte Begriffe löschen?',
	'ACP_MOT_HANGMAN_AUTODELETE_EXP'			=> 'Wenn aktiviert, werden beim Spiel verwendete Suchbegriffe bei Beendigung des Spiels aus der Datenbank gelöscht.',
	'ACP_MOT_HANGMAN_CATEGORY_ENABLE'			=> 'Kategorien einschalten?',
	'ACP_MOT_HANGMAN_CATEGORY_ENABLE_EXP'		=> 'Wenn aktiviert, wird bei der Eingabe eines Suchbegriffes ein weiteres Eingabefeld angezeigt, in dem für
													den eingegebenen Suchbegriff eine Kategorie angegeben werden kann.<br>
													Diese Kategorie wird im Spiel über dem Feld mit dem zu suchenden Begriff angezeigt und dient so als kleine Hilfestellung.',
	'ACP_MOT_HANGMAN_CATEGORY_ENFORCE'			=> 'Ausfüllen der Kategorie erzwingen?',
	'ACP_MOT_HANGMAN_CATEGORY_ENFORCE_EXP'		=> 'Wenn aktiviert, wird bei eingeschalteter ´Kategorie´ das Eingeben einer Kategorie erzwungen, das
													Eingabeformular kann dann ohne eine Eintragung im Feld ´Kategorie´ nicht verlassen werden.',
	'ACP_MOT_HANGMAN_SHOW_TERM'					=> 'Anzeige des Suchbegriffes bei Verlieren',
	'ACP_MOT_HANGMAN_SHOW_TERM_EXP'				=> 'Wenn aktiviert, wird in der Meldung über das verlorene Spiel auch der Suchbegriff im Klartext angezeigt.',
	'ACP_MOT_HANGMAN_ENFORCE_TERM'				=> 'Spieler mit zu wenigen Eingabepunkten blockieren',
	'ACP_MOT_HANGMAN_ENFORCE_TERM_EXP'			=> 'Wenn aktiviert, werden Spieler, bei denen das Verhältnis der Spielepunkte zu den Begriffseingabepunkten
													eine bestimmte Grenze überschreitet, aufgefordert vor einem neuen Spiel zunächst neue Suchbegriffe einzugeben.
													So kannst du Spieler erziehen, die das Eingaben von Suchbegriffen vernachlässigen.<br>
													Das Verhältnis Spielepunkte zu Begriffseingabepunkten kannst du in der nächsten Einstellung auswählen, sie
													wird angezeigt sobald du hier ´Ja´ auswählst.',
	'ACP_MOT_HANGMAN_ENFORCE_TERM_RATIO'		=> 'Verhältnis Spielepunkte zu Begriffseingabepunkten',
	'ACP_MOT_HANGMAN_ENFORCE_TERM_RATIO_EXP'	=> 'Es handelt sich bei dieser Maßnahme prinzipiell um den Ausschluss von Mitgliedern vom Spiel, wenn sie zu
													wenige neue Suchbegriffe eingeben; es wird deshalb empfohlen, dieses Verhältnis anfangs nicht zu niedrig
													einzustellen, beispielsweise bedeutet der voreingestellte Wert von 40, dass ein Spieler mit 40 Begriffseingabepunkten
													und mehr als 1.600 Spielepunkten so lange vom Spiel ausgeschlossen wird (er bekommt statt des Spiels einen
													entsprechenden Hinweistext angezeigt) bis er so viele neue Suchbegriffe eingegeben hat, dass das Verhältnis
													unter 40 sinkt.<br>
													Vor der ersten Verwendung sollte deshalb ein Blick in die Rangliste stehen, um die Spieler mit dem größten
													Verhältnis zu identifizieren und dann langsam diesen Wert zu senken. Langfristiges Ziel sollte ein Verhältnis
													sein, das der durchschnittlichen Punktezahl bei Spielgewinn geteilt durch die Punkte für die Eingabe eines
													Suchbegriffes entspricht.<br>
													Beispiel: Durchschnittlich 25 Punkte bei Spielgewinn zu 8 Punkten für jeden Begriff bedeutet ein Verhältnis
													von 3,125, aufgerundet 4. Damit muss jeder Spieler für (fast) jeden verwendeten Begriff einen
													neuen eingeben; dies erscheint als gesundes Verhältnis, wenn verwendete Begriffe gelöscht
													werden, ist dies nicht der Fall, kann das Verhältnis auch deutlich höher gewählt werden.',
	'ACP_MOT_HANGMAN_DISPLAY_ONLINE'			=> 'Anzeige der aktuell aktiven Hangman-Spieler',
	'ACP_MOT_HANGMAN_DISPLAY_ONLINE_EXP'		=> 'Bei Aktivierung dieser Einstellung werden auf der Foren-Übersicht im Bereich „Wer ist online“ die Gesamtanzahl und die Namen
													der Mitglieder angezeigt, die gerade eine Funktion von Hangman nutzen.',
	'ACP_MOT_HANGMAN_ROWS_PER_PAGE'				=> 'Zeilen pro Tabellenseite',
	'ACP_MOT_HANGMAN_ROWS_PER_PAGE_EXP'			=> 'Wähle hier die Anzahl der Zeilen, die pro Tabellenseite angezeigt werden soll.',
	// Game settings
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
	'ACP_MOT_HANGMAN_EVADE_ENABLE'				=> 'Verlassen eines Spieles als Verloren werten?',
	'ACP_MOT_HANGMAN_EVADE_ENABLE_EXP'			=> 'Wenn aktiviert, erhalten Spieler, die ein laufendes Spiel verlassen (z.B. durch Anklicken eines
													Links oder Neuladen der Seite) die ´Punktezahl bei Verlieren´ angerechnet.<br>
													Ist diese Option eingeschaltet, werden Spieler über ein Popup-Fenster gefragt, ob sie das Spiel wirklich
													verlassen wollen und erst bei Bejahen dieser Frage mit der ´Punktezahl bei Verlieren´ bestraft. Abhängig von
													der Einstellung ´Benutzte Begriffe löschen´ wird der in diesem Spiel verwendete Suchbegriff ggf. gelöscht.<br>
													Ist diese Option ausgeschaltet, wird die verlangte Seite ohne weitere Maßnahmen geladen.',
	'MOT_HANGMAN_EXTRA_POINTS_ENABLE'			=> 'Extrapunkte bei fehlerfreiem Lösen',
	'MOT_HANGMAN_EXTRA_POINTS_ENABLE_EXP'		=> 'Wenn du die Hangman-Spieler mit Extrapunkten für das Lösen ohne falsche Versuche belohnen möchtest, kannst du das hier
													aktivieren; nach Aktivierung kannst du in einer weiteren, dann sichtbaren Einstellung die Anzahl der Extrapunkte eingeben.',
	'MOT_HANGMAN_EXTRA_POINTS'					=> 'Extrapunkte für fehlerfreies Lösen',
	'MOT_HANGMAN_EXTRA_POINTS_EXP'				=> 'Hier kannst du die Anzahl der Extrapunkte eingeben, Minimum ist ein Extrapunkt, Maximum sind 50 Extrapunkte.',
	//Term settings
	'ACP_MOT_HANGMAN_INPUT_SETTINGS'			=> 'Einstellungen für Suchbegriff',
	'ACP_MOT_HANGMAN_INPUT_SETTINGS_EXP'		=> 'Hier kannst du Einstellungen für die Eingabe der Suchbegriffe vornehmen.',
	'ACP_MOT_HANGMAN_TERM_LENGTH'				=> 'Mindestlänge des Suchbegriffes',
	'ACP_MOT_HANGMAN_TERM_LENGTH_EXP'			=> 'Hier kannst du die Mindestlänge des Suchbegriffes als Anzahl der mindestens notwendigen Buchstaben eingeben
													(Satz- und Leerzeichen werden nicht mitgezählt).',
	'ACP_MOT_HANGMAN_PUNCTUATION_MARKS'			=> 'Erlaubte Satzzeichen',
	'ACP_MOT_HANGMAN_PUNCTUATION_MARKS_EXP'		=> 'Die Satzzeichen, die bei der Eingabe eines Suchbegriffes neben den Buchstaben und dem Leerzeichen erlaubt
													sind. Sie werden im Spiel im Suchbegriff angezeigt.<br>
													ACHTUNG: Beim Import von Suchbegriffen aus Dateien oder anderen Tabellen werden ebenfalls nur diese
													Satzzeichen übernommen!',
	'ACP_MOT_HANGMAN_SETTING_SAVED'				=> 'Die Einstellungen für das Hangman Spiel wurden erfolgreich gesichert.',
	// Data migration
	'ACP_MOT_HANGMAN_MIGRATION_SETTINGS'		=> 'Daten importieren',
	'ACP_MOT_HANGMAN_UPLOAD_XML'				=> 'Eine lokale xml-Datei hochladen',
	'ACP_MOT_HANGMAN_UPLOAD_XML_EXP'			=> 'Hier kannst du eine lokal auf deinem PC gespeicherte xml-Datei mit Suchbegriffen und Kategorien auswählen,
													auf den Server hochladen und in die Tabelle mit den Suchbegriffen integrieren.<br>
													Als Ersteller wirst dabei du eingetragen, d.h. du kannst diese Suchbegriffe nicht spielen. Außerdem erhälst
													du keine Punkte dafür gutgeschrieben.',
	'ACP_MOT_HANGMAN_UPLOAD'					=> 'Datei hochladen',
	'ACP_MOT_HANGMAN_ERROR'						=> 'Fehler!',
	'ACP_MOT_HANGMAN_SELECT_FILE'				=> 'Wähle bitte zuerst eine Datei aus',
	'ACP_MOT_HANGMAN_INVALID_FILE_EXT'			=> 'Ungültige Datei-Erweiterung.',
	'ACP_MOT_HANGMAN_INVALID_FILE_CONTENT'		=> 'Datei ist fehlerhaft, Laden abgebrochen.',
	'ACP_MOT_HANGMAN_XML_IMPORTED'				=> [
		1	=> '%1$d Datensatz aus der Datei „<i>%2$s</i>“ importiert.',
		2	=> '%1$d Datensätze aus der Datei „<i>%2$s</i>“ importiert.',
	],
	'ACP_MOT_HANGMAN_XML_NO_IMPORT'				=> 'Die Datei „<i>%1$s</i>“ enthielt keine importierbaren Daten.',
	'ACP_MOT_HANGMAN_IMPORT_TABLE'				=> 'Suchbegriffe aus ´dmzx/hangmangame´ importieren',
	'ACP_MOT_HANGMAN_IMPORT_TABLE_EXP'			=> 'Wenn du diese Auswahl siehst, existiert in der Datenbank eine Tabelle mit Suchbegriffen, die du noch nicht
													in dieses Spiel importiert hast; dies kannst du durch Anklicken der Schaltfläche rechts tun.<br>
													Dabei werden Suchbegriff, Hilfestellung (als Kategorie) und Ersteller übernommen, aber keine Punkte gutgeschrieben.',
	'ACP_MOT_HANGMAN_IMPORT_TABLE_BUTTON'		=> 'Tabelle importieren',
	'ACP_MOT_HANGMAN_TABLE_IMPORTED'			=> [
		1	=> '%1$d Datensatz aus der Tabelle „<i>%2$s</i>“ importiert.',
		2	=> '%1$d Datensätze aus der Tabelle „<i>%2$s</i>“ importiert.',
	],
	'ACP_MOT_HANGMAN_TABLE_NO_IMPORT'			=> 'Die Tabelle „<i>%1$s</i>“ enthielt keine importierbaren Daten.',
	'ACP_MOT_HANGMAN_DATA_EXPORT'				=> 'Daten exportieren',
	'ACP_MOT_HANGMAN_EXPORT_TERMS'				=> 'Suchbegriffe aus Tabelle exportieren',
	'ACP_MOT_HANGMAN_EXPORT_TERMS_EXP'			=> 'Hier kannst du die in der Tabelle “_mot_hangman_words” enthaltenen Suchbegriffe in eine XML-Datei
													exportieren.<br>
													Durch Klicken des Buttons rechts wird eine XML-Datei mit einem vordefinierten Namen erzeugt und anschließend
													zum Download und lokalen Abspeichern angeboten.',
	'ACP_MOT_HANGMAN_SUBMIT_EXPORT'				=> 'Daten exportieren',
	'ACP_MOT_HANGMAN_TABLE_NO_EXPORT'			=> 'Export der Daten ist fehlgeschlagen, Datei konnte nicht erzeugt werden.',
	// Misc
	'ACP_MOT_HANGMAN_RESET_HIGHSCORE'			=> 'Rangliste löschen',
	'ACP_MOT_HANGMAN_RESET_HIGHSCORE_CAUTION'	=> '<strong>ACHTUNG:</strong> Dieser Vorgang kann nicht rückgängig gemacht werden!',
	'ACP_MOT_HANGMAN_SCORE_TABLE_CLEARED'		=> '<strong>Hangman Rangliste gelöscht</strong>',
	'ACP_MOT_HANGMAN_HIGHSCORE_TABLE_CLEARED'	=> 'Rangliste wurde gelöscht',
	'ACP_MOT_HANGMAN_SUPPORT_HANGMAN'			=> 'Wenn du die Entwicklung des Hangman Spiels unterstützen möchtest, kannst du das hier tun:<br>',
	'ACP_MOT_HANGMAN_VERSION'					=> '<img src="https://img.shields.io/badge/Version-%1$s-green.svg?style=plastic" /><br>&copy; 2021 - %2$d by Mike-on-Tour',
]);
