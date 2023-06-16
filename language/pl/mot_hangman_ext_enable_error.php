<?php
/**
*
* @package Hangman v0.6.0
s* @author Mike-on-Tour
* @copyright (c) 2021 - 2022 Mike-on-Tour
* @former author dmzx (www.dmzx-web.net)
* @copyright (c) 2015 by dmzx (www.dmzx-web.net)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'MOT_HANGMAN_EXT_NAME'						=> 'Wisielec',
	'MOT_HANGMAN_ERROR_EXTENSION_NOT_ENABLE'	=> 'Rozszerzenie „%1$s“ nie może zostać uruchomione. Sprawdź czy wymagania niezbędne do uruchomienia są spełnione.',
	'MOT_HANGMAN_ERROR_MESSAGE_PHPBB_VERSION'	=> 'Minimalna wymagana wersja PHPBB to: „%1$s“ ,ale mniejsza niż: „%2$s“',
	'MOT_HANGMAN_PHP_VERSION_ERROR'				=> 'Minimalna wersja serwera PHP to: „%1$s“',
]);
