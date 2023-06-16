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
	'MOT_HANGMAN_EXT_NAME'						=> 'Hangman',
	'MOT_HANGMAN_ERROR_EXTENSION_NOT_ENABLE'	=> 'The extension „%1$s“ can not be enabled. Please check whether the necessary requirements for this extension are satisfied.',
	'MOT_HANGMAN_ERROR_MESSAGE_PHPBB_VERSION'	=> 'Minimum version of phpBB required is „%1$s“ but less than „%2$s“',
	'MOT_HANGMAN_PHP_VERSION_ERROR'				=> 'Minimum version of PHP is „%1$s“ but less than „%2$s“',
]);
