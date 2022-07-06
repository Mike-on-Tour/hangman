<?php
/**
*
* @package Hangman v0.6.0
* @author Mike-on-Tour
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
	'MOT_HANGMAN_EXT_NAME'						=> 'Hangman',
	'MOT_HANGMAN_ERROR_EXTENSION_NOT_ENABLE'	=> 'Die Erweiterung „%1$s“ kann nicht aktiviert werden. Prüfe die Voraussetzungen, die für die Erweiterung notwendig sind.',
	'MOT_HANGMAN_ERROR_MESSAGE_PHPBB_VERSION'	=> 'Minimum ist phpBB %1$s, aber kleiner als „%2$s“',
	'MOT_HANGMAN_PHP_VERSION_ERROR'				=> 'Minimum PHP-Version ist „%1$s“',
]);
