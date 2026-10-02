<?php
/**
*
* @package Hangman v0.6.0
* @author Mike-on-Tour
* @copyright (c) 2021 - 2022 Mike-on-Tour
* @former author dmzx (www.dmzx-web.net)
* @copyright (c) 2015 by dmzx (www.dmzx-web.net)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
* Slovenian Translation - Marko K.(max, max-ima,...)
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
	'MOT_HANGMAN_EXT_NAME'						=> 'Vislice',
	'MOT_HANGMAN_ERROR_EXTENSION_NOT_ENABLE'	=> 'Razširitve „%1$s“ ni mogoče omogočiti. Preverite, ali so potrebne zahteve za to razširitev izpolnjene.',
	'MOT_HANGMAN_ERROR_MESSAGE_PHPBB_VERSION'	=> 'Najmanjša zahtevana različica phpBB je „%1$s“ vendar manjša od „%2$s“',
	'MOT_HANGMAN_PHP_VERSION_ERROR'				=> 'Najmanjša različica PHP je „%1$s“ vendar manjša od „%2$s“',
]);
