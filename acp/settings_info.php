<?php

/**
*
* @package Hangman Game v0.2.0
* @copyright (c) 2021 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\hangman\acp;

class settings_info
{
	public function module()
	{
		return array(
			'filename'	=> '\mot\hangman\acp\settings_module',
			'title'		=> 'ACP_HANGMAN',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'ACP_HANGMAN_SETTINGS',
					'auth'	=> 'ext_mot/hangman && acl_a_board',
					'cat'	=> array('ACP_HANGMAN'),
				),
			),
		);
	}
}
