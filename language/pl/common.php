<?php
/*
*
* @package Hangman v0.7.0
* @author Mike-on-Tour
* @copyright (c) 2021 - 2023 Mike-on-Tour
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
	'MOT_HANGMAN_TAB_GAME'			=> 'Gra',
	'MOT_HANGMAN_TAB_WORD'			=> 'Wprowadzanie haseł',
	'MOT_HANGMAN_TAB_SCORE'			=> 'Wyniki',
	'MOT_HANGMAN_TAB_SUMMARY'		=> 'Podsumowanie',
	// Back menu
	'MOT_HANGMAN_TO_GAME'			=> 'Start',
	'MOT_HANGMAN_TO_WORD_INPUT'		=> 'Dodaj nowe hasło',
	'MOT_HANGMAN_TO_SCORE_TABLE'	=> 'Zobacz wyniki',
	'MOT_HANGMAN_TO_SUMMARY'		=> 'Lista chwały',
	// Game
	'MOT_HANGMAN'					=> 'Wisielec',
	'MOT_HANGMAN_TITLE'				=> 'Gra w Wisielca',
	'MOT_HANGMAN_DESC'				=> 'Witaj w grze "Wisielec". Naciśniej "Start" by wygenerować z bazy losowe hasło do gry. Na początku gry hasło jest zasnłonięte.
										Trafione litery będą odsłaniane.<br>
										Użyte przez Ciebie litery będą pojawiać się w sekcji "Trafionych" lub "Chybionych".<br>
										Zgodnie z aktualnymi ustawieniami zarobisz %1$s pkt. za każdą trafioną literę i %2$s pkt. za wygraną grę. Przegrana lub ucieczka z gry będzie Cię kosztować %3$s pkt. Ucieczka z gry = przegrana.',
	'MOT_HANGMAN_DESC_DEL_TERM'		=> '<br>ATTENTION: Terms used in a game turn will be deleted from the database after that turn. Please enter a term after you
										concluded a game turn in order to enable others to play, too.',
	// List all letters of this language as uppercase letters separated by comma. If this language contains lowercase letters without an uppercase equivalent list them here, too.
	'MOT_HANGMAN_LETTERS'			=> 'A,Ą,B,C,Ć,D,E,Ę,F,G,H,I,J,K,L,Ł,M,N,Ń,O,Ó,P,Q,R,S,Ś,T,U,V,W,X,Y,Z,Ź,Ż',
	'MOT_HANGMAN_LIVES'				=> 'Zostało Ci %1$s żyć.',
	'MOT_HANGMAN_SCORE'				=> 'Wynik:',
	'MOT_HANGMAN_LIVES_USED'		=> 'Zużyte życia:',
	'MOT_HANGMAN_NEW_QUOTE'			=> 'Start',
	'MOT_HANGMAN_NEW_QUOTE_START'	=> 'Kliknij ´Start´ by zagrać',
	'MOT_HANGMAN_NO_QUOTE'			=> 'Aktualnie wszystkie hasła są zużyte. Poproś innego forumowicza by dodał hasła.',
	'MOT_HANGMAN_CATEGORY'			=> 'Kategoria',
	'MOT_HANGMAN_FAILED_TRIES'		=> 'Chybione próby',
	'MOT_HANGMAN_CORRECT_TRIES'		=> 'Trafione próby',
	'MOT_HANGMAN_WIN_EXTRA_POINTS'	=> 'No failures!!!<br>You gain additional %1$d points!<br>',
	'MOT_HANGMAN_YOU_WIN'			=> '<strong>Wygrałeś!</strong><br>',
	'MOT_HANGMAN_YOU_WIN_PTS'		=> 'Zdobyte pkt: ',
	'MOT_HANGMAN_NEW_QUOTE_TO'		=> 'Kliknij ´Start´ by zagrać',
	'MOT_HANGMAN_YOU_LOSE'			=> '<strong>Przegrałeś!</strong><br>Zdobyte pkt: ',
	'MOT_HANGMAN_SHOW_TERM'			=> '<br><br>Hasło to:<br><i>',
	'MOT_HANGMAN_POINTS_SAVED'		=> 'Gratulacje, Twoje konto zostało zasiilone punktami które zdobyłeś w tej grze!.',
	'MOT_HANGMAN_GAME_BLOCKED'		=> 'Zdefiniowano proporcję punktów za grę w stosunku do punktów za dodawanie haseł, której nie można przekroczyć by grać.
										Zarobiłeś tak wiele punktów za grę a mało za dodawanie haseł że przekroczyłeś tą proporcję.
										Dodaj proszę trochę haseł by grać znowu i pomóc bawić się też innym! Dzięki !!!.<br><br>
										Zgodnie z aktualną punktacją musisz dodać <strong>%1$d hasło / haseł</strong> by dalej grać.',
	// Term definition
	'MOT_HANGMAN_QUOTE_INPUT_HEAD'	=> 'Wprowadzanie haseł do zgadywania',
	'MOT_HANGMAN_QUOTE_INPUT_EXPL'	=> 'Możesz wprowadzić tu nowe hasło. Hasło może zawierać litery %1$s (małe i wielkie litery), <br> spacje oraz oraz
										znaki specjalne %2$s. Hasła mogą być wielowyrazowe.
										Hasła które wprowadziłeś nie będą Tobie pokazywane.
										<br><br>
										Po kliknięciu przycisku dodaj i odczekaniu 2 sek kursor sam ustawi się w pole wprowadzania !.<br>'
										,
	'MOT_HANGMAN_CATEGORY_EXPL'		=> 'Wybierając kategorię możesz ułatwić zgadnięcie hasła.',
	'MOT_HANGMAN_INPUT_POINTS'		=> [
		1							=> 'Zgodnie z ustawieniami gry otrzymasz %1$d punkty za wprowadzenie hasła (i pomożesz bawić się innym)!.',
		2							=> 'Zgodnie z ustawieniami gry otrzymasz %1$d punktów za wprowadzenie hasła (i pomożesz bawić się innym)!.',
	],
	'MOT_HANGMAN_QUOTE_INPUT'		=> 'Wprowadź nowe hasło',
	'MOT_HANGMAN_WORD_SAVED'		=> 'Nowe hasło zostało dodane do bazy.<br>
										Otrzymujesz %1$s pkt.',
	'MOT_HANGMAN_UNAUTH_LETTERS'	=> 'Hasło zawiera niedozwolony znak: ',
	'MOT_HANGMAN_TERM_TOO_SHORT'	=> 'Hasło jest za krótkie! Minimalna ilość liter: ',
	'MOT_HANGMAN_CATEGORY_MISSING'	=> 'Kategoria nie może być pusta!',
	'MOT_HANGMAN_WORD_EXISTS'		=> '<strong>To hasło już isteniej w bazie!</strong> Spróbuj dodać inne.',
	// Ranking table
	'MOT_HANGMAN_RANKING_TABLE'		=> 'Lista chwały !!!',
	'MOT_HANGMAN_TOTAL_POINTS'		=> 'Punkty razem',
	'MOT_HANGMAN_GAME_POINTS'		=> 'Punkty za grę',
	'MOT_HANGMAN_WORD_POINTS'		=> 'Punkty za hasła',
	'MOT_HANGMAN_NO_ENTRIES'		=> 'No entries',
	// Summary
	'MOT_HANGMAN_SUMMARY'			=> 'Informacje',
	'ACP_MOT_HANGMAN_TERMS'			=> 'Hasła',
	'MOT_HANGMAN_TERMS_AVAILABLE'	=> 'Ilość wszystkich haseł',
	'MOT_HANGMAN_USER_TERMS_AVAILABLE'	=> 'Ilość haseł wprowadzonych przez Ciebie',
	'MOT_HANGMAN_USER_TERMS'		=> 'Ilość dostępnych haseł wprowadzonych przez Ciebie',
	'MOT_HANGMAN_TERM'				=> 'Twoje hasła',
	'MOT_HANGMAN_CATEGORY'			=> 'Kategorie',
	// Display players
	'MOT_HANGMAN_PLAYERS'			=> 'Hangman players',
	'MOT_HANGMAN_TOTAL_PLAYERS'		=> [
		0	=> 'Currently there is no member playing Hangman',
		1	=> 'Currently there is %1$d member playing Hangman: ',
		2	=> 'Currently there are %1$d members playing Hangman: ',
	],
]);
