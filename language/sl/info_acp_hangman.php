<?php
/**
*
* @package Hangman v0.8.0
* @copyright (c) 2021 - 2023 Mike-on-Tour
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

$lang = array_merge($lang, [
	'ACP_HANGMAN'								=> 'Vislice',							   
	'ACP_MOT_HANGMAN'							=> 'Vislice/<br>Hangman',
	'ACP_HANGMAN_SETTINGS'						=> 'Nastavitve',										   
	'ACP_MOT_HANGMAN_SETTINGS'					=> 'Nastavitve',
	// General settings
	'ACP_MOT_HANGMAN_EXT_SETTINGS'				=> 'Nastavitve razširitve',
	'ACP_MOT_HANGMAN_AUTODELETE'				=> 'Izbrišite uporabljene izraze?',
	'ACP_MOT_HANGMAN_AUTODELETE_EXP'			=> 'Če izberete ´Da´, bo izraz, uporabljen v igri, izbrisan iz baze podatkov, ko bo ta igra končana.',
	'ACP_MOT_HANGMAN_CATEGORY_ENABLE'			=> 'Omogoči kategorije?',
	'ACP_MOT_HANGMAN_CATEGORY_ENABLE_EXP'		=> 'Če izberete ´Da´, se bo med ustvarjanjem iskalnega izraza prikazalo dodatno besedilno polje. Na tem področju si
                                                    lahko vnesete ime kategorije, ki ji ta izraz pripada.<br>
													Ta kategorija bo prikazana nad poljem za iskalni izraz na zavihku igre in služi kot majhen namig.',
	'ACP_MOT_HANGMAN_CATEGORY_ENFORCE'			=> 'Uveljavi vnos kategorije?',
	'ACP_MOT_HANGMAN_CATEGORY_ENFORCE_EXP'		=> 'Če izberete ´Da´, bo vnos kategorije uveljavljen, kar pomeni, da obrazca za vnos ni mogoče oddati
                                                    brez vnosa v polje za vnos kategorije. Ta nastavitev je uporabna samo, če je omogočeno ´Omogoči kategorije´.',
	'ACP_MOT_HANGMAN_SHOW_TERM'					=> 'Prikaži izraz, ko zaprete izgubljeno igro',
	'ACP_MOT_HANGMAN_SHOW_TERM_EXP'				=> 'Če je aktiviran, bo izraz jasno prikazan s sporočilom o izgubljeni igri.',
	'ACP_MOT_HANGMAN_ENFORCE_TERM'				=> 'Blokirajte igralce z nezadostnim številom točk za vnos izrazov',
	'ACP_MOT_HANGMAN_ENFORCE_TERM_EXP'			=> 'Če izberete ´Da´ igralci z razmerjem igralnih točk in vhodnih točk, ki presegajo
                                                    nastavljeno omejitev bo pozvano, da vnesete nov termin pred igranjem. To je sredstvo za usposabljanje
                                                    igralci, ki zavračajo vnos novih izrazov.<br>
                                                    V naslednji nastavitvi lahko izberete razmerje med igralnimi točkami in terminskimi vhodnimi točkami
                                                    se prikaže po izbiri ´Da´.',
	'ACP_MOT_HANGMAN_ENFORCE_TERM_RATIO'		=> 'Razmerje med igralnimi točkami in vhodnimi točkami',
	'ACP_MOT_HANGMAN_ENFORCE_TERM_RATIO_EXP'	=> 'Omogočanje te nastavitve je predvsem sredstvo za blokiranje članov, ki igrajo Vislice, če so vnesli nezadostno
                                                    število novih terminov glede na njihove zmagovalne igre; zato je priporočljivo nastaviti to razmerje
                                                    ne prenizko. npr. privzeta vrednost 40 pomeni, da igralec s 40 točkami vnosa izrazov in več kot
                                                    1.600 igralnih točk je blokirano igranje, dokler razmerje ne pade pod 40 z vnosom števila izrazov
                                                    za dvig točk za vnos izraza (igralec bo namesto igralne plošče videl sporočilo, da je to navedeno).<br>
                                                    Pred prvo nastavitvijo te vrednosti preučite tabelo najboljših rezultatov, da prepoznate te igralce
                                                    z največjim razmerjem lahko kasneje to vrednost znižate. Vaš dolgoročni cilj bi moral biti doseči razmerje, ki
                                                    ustreza razmerju med povprečnimi zmagovalnimi točkami igre in točkami za vstop v nov termin.<br>
                                                    Kot primer to pomeni, da je pri povprečnih 25 igralnih točkah in 8 točkah vnosa terminov natančno razmerje
                                                    bi bilo 3,125 ali 4, da bi prikazali okroglo številko. Z razmerjem 4 mora igralec vnesti nov termin za
                                                    (skoraj) vsaka osvojena igra, ki se zdi zdrava številka, če so uporabljeni izrazi izbrisani. Lahko izberete
                                                    višja vrednost, če uporabljeni izrazi ostanejo v bazi podatkov.',
	'ACP_MOT_HANGMAN_GAIN_RANK'					=> 'Prikaz izboljšanja ranga',
	'ACP_MOT_HANGMAN_GAIN_RANK_EXP'				=> 'Če omogočite to nastavitev, bodo igralci videli polje s čestitkami, če bodo točke, pridobljene med končano igro, 
	                                                povzročile izboljšanje njihovega ranga.',
	'ACP_MOT_HANGMAN_LOOSE_RANK'				=> 'Obvestilo ob izgubi trenutnega ranga',
	'ACP_MOT_HANGMAN_LOOSE_RANK_EXP'			=> 'Če je omogočeno, bo vsak igralec, ki izgubi trenutni rang zaradi točk, ki jih je pridobil drug igralec, 
	                                                prejel obvestilo o tem.',
	'ACP_MOT_HANGMAN_ENABLE_FAME'				=> 'Prikaz »Dvorana slavnih«',
	'ACP_MOT_HANGMAN_ENABLE_FAME_EXP'			=> 'Če je omogočeno, je poleg zavihka z najboljšimi rezultati prikazan drug zavihek z mesečno in letno hišo slavnih, ki prikazuje igralce, 
	                                                ki so v teh časovnih okvirih pridobili največ točk.<br>
													Če je omogočeno, bo prikazana druga nastavitev, kjer lahko izberete število igralcev, ki bodo prikazani.',
	'ACP_MOT_HANGMAN_RANK_LIMIT'				=> 'Število igralcev, ki bo prikazano',
	'ACP_MOT_HANGMAN_RANK_LIMIT_EXP'			=> 'Izberete lahko število igralcev, ki bodo prikazani v tabelah za tekoči mesec in leto.',
	'ACP_MOT_HANGMAN_DISPLAY_ONLINE'			=> 'Prikaz trenutno aktivnih igralcev Vislice',
	'ACP_MOT_HANGMAN_DISPLAY_ONLINE_EXP'		=> 'Aktiviranje te nastavitve bo prikazalo skupno število in imena vseh trenutno aktivnih članov na enem od zavihkov Hangman 
	                                                v razdelku „Kdo je na spletu (Who is online)“.',												  
	'ACP_MOT_HANGMAN_ROWS_PER_PAGE'				=> 'Vrstice na stran tabele',
	'ACP_MOT_HANGMAN_ROWS_PER_PAGE_EXP'			=> 'Izberite število vrstic, ki naj bodo prikazane na strani tabele',
	'ACP_MOT_HANGMAN_GAME_SETTINGS'				=> 'Nastavitve igre',
	'ACP_MOT_HANGMAN_GAME_SETTINGS_EXP'			=> 'Tukaj lahko konfigurirate nastavitve za število življenj za igranje (neuspeli poskusi) in točke za pridobitev.<br>
                                                    Vse vnose je treba preveriti v skladu s posameznimi namigi in jih po potrebi spremeniti.',
	'ACP_MOT_HANGMAN_LIVES'						=> 'Število neuspelih poskusov (življenja)',
	'ACP_MOT_HANGMAN_LIVES_EXP'					=> 'Število neuspelih poskusov, dokler igralec ne zapleše v zraku in izgubi igro<br>
                                                    (celo število med 4 in 10)',
	'ACP_MOT_HANGMAN_POINTS_WIN'				=> 'Točke ob zmagi',
	'ACP_MOT_HANGMAN_POINTS_WIN_EXP'			=> 'Število točk, ki jih lahko pridobi, če igralec reši uganko<br>
                                                    (celo število večje od nič)',
	'ACP_MOT_HANGMAN_POINTS_LOOSE'				=> 'Točke ob porazu',
	'ACP_MOT_HANGMAN_POINTS_LOOSE_EXP'			=> 'Število točk, ki se bremenijo, če igralec ne reši uganke<br>
                                                    (celo število manjše ali enako nič)',
	'ACP_MOT_HANGMAN_POINTS_LETTER'				=> 'Število točk, ki jih lahko dobite s pravilno črko',
	'ACP_MOT_HANGMAN_POINTS_LETTER_EXP'			=> 'Število točk, ki jih lahko pridobite z izbiro črke, ki pripada uganki<br>
                                                    (celo število večje ali enako nič)',
	'ACP_MOT_HANGMAN_POINTS_WORD'				=> 'Točke za novo ponudbo',
	'ACP_MOT_HANGMAN_POINTS_WORD_EXP'			=> 'Število točk, ki jih lahko pridobite z vnosom izraza ali ponudbe v bazo podatkov<br>
                                                    (celo število večje ali enako nič)',
	'ACP_MOT_HANGMAN_EVADE_ENABLE'				=> 'Štejte igro kot izgubljeno, če igra ostane?',
	'ACP_MOT_HANGMAN_EVADE_ENABLE_EXP'			=> 'Če je ta možnost aktivirana, se igralcem, ki zapustijo tekočo igro (npr. s klikom na povezavo ali osvežitev strani),
                                                    dodelijo ´Točke ob porazu´.<br>
                                                    Če je ta možnost omogočena, bodo igralci v pojavnem oknu vprašani, ali res želijo zapustiti igro
                                                    stran. Če potrdijo to dejanje, bodo doseženi (kaznovani) z ´Točke ob porazu´. Glede na
                                                    nastavitev ´Izbriši uporabljene izraze´ iskalni izraz, uporabljen v tej igri, se lahko izbriše iz baze podatkov.<br>
                                                    Če je ta možnost onemogočena, bo predvajalnik brez nadaljnjih dejanj preusmerjen na izbrano stran.',
	'ACP_MOT_HANGMAN_EXTRA_POINTS_ENABLE'		=> 'Omogočite dodatne točke za reševanje brez neuspešnih poskusov',
	'ACP_MOT_HANGMAN_EXTRA_POINTS_ENABLE_EXP'	=> 'Če želite igralce igre Vislice nagraditi za reševanje uganke brez neuspešnih poskusov, aktivirajte to nastavitev;;
													če je aktivirano, lahko število dodatnih točk izberete v drugi, nato vidni nastavitvi.',
	'ACP_MOT_HANGMAN_EXTRA_POINTS'				=> 'Dodatne točke za rešitev brez neuspešnih poskusov',
	'ACP_MOT_HANGMAN_EXTRA_POINTS_EXP'			=> 'Izberite število dodatnih točk, najmanjše število je ena dodatna točka, največje število je 50 dodatnih točk.',					
    //Term settings
	'ACP_MOT_HANGMAN_INPUT_SETTINGS'			=> 'Nastavitve vnosa izrazov',
	'ACP_MOT_HANGMAN_INPUT_SETTINGS_EXP'		=> 'Tukaj lahko konfigurirate nastavitve za vnos iskalnih izrazov.',
	'ACP_MOT_HANGMAN_TERM_LENGTH'				=> 'Najmanjša dolžina vnosa',
	'ACP_MOT_HANGMAN_TERM_LENGTH_EXP'			=> 'Vnesite najmanjšo dolžino izraza kot najmanj potrebno število črk
                                                    (ločila in presledki se ne štejejo).',
	'ACP_MOT_HANGMAN_PUNCTUATION_MARKS'			=> 'Dovoljena ločila',
	'ACP_MOT_HANGMAN_PUNCTUATION_MARKS_EXP'		=> 'Ta ločila so dovoljena za vnos z novim izrazom poleg črk in presledkov. Oni bodo
                                                    prikazano na zavihku igre kot del izraza.<br>
                                                    POZOR: Pri uvažanju izrazov iz datotek ali drugih tabel baze podatkov bodo le ta ločila
                                                    upoštevana!',
	'ACP_MOT_HANGMAN_SETTING_SAVED'				=> 'Nastavitve za igro Vislice so bile uspešno shranjene.',
	// Data migration
	'ACP_MOT_HANGMAN_MIGRATION_SETTINGS'		=> 'Selitev podatkov',
	'ACP_MOT_HANGMAN_UPLOAD_XML'				=> 'Naložite lokalno shranjeno datoteko xml',
	'ACP_MOT_HANGMAN_UPLOAD_XML_EXP'			=> 'Izberite lokalno shranjeno datoteko xml, ki vsebuje izraze in kategorije, jo naložite na strežnik in jih vstavite
                                                    izraze in kategorije v ustrezno tabelo.<br>
                                                    Označeni boste kot ustvarjalec, kar pomeni, da za igranje ne morete izbirati med temi pogoji.
                                                    Upoštevajte, da vam za to dejanje ne bodo pripisane nobene točke.',
	'ACP_MOT_HANGMAN_UPLOAD'					=> 'Naloži datoteko',
	'ACP_MOT_HANGMAN_ERROR'						=> 'Napaka!',
	'ACP_MOT_HANGMAN_SELECT_FILE'				=> 'Najprej izberite datoteko',
	'ACP_MOT_HANGMAN_INVALID_FILE_EXT'			=> 'Neveljavna pripona datoteke.',
	'ACP_MOT_HANGMAN_INVALID_FILE_CONTENT'		=> 'Vsebina datoteke je napačna, nalaganje je bilo prekinjeno.',
	'ACP_MOT_HANGMAN_XML_IMPORTED'				=> [
		1	=> 'Vstavljen je %1$d nabor podatkov iz datoteke „<i>%2$s</i>“.',
		2	=> 'Vstavljenih %1$d naborov podatkov iz datoteke „<i>%2$s</i>“.',
	],
	'ACP_MOT_HANGMAN_XML_NO_IMPORT'				=> 'Datoteka „<i>%1$s</i>“ ne vsebuje nobenih veljavnih podatkov.',
	'ACP_MOT_HANGMAN_IMPORT_TABLE'				=> 'Preseli nabore podatkov iz ´dmzx/hangmangame´',
	'ACP_MOT_HANGMAN_IMPORT_TABLE_EXP'			=> 'Če vidite to možnost, obstaja tabela, ki vsebuje izraze, ki niso bili uvoženi v to
                                                    igro; to lahko storite s klikom na gumb na desni.<br>
                                                    Sam izraz, namig (kot kategorija) in ustvarjalec bodo uvoženi, vendar točke ne bodo pripisane.',
	'ACP_MOT_HANGMAN_IMPORT_TABLE_BUTTON'		=> 'Preselitev tabele',
	'ACP_MOT_HANGMAN_TABLE_IMPORTED'			=> [
		1	=> 'Iz tabele je bil vstavljen %1$d nabor podatkov „<i>%2$s</i>“.',
		2	=> 'Vstavljenih %1$d naborov podatkov iz tabele „<i>%2$s</i>“.',
	],
	'ACP_MOT_HANGMAN_TABLE_NO_IMPORT'			=> 'Tabela „<i>%1$s</i>“ ne vsebuje nobenih veljavnih podatkov.',
	'ACP_MOT_HANGMAN_DATA_EXPORT'				=> 'Izvozi podatke',
	'ACP_MOT_HANGMAN_EXPORT_TERMS'				=> 'Izvozi izraze iz tabele',
	'ACP_MOT_HANGMAN_EXPORT_TERMS_EXP'			=> 'Tukaj lahko izvozite izraze iz tabele “_mot_hangman_words” v datoteko XML.<br>
                                                    S klikom na gumb na desni ustvarite datoteko XML z vnaprej določenim imenom in vam jo ponudi za
                                                    prenos in lokalno shranjevanje.',
	'ACP_MOT_HANGMAN_SUBMIT_EXPORT'				=> 'Izvozi podatke',
	'ACP_MOT_HANGMAN_TABLE_NO_EXPORT'			=> 'Izvoz podatkov ni uspel, ni mogoče ustvariti datoteke.',
	// Misc
	'ACP_MOT_HANGMAN_RESET_HIGHSCORE'			=> 'Ponastavitev visoke ocene',
	'ACP_MOT_HANGMAN_RESET_HIGHSCORE_CAUTION'	=> '<strong>POZOR:</strong> To dejanje je nepovratno!',
	'ACP_MOT_HANGMAN_SCORE_TABLE_CLEARED'		=> '<strong>Tabela Najvišja ocena Vislice je očiščena</strong>',
	'ACP_MOT_HANGMAN_HIGHSCORE_TABLE_CLEARED'	=> 'Tabela rezultatov je počiščena',
	'ACP_MOT_HANGMAN_SUPPORT_HANGMAN'			=> 'Če želite podpreti razvoj Vislice, uporabite to povezavo za donacijo:<br>',
	'ACP_MOT_HANGMAN_VERSION'					=> '<img src="https://img.shields.io/badge/Version-%1$s-green.svg?style=plastic" /><br>&copy; 2021 - %2$d by Mike-on-Tour',
]);
