<?php
/*
*
* @package Hangman v0.8.0
* @author Mike-on-Tour
* @copyright (c) 2021 - 2023 Mike-on-Tour
* @former author dmzx (www.dmzx-web.net)
* @copyright (c) 2015 by dmzx (www.dmzx-web.net)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
* Slovenian Translation - Marko K.(max, max-ima,...)
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
	'MOT_HANGMAN_TAB_GAME'			=> 'Igra',
	'MOT_HANGMAN_TAB_WORD'			=> 'Vnos iskalnega izraza',
	'MOT_HANGMAN_TAB_SCORE'			=> 'Najboljši rezultat',
	'MOT_HANGMAN_TAB_FAME'			=> 'Dvorana slavnih',											
	'MOT_HANGMAN_TAB_SUMMARY'		=> 'Povzetek',
	// Back menu
	'MOT_HANGMAN_TO_GAME'			=> 'Začni igro',
	'MOT_HANGMAN_TO_WORD_INPUT'		=> 'Pošlji nov iskalni izraz',
	'MOT_HANGMAN_TO_SCORE_TABLE'	=> 'Oglejte si visok rezultat',
	'MOT_HANGMAN_TO_FAME'			=> 'Ogled dvorane slavnih',												
	'MOT_HANGMAN_TO_SUMMARY'		=> 'Povzetek',
	// Game
	'MOT_HANGMAN'					=> 'Vislice',
	'MOT_HANGMAN_TITLE'				=> 'Igra Vislice',
	'MOT_HANGMAN_DESC'				=> 'Dobrodošli v igralnem območju `Vislice`. S klikom na gumb `Začni igro` bo iz baze podatkov izbran naključni izraz
                                        in prikazano v območju izraza. Vsaka črka bo predstavljena s podčrtajem.
                                        Če izberete črko, ki jo vsebuje izraz, bo prikazana namesto podčrtaja.<br>
                                        Izbrane črke bodo izginile iz izbirnega območja in ne bodo več na voljo. Črke, ki ste jih že izbrali, bodo
                                        prikazano v območju `Neuspešni poskusi` ali `Pravilni poskusi`.<br>
                                        Glede na trenutne nastavitve boste prejeli %1$s točk za vsako pravilno izbrano črko in %2$s točk za obrat
                                        zmagali ste, poraz vas bo stal %3$s točk.',
	'MOT_HANGMAN_DESC_DEL_TERM'		=> '<br>POZOR: Izrazi, uporabljeni v potezi igre, bodo po tem potezi izbrisani iz baze podatkov. Prosimo, vnesite izraz, potem ko ste zaključili igro,
	                                    da lahko tudi drugi igrajo.',
	// List all letters of this language as uppercase letters separated by comma. If this language contains lowercase letters without an uppercase equivalent list them here, too.
	'MOT_HANGMAN_LETTERS'			=> 'A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z',
	'MOT_HANGMAN_LIVES'				=> 'Imate %1$s življenj za igranje.',
	'MOT_HANGMAN_SCORE'				=> 'Rezultat:',
	'MOT_HANGMAN_LIVES_USED'		=> 'Uporabljena življenja:',
	'MOT_HANGMAN_NEW_QUOTE'			=> 'Začni igro',
	'MOT_HANGMAN_NEW_QUOTE_START'	=> 'Kliknite gumb ´Začni igro´, da zaženete Vislice',
	'MOT_HANGMAN_NO_QUOTE'			=> 'Trenutno ni na voljo nobenih izrazov. Prosim poskusite kasneje.',
	'MOT_HANGMAN_CATEGORY'			=> 'Kategorija',
	'MOT_HANGMAN_FAILED_TRIES'		=> 'Neuspešni poskusi',
	'MOT_HANGMAN_CORRECT_TRIES'		=> 'Pravilni poskusi',
	'MOT_HANGMAN_WIN_EXTRA_POINTS'	=> 'Brez napak!!!<br>Pridobiš dodatnih %1$d točk!<br>',																							
	'MOT_HANGMAN_YOU_WIN'			=> '<strong>Zmagali ste!</strong><br>',
	'MOT_HANGMAN_YOU_WIN_PTS'		=> 'Pridobljene točke: ',												 
	'MOT_HANGMAN_NEW_QUOTE_TO'		=> 'Kliknite ´Začni igro´, da zaženete Vislice!',
	'MOT_HANGMAN_YOU_LOSE'			=> '<strong>Izgubili ste!</strong><br>Pridobljene točke: ',
	'MOT_HANGMAN_SHOW_TERM'			=> '<br><br>Izraz se je glasil:<br><i>',
	'MOT_HANGMAN_POINTS_SAVED'		=> 'Vašemu igralnemu računu so bile pripisane točke, pridobljene v tej igri.',
	'MOT_HANGMAN_GAME_BLOCKED'		=> 'Skrbnik je določil razmerje igralnih točk in terminskih vhodnih točk, ki se ne sme preseči.
                                        Prislužili ste si toliko igralnih točk, da je v vašem primeru to razmerje preseženo. Vnesti morate novo
                                        pogoje pred ponovnim igranjem.<br><br>
                                        Glede na vaš trenutni rezultat morate vnesti vsaj <strong>%1$d izraz(e)</strong>, to storite
                                        in lahko igrate ponovno.',
	'MOT_HANGMAN_RANK_GAINED'		=> '<strong>Čestitke!</strong><br><br>Z ranga %1$d. ste se povzpeli na %2$d.!',																											 
	// Term definition
	'MOT_HANGMAN_QUOTE_INPUT_HEAD'	=> 'Vnesite nov izraz',
	'MOT_HANGMAN_QUOTE_INPUT_EXPL'	=> 'V ta obrazec lahko vnesete nov izraz. Ta izraz lahko vsebuje črke %1$s (velike in male črke), presledke in
                                        ločila %2$s. Zato niste omejeni na posamezne besede in lahko
                                        vnesite tudi narekovaje.<br>
                                        Izrazi, ki jih vnesete sami, vam med igranjem ne bodo prikazani!',
	'MOT_HANGMAN_CATEGORY_EXPL'		=> 'Z navedbo kategorije lahko podate namig za rešitev pojma.',
	'MOT_HANGMAN_INPUT_POINTS'		=> [
		1							=> 'V skladu s trenutnimi nastavitvami bo vašemu igralnemu računu pripisana %1$d točka za vnos izraza.',
		2							=> 'V skladu s trenutnimi nastavitvami bo vašemu igralnemu računu pripisanih %1$d točk za vnos izraza.',
	],
	'MOT_HANGMAN_QUOTE_INPUT'		=> 'Nov izraz',
	'MOT_HANGMAN_WORD_SAVED'		=> 'Izraz, ki ste ga vnesli, je bil uspešno shranjen v bazi podatkov.<br>
										Vaš igralni račun za igro je prejel %1$s točk.',
	'MOT_HANGMAN_UNAUTH_LETTERS'	=> 'Izraz vsebuje te neveljavne znake: ',
	'MOT_HANGMAN_TERM_TOO_SHORT'	=> 'Izraz je prekratek! Najmanjše število črk je: ',
	'MOT_HANGMAN_CATEGORY_MISSING'	=> 'Kategorija ne sme biti prazna!',
	'MOT_HANGMAN_WORD_EXISTS'		=> '<strong>Izraz, ki ste ga vnesli, že obstaja!</strong> Prosimo, poskusite znova z drugim izrazom.',
	// Ranking table
	'MOT_HANGMAN_RANKING_TABLE'		=> 'Najboljši rezultat',
	'MOT_HANGMAN_TOTAL_POINTS'		=> 'Skupno število točk',
	'MOT_HANGMAN_GAME_POINTS'		=> 'Igralne točke',
	'MOT_HANGMAN_WORD_POINTS'		=> 'Točke vnosa izrazov',
	'MOT_HANGMAN_NO_ENTRIES'		=> 'Brez vnosov',
	// Hall of Fame
	'MOT_HANGMAN_CURRENT_MONTH'		=> 'Trenutni mesec',
	'MOT_HANGMAN_CURRENT_YEAR'		=> 'Trenutno leto',
	'MOT_HANGMAN_LAST_MONTHS'		=> [
		1	=> 'Prejšnji mesec',
		2	=> 'Zadnjih %1$d mesecev',
	],
	'MOT_HANGMAN_LAST_YEARS'		=> [
		1	=> 'Lansko leto',
		2	=> 'Zadnjih %1$d let',

	// Summary
	'MOT_HANGMAN_SUMMARY'			=> 'Povzetek',
	'ACP_MOT_HANGMAN_TERMS'			=> 'Izrazi',
	'MOT_HANGMAN_TERMS_AVAILABLE'	=> 'Število razpoložljivih izrazov',
	'MOT_HANGMAN_USER_TERMS_AVAILABLE'	=> 'Število izrazov, ki ste jih vnesli sami',
	'MOT_HANGMAN_USER_TERMS'		=> 'Razpoložljivi izrazi, ki ste jih vnesli sami',
	'MOT_HANGMAN_TERM'				=> 'Izraz',
	'MOT_HANGMAN_CATEGORY'			=> 'Kategorija',
	// Display players
	'MOT_HANGMAN_PLAYERS'			=> 'Igralci vislic',
	'MOT_HANGMAN_TOTAL_PLAYERS'		=> [
		0	=> 'Trenutno noben član ne igra Vislice',
		1	=> 'Trenutno %1$d član igra Vislice: ',
		2	=> 'Trenutno %1$d članov igra Vislice: ',
	],

	// Notification text
	'MOT_HANGMAN_NOTIFICATION_RANK_LOST'	=> '<strong>Zdrsnilo ti je za korak!</strong><br>„%1$s“ vas je izpodrinil z vaše lestvice Vislice.',

	// Months
	'JANUARY'		=> 'Januar',
	'FEBRUARY'		=> 'Februar',
	'MARCH'			=> 'Marec',
	'APRIL'			=> 'April',
	'MAY'			=> 'Maj',
	'JUNE'			=> 'Junij',
	'JULY'			=> 'Julij',
	'AUGUST'		=> 'Avgust',
	'SEPTEMBER'		=> 'September',
	'OCTOBER'		=> 'Oktober',
	'NOVEMBER'		=> 'November',
	'DECEMBER'		=> 'December',
]);
