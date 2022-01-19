<?php
/**
*
* @package Hangman v0.4.0
* @copyright (c) 2021 - 2022 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\hangman\acp;

class settings_module
{
	public $u_action;
	public $tpl_name;
	public $page_title;

	/**
	 * Main ACP module
	 *
	 * @param	string	$id		The module identifier (\mot\userreminder\acp\main_module)
	 *		string	$mode	The module mode (registrated_only|reminder|settings|zeroposter)
	 *
	 * @throws \Exception
	 */
	public function main($id, $mode)
	{
		global $phpbb_container;

		/** @var \mot.userreminder.controller.acp $acp_controller */
		$acp_controller = $phpbb_container->get('mot.hangman.controller.hangman_acp');

		/** @var \phpbb\language\language $language */
		$language = $phpbb_container->get('language');

		// Load a template from adm/style for our ACP page
		$this->tpl_name = 'acp_hangman_' . $mode;

		// Set the page title for our ACP page
		$this->page_title = $language->lang('ACP_MOT_HANGMAN') . ' - ' . $language->lang('ACP_MOT_HANGMAN_' . utf8_strtoupper($mode));

		// Make the $u_action url available in our ACP controller
		$acp_controller->set_page_url($this->u_action)->{$mode}();
	}

}
