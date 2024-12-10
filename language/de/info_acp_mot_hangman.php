<?php
/**
*
* @package Hangman v0.11.0
* @copyright (c) 2021 - 2024 Mike-on-Tour
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
	'ACP_MOT_HANGMAN_ENABLE'					=> 'Hangman aktivieren',
	'ACP_MOT_HANGMAN_ENABLE_EXP'				=> 'Hangman für die berechtigten Mitglieder ein- bzw. ausschalten, zeigt je nach Einstellung den Link in der Navigationsleiste an.<br>
													Diese Einstellung gilt nicht für Gründer, diese können Hangman immer sehen.',
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
													So kannst du Spieler erziehen, die das Eingeben von Suchbegriffen vernachlässigen.<br>
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
	'ACP_MOT_HANGMAN_GAIN_RANK'					=> 'Verbesserung Ranglistenplatz anzeigen',
	'ACP_MOT_HANGMAN_GAIN_RANK_EXP'				=> 'Bei Aktivierung dieser Einstellung wird einem Spieler nach dem Spiel ein Glückwunsch-Fenster angezeigt, wenn er mit dem Ergebnis
													seinen Ranglistenplatz verbessert hat.',
	'ACP_MOT_HANGMAN_LOOSE_RANK'				=> 'Benachrichtigung bei Verlust Ranglistenplatz',
	'ACP_MOT_HANGMAN_LOOSE_RANK_EXP'			=> 'Bei Aktivierung dieser Einstellung erhält jeder Spieler eine Benachrichtigung, wenn er seinen Ranglistenplatz durch das
													Spielergebnis eines anderen Spielers verliert.',
	'ACP_MOT_HANGMAN_ENABLE_RANK'				=> 'Rangliste anzeigen',
	'ACP_MOT_HANGMAN_ENABLE_RANK_EXP'			=> 'Diese Einstellung schaltet die Anzeige der Rangliste ein oder aus.',
	'ACP_MOT_HANGMAN_ENABLE_FAME'				=> '»Hall of Fame« anzeigen',
	'ACP_MOT_HANGMAN_ENABLE_FAME_EXP'			=> 'Wenn aktiviert, wird neben der Rangliste ein weiterer Reiter angezeigt, auf dem die monatlichen und jährlichen Spieler mit den
													meisten Punkten im jeweiligen Zeitraum angezeigt werden.<br>
													Wenn aktiviert, wird ein weiteres Eingabefeld angezeigt, mit dem die Anzahl der anzuzeigenden Spieler ausgewählt wird.',
	'ACP_MOT_HANGMAN_RANK_LIMIT'				=> 'Anzahl der anzuzeigenden Spieler pro laufender Tabelle',
	'ACP_MOT_HANGMAN_RANK_LIMIT_EXP'			=> 'Hier kannst du auswählen wie viele Spieler in den Tabellen für den laufenden Monat und das laufende Jahr angezeigt werden sollen.',
	'ACP_MOT_HANGMAN_DISPLAY_ONLINE'			=> 'Anzeige der aktuell aktiven Hangman-Spieler',
	'ACP_MOT_HANGMAN_DISPLAY_ONLINE_EXP'		=> 'Bei Aktivierung dieser Einstellung werden auf der Foren-Übersicht im Bereich „Wer ist online“ die Gesamtanzahl und die Namen
													der Mitglieder angezeigt, die gerade eine Funktion von Hangman nutzen.',
	'ACP_MOT_HANGMAN_ROWS_PER_PAGE'				=> 'Zeilen pro Tabellenseite',
	'ACP_MOT_HANGMAN_ROWS_PER_PAGE_EXP'			=> 'Wähle hier die Anzahl der Zeilen, die in der Rangliste pro Tabellenseite angezeigt werden soll.',

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
	'ACP_MOT_HANGMAN_EXTRA_POINTS_ENABLE'		=> 'Extrapunkte bei fehlerfreiem Lösen',
	'ACP_MOT_HANGMAN_EXTRA_POINTS_ENABLE_EXP'	=> 'Wenn du die Hangman-Spieler mit Extrapunkten für das Lösen ohne falsche Versuche belohnen möchtest, kannst du das hier
													aktivieren; nach Aktivierung kannst du in einer weiteren, dann sichtbaren Einstellung die Anzahl der Extrapunkte eingeben.',
	'ACP_MOT_HANGMAN_EXTRA_POINTS'				=> 'Extrapunkte für fehlerfreies Lösen',
	'ACP_MOT_HANGMAN_EXTRA_POINTS_EXP'			=> 'Hier kannst du die Anzahl der Extrapunkte eingeben, Minimum ist ein Extrapunkt, Maximum sind 50 Extrapunkte.',

	//Term settings
	'ACP_MOT_HANGMAN_INPUT_SETTINGS'			=> 'Einstellungen für Suchbegriff',
	'ACP_MOT_HANGMAN_INPUT_SETTINGS_EXP'		=> 'Hier kannst du Einstellungen für die Eingabe der Suchbegriffe vornehmen.',
	'ACP_MOT_HANGMAN_TERM_LENGTH'				=> 'Mindestlänge des Suchbegriffes',
	'ACP_MOT_HANGMAN_TERM_LENGTH_EXP'			=> 'Hier kannst du die Mindestlänge des Suchbegriffes als Anzahl der mindestens notwendigen Buchstaben eingeben
													(Satz- und Leerzeichen werden nicht mitgezählt).',
	'ACP_MOT_HANGMAN_PUNCTUATION_MARKS'			=> 'Erlaubte Satzzeichen',
	'ACP_MOT_HANGMAN_PUNCTUATION_MARKS_EXP'		=> 'Die Satzzeichen, die bei der Eingabe eines Suchbegriffes neben den Buchstaben und dem Leerzeichen erlaubt
													sind. Sie werden im Spiel im Suchbegriff angezeigt. Einfache und doppelte Anführungsstriche sowie der Unterstrich sind nicht erlaubt!<br>
													ACHTUNG: Beim Import von Suchbegriffen aus Dateien oder anderen Tabellen werden ebenfalls nur diese
													Satzzeichen übernommen!',
	'ACP_MOT_HANGMAN_SETTING_SAVED'				=> 'Die Einstellungen für das Hangman Spiel wurden erfolgreich gesichert.',

	// UP and rwards settings
	'ACP_MOT_HANGMAN_UP_SETTINGS'				=> 'Einstellungen Punkte-System',
	'ACP_MOT_HANGMAN_POINTS_ENABLE'				=> 'Punkte-System aktivieren',
	'ACP_MOT_HANGMAN_POINTS_ENABLE_EXPL'		=> 'Wenn ein Punkte-System (z.B. ´Ultimate Points´) auf deinem Board installiert ist, werden die Punkte vom Hangman dem Spielekonto
													hinzugefügt bzw. von dort auch abgezogen.<br>
													Nach Aktivierung werden dafür weitere Einstellmöglichkeiten angezeigt.',
	'ACP_MOT_HANGMAN_POINTS_RATIO'				=> 'Verhältnis Punkte Hangman zu Punkte-System',
	'ACP_MOT_HANGMAN_POINTS_RATIO_EXPL'			=> 'Legt fest, wieviele Punkte dem Benutzerkonto des Punkte-Systems pro %1$d Hangman-Punkte gutgeschrieben werden sollen.',
	'ACP_MOT_HANGMAN_POINTS_NAME'				=> 'Punkte',
	'ACP_MOT_HANGMAN_REWARD_SETTINGS'			=> 'Einstellungen für Bonussystem',
	'ACP_MOT_HANGMAN_REWARD_ON'					=> 'Hangman Bonussystem aktivieren',
	'ACP_MOT_HANGMAN_REWARD_ON_EXPL'			=> 'Periodische Kalkulation der Bonuszahlungen aktivieren.<br>
													Nach Aktivierung werden dafür weitere Einstellmöglichkeiten angezeigt.',
	'ACP_MOT_HANGMAN_REWARD_TIME'				=> 'Zeitintervall zwischen zwei Bonusberechnungen',
	'ACP_MOT_HANGMAN_REWARD_TIME_EXPL'			=> 'Der Abstand zwischen zwei Berechnungen zum Ermitteln des Gewinners für die Bonuszahlung.',
	'ACP_MOT_HANGMAN_WEEK_START'				=> 'Auswahl Wochentag für wöchentliche Berechnung',
	'ACP_MOT_HANGMAN_WEEK_START_EXPL'			=> 'Wähle hier bei wöchentlicher Berechnung der Bonuszahlung den Wochentag aus, an dem die Berechnung erfolgen soll.',
	'ACP_MOT_HANGMAN_DAILY'						=> 'Täglich',
	'ACP_MOT_HANGMAN_WEEKLY'					=> 'Wöchentlich',
	'ACP_MOT_HANGMAN_MONTHLY'					=> 'Monatlich',
	'ACP_MOT_HANGMAN_YEARLY'					=> 'Jährlich',
	'ACP_MOT_HANGMAN_WEEK_START'				=> 'Auswahl Wochentag für wöchentliche Berechnung',
	'ACP_MOT_HANGMAN_WEEK_START_EXPL'			=> 'Wähle hier bei wöchentlicher Berechnung der Bonuszahlung den Wochentag aus, an dem die Berechnung erfolgen soll.',
	'ACP_MOT_HANGMAN_SUNDAY'					=> 'Sonntag',
	'ACP_MOT_HANGMAN_MONDAY'					=> 'Montag',
	'ACP_MOT_HANGMAN_TUESDAY'					=> 'Dienstag',
	'ACP_MOT_HANGMAN_WEDNESDAY'					=> 'Mittwoch',
	'ACP_MOT_HANGMAN_THURSDAY'					=> 'Donnerstag',
	'ACP_MOT_HANGMAN_FRIDAY'					=> 'Freitag',
	'ACP_MOT_HANGMAN_SATURDAY'					=> 'Samstag',
	'ACP_MOT_HANGMAN_REWARD_LAST_GC'			=> 'Zeitpunkt der letzten Laufes des Cron-Tasks',
	'ACP_MOT_HANGMAN_REWARD_LAST_GC_EXPL'		=> 'Zeitpunkt des letzten Laufes des Cron-Tasks zur Berechnung der Bonuszahlungen. Diese Angabe bezieht sich nur auf die Ausführung
													des Cron-Tasks und sagt nichts über den Zeitpunkt der letzten Berechnung bzw. Gutschrift aus.',
	'ACP_MOT_HANGMAN_POINTS_PRICE'				=> 'Bonus für den Spieler mit den meisten Punkten',
	'ACP_MOT_HANGMAN_POINTS_PRICE_EXPL'			=> 'Bonuspunkte für den Spieler mit den meisten Punkten in der laufenden Periode.',
	'ACP_MOT_HANGMAN_PM_ENABLE'					=> 'Persönliche Nachricht aktivieren',
	'ACP_MOT_HANGMAN_PM_ENABLE_EXPL'			=> 'Der Gewinner wird per PN über seinen Gewinn informiert. Zeitgleich erhält der ausgewählte Administrator eine PN mit dem Namen des Gewinners.',
	'ACP_MOT_HANGMAN_ADMIN_LIST'				=> 'Administrator für das Hangman Bonussystem',
	'ACP_MOT_HANGMAN_ADMIN_LIST_EXPL'			=> 'Ein Board Administrator oder Moderator, der die regelmäßigen Reports erhält und dessen Name als Absender in der PN für den
													Gewinner erscheint.',

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
	'ACP_MOT_HANGMAN_CLEAR_SCORE_CONFIRM'		=> 'Willst du wirklich die Hangman Rangliste löschen?',
	'ACP_MOT_HANGMAN_SCORE_TABLE_CLEARED'		=> '<strong>Hangman Rangliste gelöscht</strong>',
	'ACP_MOT_HANGMAN_HIGHSCORE_TABLE_CLEARED'	=> 'Rangliste wurde gelöscht',
	'ACP_MOT_HANGMAN_CLEAR_FAME'				=> 'Einträge aus Tabelle „Ruhmeshalle“ löschen',
	'ACP_MOT_HANGMAN_CLEAR_FAME_EXPL'			=> 'Hier werden die vergangenen Jahre aufgelistet, für die noch Einträge in der Tabelle für die Ruhmeshalle vorhanden sind. Du
													kannst aus dem Auswahlfeld rechts alle die Jahre auswählen (Mehrfachauswahl mit Klicken unter Halten der `Strg`-Taste), deren
													Einträge du löschen möchtest. ALLE Einträge für diese Jahre werden dann gelöscht (die Bestenlisten für die zurückliegenden
													Jahre und Monate sind in anderen Tabellen gespeichert, diese Daten gehen also nicht verloren).',
	'ACP_MOT_HANGMAN_NO_FAME_YEARS'				=> 'Keine Einträge zum Löschen vorhanden',
	'ACP_MOT_HANGMAN_CLEAR_FAME_ERROR'			=> 'Du hast keine Auswahl getroffen, Löschen deshalb nicht möglich!',
	'ACP_MOT_HANGMAN_CLEAR_FAME_CONFIRM'		=> [
		1	=> 'Willst du die Daten des ausgewählten Jahres für die „Ruhmeshalle“ wirklich löschen?',
		2	=> 'Willst du die Daten der ausgewählten %1$d Jahre für die „Ruhmeshalle“ wirklich löschen?',
	],
	'ACP_MOT_HANGMAN_CLEAR_FAME_SUCCESS'		=> 'Daten erfolgreich aus der Tabelle für die „Ruhmeshalle“ gelöscht.',
	'ACP_MOT_HANGMAN_SUPPORT_HANGMAN'			=> 'Wenn du die Entwicklung des Hangman Spiels unterstützen möchtest, kannst du das hier tun:<br>',
	'ACP_MOT_HANGMAN_VERSION'					=> '<img src="https://img.shields.io/badge/Version-%1$s-green.svg?style=plastic"><br>&copy; 2021 - %2$d by Mike-on-Tour',
]);
